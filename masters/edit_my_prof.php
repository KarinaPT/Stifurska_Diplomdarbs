<?php

require("../admin/config.php");
session_start();
$Pardevejs_ID = $_GET['Pardevejs_ID'];
$E_pasts_pardevejs = $_GET['E_pasts_pardevejs'];
$T_numurs_pardevejs = $_GET['T_numurs_pardevejs'];
$Apraksts = $_GET['Apraksts'];
$error = array();
if (isset($_SESSION['user_name'])) {


    if (isset($_POST['update'])) {

        $new_E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);
        $new_T_numurs_pardevejs = mysqli_real_escape_string($conn, $_POST['T_numurs_pardevejs']);
        $new_Apraksts = mysqli_real_escape_string($conn, $_POST['Apraksts']);

        $newPhotoPath = null;

        if (!empty($_FILES['newPhoto']['name'])) {
            // Проверяем, был ли выбран новый файл изображения
            $file = $_FILES['newPhoto'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];
        
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
        
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
        
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 500000) {
                        // Если новый файл выбран и прошел все проверки, сохраняем его в папке "uploads"
                        $newPhotoPath = "uploads/" . uniqid('', true) . "." . $fileActualExt;
                        move_uploaded_file($fileTmpName, $newPhotoPath);
                    } else {
                        // Если новый файл слишком большой, добавляем ошибку в массив ошибок
                        $error[] = "Faila izmērs ir pārāk liels";
                        $newPhotoPath = null; // Установите $newPhotoPath в null, чтобы избежать обновления пути файла
                        header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                    }
                } else {
                    // Если при загрузке нового файла произошла ошибка, добавляем ошибку в массив ошибок
                    $error[] = "Radās kļūda, ielādējot failu";
                    $newPhotoPath = null; // Установите $newPhotoPath в null, чтобы избежать обновления пути файла
                    header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                }
            } else {
                // Если формат нового файла не соответствует разрешенным форматам, добавляем ошибку в массив ошибок
                $error[] = "Faila formāts nav atļauts";
                $newPhotoPath = null; // Установите $newPhotoPath в null, чтобы избежать обновления пути файла
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);  
            }
        }
        
        // Проверяем, есть ли уже другой пользователь с таким же email
        $check_query = "SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '" . $new_E_pasts_pardevejs . "' AND Pardevejs_ID != '" . $Pardevejs_ID . "'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            // Если есть, выводим сообщение об ошибке
            $error[] = 'Šī e-pasta adrese jau tiek izmantota!';
        } else {
            // Иначе, обновляем запись в базе данных
            $query = "UPDATE `pardevejs` SET `E_pasts_pardevejs`='" . $new_E_pasts_pardevejs . "', `T_numurs_pardevejs`='" . $new_T_numurs_pardevejs . "'
                , `Apraksts`='" . $new_Apraksts . "'";
        
            if (!is_null($newPhotoPath)) {
                $query .= ", `Attela_URL`='" . $newPhotoPath . "'";
            }
        
            $query .= " WHERE `Pardevejs_ID`='" . $Pardevejs_ID . "'";
        
            if (mysqli_query($conn, $query)) {
                if (!empty($error)) {
                    foreach ($error as $errorMsg) {
                    }
                } else {
                    header('location:about_me.php');
                }
            } else {
                $errorMsg = "Ошибка при обновлении данных: " . mysqli_error($conn) . " with query: " . $query;
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
                
                if (!empty($error)) {
                    foreach ($error as $errorMsg) {
                        echo '<span class="error-msg">' . $errorMsg . '</span>';
                    }
                }
                ?>
                <input type="file" name="newPhoto" title="Logo" accept=".jpg,.jpeg,.png,.gif">
                <input type="email" name="E_pasts_pardevejs" required value="<?php echo $E_pasts_pardevejs ?>">
                <input type="tel" name="T_numurs_pardevejs" required
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