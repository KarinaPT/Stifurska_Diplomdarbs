 <!-- Подключение стилей для формы подтверждения удаления -->
 <head>
    <link rel="stylesheet" type="text/css" href="../assets/css/confirm.css">
</head>
<?php
	include('../admin/config.php');  // Подключение к базе данных
	$id=$_GET['prece_ID']; // Получение ID удаляемой записи из URL-адреса
	
	if(isset($_POST['confirm'])){ // Если кнопка "Jā" была нажата
	    $query = "DELETE FROM `prece` WHERE `prece_ID`='$id'"; // Удаление записи из базы данных
		if (mysqli_query($conn, $query)) {
			// Удаление записи из базы данных
			echo "<div class='success-message'>Ieraksts veiksmīgi izdzēsts!</div>";
			header("refresh:2;url=my_products.php");
		} else {
			// Ошибка при удалении записи
			echo "<div class='error-message'>Neizdevās izdzēst ierakstu: šis ID tiek izmantots</div>";
			echo "<div class='error-message'>Jūs tiksiet pāradresēts uz iepriekšējo lapu pēc 3 sekundēm.</div>";
			header("refresh:2;url=my_products.php");
		}
	}
?>

<form method="post">
	<p>Vai tiešām vēlaties dzēst ierakstu?</p>  <!-- Вопрос о подтверждении удаления записи -->
	<button type="submit" name="confirm">Jā</button>  <!-- Кнопка подтверждения удаления записи -->
	<a href="my_products.php">Nē</a> <!-- Ссылка на отмену удаления записи -->
</form>