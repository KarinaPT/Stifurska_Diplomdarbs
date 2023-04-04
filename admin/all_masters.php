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
        <a href="all_products.php">Preces</a>
        <a href="#" class="active">Pārdevēji</a>
        <a href="category.php">Kategorijas</a>
        <a href="../index.html"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
    </nav>
</header>

<section id="forInfo">
    <div class="row">
            <div class="info">
                <div class="head-info head-color">Pārdevēju administrācija: <br>
                </div>
                <table>
                    <tr>
                        <th>Nosaukums</th>
                        <th><a class='btn2' href="#">Pievienot jaunu pārdevēju</a></th>
                        <th></th>
                    </tr>

                    <?php 
                        $pardevejsSQL = "SELECT * FROM pardevejs"; 
                        $atlasa_pardevejs = mysqli_query($conn, $pardevejsSQL) or die ("Nekorekts vaicājums");

                        if(mysqli_num_rows($atlasa_pardevejs) >0){
                            while($row = mysqli_fetch_assoc($atlasa_pardevejs)){
                    ?>
                        <tr>
                            <td><?php echo $row['Brenda_nosaukums']; ?></td>
                            <td>
                                <a class='btn2'><i class="fa fa-trash" aria-hidden="true" title="Dzēst"></i></a>
                                <form action='#' method='post'>
                                    <button type = 'submit' class = 'btn2' name='Apskatīt '>
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
    

</section>

<footer>
    Kiriyena © 2023 Small start = Big deal</br>
    Designed by Kiriyena
</footer>

</body>
</html>