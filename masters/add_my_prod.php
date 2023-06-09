<?php
/* Šis PHP kods iekļauj nepieciešamās konfigurācijas faila (config.php) iekļaušanu un sesijas sākšanu. Tas iegūst lietotāja e-pastu no sesijas ($_SESSION['user_name']) 
un veic vaicājumu, lai iegūtu Pardevejs_ID no datubāzes tabulas "pardevejs". Rezultātā tiek iegūts lietotāja ID ($Pardevejs_ID), kas var tikt izmantots turpmākajam kodam.*/
require("../admin/config.php");
session_start();

$email = $_SESSION['user_name'];
$query = "SELECT Pardevejs_ID FROM pardevejs WHERE E_pasts_pardevejs = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$Pardevejs_ID = $user['Pardevejs_ID'];

if (isset($_SESSION['user_name'])) {
    if (isset($_POST['add'])) {
        // Saglabāju saņemtos datus no lietotāja ievades formas
        $Nosaukums_prece = mysqli_real_escape_string($conn, $_POST['Nosaukums_prece']);
        $Cena = mysqli_real_escape_string($conn, $_POST['Cena']);
        $Apraksts_prece = mysqli_real_escape_string($conn, $_POST['Apraksts_prece']);
        $Attela_prece = mysqli_real_escape_string($conn, $_POST['Attela_prece']);
        $Ipatnibas_prece = mysqli_real_escape_string($conn, $_POST['Ipatnibas_prece']);
        $Kategorija_ID = mysqli_real_escape_string($conn, $_POST['Kategorija_ID']);
        $Kapakssadala_ID = mysqli_real_escape_string($conn, $_POST['Kapakssadala_ID']);

        $file = $_FILES['image']; // Iegūstu faila informāciju no ievades
        $fileName = $file['name']; // Iegūstu faila nosaukumu
        $fileTmpName = $file['tmp_name']; // Iegūstu pagaidu faila nosaukumu
        $fileSize = $file['size']; // Iegūstu faila izmēru
        $fileError = $file['error']; // Iegūstu kļūdas kodu, ja tāda ir
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Iegūstu faila paplašinājumu (bez lielajiem burtiem)
        $allowedExt = array('jpg', 'jpeg', 'png', 'gif'); // Atļautie faila paplašinājumi
        if (in_array($fileExt, $allowedExt)) {
            // Pārbauda, vai faila paplašinājums ir atļauts.
            if ($fileError === 0) {
                 // Pārbauda, vai nav kļūdas, ielādējot failu.
                if ($fileSize < 500000) {
                    // Pārbauda, vai faila izmērs ir mazāks par 500 000 baitiem.
                    $newFileName = uniqid('', true) . "." . $fileExt;
                    $fileDestination = 'uploads/' . $newFileName;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    // Saglabājam datus datu bāzē
                    mysqli_query($conn, "INSERT INTO `prece`(`Nosaukums_prece`, `Cena`, `Apraksts_prece`, `Attela_prece`, `Ipatnibas_prece`, `ID_Pardevejs`, `IDKapakssadala`, `ID_Kategorija`) 
        VALUES ('$Nosaukums_prece','$Cena','$Apraksts_prece','$fileDestination','$Ipatnibas_prece','$Pardevejs_ID','$Kapakssadala_ID','$Kategorija_ID')");

                    header('location:my_products.php');
                } else {
                    // Ja faila izmērs ir pārāk liels, parādām kļūdas paziņojumu
                    $error[] = 'Faila izmērs ir pārāk liels';
                    header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                }
            } else {
                // Ja radās kļūda augšupielādes procesā, parādām kļūdas paziņojumu
                $error[] = 'Neizdevās augšupielādēt failu';
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
            }
        } else {
            // Ja faila formāts nav atļauts, parādām kļūdas paziņojumu
            $error[] = 'Atļautie faila formāti ir: JPG, JPEG, PNG, GIF';
            header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
        }
    } else {

        $kategorija = mysqli_query($conn, 'SELECT * FROM kategorija');
        $k_apakssadala = mysqli_query($conn, 'SELECT * FROM k_apakssadala');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preču administrēšana</title>
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
                <a href="my_products.php" class="active">Preces / Reģistrācija </a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Reģistrācija</h3>
                <?php
                // Pārbaudu, vai ir kļūdas un izvadam tos kā kļūdas ziņojumus
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                    ;
                }
                ;
                ?>
                <input type="text" name="Nosaukums_prece" required placeholder="Nosaukums">
                <!-- Ievades lauks, kur lietotājs ievada preces nosaukumu. Obligāts -->
                <input type="number" step="00.01" name="Cena" required placeholder="Cena">
                <!-- Ievades lauks, kur lietotājs ievada preces cenu. Obligāts -->
                <textarea name="Apraksts_prece" required placeholder="Apraksts" style="height:200px;"></textarea>
                <!-- Teksta lauks, kur lietotājs ievada preces aprakstu. Obligāts -->
                <input type="file" name="image" required accept="image/*" title="Fotoattēls">
                <!-- Faila ielādes lauks, kur lietotājs ielādē attēlu. Obligāts -->
                <textarea name="Ipatnibas_prece" placeholder="Īpatnības" style="height: 200px;"></textarea>
                <!-- Teksta lauks, kur lietotājs ievada preces īpašības -->
                <select name="Kategorija_ID" id="Kategorija_ID" required="true">
                    <option value="" disabled selected hidden>Kategorija</option>
                    <?php
                    // Iegūstu visus pieejamos kategoriju nosaukumus un tos attēlojam kā izvēles opcijas
                    $sql = "SELECT Kategorija_ID, Nosaukums_kategorija FROM kategorija";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <option value="<?= $row['Kategorija_ID'] ?>"><?= $row['Nosaukums_kategorija'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <select name="Kapakssadala_ID" required="true">
                    <option value="" disabled selected hidden>Apakškategorija</option>
                    <?php
                    // Iegūstu visus pieejamos apakškategoriju nosaukumus un tos attēlojam kā izvēles opcijas
                    if (mysqli_num_rows($k_apakssadala) > 0) {
                        while ($row = mysqli_fetch_assoc($k_apakssadala)) {
                            ?>
                            <option value="<?= $row['Kapakssadala_ID'] ?>"><?= $row['Nosaukums_sadala'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <input type="submit" title="Reģistrēt" name="add" value="Reģistrēt" class="form-btn">
                <input type="button" onclick="history.back();" title="Atpakaļ" value="Manas preces" class="form-btn ">
            </form>

            <?php include '../admin/footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>