<head>
	<link rel="stylesheet" type="text/css" href="../assets/css/confirm.css">
</head>

<?php
// Šīs trīs rindiņas iestata kļūdu ziņojumu parādīšanu un reģistrēšanu.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Konfigurācijas fails
include('../admin/config.php'); 
// Preces ID no GET parametriem
$id = $_GET['prece_ID']; 

// Pārbaude, vai ir iesniegts apstiprinājuma vaicājums
if (isset($_POST['confirm'])) { 
	// Vaicājums, lai dzēstu ierakstu no datubāzes
	$query = "DELETE FROM `prece` WHERE `prece_ID`='$id'"; 
	try {
		if (mysqli_query($conn, $query)) {
			// Veiksmīgas dzēšanas paziņojums
			echo "<div class='success-message'>Ieraksts veiksmīgi izdzēsts!</div>";
			header("refresh:2;url=my_products.php");
		} else {
			// Neizdevās dzēst ierakstu, jo tas ir saistīts ar citiem datiem
			echo "<div class='error-message'>Neizdevās izdzēst ierakstu: šis ID tiek izmantots</div>";
			echo "<div class='error-message'>Jūs tiksiet pāradresēts uz iepriekšējo lapu pēc 3 sekundēm.</div>";
			header("refresh:2;url=my_products.php");
		}
	} catch (mysqli_sql_exception $e) {
		// Neizdevās izpildīt dzēšanas vaicājumu
		echo "<div class='error-message'>Neizdevās izdzēst ierakstu! </div>";
		header("refresh:2;url=my_products.php");
	}
}
?>

<form method="post">
	<p>Vai tiešām vēlaties dzēst ierakstu?</p> 
	<button type="submit" name="confirm">Jā</button> 
	<a href="my_products.php">Nē</a> 
</form>