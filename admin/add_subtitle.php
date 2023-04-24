<?php

require("config.php");
session_start();
if(isset($_SESSION['admin_name'])){

    if(isset($_POST['add'])){
        $Nosaukums_sadala = mysqli_real_escape_string($conn, $_POST['Nosaukums_sadala']);
        $Kategorija_ID = mysqli_real_escape_string($conn, $_POST['Kategorija_ID']);
    
        // Проверяем, существует ли уже такое значение поля Nosaukums_sadala
        $result = mysqli_query($conn, "SELECT * FROM k_apakssadala WHERE Nosaukums_sadala = '$Nosaukums_sadala'");
        if(mysqli_num_rows($result) > 0){
            // Если значение уже существует, то выводим сообщение об ошибке
            header('location:error.php');
            
        }else{
            mysqli_query($conn,"INSERT INTO `k_apakssadala`(`Nosaukums_sadala`, `ID_Kategorija`) 
            VALUES ('$Nosaukums_sadala','$Kategorija_ID')");
            header('location:category.php');   
        }
    }else{
        $kategorija = mysqli_query($conn, 'SELECT * FROM kategorija');

    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategoriju apakšsadaļu administrēšana</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <a class="logo">Administrēšanas panelis</a>
        <nav class="navbar">
            <a href="statistics.php">Statistika/Profils</a>
            <a href="all_products.php">Preces</a>
            <a href="all_masters.php" >Pārdevēji</a>
            <a href="category.php"  class="active">Kategorijas / Reģistrācija</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <div class="form-container">
        <form action="" method="post">
            <h3>Reģistrācija</h3>
            <input type="text" name="Nosaukums_sadala" required placeholder="Kategorijas apakšsadaļas nosaukums">
            <select name="Kategorija_ID" required="true">
                <option value="" disabled selected hidden>Kategorija</option>
                     <?php
                        if(mysqli_num_rows($kategorija) >0){
                             while($row = mysqli_fetch_assoc($kategorija)){
                    ?>
                         <option  value="<?=$row['Kategorija_ID']?>"><?=$row['Nosaukums_kategorija']?></option>
                    <?php
                            }
                        }
                     ?>
            </select>

            <input type="submit" name="add" value="Reģistrēt" class="form-btn">
            <input type="button" onclick="history.back();" value="Atpakaļ" class="form-btn ">
        </form>


    <footer>
        Kiriyena © 2023 Small start = Big deal</br>
        Designed by Kiriyena
    </footer>
<?php
   }
?>
</body>
</html>