<?php
require("config.php"); // Pieprasa konfigurācijas failu, kas iestatīs savienojumu ar datubāzi
session_start(); // Sāk vai atjauno sesiju

if (isset($_SESSION['admin_name'])) { // Pārbauda, vai ir iestatīta administrators piekļuve
    if (isset($_POST['add'])) { // Pārbauda, vai ir nospiesta pogas "add" nosūtīšanas datums

        // Iegūst un apstrādā ievadītos datus
        $Vards_pardevejs = mysqli_real_escape_string($conn, $_POST['Vards_pardevejs']);
        $Uzvards_pardevejs = mysqli_real_escape_string($conn, $_POST['Uzvards_pardevejs']);
        $E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);
        $T_numurs_pardevejs = mysqli_real_escape_string($conn, $_POST['T_numurs_pardevejs']);
        $Apraksts = mysqli_real_escape_string($conn, $_POST['Apraksts']);
        $Brenda_nosaukums = mysqli_real_escape_string($conn, $_POST['Brenda_nosaukums']);
        $Attela_URL = mysqli_real_escape_string($conn, $_POST['Attela_URL']);
        $Parole_pardevejs = md5($_POST['Parole_pardevejs']); // Šifrē paroles vērtību, piemēram, izmantojot md5 algoritmu

        $select = " SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '$E_pasts_pardevejs' "; // Pārbauda, vai rezultātu kopā ir vismaz viens ieraksts ar norādīto e-pasta adresi, ja ir, tad rodās kļūda

        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {

            $error[] = 'Tāds E-pasts jau ir';
        } else {

            $file = $_FILES['image']; // Iegūst informāciju par augšupielādēto failu
            $fileName = $file['name']; // Iegūst faila nosaukumu
            $fileTmpName = $file['tmp_name']; // Iegūst pagaidu faila nosaukumu
            $fileSize = $file['size']; // Iegūst faila izmēru
            $fileError = $file['error']; // Iegūst kļūdas kodu, ja tāda ir notikusi pie augšupielādes
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Iegūst faila paplašinājumu (piemēram, jpg, png, utt.)
            $allowedExt = array('jpg', 'jpeg', 'png', 'gif'); // Definē atļautos faila paplašinājumus

            if (in_array($fileExt, $allowedExt)) { // Pārbauda, vai faila paplašinājums atrodas atļauto paplašinājumu sarakstā
                if ($fileError === 0) { // Pārbauda, vai nekļūda ir notikusi pie faila augšupielādes
                    if ($fileSize < 500000) { // Pārbauda, vai faila izmērs ir mazāks par noteikto limitu
                        $newFileName = uniqid('', true) . "." . $fileExt; // Izveido jaunu unikālu faila nosaukumu
                        $fileDestination = 'uploads/' . $newFileName; // Norāda mērķa direktoriju un jauno faila nosaukumu

                        // Pārējais koda bloks, kurā notiek datu ievietošana datubāzē un faila augšupielāde
                        mysqli_query($conn, "INSERT INTO `pardevejs`(`Vards_pardevejs`, `Uzvards_pardevejs`, `E_pasts_pardevejs`, `T_numurs_pardevejs`, `Apraksts`, `Brenda_nosaukums`, `Attela_URL`, `Parole_pardevejs`) 
                                VALUES ('$Vards_pardevejs','$Uzvards_pardevejs','$E_pasts_pardevejs','$T_numurs_pardevejs','$Apraksts','$Brenda_nosaukums','$fileDestination','$Parole_pardevejs')");
                        move_uploaded_file($fileTmpName, $fileDestination);
                        header('location:all_masters.php');
                    } else {
                        $error[] = 'Faila izmērs ir pārāk liels'; // Pievieno kļūdu ziņojumu, ja faila izmērs ir pārāk liels
                        header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']); // Pāradresē uz iepriekšējo lapu pēc 1 sekundes
                    }
                } else {
                    $error[] = 'Neizdevās augšupielādēt failu'; // Pievieno kļūdu ziņojumu, ja ir notikusi kļūda pie faila augšupielādes
                    header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']); // Pāradresē uz iepriekšējo lapu pēc 1 sekundes
                }
            } else {
                $error[] = 'Atļautie faila formāti ir: JPG, JPEG, PNG, GIF'; // Pievieno kļūdu ziņojumu, ja fails nav atļautā formātā
                header("Refresh: 1; url=" . $_SERVER['HTTP_REFERER']);// Pāradresē uz iepriekšējo lapu pēc 1 sekundes
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
        <title>Pārdevēja administrēšana</title>
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
                <a href="all_masters.php" class="active">Pārdevēji / Reģistrācija </a>
                <a href="category.php">Kategorijas</a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Reģistrācija</h3>
                <?php
                // Parāda kļūdas ziņojumus, ja tie ir definēti
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                    ;
                }
                ;
                ?>
                <!-- Šis ir HTML veidlapas kods, kas parāda reģistrācijas formu. Forma tiek iesniegta POST metodes palīdzību, kas nozīmē, ka dati tiks nosūtīti uz pašu lapu. 
                enctype="multipart/form-data" ir nepieciešams, 
                lai ļautu augšupielādēt failus.-->
                <input type="text" name="Vards_pardevejs" required placeholder="Vārds">
                <input type="text" name="Uzvards_pardevejs" required placeholder="Uzvārds">
                <input type="email" name="E_pasts_pardevejs" required placeholder="E-pasts">
                <input type="text" name="T_numurs_pardevejs" placeholder="T.numurs">
                <textarea name="Apraksts" placeholder="Apraksts" style="height: 200px;"></textarea>
                <input type="text" name="Brenda_nosaukums" required placeholder="Brenda nosaukums">
                <input type="file" name="image" accept="image/*" title="Logo" required max-width="400" max-height="400 ">
                <input type="password" name="Parole_pardevejs" required placeholder="Parole">
                <input type="submit" name="add" value="Reģistrēt" title="Reģistrēt" class="form-btn">
                <a href="all_masters.php" title="Atpakaļ" class="btn">Atpakaļ</a>
            </form>

            <?php include 'footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>