<?php
require("admin/config.php");
session_start();
if (isset($_POST['add'])) {
    // Pārbaude un sagatavošana ievadītajiem datiem
    $Vards_pardevejs = mysqli_real_escape_string($conn, $_POST['Vards_pardevejs']);
    $Uzvards_pardevejs = mysqli_real_escape_string($conn, $_POST['Uzvards_pardevejs']);
    $E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);
    $T_numurs_pardevejs = mysqli_real_escape_string($conn, $_POST['T_numurs_pardevejs']);
    $Apraksts = mysqli_real_escape_string($conn, $_POST['Apraksts']);
    $Brenda_nosaukums = mysqli_real_escape_string($conn, $_POST['Brenda_nosaukums']);
    $Attela_URL = mysqli_real_escape_string($conn, $_POST['Attela_URL']);
    $Parole_pardevejs = md5($_POST['Parole_pardevejs']);

    // Apstrādā attēla augšupielādi
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExt = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileExt, $allowedExt)) {
        if ($fileError === 0) {
            if ($fileSize < 500000) {
                $newFileName = uniqid('', true) . "." . $fileExt;
                $fileDestination = 'admin/uploads/' . $newFileName;
                move_uploaded_file($fileTmpName, $fileDestination);

                // Pārbaude vai e-pasta adrese jau ir izmantota
                $select = " SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '$E_pasts_pardevejs' ";
                $result = mysqli_query($conn, $select);
                if (mysqli_num_rows($result) > 0) {
                    $error[] = 'Šī e-pasta adrese jau tiek izmantota.';
                } else {
                    // Jauna pardevēja ievietošana datubāzē
                    mysqli_query($conn, "INSERT INTO `pardevejs`(`Vards_pardevejs`, `Uzvards_pardevejs`, `E_pasts_pardevejs`, `T_numurs_pardevejs`, `Apraksts`, `Brenda_nosaukums`, `Attela_URL`, `Parole_pardevejs`) 
                              VALUES ('$Vards_pardevejs','$Uzvards_pardevejs','$E_pasts_pardevejs','$T_numurs_pardevejs','$Apraksts','$Brenda_nosaukums','$fileDestination','$Parole_pardevejs')");
                    header('location:admin/welcome.php');
                }
            } else {
                $error[] = 'Faila izmērs ir pārāk liels';
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);
            }
        } else {
            $error[] = 'Nepareizs faila formāts';
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
    <title>Pārdevēja pieteikšanās forma</title>
    <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="admin/css/css.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <header>
        <a class="logo"><span style="font-weight: bold; color: white;">Pārdevēja </span> reģistrācijas
            forma</a>
        <button class="menu-toggle" aria-label="Toggle navigation menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="navbar">
            <a href="index.php">Sākumlapa</a>
            <a href="shop.php">Preces</a>
            <a href="masters.php">Pārdevēji</a>
            <a href="policy.php">Mūsu politika</a>
            <a href="login_master.php" class="active"></i>Pieslēgties / Reģistrācija</a>
            <a href="login_admin.php"><i class="fa-solid fa-user-lock"></i></a>
        </nav>
    </header>

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Reģistrācija</h3>
            <?php
            if (!empty($error)) {
                foreach ($error as $errorMsg) {
                    echo '<span class="error-msg">' . $errorMsg . '</span>';
                }
            }
            //Forma ietver ievades laukus, kur lietotājs ievada savus datus, kā arī pogu "Reģistrēt" un saites uz sākumlapu un ienākšanu, ja jau ir reģistrēts. 
            //Pēc formu iesniegšanas dati tiks nosūtīti uz tādu pašu lapu (action=""), 
            //kur notiks datu apstrāde un ievietošana datubāzē, kā redzēts iepriekšējā PHP kodā.
            ?>
            <input type="text" name="Vards_pardevejs" required placeholder="Vārds">
            <input type="text" name="Uzvards_pardevejs" required placeholder="Uzvārds">
            <input type="email" name="E_pasts_pardevejs" required placeholder="E-pasts">
            <input type="text" name="T_numurs_pardevejs" placeholder="Telefona numurs (Nav obligāts)">
            <textarea name="Apraksts" placeholder="Apraksts (Nav obligāts)" style="height: 200px;"></textarea>
            <input type="text" name="Brenda_nosaukums" required placeholder="Brenda nosaukums">
            <input type="file" name="image" required title="Logo">
            <input type="password" name="Parole_pardevejs" required placeholder="Parole">
            <input type="submit" name="add" value="Reģistrēt" class="form-btn">
            <a class='btn' title='Sākumlapa' href='index.php'>Sākumlapa</a>
            <p>Esi jau reģistrējies? <a href="login_master.php">Ienākt</a></p>

        </form>


        <?php include 'admin/footer_adm.php'; ?>
        <script>
            //Šis kods ir JavaScript kods, kas nodrošina funkcionalitāti izvēlnes atvēršanai un aizvēršanai, kad tiek noklikšķināts uz izvēlnes poga. (Maziem ekrāniem)
            const menuToggle = document.querySelector('.menu-toggle');
            const navbar = document.querySelector('.navbar');

            menuToggle.addEventListener('click', () => {
                navbar.classList.toggle('show');
            });</script>

</body>

</html>