<?php
// Pārbauda, vai forma ir iesniegt
if (isset($_POST['submit'])) {
   // Nepieciešams konfigurācijas fails un sesijas sākums
   require("admin/config.php");
   session_start();

   // Iegūst un apstrādā ievades laukus
   $E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);
   $Parole_pardevejs = md5($_POST['Parole_pardevejs']);

   // Veic datubāzes vaicājumu, lai pārbaudītu lietotāja datus
   $select = "SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '$E_pasts_pardevejs' AND Parole_pardevejs = '$Parole_pardevejs'";
   $result = mysqli_query($conn, $select);

   // Pārbauda, vai ir atrasts lietotājs ar norādīto e-pasta adresi un paroli
   if (mysqli_num_rows($result) > 0) {
      // Iegūst lietotāja datus un saglabā sesijā
      $row = mysqli_fetch_array($result);
      $_SESSION['user_name'] = $E_pasts_pardevejs;

      // Novirza uz norādīto lapu
      header('location:masters/about_me.php');

   } else {
      //Kļūda
      $error[] = 'Nepareiza e-pasta adrese vai parole!';
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pārdevēja pieteikšanās forma</title>
   <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">
   <link rel="stylesheet" href="admin/css/css.css">
   <link rel="stylesheet" href="assets/css/login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
   <header>
      <a class="logo"><span style="font-weight: bold; color: white;">Pārdevēja</span> pieteikšanās forma</a>
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
         <a href="#" class="active"></i>Pieslēgties</a>
         <a href="login_admin.php"><i class="fa-solid fa-user-lock"></i></a>
      </nav>
   </header>

   <div class="form-container">

      <form action="" method="post">
         <h3>Pieslēgties</h3>
         <?php
         // Parāda kļūdas ziņojumus, ja ir kļūdas
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            }
            ;
         }
         ; //Tālāk seko ievades lauki (e-pasta adrese un parole), poga "Pieslēgties" un saite uz reģistrācijas lapu. 
         //Katrai HTML elementam ir atbilstošs PHP kods, lai nodrošinātu to pareizu darbību.
         ?>
         <input type="email" name="E_pasts_pardevejs" required placeholder="E-pasts">
         <input type="password" name="Parole_pardevejs" required placeholder="Parole">
         <input type="submit" title='Pieslēgties' name="submit" value="Pieslēgties" class="form-btn">
         <a class='btn' title='Sākumlapa' href='index.php'>Sākumlapa</a>
         <p>Jūs vēl neesat reģistrējies? <a title='Reģistrēties' href="registration.php">Reģistrēties</a></p>


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