<?php
require("../admin/config.php");
session_start();
if (isset($_SESSION['user_name'])) {
    $prece_ID = $_GET['prece_ID'];
    $Nosaukums_prece = $_GET['Nosaukums_prece'];
    $Cena = $_GET['Cena'];
    $Statuss = $_GET['Statuss'];
    $Apraksts_prece = $_GET['Apraksts_prece'];
    $Ipatnibas_prece = $_GET['Ipatnibas_prece'];
    $Nosaukums_kategorija = $_GET['Nosaukums_kategorija'];
    $Nosaukums_sadala = $_GET['Nosaukums_sadala'];


    if (isset($_POST['update'])) {

        $Nosaukums_prece = mysqli_real_escape_string($conn, $_POST['Nosaukums_prece']);
        $Cena = mysqli_real_escape_string($conn, $_POST['Cena']);
        $Statuss = mysqli_real_escape_string($conn, $_POST['Statuss']);
        $Apraksts_prece = mysqli_real_escape_string($conn, $_POST['Apraksts_prece']);
        $Ipatnibas_prece = mysqli_real_escape_string($conn, $_POST['Ipatnibas_prece']);
        $Kapakssadala_ID = mysqli_real_escape_string($conn, $_POST['Kapakssadala_ID']);
        $Kategorija_ID = mysqli_real_escape_string($conn, $_POST['Kategorija_ID']);

        $newPhotoPath = null;
        if (!empty($_FILES['newPhoto']['name'])) {
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
                        $newPhotoPath = "uploads/" . uniqid('', true) . "." . $fileActualExt;
                        move_uploaded_file($fileTmpName, $newPhotoPath);
                    } else {
                        $error[] = "Faila izmērs ir pārāk liels";
                        $newPhotoPath = null; // Установите $newPhotoPath в null, чтобы избежать обновления пути файла
                        header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $error[] = "Radās kļūda, ielādējot failu";
                    $newPhotoPath = null; // Установите $newPhotoPath в null, чтобы избежать обновления пути файла
                    header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
                }
            } else {
                $error[] = "Faila formāts nav atļauts";
                $newPhotoPath = null; // Установите $newPhotoPath в null, чтобы избежать обновления пути файла
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

        if (!is_null($newPhotoPath)) {
            $query .= ", `Attela_prece`='" . $newPhotoPath . "'";
        }

        $query .= " WHERE `prece_ID`='" . $prece_ID . "'";

        if (mysqli_query($conn, $query)) {
            if (!empty($error)) {
                foreach ($error as $errorMsg) {
                }
            } else {
                header('location:my_products.php');
            }
        } else {
            $errorMsg = "Ошибка при обновлении данных: " . mysqli_error($conn) . " with query: " . $query;
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

                if (!empty($error)) {
                    foreach ($error as $errorMsg) {
                        echo '<span class="error-msg">' . $errorMsg . '</span>';
                    }
                }
                ?>

                <input type="text" name="Nosaukums_prece"
                    value="<?php echo $Nosaukums_prece; ?>"><!--Это текстовое поле требует от пользователя ввести цену товара и является обязательным для заполнения.  "placeholder" указывает, что ожидается ввод названия товара.-->
                <input type="text" name="Cena" value="<?php echo $Cena; ?>">
                <textarea name="Apraksts_prece" style="height: 200px;"><?php echo $Apraksts_prece; ?></textarea>
                <textarea name="Ipatnibas_prece" style="height: 200px;"><?php echo $Ipatnibas_prece; ?></textarea>
                <input type="file" name="newPhoto" title="Fotoattēls" accept=".jpg,.jpeg,.png,.gif">
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
                </select>
                <select name="Kategorija_ID">
                    <?php
                    $kat_query = "SELECT `Kategorija_ID`, `Nosaukums_kategorija` FROM `kategorija` WHERE `Nosaukums_kategorija` = '" . $Nosaukums_kategorija . "'";
                    $kat_result = mysqli_query($conn, $kat_query);
                    $row = mysqli_fetch_assoc($kat_result);
                    $Kategorija_ID = $row['Kategorija_ID'];

                    $result = mysqli_query($conn, "SELECT * FROM kategorija");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($row['Kategorija_ID'] == $Kategorija_ID) ? 'selected' : '';
                        echo "<option value='" . $row['Kategorija_ID'] . "' " . $selected . ">" . $row['Nosaukums_kategorija'] . "</option>";
                    }
                    ?>
                </select>

                <select name="Kapakssadala_ID">
                    <?php
                    $sublile_query = "SELECT `Kapakssadala_ID`, `Nosaukums_sadala` FROM `k_apakssadala` WHERE `Nosaukums_sadala` = '" . $Nosaukums_sadala . "'";
                    $sublile_result = mysqli_query($conn, $sublile_query);
                    $row_sub = mysqli_fetch_assoc($sublile_result);
                    $Kapakssadala_ID = $row_sub['Kapakssadala_ID'];
                    $query = "SELECT * FROM k_apakssadala";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($row['Kapakssadala_ID'] == $Kapakssadala_ID) ? 'selected' : '';
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