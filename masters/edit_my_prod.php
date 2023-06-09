<?php
// Šis PHP kods iekļauj nepieciešamās konfigurācijas faila (config.php) iekļaušanu un sesijas sākšanu. 
// Tas pārbauda, vai sesijā ir saglabāts lietotāja vārds (user_name) un izpilda papildu kodu, ja lietotājs ir pieslēdzies. 
require("../admin/config.php");
session_start();

if (isset($_SESSION['user_name'])) {
    // Pārbauda, vai sesijā ir iestatīts 'user_name' atslēgas elements. Nepieciešama lietotāja autentifikācija.

    // Iegūst vērtības no GET parametriem un piešķir atbilstošiem mainīgajiem.
    $prece_ID = $_GET['prece_ID'];
    $Nosaukums_prece = $_GET['Nosaukums_prece'];
    $Cena = $_GET['Cena'];
    $Statuss = $_GET['Statuss'];
    $Apraksts_prece = $_GET['Apraksts_prece'];
    $Ipatnibas_prece = $_GET['Ipatnibas_prece'];
    $Nosaukums_kategorija = $_GET['Nosaukums_kategorija'];
    $Nosaukums_sadala = $_GET['Nosaukums_sadala'];

    if (isset($_POST['update'])) {
        // Pārbauda, vai POST pieprasījumā ir nospiests 'update' poga.

        //POST datus, lai novērstu SQL ievainojamības.
        $Nosaukums_prece = mysqli_real_escape_string($conn, $_POST['Nosaukums_prece']);
        $Cena = mysqli_real_escape_string($conn, $_POST['Cena']);
        $Statuss = mysqli_real_escape_string($conn, $_POST['Statuss']);
        $Apraksts_prece = mysqli_real_escape_string($conn, $_POST['Apraksts_prece']);
        $Ipatnibas_prece = mysqli_real_escape_string($conn, $_POST['Ipatnibas_prece']);
        $Kapakssadala_ID = mysqli_real_escape_string($conn, $_POST['Kapakssadala_ID']);
        $Kategorija_ID = mysqli_real_escape_string($conn, $_POST['Kategorija_ID']);

        $newPhotoPath = null;
        if (!empty($_FILES['newPhoto']['name'])) {
            // Pārbauda, vai nav tukšs 'newPhoto' elements POST datu masīvā.

            $file = $_FILES['newPhoto'];
            $fileName = $file['name']; // Iegūst faila nosaukumu.
            $fileTmpName = $file['tmp_name']; // Iegūst pagaidu faila nosaukumu un atrašanās vietu serverī.
            $fileSize = $file['size']; // Iegūst faila izmēru baitos.
            $fileError = $file['error']; // Iegūst kļūdas kodu, ja tāda radās augšupielādes procesā.
            $fileType = $file['type']; // Iegūst faila tipu (piemēram, image/jpeg).

            $fileExt = explode('.', $fileName); // Sadala faila nosaukumu un paplašinājumu punktu atdalot.
            $fileActualExt = strtolower(end($fileExt)); // Iegūst faila paplašinājumu un pārveido to par mazajiem burtiem.

            $allowed = array('jpg', 'jpeg', 'png', 'gif'); // Izveido atļauto faila paplašinājumu masīvu (tiek atļauti tikai .jpg, .jpeg, .png, .gif faili).

            if (in_array($fileActualExt, $allowed)) {
                // Pārbauda, vai faila paplašinājums ir atļauts.
                if ($fileError === 0) {
                    // Pārbauda, vai nav kļūdas, ielādējot failu.
                    if ($fileSize < 500000) {
                        // Pārbauda, vai faila izmērs ir mazāks par 500 000 baitiem.
                        $newPhotoPath = "uploads/" . uniqid('', true) . "." . $fileActualExt;
                        // Izveido jaunu faila ceļu un nosaukumu, izmantojot unikālu identifikatoru un faila paplašinājumu.
                        move_uploaded_file($fileTmpName, $newPhotoPath);
                        // Pārvieto augšupielādēto failu uz norādīto vietu.
                    } else {
                        $error[] = "Faila izmērs ir pārāk liels";
                        $newPhotoPath = null;
                        header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                        // Pievieno kļūdas ziņojumu un pāradresē lapu atpakaļ uz iepriekšējo lapu pēc 1 sekundes.
                    }
                } else {
                    $error[] = "Radās kļūda, ielādējot failu";
                    $newPhotoPath = null;
                    header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                }
            } else {
                $error[] = "Faila formāts nav atļauts";
                $newPhotoPath = null;
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
            }
        }

        $query = "UPDATE `prece`
                LEFT JOIN `kategorija` ON `prece`.`ID_Kategorija` = `kategorija`.`Kategorija_ID`
                LEFT JOIN `k_apakssadala` ON `prece`.`IDKapakssadala` = `k_apakssadala`.`Kapakssadala_ID`
                SET `prece`.`Nosaukums_prece`='" . $Nosaukums_prece . "', 
                    `prece`.`Cena`='" . $Cena . "', 
                    `prece`.`Statuss`='" . $Statuss . "', 
                    `prece`.`Apraksts_prece`='" . $Apraksts_prece . "', 
                    `prece`.`Ipatnibas_prece`='" . $Ipatnibas_prece . "', 
                    `prece`.`ID_Kategorija`='" . $Kategorija_ID . "', 
                    `prece`.`IDKapakssadala`='" . $Kapakssadala_ID . "'";
        // Izveido SQL vaicājumu, kas atjaunina ierakstu `prece` tabulā, izmantojot LEFT JOIN, lai savienotu arī citas tabulas un iestatītu jaunas vērtības kolonnām.

        if (!is_null($newPhotoPath)) {
            $query .= ", `Attela_prece`='" . $newPhotoPath . "'";
        }
        // Ja ir norādīta jauna attēla ceļš (`$newPhotoPath` nav null vērtība), tad papildina SQL vaicājumu ar jauno attēla ceļu, lai atjauninātu arī attēla kolonnu.

        $query .= " WHERE `prece_ID`='" . $prece_ID . "'";
        // Izveido SQL vaicājumu, lai atjauninātu ierakstu datu bāzē.

        if (mysqli_query($conn, $query)) {
            // Izpilda SQL vaicājumu datu bāzē.

            if (!empty($error)) {
                foreach ($error as $errorMsg) {
                    // Ja ir kļūdas ziņojumi, tos var izvadīt.
                }
            } else {
                header('location:my_products.php');
                // Ja nav kļūdu, tiek pāradresēts uz 'my_products.php' lapu.
            }
        } else {
            $errorMsg = "Kļūda " . mysqli_error($conn) . " with query: " . $query;
            // Ja ir datu bāzes kļūda, tiek sagatavots kļūdas ziņojums ar konkrēto kļūdas paziņojumu un vaicājumu.
        }
    }
    ;
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preču administrācija</title>
        <link rel="stylesheet" href="css/cssForMaster.css">
        <link rel="stylesheet" href="../assets/css/login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>
        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar">
                <a href="about_me.php">Statistika/Profils</a>
                <a href="my_products.php" class="active">Preces / Rediģēšāna</a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <div class="form-container">

            <form action="" method="post" enctype="multipart/form-data">
                <h3>REDIĢĒT</h3>
                <?php
                // Pārbaudu, vai ir kļūdas un izvadam tos kā kļūdas ziņojumus
                if (!empty($error)) {
                    foreach ($error as $errorMsg) {
                        echo '<span class="error-msg">' . $errorMsg . '</span>';
                    }
                }
                ?>

                <input type="text" required name="Nosaukums_prece" value="<?php echo $Nosaukums_prece; ?>">
                <!-- Ievades lauks teksta ievadei ar nosaukumu "Nosaukums_prece". Lai ievadlauks būtu obligāts, ir norādīts required atribūts. Ievadlaukam tiek piešķirta vērtība, kas atgriežas no PHP mainīgā $Nosaukums_prece -->
                <textarea name="Apraksts_prece" required style="height: 200px;"><?php echo $Apraksts_prece; ?></textarea>
                <!-- Teksta lauks ar nosaukumu "Apraksts_prece". Lai lauks būtu obligāts, ir norādīts required atribūts. Iekš textarea tiek ievietota vērtība, kas atgriežas no PHP mainīgā $Apraksts_prece. Iestatīts arī stils, lai textarea būtu augstāka -->
                <input type="number" step="00.01" name="Cena" required value="<?php echo $Cena; ?>">
                <!-- Ievades lauks skaitļa ievadei ar nosaukumu "Cena". Lai ievadlauks būtu obligāts, ir norādīts required atribūts. Ievadlaukam tiek piešķirta vērtība, kas atgriežas no PHP mainīgā $Cena. Norādīts arī solis skaitļu ievadei (0.01) -->
                <textarea name="Ipatnibas_prece" style="height: 200px;"><?php echo $Ipatnibas_prece; ?></textarea>
                <!-- Teksta lauks ar nosaukumu "Ipatnibas_prece". Iekš textarea tiek ievietota vērtība, kas atgriežas no PHP mainīgā $Ipatnibas_prece. Iestatīts arī stils, lai textarea būtu augstāka -->
                <input type="file" name="newPhoto" title="Fotoattēls" accept=".jpg,.jpeg,.png,.gif">
                <!-- Faila ievades lauks ar nosaukumu "newPhoto". Pieņem tikai failus ar atļautajiem paplašinājumiem (.jpg, .jpeg, .png, .gif). Iestatīts arī atribūts title, kas parāda uzvedni, kad peli novieto uz lauka -->
                <select name="Statuss">
                    <?php
                    $status_query = "SHOW COLUMNS FROM `prece` LIKE 'statuss'";
                    $status_result = mysqli_query($conn, $status_query);
                    $row = mysqli_fetch_assoc($status_result);
                    $enum_values = explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", "\\2", $row['Type']));

                    foreach ($enum_values as $value) {
                        $selected = ($value == $selected_status) ? 'selected' : '';
                        echo "<option value='$value' $selected>$value</option>";
                    }
                    ?>
                    <!-- Izvēles lauks ar nosaukumu "Statuss". Izvēles laukam tiek dinamiski pievienotas opcijas, kas atgriežas no datu bāzes. 
                    Izvēlētā opcija tiek iezīmēta ar atbilstošo selected atribūtu, ja tā ir atbilstoša PHP mainīgajam $selected_status -->
                </select>
                <select name="Kategorija_ID">
                    <?php
                    // Izveido vaicājumu, lai iegūtu kategorijas informāciju, kas atbilst noteiktam nosaukumam
                    $kat_query = "SELECT `Kategorija_ID`, `Nosaukums_kategorija` FROM `kategorija` WHERE `Nosaukums_kategorija` = '" . $Nosaukums_kategorija . "'";
                    $kat_result = mysqli_query($conn, $kat_query);
                    $row = mysqli_fetch_assoc($kat_result);
                    $Kategorija_ID = $row['Kategorija_ID'];

                    // Izveido vaicājumu, lai iegūtu visas kategorijas
                    $result = mysqli_query($conn, "SELECT * FROM kategorija");
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Pārbauda, vai šī kategorija ir izvēlēta (saglabātās vērtības pārbaude)
                        $selected = ($row['Kategorija_ID'] == $Kategorija_ID) ? 'selected' : '';
                        // Izvada opciju ar kategorijas ID, nosaukumu un atbilstošo izvēli
                        echo "<option value='" . $row['Kategorija_ID'] . "' " . $selected . ">" . $row['Nosaukums_kategorija'] . "</option>";
                    }
                    ?>
                </select>

                <select name="Kapakssadala_ID">
                    <?php
                    // Izveido vaicājumu, lai iegūtu kapakšsadaļas informāciju, kas atbilst noteiktam nosaukumam
                    $sublile_query = "SELECT `Kapakssadala_ID`, `Nosaukums_sadala` FROM `k_apakssadala` WHERE `Nosaukums_sadala` = '" . $Nosaukums_sadala . "'";
                    $sublile_result = mysqli_query($conn, $sublile_query);
                    $row_sub = mysqli_fetch_assoc($sublile_result);
                    $Kapakssadala_ID = $row_sub['Kapakssadala_ID'];

                    // Izveido vaicājumu, lai iegūtu visas kapakšsadaļas
                    $query = "SELECT * FROM k_apakssadala";

                     
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                         // Pārbauda, vai šī kapakšsadaļa ir izvēlēta (saglabātās vērtības pārbaude)
                        $selected = ($row['Kapakssadala_ID'] == $Kapakssadala_ID) ? 'selected' : '';
                        // Izvada opciju ar kapakšsadaļas ID, nosaukumu un atbilstošo izvēli
                        echo "<option value='" . $row['Kapakssadala_ID'] . "' " . $selected . ">" . $row['Nosaukums_sadala'] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" name="update" title="Rediģēt" value="Rediģēt" class="form-btn">
                <a class='btn' title='Atpakaļ' href='my_products.php'>Manas preces</a>

            </form>


        </div>

        <?php include '../admin/footer_adm.php'; ?>
        <?php
}
?>
</body>

</html>