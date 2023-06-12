<?php
// Šis PHP kods iekļauj nepieciešamās konfigurācijas faila (config.php) iekļaušanu un sesijas sākšanu. 
// Tas pārbauda, vai sesijā ir saglabāts lietotāja vārds (user_name) un izpilda papildu kodu, ja lietotājs ir pieslēdzies. 
require("../admin/config.php");
session_start();
if (isset($_SESSION['user_name'])) {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Statistika un profilu administrēšana</title>
        <link rel="stylesheet" href="css/cssForMaster.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />

    </head>

    <body>
        <header>
            <a class="logo">Administrēšanas panelis</a>
            <button class="menu-toggle" aria-label="Toggle navigation menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="navbar">
                <a href="about_me.php" class="active">Statistika/Profils</a>
                <a href="my_products.php">Preces</a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <section id="description">
            <h1>Profils</h1>
            <div class="box-container">
                <?php
                // Šis kods veic vaicājumu, lai atlasītu pardevēju ar noteiktu e-pasta adresi, kas saglabāta $_SESSION['user_name'] mainīgajā. 
                // Ja vaicājums nav veiksmīgs, tad izvadīsies kļūdas paziņojums "Nekorekts vaicājums". 
                $lietotajsSQL = "SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '" . $_SESSION['user_name'] . "'";
                $atlasa_lietotajs = mysqli_query($conn, $lietotajsSQL) or die("Nekorekts vaicājums");

                if (mysqli_num_rows($atlasa_lietotajs) > 0) {
                    while ($row = mysqli_fetch_assoc($atlasa_lietotajs)) {
                        // Izgūstu nepieciešamās vērtības no datu rindas
                        $T_numurs_pardevejs = $row['T_numurs_pardevejs'];
                        $Pardevejs_ID = $row['Pardevejs_ID'];
                        $Attela_URL = $row['Attela_URL'];
                        $Apraksts = $row['Apraksts'];

                        // Noteiku attēla ceļu
                        $image_path = '';
                        if (file_exists($row['Attela_URL'])) {
                            $image_path = $row['Attela_URL'];
                        } elseif (file_exists('../admin/' . $row['Attela_URL'])) {
                            $image_path = '../admin/' . $row['Attela_URL'];
                        } elseif (file_exists('../' . $row['Attela_URL'])) {
                            $image_path = '../' . $row['Attela_URL'];
                        }

                        // Attēloju datus un veidoju saites
                        echo "
                            <div class='box'>
                            <img src='{$image_path}' class='fixed-size-img' title='Logo'>
                            <h3>{$row['Brenda_nosaukums']}</h3>
                            <p><b>Vārds: </b>{$row['Vards_pardevejs']}</p>
                            <p><b>Uzvārds: </b>{$row['Uzvards_pardevejs']}</p>
                            <p><b>E-pasts: </b>{$row['E_pasts_pardevejs']}</p>
                            <p><b>Telefona numurs: </b>{$row['T_numurs_pardevejs']}</p>
                            <p><b>Loma: </b>{$row['Loma']}</p>
                            <p><b>Apraksts: </b>{$row['Apraksts']}</p>        
                            <a class='btn' title='Rediģēt Profilu' href='edit_my_prof.php?Pardevejs_ID={$Pardevejs_ID}&E_pasts_pardevejs={$_SESSION['user_name']}&T_numurs_pardevejs={$T_numurs_pardevejs}
                            &Attela_URL={$Attela_URL}&Apraksts={$Apraksts}'>Rediģēt profilu</a>
                            <a class='btn' title='Rediģēt parole' href='edit_password.php?Pardevejs_ID={$Pardevejs_ID}'>Rediģēt parole</a>
                           
                            
                        ";
                    }
                } else {
                    // Ja tabulā nav datu, attēloju paziņojumu un veicu pāradresāciju
                    echo "Tabula nav datu ko attēlot";
                    header("location:../admin/confirmation.php");
                }
                ?>
            </div>
        </section>

        <?php
        /*Šis kods veic SQL vaicājumu, lai atlasītu "prece" un "pardevejs" tabulu ierakstus, kur "E_pasts_pardevejs" kolonna "pardevejs" tabulā atbilst $_SESSION['user_name'] vērtībai. 
        Vaicājums arī aprēķina "prece.prece_ID" ierakstu skaitu un saglabā rezultātu mainīgajā "total". */
        $sql = "SELECT COUNT(prece.prece_ID) AS total,
        pardevejs.Pardevejs_ID, pardevejs.E_pasts_pardevejs
        FROM prece
        JOIN pardevejs
        ON Pardevejs_ID = prece.ID_Pardevejs
        WHERE pardevejs.E_pasts_pardevejs = '" . $_SESSION['user_name'] . "'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        ?>

        <?php
        //Šis kods veic SQL vaicājumu, lai atlasītu datus no "administrators" tabulas un saglabātu "E_pasts" vērtību mainīgajā "phone_number", lai pēctam to izmantot
        $sql2 = "SELECT * FROM administrators";
        $result = mysqli_query($conn, $sql2);
        $data2 = mysqli_fetch_assoc($result);
        $phone_number = $data2['E_pasts'];
        ?>

        <section id="statistics">
            <!-- Šis kods iekļauj divus blokus ar statistikas informāciju. Pirmajā blokā tiek parādīts "total" vērtība, kas ir atgriezta no SQL vaicājuma un attēlo preču skaitu. 
            Otrajā blokā tiek attēlots administrators ar viņa e-pasta adresi un saiti, lai atvērtu e-pastu.-->
            <div class="icons-container">
                <div class="icons">
                    <h1> Statistika</h1>
                    <i class="fa-solid fa-people-group" style="font-size:31px"></i>
                    <h3>
                        <?php echo $data['total'] ?>
                    </h3>
                    <p style="font-size:18px">Preces</p>
                </div>

                <div class="icons">
                    <h1> Administrātors</h1>
                    <i class="fa-solid fa-id-card-clip"></i></i>
                    <h3>
                        <?php echo $data2['E_pasts'] ?>
                    </h3>
                    <p style="font-size:18px">E-pasts</p>
                    <a class='btn' title='Sazināties' target="_blank"
                        href="https://mail.google.com/mail/?view=cm&to=<?php echo $data2['E_pasts']; ?>">Atvērt
                        e-pastu</a>

                </div>
            </div>
        </section>

        <?php include '../admin/footer_adm.php'; ?>

        <script>
            //Šis kods ir JavaScript kods, kas nodrošina funkcionalitāti izvēlnes atvēršanai un aizvēršanai, kad tiek noklikšķināts uz izvēlnes poga. (Maziem ekrāniem)
            const menuToggle = document.querySelector('.menu-toggle');
            const navbar = document.querySelector('.navbar');

            menuToggle.addEventListener('click', () => {
                navbar.classList.toggle('show');
            });
        </script>

        <?php
}
?>
</body>

</html>