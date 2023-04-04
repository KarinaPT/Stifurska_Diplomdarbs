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
    <title>Pārdevēja administrācija</title>
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
        <h1>Informācija par pārdevēju
        </h1>
        <div class="box-container">
            <div class='box'>
                <?php
                    $pardevejsSQL = "SELECT * FROM pardevejs";
                    $atlasa = mysqli_query($conn, $pardevejsSQL) or die ("Nekorekts vaicājums");

                        if(mysqli_num_rows($atlasa) >0){
                            while($row = mysqli_fetch_assoc($atlasa)){
                                echo "                           
                                    <h3>{$row['Brenda_nosaukums']}</h3>
                                    <p><b>Vārds: </b>{$row['Vards_pardevejs']}</p>
                                    <p><b>Uzvārds: </b>{$row['Uzvards_pardevejs']}</p>
                                    <p><b>E-pasts: </b>{$row['E_pasts_pardevejs']}</p>
                                    <p><b>Telefona numurs: </b>{$row['T_numurs_pardevejs']}</p>
                                    <p><b>Preču skaits: </b> 14</p>
                                    <p><b>Loma: </b>{$row['Loma']}</p>
                                ";
                            }
                        }else{
                            echo "Tabula nav datu ko attēlot";
                        }
                                            
                ?>
            </div>                          
        </div>
    </section>

    <footer>
        Kiriyena © 2023 Small start = Big deal</br>
        Designed by Kiriyena
    </footer>

</body>
</html>