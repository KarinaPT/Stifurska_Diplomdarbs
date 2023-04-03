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
    <title>Statistika un profilu administrēšana</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <a class="logo">Administrēšanas panelis</a>
        <nav class="navbar">
            <a href="#" class="active">Statistika/Profils</a>
            <a href="all_products.html">Preces</a>
            <a href="all_masters.html" >Pārdevēji</a>
            <a href="category.html">Kategorijas</a>
            <a href="../index.html"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <section id="description">
        <h1>Administratora informācija
        </h1>
        <div class="box-container">
            <?php
                $adminSQL = "SELECT * FROM administrators";
                $output = mysqli_query($conn, $adminSQL)  or die ("Nekorekts vaicājums");
                                            
                if(mysqli_num_rows($output) >0){
                    while($row = mysqli_fetch_assoc($output)){
                        echo "
                            <div class='box'>
                            <img src='{$row['Attela']}'>
                            <p><b>Vārds: </b>{$row['Vards']}</p>
                            <p><b>Uzvārds: </b>{$row['Uzvards']}</p>
                            <p><b>E-pasts: </b>{$row['E_pasts']}</p>
                            <p><b>Telefona numurs: </b>{$row['T_numurs']}</p>
                            <p><b>Loma: </b>{$row['Loma']}</p>
                            </div>
                        ";
                    }
                }else{
                    echo "Tabula nav datu ko attēlot";
                }
            ?>                       
        </div>
    </section>

    <?php 
        $sql ="SELECT COUNT(Prece_ID ) AS total1 from prece";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>
    <?php 
        $sql2 ="SELECT COUNT(Pardevejs_ID) AS total2 from pardevejs ";
        $result2 = mysqli_query($conn, $sql2);
        $data2 = mysqli_fetch_assoc($result2);
    ?>
    <?php 
        $sql3 ="SELECT COUNT(Kategorija_ID) AS total3 from kategorija ";
        $result3 = mysqli_query($conn, $sql3);
        $data3 = mysqli_fetch_assoc($result3);
    ?>

    <section id="statistics">
        <h1> Statistika</h1>
        <div class="icons-container">
            <div class="icons">
                <i class="fa-solid fa-people-group" style="font-size:31px"></i>
                <h3><?php echo $data2['total2']?></h3>
                <p style="font-size:18px">Pārdevēji</p>
            </div>
            <div class="icons">
                <i class="fa-solid fa-gifts" style="font-size:31px"></i>
                <h3><?php echo $data['total1']?></h3>
                <p style="font-size:18px">Preces</p>
            </div>
            <div class="icons">
                <i class="fa-solid fa-list-ul"  style="font-size:31px"></i>
                <h3><?php echo $data3['total3']?></h3>
                <p style="font-size:18px">Kategorijas</p>
            </div>
        </div>
    </section>

    <footer>
        Kiriyena © 2023 Small start = Big deal</br>
        Designed by Kiriyena
    </footer>

</body>
</html>