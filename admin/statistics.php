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
            <a href="all_products.php">Preces</a>
            <a href="all_masters.php" >Pārdevēji</a>
            <a href="category.php">Kategorijas</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <section id="description">
        <h1>Profils
        </h1>
        <div class="box-container">
            <?php
                $adminSQL = "SELECT * FROM administrators WHERE E_pasts = '".$_SESSION['admin_name']."'";
                $output = mysqli_query($conn, $adminSQL)  or die ("Nekorekts vaicājums");
                                            
                if(mysqli_num_rows($output) >0){
                    while($row = mysqli_fetch_assoc($output)){
                        $t_numurs = $row['T_numurs']; // сохраняем значение T_numurs в отдельной переменной
                        $Administrators_ID = $row['Administrators_ID']; // сохраняем значение Administrators_ID в отдельной переменной
                        echo "
                            <div class='box'>
                            <img src='{$row['Attela_admin']}'>
                            <p><b>Vārds: </b>{$row['Vards']}</p>
                            <p><b>Uzvārds: </b>{$row['Uzvards']}</p>
                            <p><b>E-pasts: </b>{$row['E_pasts']}</p>
                            <p><b>Telefona numurs: </b>{$t_numurs}</p>
                            <p><b>Loma: </b>{$row['Loma']}</p>
                            <a class='btn2' title='Rediģēt' href='edit_profile.php?Administrators_ID={$Administrators_ID}&E_pasts={$_SESSION['admin_name']}&T_numurs={$t_numurs}'><i class='far fa-edit' aria-hidden='true'></i></a>  
                            </div>
                                          
                        ";
                    }
                }else{
                    echo "Tabula nav datu ko attēlot";
                    header("location: confirmation.php");
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
    <?php 
        $sql4 ="SELECT COUNT(Kapakssadala_ID) AS total4 from k_apakssadala ";
        $result4 = mysqli_query($conn, $sql4);
        $data4 = mysqli_fetch_assoc($result4);
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
            <div class="icons">
                <i class="fa-solid fa-list-ul"  style="font-size:31px"></i>
                <h3><?php echo $data4['total4']?></h3>
                <p style="font-size:18px">Kategoriju apakšsadaļas</p>
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