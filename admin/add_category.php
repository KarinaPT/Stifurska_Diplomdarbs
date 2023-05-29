<?php

require("config.php");
session_start();
if (isset($_SESSION['admin_name'])) {

    if (isset($_POST['add'])) {

        $Nosaukums_kategorija = mysqli_real_escape_string($conn, $_POST['Nosaukums_kategorija']);
        $file = $_FILES['image'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExt, $allowedExt)) {
            if ($fileError === 0) {
                    if ($fileSize < 500000) { // maximum file size allowed
                        $newFileName = uniqid('', true) . "." . $fileExt;
                        $fileDestination = 'uploads/' . $newFileName;
                        // check if category already exists
                        $select = "SELECT * FROM kategorija WHERE Nosaukums_kategorija = '$Nosaukums_kategorija'";
                        $result = mysqli_query($conn, $select);
                        if (mysqli_num_rows($result) > 0) {
                            $error[] = 'Tāda kategotija jau ir';
                        } else {
                            // save the file path to database
                            mysqli_query($conn, "INSERT INTO `kategorija` (`Nosaukums_kategorija`, `Kat_attela`) 
                        VALUES ('$Nosaukums_kategorija', '$fileDestination')");
                            move_uploaded_file($fileTmpName, $fileDestination);
                            header('location:category.php');
                        }
                    } else {
                        $error[] = 'Faila izmērs ir pārāk liels';
                        header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                    }
            } else {
                $error[] = 'Neizdevās augšupielādēt failu';
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
            }
        } else {
            $error[] = 'Atļautie faila formāti ir: JPG, JPEG, PNG, GIF';
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
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                    ;
                }
                ;
                ?>
                <input type="text" name="Nosaukums_kategorija" required placeholder="Kategorija">
                <input type="file" name="image" required>
                <input type="submit" name="add" value="Reģistrēt" class="form-btn">
                <a href="category.php" title="Atpakaļ" class="btn">Atpakaļ</a>
            </form>


            <?php include 'footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>