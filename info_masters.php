<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kiriyena</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body class="bg-light">

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
                            <a class="nav-link active" href="masters.php">Pārdevēji</a>
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

    <section class="bg-light">
        <div class="container pb-5">
            <?php
            require("admin/config.php"); // Iekļauj konfigurācijas failu un izveido datu bāzes savienojumu
            $Pardevejs_ID = $_GET['Pardevejs_ID']; // Iegūst Pardevejs_ID parametru no URL
            $pardevejsSQL = "SELECT *
            FROM pardevejs
            WHERE Pardevejs_ID=$Pardevejs_ID"; // SQL vaicājums, kas atlasa datus no tabulas "pardevejs" pēc Pardevejs_ID
            
            $precesCountSQL = "SELECT COUNT(*) AS precesCount FROM prece WHERE Pardevejs_ID = $Pardevejs_ID";
            // Izpilda SQL vaicājumu un iegūst rezultātu
            $atlasaPardevejs = mysqli_query($conn, $pardevejsSQL) or die("Nekorekts vaicājums");
            if (mysqli_num_rows($atlasaPardevejs) > 0) {
                while ($row = mysqli_fetch_assoc($atlasaPardevejs)) {
                    ?>
                    <div class="row">
                        <div class="col-lg-5 mt-5">
                            <div class="card mb-3">
                                <?php
                                $image_path = ''; // Mainīgais, kurā tiks glabāta attēla ceļš

                                if (file_exists('admin/' . $row['Attela_URL'])) {
                                    $image_path = 'admin/' . $row['Attela_URL']; // Ja attēls atrodas "admin" mapē, iestatām attiecīgo ceļu
                                } elseif (file_exists('masters/' . $row['Attela_URL'])) {
                                    $image_path = 'masters/' . $row['Attela_URL']; // Ja attēls atrodas "masters" mapē, iestatām attiecīgo ceļu
                                } elseif (file_exists($row['Attela_URL'])) {
                                    $image_path = $row['Attela_URL']; // Ja attēls atrodas pašā saknes mapē, iestatām attiecīgo ceļu
                                }

                                if ($image_path) {
                                    echo '<img src="' . $image_path . '" title="Logo" class="card-img-top" alt="...">';
                                } else {
                                    echo 'Attēls nav atrasts.'; //Ja attēls nav atrasts, izvadam atbilstošu paziņojumu
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-7 mt-5">
                            <div class="card">
                                <div class="card-body">

                                    <h1 class="h2 text-dark">
                                        <?php echo $row['Brenda_nosaukums']; ?>
                                    </h1>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5><b>Ražotājs:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>
                                                    <?php echo $row['Brenda_nosaukums']; ?>
                                                </strong></p>
                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5><b>Pārdevēja vārds:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>
                                                    <?php echo $row['Vards_pardevejs']; ?>
                                                </strong></p>
                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5><b>E-pasts:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>
                                                    <?php echo $row['E_pasts_pardevejs']; ?>
                                                </strong></p>
                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5><b>Telefona numurs:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>
                                                    <?php echo $row['T_numurs_pardevejs']; ?>
                                                </strong></p>
                                        </li>
                                    </ul>


                                    <h5><b>Apraksts:</b></h5>
                                    <p class="text-black">
                                        <?php echo $row['Apraksts']; ?>
                                    </p>

                                    <form action="" method="GET">
                                        <div class="row pb-3">
                                            <div class="col d-grid">
                                                <a title="Sazināties"
                                                    href="https://mail.google.com/mail/?view=cm&to=<?php echo $row['E_pasts_pardevejs']; ?>"
                                                    target="_blank" class="btn btn-success btn-lg">
                                                    Sazinies ar pārdevēju
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    <?php
                }
            } else {
                echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
            }
            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5 ">
        <div class="row">

            <div class="col-lg-3">
                <h1 class="h2 pb-4 text-dark">Apskatiet pārdevēja preces</h1>
            </div>

            <div class="col-lg-9">
                <div class="row bg-light">
                    <div class="row bg-light">
                        <?php
                        require("admin/config.php"); // Iekļaujam datu bāzes konfigurācijas failu
                        $prece = "SELECT prece.prece_ID, prece.Attela_prece,prece.Nosaukums_prece,prece.Cena
                          FROM prece
                          JOIN pardevejs ON Pardevejs_ID = ID_Pardevejs
                            WHERE Pardevejs_ID = $Pardevejs_ID"; // SQL vaicājums, lai atlasītu preces, kas pieder konkrētam pārdevējam
                        $atlasaPrece = mysqli_query($conn, $prece) or die("Nekorekts vaicājums");
                        $count = 0;  // Mainīgais, lai skaitītu atgrieztās preces skaits
                        if (mysqli_num_rows($atlasaPrece) > 0) {
                            while ($row = mysqli_fetch_assoc($atlasaPrece)) {
                                ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 product-wap rounded-0 ">
                                        <div class="card rounded-0">
                                            <?php
                                            // Mainīgais, lai glabātu attēla ceļu
                                            $image_path = '';

                                            if (file_exists('admin/' . $row['Attela_prece'])) { // Pārbaudām vai attēls eksistē admin mapē
                                                $image_path = 'admin/' . $row['Attela_prece'];
                                            } elseif (file_exists('masters/' . $row['Attela_prece'])) { // Pārbaudām vai attēls eksistē masters mapē
                                                $image_path = 'masters/' . $row['Attela_prece'];
                                            }

                                            if ($image_path) { // Pārbaudām vai ir atrasts attēla ceļš
                                                echo '<img src="' . $image_path . '" title="Fotoattēls" class="card-img-top fixed-size-img-list img-fluid" alt="...">';
                                            } else {
                                                echo 'Attēls nav atrasts.'; // Ja attēls nav atrasts, izvadam ziņojumu
                                            }
                                            ?>

                                            <div
                                                class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                                <ul class="list-unstyled">
                                                    <li><a title="Apskatīt" class="btn btn-success text-white mt-2"
                                                            href="single.php?prece_ID=<?php echo $row['prece_ID']; ?>"><i
                                                                class="far fa-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <a href="shop-single.html" class="h3 text-decoration-none">
                                                <?php echo $row['Nosaukums_prece']; ?>
                                            </a>
                                            <p class="text-center mb-0">
                                                <?php echo $row['Cena']; ?>€
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $count++; // Palielinām skaitītāju par vienu
                                if ($count % 3 == 0) { // Pārbaudām vai skaitītājs dalās bez atlikuma ar 3
                                    echo '</div><div class="row bg-light">'; // Ja dalās bez atlikuma, aizveram iepriekšējo rindu un sākam jaunu rindā
                                }
                            }
                        } else {
                            echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>