<?php
   require("config.php");
   session_start();
   if(isset($_SESSION['admin_name'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Kategoriju apakšsadaļu administrēšana</title>
   <link rel="stylesheet" href="css/css.css">
   <link rel="stylesheet" href="../assets/css/confirm.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
   <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>

<header>
    <a class="logo">Administrēšanas panelis</a>
    <nav class="navbar">
        <a href="statistics.php">Statistika/Profils</a>
        <a href="all_products.php">Preces</a>
        <a href="all_masters.php">Pārdevēji</a>
        <a href="categoty.php" class="active">Kategorijas / Apakšsadaļas</a>
        <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
    </nav>
</header>

<section id="forInfo">
    <div class="row">
            <div class="info">
                <div class="head-info head-color">Kategoriju apakšsadaļu administrēšana: <input type="button" onclick="history.back();" value="Atpakaļ" class="btn "><br>
                </div>
                <table>
                    <tr>
                        <th>Kategorijas apakšsadaļu nosaukumi</th>
                        <th></th>
                    </tr>

                    <?php 
                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        require("config.php"); 
                        $Kategorija_ID = $_POST['Apskatīt'];
                        $kategorijaSQL = "SELECT k_apakssadala.Kapakssadala_ID, k_apakssadala.Nosaukums_sadala,
                        kategorija.Nosaukums_kategorija
                        FROM k_apakssadala
                        LEFT JOIN kategorija
                        ON Kategorija_ID = k_apakssadala.ID_Kategorija
                        WHERE Kategorija_ID=$Kategorija_ID;"; 
                        $atlasa_kategorija = mysqli_query($conn, $kategorijaSQL) or die ("Nekorekts vaicājums");
                        if(mysqli_num_rows($atlasa_kategorija) >0){
                            while($row = mysqli_fetch_assoc($atlasa_kategorija)){
                    ?>
                        <tr>
                            <td><?php echo $row['Nosaukums_sadala']; ?></td>
                            <td>
                            <a class='btn2' href="delete_subtitle.php?Kapakssadala_ID=<?php echo $row['Kapakssadala_ID']; ?>"><i class="fa fa-trash" aria-hidden="true" title="Dzēst"></i></a>
                            </td>
                        </tr>
                    <?php
					        }
                        }else{
                            ?>
                             <p class="no-data">Tabula nav datu ko attēlot</p>
                             <?php
                        }
                     }  
                    ?>
                </table>
            </div>
    </div>
    

</section>

<footer>
    Kiriyena © 2023 Small start = Big deal</br>
    Designed by Kiriyena
</footer>
<?php
   }
?>
</body>
</html>