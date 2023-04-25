<?php
    require("../admin/config.php");
    session_start();
    if(isset($_SESSION['user_name'])){
        $prece_ID = $_GET['prece_ID'];
        $Nosaukums_prece = $_GET['Nosaukums_prece'];
        $Cena = $_GET['Cena'];
        $Statuss = $_GET['Statuss'];
        $Apraksts_prece = $_GET['Apraksts_prece'];
        $Ipatnibas_prece = $_GET['Ipatnibas_prece'];


if(isset($_POST['update'])){

   $Nosaukums_prece = mysqli_real_escape_string($conn, $_POST['Nosaukums_prece']);
   $Cena = mysqli_real_escape_string($conn, $_POST['Cena']);
   $Statuss = mysqli_real_escape_string($conn, $_POST['Statuss']);
   $Apraksts_prece = mysqli_real_escape_string($conn, $_POST['Apraksts_prece']);
   $Ipatnibas_prece = mysqli_real_escape_string($conn, $_POST['Ipatnibas_prece']);

   $query = "UPDATE `prece` SET `Nosaukums_prece`='".$Nosaukums_prece."', `Cena`='".$Cena."', `Statuss`='".$Statuss."', `Apraksts_prece`='".$Apraksts_prece."', `Ipatnibas_prece`='".$Ipatnibas_prece."' WHERE `prece_ID`='".$prece_ID."'";

   if(mysqli_query($conn, $query)){
      header("location:my_products.php");
   } else {
      echo "Error updating record: " . mysqli_error($conn);
   }

};

        
?>
 

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preču administrācija</title>
    <link rel="stylesheet" href="css/cssForMaster.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png"/>

</head>
<body>
    <header>
        <a class="logo">Administrēšanas panelis</a>
        <nav class="navbar">
            <a href="about_me.html" >Statistika/Profils</a>
            <a href="my_products.php" class="active">Preces / Rediģēšāna</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

<div class="form-container">

   <form action="" method="post"> 
      <h3>Veikt rediģēšanu</h3>

    
                <input type="text" name="Nosaukums_prece" value="<?php echo $Nosaukums_prece; ?>"><!--Это текстовое поле требует от пользователя ввести цену товара и является обязательным для заполнения.  "placeholder" указывает, что ожидается ввод названия товара.-->
                <input type="text" name="Cena"  value="<?php echo $Cena; ?>">
                <input type="text" name="Statuss"  value="<?php echo $Statuss; ?>">
                <textarea  name="Apraksts_prece"  style="height: 200px;"><?php echo $Apraksts_prece; ?>"</textarea>
                <textarea  name="Ipatnibas_prece" style="height: 200px;"><?php echo $Ipatnibas_prece; ?></textarea><!--Это текстовое поле требует от пользователя ввести цену товара и является обязательным для заполнения.  "placeholder" указывает, что ожидается ввод названия товара.-->
                <input type="submit" name="update" value="Reģistrēt" class="form-btn">
               
   </form>


</div>

<footer>
            Kiriyena © 2023 Small start = Big deal</br>
            Designed by Kiriyena
        </footer>
<?php
    } 
?>
</body>
</html>