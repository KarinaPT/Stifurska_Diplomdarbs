<?php

require("../admin/config.php");
session_start();
$Pardevejs_ID = $_GET['Pardevejs_ID'];

if (isset($_SESSION['user_name'])) {
    if (isset($_POST['update'])) {
        $old_password = $_POST['Old_password'];
        $new_password = $_POST['New_password'];
        $confirm_password = $_POST['Confirm_password'];

        // Проверяем, соответствует ли введенный старый пароль текущему паролю в базе данных
        $query = "SELECT `Parole_pardevejs` FROM `pardevejs` WHERE `Pardevejs_ID`='" . $Pardevejs_ID . "'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $current_password = $row['Parole_pardevejs'];

        if (md5($old_password) == $current_password) {
            // Проверяем, совпадают ли новый пароль и подтверждение пароля
            if ($new_password == $confirm_password) {
                // Обновляем запись в базе данных
                $new_password = md5($new_password);
                mysqli_query($conn, "UPDATE `pardevejs` SET `Parole_pardevejs`='" . $new_password . "'
                 WHERE `Pardevejs_ID`='" . $Pardevejs_ID . "'");
                header("location:../admin/confirmation.php");
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
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                }
                ?>
                <input type="password" name="Old_password" required placeholder="Vecā parole">
                <input type="password" name="New_password" required placeholder="Jaunā parole">
                <input type="password" name="Confirm_password" required placeholder="Apstiprināt jauno paroli">
                <input type="submit" title="Rediģēt" name="update" value="Rediģēt" class="form-btn">
                <a href="about_me.php" title="Atpakaļ" class="btn">Atpakaļ</a>
            </form>


            <?php include '../admin/footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>