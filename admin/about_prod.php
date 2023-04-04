<?php
    require("config.php");
    session_start();
   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preču administrācija</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <a class="logo">Administrēšanas panelis</a>
        <nav class="navbar">
            <a href="statistics.php">Statistika/Profils</a>
            <a href="all_products.php" class="active">Preces</a>
            <a href="all_masters.php" >Pārdevēji</a>
            <a href="category.php">Kategorijas</a>
            <a href="../index.html"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

<section id="description">
    <h1>Detalizēts preču apraksts</h1>
    <div class="box-container">
        <div class='box'>
            <?php 
                $apraksts_preceSQL = "SELECT * FROM prece"; 
                $atlasa_apraksts = mysqli_query($conn, $apraksts_preceSQL) or die ("Nekorekts vaicājums");

                if(mysqli_num_rows($atlasa_apraksts) >0){
                     while($row = mysqli_fetch_assoc($atlasa_apraksts)){
                        echo "
                            <img src='{$row['Attela_prece']}'>
                            <h3>{$row['Nosaukums_prece']}</h3>
                            <p><b>Cena: </b>{$row['Cena']}€</p>
                            <p><b>Pārdevējs: </b>{$row['ID_Pardevejs']}</p>
                            <p><b>Apraksts: </b>{$row['Apraksts_prece']}</p>
                            <p><b>Statuss: </b>{$row['Statuss']}</p>
                            <p><b>Īpatnības: </b>{$row['Ipatnibas_prece']}</p>
                            ";  
					}
                }else{
                    echo "Tabula nav datu ko attēlot";
                }
            ?>  
            <input type="button" onclick="history.back();" value="Atpakaļ" class="btn ">
        </div>
                                    
    </div>
</section>

<footer>
    Kiriyena © 2023 Small start = Big deal</br>
    Designed by Kiriyena
</footer>

</body>
</html>