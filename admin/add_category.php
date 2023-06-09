<?php

require("config.php");
session_start();
if (isset($_SESSION['admin_name'])) {

    if (isset($_POST['add'])) {

        // Iegūstam kategorijas nosaukumu no ievades formas
        $Nosaukums_kategorija = mysqli_real_escape_string($conn, $_POST['Nosaukums_kategorija']);

        // Iegūstam attēla faila informāciju
        $file = $_FILES['image']; // Iegūstam faila informāciju no $_FILES masīva, izmantojot atslēgu "image"
        $fileName = $file['name']; // Iegūstam faila nosaukumu
        $fileTmpName = $file['tmp_name']; // Iegūstam pagaidu faila nosaukumu
        $fileSize = $file['size']; // Iegūstam faila izmēru
        $fileError = $file['error']; // Iegūstam kļūdas kodu, ja tāda ir
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Iegūstam faila paplašinājumu
        $allowedExt = array('jpg', 'jpeg', 'png', 'gif'); // Atļautie faila paplašinājumi

        if (in_array($fileExt, $allowedExt)) {
            // Pārbaudām vai faila paplašinājums atrodas atļauto paplašinājumu sarakstā
            // Ja fails atbilst atļauto paplašinājumu sarakstam, turpinām ar pārbaudi
            if ($fileError === 0) {
                // Pārbaudām vai nav radusies kļūda, kas saistīta ar faila augšupielādi
                // Ja nav radusies kļūda, turpinām ar pārbaudi
                if ($fileSize < 500000) {
                    $newFileName = uniqid('', true) . "." . $fileExt; // Izveido jaunu unikālu faila nosaukumu
                    $fileDestination = 'uploads/' . $newFileName; // Norāda atrašanās vietu, kur failu saglabāt

                    // Pārbaudam vai kategorija jau eksistē
                    $select = "SELECT * FROM kategorija WHERE Nosaukums_kategorija = '$Nosaukums_kategorija'";
                    $result = mysqli_query($conn, $select);
                    if (mysqli_num_rows($result) > 0) {
                        $error[] = 'Tāda kategotija jau ir';
                    } else {
                        // Ievietojam jauno kategoriju datubāzē un pārvietojam attēlu uz galamērķa direktoriju
                        mysqli_query($conn, "INSERT INTO `kategorija` (`Nosaukums_kategorija`, `Kat_attela`) 
                        VALUES ('$Nosaukums_kategorija', '$fileDestination')");
                        move_uploaded_file($fileTmpName, $fileDestination);
                        header('location:category.php');
                    }
                } else {
                    $error[] = 'Faila izmērs ir pārāk liels'; // Pievieno kļūdas ziņojumu masīvam
                    header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                }
            } else {
                $error[] = 'Neizdevās augšupielādēt failu'; // Pievieno kļūdas ziņojumu masīvam
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
            }
        } else {
            $error[] = 'Atļautie faila formāti ir: JPG, JPEG, PNG, GIF'; // Pievieno kļūdas ziņojumu masīvam
            header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kategoriju administrēšana</title>
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
                <a href="all_products.php">Preces</a>
                <a href="all_masters.php">Pārdevēji</a>
                <a href="category.php" class="active">Kategorijas / Reģistrācija</a>
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
                <input type="text" name="Nosaukums_kategorija" required placeholder="Kategorija">
                <!-- Ievades lauks, kur lietotājs ievada kategorijas nosaukumu. Obligāts -->
                <input type="file" name="image" required>
                <!-- Faila ielādes lauks, kur lietotājs ielādē attēlu. Obligāts -->
                <input type="submit" name="add" value="Reģistrēt" class="form-btn">
                <a href="category.php" title="Atpakaļ" class="btn">Atpakaļ</a>
            </form>


            <?php include 'footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>