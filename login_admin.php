<?php
// Pārbauda, vai nospiesta forma ar pogu "submit"
if (isset($_POST['submit'])) {

   require("admin/config.php"); // Iekļauj datubāzes konfigurācijas failu
   session_start(); // Sāk sesiju

   $E_pasts = mysqli_real_escape_string($conn, $_POST['E_pasts']); // Iegūst e-pasta adresi no formas un apstrādā to
   $Parole = md5($_POST['Parole']); // Iegūst paroli no formas un pārveido to, izmantojot md5 hēšu


   $select = "SELECT * FROM administrators WHERE E_pasts = '$E_pasts' AND Parole = '$Parole'"; // Izveido vaicājumu, lai pārbaudītu, vai eksistē administrators ar norādīto e-pasta adresi un paroli
   $result = mysqli_query($conn, $select); // Izpilda vaicājumu datubāzē


   if (mysqli_num_rows($result) > 0) {
      // Ja atrodas administrators ar norādīto e-pasta adresi un paroli
      $row = mysqli_fetch_array($result); // Izgūst datus par administratoru

      $_SESSION['admin_name'] = $E_pasts; // Saglabā e-pasta adresi sesijas mainīgajā
      header('location:admin/statistics.php'); // Novirza uz administrātora statistikas lapu

   } else {
      $error[] = 'Nepareiza e-pasta adrese vai parole!'; // Ja nav atrasts atbilstošs administrators, tiek iestatīta kļūdas ziņa
   }
}
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
      <a class="logo"> <span style="font-weight: bold; color: white;">Administratora</span> pieteikšanās
         forma</a><!--логотип административной панели (Название) -->
      <button class="menu-toggle" aria-label="Toggle navigation menu">
         <span></span>
         <span></span>
         <span></span>
      </button>
      <nav class="navbar">

         <a href="index.php">Sākumlapa</a>
         <a href="shop.php">Preces</a>
         <a href="masters.php">Pārdevēji</a>
         <a href="policy.php">Mūsu politika</a>
         <a href="login_master.php"></i>Pieslēgties</a>
         <a href="#" class="active"><i class="fa-solid fa-user-lock"></i></a>
      </nav>
   </header>

   <div class="form-container">

      <form action="" method="post">
         <h3>Pieslēgties</h3>
         <?php
         //Šis ir HTML kods, kas attēlo pieteikšanās formu administrātora saskarnē. Forma tiek iesniegta ar metodi POST un dati tiek nosūtīti uz pašu lapu (tukšs action atribūts). 
         //Ievadlaukos "E-pasts" un "Parole" lietotājam tiek prasīts ievadīt savus pieteikšanās datus. 
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            }
            ;
         }
         ;
         ?>
         <input type="email" name="E_pasts" required placeholder="E-pasts">
         <input type="password" name="Parole" required placeholder="Parole">
         <input type="submit" name="submit" title='Pieslēgties' value="Pieslēgties" class="form-btn">
      </form>

   </div>
   <?php include 'admin/footer_adm.php'; ?>

   <script>
      //Šis kods ir JavaScript kods, kas nodrošina funkcionalitāti izvēlnes atvēršanai un aizvēršanai, kad tiek noklikšķināts uz izvēlnes poga. (Maziem ekrāniem)
      const menuToggle = document.querySelector('.menu-toggle');
      const navbar = document.querySelector('.navbar');

      menuToggle.addEventListener('click', () => {
         navbar.classList.toggle('show');
      });</script>
</body>

</html>