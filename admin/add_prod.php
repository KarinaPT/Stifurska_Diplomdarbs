<?php
require("config.php"); // Iekļauj konfigurācijas failu
session_start(); // Sāk sesiju
if (isset($_SESSION['admin_name'])) { // Pārbauda, vai lietotājs ir autorizēts kā administrators
    if (isset($_POST['add'])) { // Pārbauda, vai ir iesniegts pievienošanas formas datu nosūtījums
        // Iegūst un apstrādā formas ievades datus
        $Nosaukums_prece = mysqli_real_escape_string($conn, $_POST['Nosaukums_prece']);
        $Cena = mysqli_real_escape_string($conn, $_POST['Cena']);
        $Apraksts_prece = mysqli_real_escape_string($conn, $_POST['Apraksts_prece']);
        $Attela_prece = mysqli_real_escape_string($conn, $_POST['Attela_prece']);
        $Ipatnibas_prece = mysqli_real_escape_string($conn, $_POST['Ipatnibas_prece']);
        $Pardevejs_ID = mysqli_real_escape_string($conn, $_POST['Pardevejs_ID']);
        $Kategorija_ID = mysqli_real_escape_string($conn, $_POST['Kategorija_ID']);
        $Kapakssadala_ID = mysqli_real_escape_string($conn, $_POST['Kapakssadala_ID']);
        // Apstrādā attēla augšupielādi
        $file = $_FILES['image']; // Iegūst faila datus no formas ievades
        $fileName = $file['name']; // Iegūst faila nosaukumu
        $fileTmpName = $file['tmp_name']; // Iegūst pagaidu faila atrašanās vietu
        $fileSize = $file['size']; // Iegūst faila lielumu
        $fileError = $file['error']; // Iegūst kļūdas kodu, ja tāda ir
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Iegūst faila paplašinājumu (piemēram, "jpg", "png")
        $allowedExt = array('jpg', 'jpeg', 'png', 'gif'); // Atļautie faila paplašinājumi
        if (in_array($fileExt, $allowedExt)) { // Pārbauda, vai faila paplašinājums atbilst atļautajiem
            if ($fileError === 0) { // Pārbauda, vai nav kļūdas ar failu
                if ($fileSize < 500000) { // Pārbauda, vai faila lielums ir mazāks par 500KB
                    $newFileName = uniqid('', true) . "." . $fileExt; // Izveido jaunu unikālu faila nosaukumu
                    $fileDestination = 'uploads/' . $newFileName; // Norāda atrašanās vietu, kur failu saglabāt
                    move_uploaded_file($fileTmpName, $fileDestination);

                    // Ievieto iegūtos datus datu bāzē
                    mysqli_query($conn, "INSERT INTO `prece`(`Nosaukums_prece`, `Cena`, `Apraksts_prece`, `Attela_prece`, `Ipatnibas_prece`, `ID_Pardevejs`, `IDKapakssadala`, `ID_Kategorija`) 
                  VALUES ('$Nosaukums_prece','$Cena','$Apraksts_prece','$fileDestination','$Ipatnibas_prece','$Pardevejs_ID','$Kapakssadala_ID','$Kategorija_ID')");
                    header('location:all_products.php'); //Lapas pārlādēšana, lai atiestatītu kļūdas ziņojumus
                } else {
                    $error[] = 'Faila izmērs ir pārāk liels'; // Pievieno kļūdu ziņojumu, ja faila izmērs ir pārāk liels
                    header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']); //Lapas pārlādēšana, lai atiestatītu kļūdas ziņojumus
                }
            } else {
                $error[] = 'Neizdevās augšupielādēt failu'; // Pievieno kļūdu ziņojumu, ja ir notikusi kļūda pie faila augšupielāde
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']); // Lapas pārlādēšana, lai atiestatītu kļūdas ziņojumus
            }
        } else {
            $error[] = 'Atļautie faila formāti ir: JPG, JPEG, PNG, GIF'; // Pievieno kļūdu ziņojumu, ja fails nav atļautā formātā
            header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']); // Lapas pārlādēšana, lai atiestatītu kļūdas ziņojumus
        }
    } else {
        // Iegūst kategoriju, pārdevēju un apakšsadaļu datus no datu bāzes
        $kategorija = mysqli_query($conn, 'SELECT * FROM kategorija');
        $pardevejs = mysqli_query($conn, 'SELECT * FROM pardevejs');
        $k_apakssadala = mysqli_query($conn, 'SELECT * FROM k_apakssadala');
        $prece = mysqli_query($conn, 'SELECT * FROM prece');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preču administrēšana</title>
        <link rel="stylesheet" href="css/css.css">
        <link rel="stylesheet" href="../assets/css/login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>

        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar">
                <a href="statistics.php">Statistika/Profils</a>
                <a href="all_products.php" class="active">Preces / Reģistrācija</a>
                <a href="all_masters.php">Pārdevēji</a>
                <a href="category.php">Kategorijas</a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Reģistrācija</h3>
                <?php
                // Parādīt kļūdas paziņojumus, ja tādi ir
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                    ;
                }
                ;
                ?>
                <input type="text" name="Nosaukums_prece" required placeholder="Nosaukums">
                <input type="number" step="00.01" name="Cena" required placeholder="Cena">
                <textarea name="Apraksts_prece" required placeholder="Apraksts" style="height:200px;"></textarea>
                <input type="file" name="image" required accept="image/*" title="Fotoattēls">
                <textarea name="Ipatnibas_prece" placeholder="Īpatnības" style="height: 200px;"></textarea>
                <select name="Kategorija_ID" id="Kategorija_ID" required="true">
                    <option value="" disabled selected hidden>Kategorija</option>

                    <?php
                     // Iegūt kategoriju datus no datu bāzes un veidot izvēlnes opcijas
                    $sql = "SELECT Kategorija_ID, Nosaukums_kategorija FROM kategorija";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <option value="<?= $row['Kategorija_ID'] ?>">
                                <?= $row['Nosaukums_kategorija'] ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <select name="Kapakssadala_ID" required="true">
                    <option value="" disabled selected hidden>Apakškategorija</option>
                    <?php
                    if (mysqli_num_rows($k_apakssadala) > 0) {
                        while ($row = mysqli_fetch_assoc($k_apakssadala)) {
                            ?>
                            <option value="<?= $row['Kapakssadala_ID'] ?>"><?= $row['Nosaukums_sadala'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <select name="Pardevejs_ID" required="true">
                    <option value="" disabled selected hidden>Pārdevējs</option>
                    <?php
                    if (mysqli_num_rows($pardevejs) > 0) {
                        while ($row = mysqli_fetch_assoc($pardevejs)) {
                            ?>
                            <option value="<?= $row['Pardevejs_ID'] ?>"><?= $row['Brenda_nosaukums'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <input type="submit" name="add" title='Reģistrēt' value="Reģistrēt" class="form-btn">
                <a href="all_products.php" title="Atpakaļ" class="btn">Atpakaļ</a>
            </form>

            <?php include 'footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>