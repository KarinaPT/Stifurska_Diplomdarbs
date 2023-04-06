<?php 
if(isset($_POST['submit'])){
   include 'admin/config.php';

   session_start();
   $E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);
   $Parole_pardevejs = md5($_POST['Parole_pardevejs']);

   $select = " SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '$E_pasts_pardevejs' && Parole_pardevejs = '$Parole_pardevejs' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['Loma'] == 'Pārdevējs'){

         $_SESSION['user_name'] = $E_pasts_pardevejs;
         header('location:masters/about_me.php');

      }
   }else{
      $error[] = 'Nepareizs e-pasts vai parole!';
   }
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Administratora pieteikšanās forma</title>
   <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">

   <link rel="stylesheet" href="admin/css/css.css">
   <link rel="stylesheet" href="assets/css/login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
   <header>
      <a class="logo">Вход для продавцов</a>
      <nav class="navbar">
          <a href="shop.html">Товары</a>
          <a href="masters.html">Мастера</a>
          <a href="#">Наша политика</a>
          <a href="#" class="active"></i>Вход</a>
          <a href="login_admin.html"><i class="fa-solid fa-user-lock"></i></a>
      </nav>
  </header>
   
   <div class="form-container">

      <form action="" method="post">
         <h3>Pieslēgties</h3>
         <?php
          if(isset($error)){
            foreach($error as $error){
                echo '<span class="error-msg">'.$error.'</span>';
            };
            };
         ?>
         <input type="email" name="E_pasts_pardevejs" required placeholder="E-pasts">
         <input type="password" name="Parole_pardevejs" required placeholder="Parole">
         <input type="submit" name="submit" value="Pieslēgties" class="form-btn">
      </form>

   </div>

</body>
</html>