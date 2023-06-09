<?php
// Importēt nepieciešamos failus un sākt sesiju
require("config.php");
session_start();

// Iegūt administratora ID, e-pastu un tālruņa numuru no GET parametriem
$Administrators_ID = $_GET['Administrators_ID'];
$E_pasts = $_GET['E_pasts'];
$T_numurs = $_GET['T_numurs'];

// Pārbauda vai administrators ir ielogojies
if (isset($_SESSION['admin_name'])) {

    // Pārbaudīt, vai ir iesniegts atjaunināšanas formas pieprasījums
    if (isset($_POST['update'])) {

        // Iegūt jauno e-pastu un tālruņa numuru ar aizsardzību pret SQL injekcijām
        $new_E_pasts = mysqli_real_escape_string($conn, $_POST['E_pasts']);
        $new_T_numurs = mysqli_real_escape_string($conn, $_POST['T_numurs']);

        // Pārbauda vai jaunais e-pasts jau netiek izmantots citam administratoram
        $check_query = "SELECT * FROM administrators WHERE E_pasts = '" . $new_E_pasts . "' AND Administrators_ID != '" . $Administrators_ID . "'";
        $check_result = mysqli_query($conn, $check_query);

        // Ja ir atrasti rezultāti, tas nozīmē, ka e-pasts jau tiek izmantots citam administratoram
        if (mysqli_num_rows($check_result) > 0) {

            $error[] = 'Šī e-pasta adrese jau tiek izmantota!';
        } else {

            // Jaunināt administratora informāciju datubāzē
            mysqli_query($conn, "UPDATE `administrators` SET `E_pasts`='" . $new_E_pasts . "', `T_numurs`='" . $new_T_numurs . "' WHERE `Administrators_ID`='" . $Administrators_ID . "'");
            header("location: statistics.php");
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
        <link rel="stylesheet" href="css/css.css">
        <link rel="stylesheet" href="../assets/css/login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>
        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar">
                <a href="statistics.php" class="active">Statistika/Profils</a>
                <a href="all_products.php">Preces</a>
                <a href="all_masters.php">Pārdevēji</a>
                <a href="category.php">Kategorijas</a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <div class="form-container">
            <form action="" method="post">
                <h3>Rediģēt</h3>
                <?php
                 // Izvada kļūdas ziņas, ja tādas ir
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                    ;
                }
                ;
                ?>
                <input type="email" name="E_pasts" required value="<?php echo $E_pasts ?>">
                 <!-- Lauks, kurā ievadīt administratora e-pastu, iepriekšējo vērtību iestatīts uz $E_pasts -->
                <input type="tel" name="T_numurs"
                    value="<?php echo ($T_numurs && $T_numurs[0] === '+') ? $T_numurs : '+371'; ?>">
                <!-- Lauks, kurā ievadīt administratora tālruņa numuru, iepriekšējo vērtību iestatīts uz $T_numurs -->
                <input type="submit" title='Rediģēt' name="update" value="Rediģēt" class="form-btn">
                <a href="statistics.php" title="Atpakaļ" class="btn">Atpakaļ</a>
            </form>


            <?php include 'footer_adm.php'; ?>
            <?php
}
?>
</body>

</html>