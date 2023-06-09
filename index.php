<?php
require("admin/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kiriyena</title>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light shadow bg-dark">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="index.php">
                Kiriyena
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#templatemo_main_nav"
                aria-controls="templatemo_main_nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between"
                id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="shop.php">Preces</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="masters.php">Pārdevēji</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contacts">Kontakti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="policy.php">Mūsu politika</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login_master.php">Pieslēgties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login_admin.php"><i class="fa-solid fa-user-lock"></i></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        </div>
    </nav>


    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            // Iekļaujam konfigurācijas failu
            require("admin/config.php");

            // Veicam vaicājumu, lai iegūtu datus no tabulas "Kiriyena"
            $sql = "SELECT * FROM Kiriyena";
            $result = mysqli_query($conn, $sql);

            // Pārbaudām, vai iegūtie rezultāti nav tukši
            if (mysqli_num_rows($result) > 0) {
                // Definējam mainīgo "active" kā "true", lai pirmajam slaidam būtu klase "active"
                $active = true;

                // Iterējam cauri katram iegūtajam rindas rezultātam
                while ($row = mysqli_fetch_assoc($result)) {
                    // Definējam klasi "active" pēc "active" mainīgā vērtības
                    $activeClass = $active ? 'active' : '';
                    ?>
                    <div class="carousel-item <?php echo $activeClass; ?>">
                        <div class="container">
                            <div class="row p-5">
                                <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                    <img class="img-fluid" title='Ilustrācija'
                                        src="assets/img/<?php echo $row['Kiriyena_attela']; ?>" alt="">
                                </div>
                                <div class="col-lg-6 mb-0 d-flex align-items-center">
                                    <div class="text-align-left align-self-center">
                                        <h1 class="h1 text-success"><b>
                                                <?php echo $row['Kiriyena_nosaukums']; ?>
                                            </b></h1>
                                        <p class="text-black">
                                            <?php echo $row['Kiriyena_apraksts']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $active = false;
                }
            } else {
                // Ja tabulā nav ierakstu, izvadam paziņojumu
                echo "Tabulā nav ierakstu.";
            }
            ?>
        </div>
    </div>


    <script>
        // Iegūstam karuseli pēc tā ID
        var carousel = document.getElementById('template-mo-zay-hero-carousel');

        // Izveidojam intervalu, kas pārslēdz slaidus katras 5 sekundes laikā
        setInterval(function () {
            // Atrodam aktīvo slaidu
            var activeSlide = carousel.querySelector('.carousel-item.active');

            // Atrodam nākamo slaidu
            var nextSlide = activeSlide.nextElementSibling;

            // Ja nākamais slaid nav atrasts, tad izvēlamies pirmo slaidu
            if (!nextSlide) {
                nextSlide = carousel.querySelector('.carousel-item:first-child');
            }

            // Noņemam aktīvo klasi no pašreizējā slaida
            activeSlide.classList.remove('active');
            // Pievienojam aktīvo klasi nākamajam slaidam
            nextSlide.classList.add('active');
        }, 7000); // Intervala periods - 7000 ms (7 sekundes)
    </script>

    </div>

    <section class="container py-5 ">
        <div class="row text-center pt-3 ">
            <div class="col-lg-6 m-auto">
                <h1 class="h1 text-dark ">Kategoriju saraksts</h1>
                <p class="text-black">
                    Iepazīsties ar mūsu katalogu, tas palīdzēs atrast to, kas tev nepieciešams.
                    <br />
                    "Top 3" kategorijas!
                </p>
            </div>
        </div>
        <div class="row ">
            <?php
            // Veicam vaicājumu, lai iegūtu populārākās kategorijas
            $kategorijaSQL = "SELECT kategorija.Kategorija_ID, kategorija.Nosaukums_kategorija, kategorija.Kat_attela, COUNT(prece.Prece_ID) as Preces_skaits 
            FROM kategorija 
            LEFT JOIN prece ON kategorija.Kategorija_ID = prece.ID_Kategorija 
            GROUP BY kategorija.Kategorija_ID  
            ORDER BY Preces_skaits DESC 
            LIMIT 3";

            $atlasa_kategorija = mysqli_query($conn, $kategorijaSQL) or die("Nekorekts vaicājums");

            // Pārbaudām, vai iegūtie rezultāti nav tukši
            if (mysqli_num_rows($atlasa_kategorija) > 0) {
                while ($row = mysqli_fetch_assoc($atlasa_kategorija)) {
                    ?>
                    <div class="col-12 col-md-4 p-5 mt-3">
                        <a href="shop.php"><img title='Ilustrācija' src="admin/<?php echo $row['Kat_attela']; ?>"
                                class="rounded-circle img-fluid border"></a>
                        <h5 class="text-center mt-3 mb-3">
                            <?php echo $row['Nosaukums_kategorija']; ?>
                        </h5>

                    </div>
                    <?php
                }
            } else {
                // Ja tabulā nav ierakstu, izvadam paziņojumu
                echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
            }
            ?>
        </div>

        <p align="right"><a class="btn btn-success" title="Preču saraksts" href="shop.php">Apskatīt visus</a></p>

    </section>

    <section class="bg-light">
        <div class="container py-5">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1 text-dark ">Mūsu pārdevēji</h1>
                    <p class="text-black">
                        Iepazīsties ar mūsu pārdevējiem, varbūt kāds no tiem tev patiks vairāk.<br />
                        "Top 3" pārdevēji
                    </p>
                </div>
            </div>
            <div class="row">
                <?php
                // Veicam vaicājumu, lai iegūtu populārākos pārdevējus
                $pardevejsSQL = "SELECT pardevejs.Pardevejs_ID, pardevejs.Brenda_nosaukums, pardevejs.Apraksts, pardevejs.Attela_URL, COUNT(prece.Prece_ID) as Preces_skaits 
                    FROM pardevejs 
                    LEFT JOIN prece ON pardevejs.Pardevejs_ID = prece.ID_Pardevejs
                    GROUP BY pardevejs.Pardevejs_ID
                    ORDER BY Preces_skaits DESC
                    LIMIT 3";
                $atlasa_pardevejs = mysqli_query($conn, $pardevejsSQL) or die("Nekorekts vaicājums");

                // Pārbaudām, vai iegūtie rezultāti nav tukši
                if (mysqli_num_rows($atlasa_pardevejs) > 0) {
                    while ($row = mysqli_fetch_assoc($atlasa_pardevejs)) {
                        ?>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card h-100">

                                <a href="info_masters.php?Pardevejs_ID=<?php echo $row['Pardevejs_ID']; ?>"
                                    class="h2 text-decoration-none text-dark">
                                    <?php

                                    $image_path = '';

                                     // Pārbaudām, vai attēla fails eksistē
                                    if (file_exists('admin/' . $row['Attela_URL'])) {
                                        $image_path = 'admin/' . $row['Attela_URL'];
                                    } elseif (file_exists('masters/' . $row['Attela_URL'])) {
                                        $image_path = 'masters/' . $row['Attela_URL'];
                                    } elseif (file_exists($row['Attela_URL'])) {
                                        $image_path = $row['Attela_URL'];
                                    }

                                    // Izvadam attēlu vai kļūdas paziņojumu
                                    if ($image_path) {
                                        echo '<img src="' . $image_path . '"  title="Logo" class="card-img-top  fixed-size-img-index" alt="...">';
                                    } else {
                                        echo 'Problēma ar logotipa iegūšanu.';
                                    }
                                    ?>
                                </a>
                                <div class="card-body">
                                    <a class="h2 text-decoration-none text-dark">
                                        <?php echo $row['Brenda_nosaukums']; ?>
                                    </a>

                                    <p class="text-muted">Preču skaits (
                                        <?php echo $row['Preces_skaits']; ?>)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Ja tabulā nav ierakstu, izvadam paziņojumu
                    echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
                }
                ?>
            </div>
            <p align="right"><a class="btn btn-success" title="Pārdevēju saraksts" href="masters.php">Apskatīt visus</a>
            </p>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>