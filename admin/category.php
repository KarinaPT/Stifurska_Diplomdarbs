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
   <title>Kategoriju administrēšana</title>
   <link rel="stylesheet" href="css/css.css">
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
        <a href="#" class="active">Kategorijas</a>
        <a href="../index.html"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
    </nav>
</header>

<section id="forInfo">
    <div class="row">
            <div class="info">
                <div class="head-info head-color">Kategoriju administrēšana: <br>
                </div>
                <table>
                    <tr>
                        <th>Kategorijas nosaukumus</th>
                        <th><a class='btn2' href="add_category.php">Pievienot kategoriju</a></th>
                        <th></th>
                    </tr>

                    <?php 
                        $kategorijaSQL = "SELECT * FROM kategorija"; 
                        $atlasa_kategorija = mysqli_query($conn, $kategorijaSQL) or die ("Nekorekts vaicājums");

                        if(mysqli_num_rows($atlasa_kategorija) >0){
                            while($row = mysqli_fetch_assoc($atlasa_kategorija)){
                    ?>
                        <tr>
                            <td><?php echo $row['Nosaukums_kategorija']; ?></td>
                            <td>
                                <a class='btn2'><i class="fa fa-trash" aria-hidden="true" title="Dzēst"></i></a>
                                <form action='about_cat.php' method='post'>
                                    <button type = 'submit' class = 'btn2' name='Apskatīt' value=<?php echo $row['Kategorija_ID']; ?> title="Detalizēts preču apraksts">
                                        <a><i class="far fa-clipboard" aria-hidden="true"></i></a>
                                    </button>
                                </form> 
                            </td>
                        </tr>
                        
                    <?php
					        }
                        }else{
                             echo "Tabula nav datu ko attēlot";
                        }
                    ?>
                </table>
            </div> 
    </div>
    <a class='btn2' href="add_subtitle.php">Pievienot apakšsadaļu</a>
    

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