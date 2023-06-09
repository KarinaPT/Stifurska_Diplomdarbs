<?php
require("../admin/config.php"); // Iekļauj konfigurācijas failu, kas satur datu bāzes pieslēguma informāciju.
session_start(); // Sāk jaunu sesiju vai atjauno esošo sesiju
$Pardevejs_ID = $_GET['Pardevejs_ID']; // Iegūst Pardevejs_ID vērtību no GET parametriem.
$E_pasts_pardevejs = $_GET['E_pasts_pardevejs']; // Iegūst E_pasts_pardevejs vērtību no GET parametriem.
$T_numurs_pardevejs = $_GET['T_numurs_pardevejs']; // Iegūst T_numurs_pardevejs vērtību no GET parametriem.
$Apraksts = $_GET['Apraksts']; // Iegūst Apraksts vērtību no GET parametriem.
$error = array(); // Izveido tukšu masīvu, kas tiks izmantots kļūdu ziņu glabāšanai.

if (isset($_SESSION['user_name'])) {


    if (isset($_POST['update'])) {
        // Pārbauda, vai POST pieprasījumā ir nospiests 'update' poga.

        // Iegūst jaunās vērtības no formas ievades laukiem un pasargā pret SQL injekcijām
        $new_E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);
        $new_T_numurs_pardevejs = mysqli_real_escape_string($conn, $_POST['T_numurs_pardevejs']);
        $new_Apraksts = mysqli_real_escape_string($conn, $_POST['Apraksts']);

        // Noklusējuma vērtība jaunajai fotogrāfijas ceļam (tukšs)
        $newPhotoPath = null;

        // Pārbauda, vai ir augšupielādēta jauna fotogrāfija
        if (!empty($_FILES['newPhoto']['name'])) {

            $file = $_FILES['newPhoto'];
            $fileName = $file['name']; // Iegūst faila nosaukumu.
            $fileTmpName = $file['tmp_name']; // Iegūst pagaidu faila nosaukumu un atrašanās vietu serverī.
            $fileSize = $file['size']; // Iegūst faila izmēru baitos.
            $fileError = $file['error']; // Iegūst kļūdas kodu, ja tāda radās augšupielādes procesā.
            $fileType = $file['type']; // Iegūst faila tipu (piemēram, image/jpeg).

            $fileExt = explode('.', $fileName); // Sadala faila nosaukumu un paplašinājumu punktu atdalot.
            $fileActualExt = strtolower(end($fileExt)); // Iegūst faila paplašinājumu un pārveido to par mazajiem burtiem.

            $allowed = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 500000) {
                        // Jaunās fotogrāfijas ceļš un nosaukums
                        $newPhotoPath = "uploads/" . uniqid('', true) . "." . $fileActualExt;
                        // Pārvieto augšupielādēto failu uz norādīto ceļu
                        move_uploaded_file($fileTmpName, $newPhotoPath);
                    } else {
                        // Ja fails pārsniedz maksimālo atļauto izmēru
                        $error[] = "Faila izmērs ir pārāk liels";
                        $newPhotoPath = null;
                        header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                    }
                } else {
                    // Ja radās kļūda, augšupielādējot failu
                    $error[] = "Radās kļūda, ielādējot failu";
                    $newPhotoPath = null;
                    header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                }
            } else {
                // Ja faila paplašinājums nav atļauts
                $error[] = "Faila formāts nav atļauts";
                $newPhotoPath = null;
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
            }
        }

        // Pārbauda, vai jaunais e-pasta adrese jau netiek izmantota citam lietotājam
        $check_query = "SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '" . $new_E_pasts_pardevejs . "' AND Pardevejs_ID != '" . $Pardevejs_ID . "'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Ja adrese jau tiek izmantota
            $error[] = 'Šī e-pasta adrese jau tiek izmantota!';
        } else {
            // Izveido vaicājumu, lai atjauninātu datus datu bāzē
            $query = "UPDATE `pardevejs` SET `E_pasts_pardevejs`='" . $new_E_pasts_pardevejs . "', `T_numurs_pardevejs`='" . $new_T_numurs_pardevejs . "'
                , `Apraksts`='" . $new_Apraksts . "'";

            // Ja ir jauna fotogrāfija, pievieno attēla ceļu vaicājumam
            if (!is_null($newPhotoPath)) {
                $query .= ", `Attela_URL`='" . $newPhotoPath . "'";
            }

            $query .= " WHERE `Pardevejs_ID`='" . $Pardevejs_ID . "'";

            if (mysqli_query($conn, $query)) {
                if (!empty($error)) {
                    foreach ($error as $errorMsg) {
                        // Vēlamā darbība ar kļūdas ziņām
                    }
                } else {
                    // Ja dati ir veiksmīgi atjaunināti, pārvirza uz attiecīgo lapu
                    header('location:about_me.php');
                }
            } else {
                // Ja radās kļūda, izpildot vaicājumu
                $errorMsg = "Kļūda" . mysqli_error($conn) . " with query: " . $query;
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profilu administrēšana</title>
        <link rel="stylesheet" href="css/cssForMaster.css">
        <link rel="stylesheet" href="../assets/css/login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>
        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar">
                <a href="about_me.php" class="active">Statistika/Profils</a>
                <a href="my_products.php">Preces </a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Rediģēt</h3>
                <?php
                //Šī forma ietver dažādus ievades laukus un pogas, kas ļauj lietotājam rediģēt informāciju. Kods atbild par attēla augšupielādi, jaunu e-pasta adreses, 
                //  telefona numura un apraksta ievadi. 
                //  Ja ir kļūdas, tās tiek parādītas kā kļūdu ziņas. Forma arī ietver pogu, kas atgriež lietotāju atpakaļ uz "about_me.php" lapu.
                if (!empty($error)) {
                    foreach ($error as $errorMsg) {
                        echo '<span class="error-msg">' . $errorMsg . '</span>';
                    }
                }
                ?>
                <input type="file" name="newPhoto" title="Logo" accept=".jpg,.jpeg,.png,.gif">
                <input type="email" name="E_pasts_pardevejs" required value="<?php echo $E_pasts_pardevejs ?>">
                <input type="tel" name="T_numurs_pardevejs"
                    value="<?php echo ($T_numurs_pardevejs && $T_numurs_pardevejs[0] === '+') ? $T_numurs_pardevejs : '+371'; ?>">
                <textarea name="Apraksts" placeholder="Apraksts" style="height:200px;"><?php echo $Apraksts ?></textarea>
                <input type="submit" name="update" value="Rediģēt" class="form-btn">
                <a href="about_me.php" title="Atpakaļ" class="btn">Atpakaļ</a>
            </form>


            <?php include '../admin/footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>