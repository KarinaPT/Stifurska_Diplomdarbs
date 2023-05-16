<?php

require("../admin/config.php");
session_start();
$Pardevejs_ID = $_GET['Pardevejs_ID'];
if (isset($_SESSION['user_name'])) {

    if (isset($_POST['update'])) {

        $new_password = md5($_POST['Parole_pardevejs']);
       
            // Иначе, обновляем запись в базе данных
            mysqli_query($conn, "UPDATE `pardevejs` SET `Parole_pardevejs`='" . $new_password . "'
             WHERE `Pardevejs_ID`='" . $Pardevejs_ID . "'");
            header("location:../admin/confirmation.php");
        
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
            <form action="" method="post">
                <h3>Rediģēt</h3>
                <?php
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                    ;
                }
                ;
                ?>
                <input type="password" name="Parole_pardevejs" required placeholder="Parole">
                <input type="submit" title="Rediģēt" name="update" value="Rediģēt" class="form-btn">
                <input type="button" onclick="history.back();" title="Statistika" value="Atpakaļ" class="form-btn ">
            </form>


            <footer>
                Kiriyena © 2023 Small start = Big deal</br>
                Designed by Kiriyena
            </footer>
            <?php
}
?>
</body>

</html>