<?php

require("../admin/config.php"); // Iekļauj konfigurācijas failu
session_start(); // Sāk sesiju
$Pardevejs_ID = $_GET['Pardevejs_ID']; // Saņem Pardevejs_ID vērtību no GET parametriem

if (isset($_SESSION['user_name'])) { // Pārbauda, vai lietotājs ir pierakstījies
    if (isset($_POST['update'])) {  // Pārbauda, vai tiek nospiests "update" poga
        $old_password = $_POST['Old_password']; // Iegūst ievadīto veco paroli
        $new_password = $_POST['New_password']; // Iegūst ievadīto jauno paroli
        $confirm_password = $_POST['Confirm_password'];  // Iegūst ievadīto apstiprinājuma paroli

       // Pārbauda, vai ievadītā vecā parole ir pareiza
        $query = "SELECT `Parole_pardevejs` FROM `pardevejs` WHERE `Pardevejs_ID`='" . $Pardevejs_ID . "'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $current_password = $row['Parole_pardevejs'];

        if (md5($old_password) == $current_password) { // Salīdzina ievadīto veco paroli ar esošo paroli (izmantojot md5 heškodu)
           // Pārbauda, vai jaunā parole sakrīt ar apstiprinājuma paroli
            if ($new_password == $confirm_password) {
                 // Jaunā parole tiek saglabāta kā md5 heškods
                $new_password = md5($new_password);
                mysqli_query($conn, "UPDATE `pardevejs` SET `Parole_pardevejs`='" . $new_password . "'
                 WHERE `Pardevejs_ID`='" . $Pardevejs_ID . "'");
                header("location:../admin/confirmation.php");  // Pāradresē uz apstiprinājuma lapu pēc paroles atjaunināšanas
            } else {
                $error[] = "Jaunā parole un apstiprinājuma parole nesakrīt.";
            }
        } else {
            $error[] = "Ievadītā vecā parole nav pareiza.";
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
            <form action="" method="post">
                <h3>Rediģēt</h3>
                <?php
                // Pārbaudu, vai ir kļūdas un izvadam tos kā kļūdas ziņojumus
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                }
                ?>
                <input type="password" name="Old_password" required placeholder="Vecā parole">
                 <!-- Ievades lauks vecās paroles ievadei -->
                <input type="password" name="New_password" required placeholder="Jaunā parole">
                 <!-- Ievades lauks jaunās paroles ievadei -->
                <input type="password" name="Confirm_password" required placeholder="Apstiprināt jauno paroli">
                 <!-- Ievades lauks jaunās paroles apstiprinājumam -->
                <input type="submit" title="Rediģēt" name="update" value="Rediģēt" class="form-btn">
                <a href="about_me.php" title="Atpakaļ" class="btn">Atpakaļ</a>
            </form>


            <?php include '../admin/footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>