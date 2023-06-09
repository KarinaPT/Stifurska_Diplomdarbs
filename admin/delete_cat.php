<head>
    <link rel="stylesheet" type="text/css" href="../assets/css/confirm.css">
</head>
<?php
// Iestatīt, lai kļūdas tiktu parādītas uz ekrāna
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iekļaut datu bāzes konfigurācijas failu
include('config.php');

// Iegūt kategorijas ID no GET parametra
$id = $_GET['Kategorija_ID'];

// Pārbaudīt, vai ir nospiesta "confirm" poga
if (isset($_POST['confirm'])) {
    // Izveidot dzēšanas vaicājumu
    $query = "DELETE FROM `kategorija` WHERE `Kategorija_ID`='$id'";

    try {
        // Izpildīt dzēšanas vaicājumu
        if (mysqli_query($conn, $query)) {
            // Ja dzēšana ir veiksmīga, izvadīt veiksmes ziņu un pāradresēt uz kategoriju lapu
            echo "<div class='success-message'>Ieraksts veiksmīgi izdzēsts!</div>";
            header("refresh:2;url=category.php");
        } else {
            // Ja dzēšana neizdevās, izvadīt kļūdas ziņu un pāradresēt uz kategoriju lapu
            echo "<div class='error-message'>Neizdevās izdzēst ierakstu! </div>";
            header("refresh:2;url=category.php");
        }
    } catch (mysqli_sql_exception $e) {
        // Ja radās kļūda dzēšanas procesā, izvadīt kļūdas ziņu un pāradresēt uz kategoriju lapu
        echo "<div class='error-message'>Neizdevās izdzēst ierakstu! </div>";
        header("refresh:2;url=category.php");
    }
}
?>

<form method="post">
    <p>Vai tiešām vēlaties dzēst ierakstu?</p>
    <button type="submit" name="confirm">Jā</button>
    <a href="category.php">Nē</a>
</form>