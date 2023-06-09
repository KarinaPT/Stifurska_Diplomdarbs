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
            <a href="statistics.php">Statistika/Profils</a>
            <a href="#" class="active">Preces</a>
            <a href="all_masters.php">Pārdevēji</a>
            <a href="category.php">Kategorijas</a>
            <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
        </nav>
    </header>

    <section id="forInfo">
        <div class="row">
            <div class="info">
                <div class="head-info head-color">Preču administrēšana: <br>
                </div>
                <table>
                    <tr>
                        <th>Nosaukums</th>
                        <th>Cena</th>
                        <th>Pārdevējs</th>
                        <th><a class='btn2' title='Pievienot jaunu prece' href="add_prod.php">Pievienot jaunu preci</a>
                        </th>
                        <th></th>
                    </tr>

                    <?php
                    require("config.php"); // Iekļauj konfigurācijas failu, kas satur datubāzes savienojuma iestatījumus
                    $preceSQL = "SELECT prece.prece_ID, prece.Nosaukums_prece, prece.Cena, 
                            pardevejs.Brenda_nosaukums
                            FROM prece
                            JOIN pardevejs
                            ON Pardevejs_ID = prece.ID_Pardevejs;"; /* Šī SQL vaicājuma mērķis ir atlasīt datus no "prece" un "pardevejs" tabulām, izmantojot JOIN apvienošanu. Rezultātā tiks iegūtas kolonnas 
                                 "prece_ID", "Nosaukums_prece", "Cena" un "Brenda_nosaukums". Šie dati tiks izmantoti vēlāk, 
                                 lai aizpildītu tabulu vai veiktu citus datu apstrādes soļus. */
                    $atlasa_prece = mysqli_query($conn, $preceSQL) or die("Nekorekts vaicājums"); // Izpilda vaicājumu un atgriež rezultātu resursu vai izvada kļūdas ziņojumu
                    if (mysqli_num_rows($atlasa_prece) > 0) {
                        while ($row = mysqli_fetch_assoc($atlasa_prece)) {
                            // Izvada preču datus tabulas rindiņā
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['Nosaukums_prece']; ?> <!-- Izvada preces nosaukumu -->
                                </td>
                                <td>
                                    <?php echo $row['Cena']; ?>€ <!-- Izvada preces cenu -->
                                </td>
                                <td>
                                    <?php echo $row['Brenda_nosaukums']; ?> <!-- Izvada preces brenda nosaukumu -->
                                </td>
                                <td>
                                    <a title="Dzēst" class='btn2'
                                        href="delete_prod.php?prece_ID=<?php echo $row['prece_ID']; ?>"><i class="fa fa-trash"
                                            aria-hidden="true"></i></a> <!-- "Dzēst sadaļa" ar atbilstošu ikonu un ID -->
                                    <form action='about_prod.php' method='post'>
                                        <button type='submit' class='btn2' name='Apskatīt' value=<?php echo $row['prece_ID']; ?>
                                            title="Detalizēts preču apraksts">
                                            <a><i class="far fa-clipboard" aria-hidden="true"></i></a>
                                            <!-- "Apskatīt sadaļa" ar atbilstošu ikonu un ID -->
                                        </button>
                                    </form>
                                </td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>"; // Izvada paziņojumu, ja nav ierakstu
                    }
                    ?>


                </table>
            </div>
        </div>


    </section>

    <?php include 'footer_adm.php'; ?>
    <script>
        //Šis kods ir JavaScript kods, kas nodrošina funkcionalitāti izvēlnes atvēršanai un aizvēršanai, kad tiek noklikšķināts uz izvēlnes poga. (Maziem ekrāniem)
        const menuToggle = document.querySelector('.menu-toggle');
        const navbar = document.querySelector('.navbar');

        menuToggle.addEventListener('click', () => {
            navbar.classList.toggle('show');
        });</script>
    <?php
    ?>
</body>

</html>