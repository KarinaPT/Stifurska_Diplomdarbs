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
                            <a class="nav-link active" href="shop.php">Preces</a>
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

    <div class="container py-5 ">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="h2 text-dark">Kategorijas</h1>
                <p class="mb-0 pb-4">Lūdzu, izvēlieties kategoriju, lai apskatītu preču sarakstu.</p>
                <ul class="list-unstyled templatemo-accordion">
                    <?php
                    require("admin/config.php");

                    // Pārbauda vai ir norādīta izvēlētā kategorija GET parametru vērtībā
                    if (isset($_GET['category'])) {
                        $selectedCategory = $_GET['category'];
                    } else {
                        $selectedCategory = "";
                    }

                    // Izgūst visus ierakstus no tabulas "kategorija"
                    $preceKatSQL = "SELECT * FROM kategorija;";
                    $atlasa_kat = mysqli_query($conn, $preceKatSQL) or die("Nekorēkts vaicājums.");

                    // Pārbauda vai ir iegūti ieraksti no datubāzes
                    if (mysqli_num_rows($atlasa_kat) > 0) {
                        while ($row = mysqli_fetch_assoc($atlasa_kat)) {
                            $categoryId = $row['Kategorija_ID'];
                            $categoryName = $row['Nosaukums_kategorija'];

                            // Noteikt, vai šī kategorija ir izvēlēta (atbilstības pārbaude ar GET parametru vērtību)
                            $activeClass = ($selectedCategory == $categoryId) ? "active" : "";

                            // Izvada kategoriju sarakstu ar saitēm uz attiecīgajām kategorijām
                            echo '<li class="pb-3">';
                            echo '<a class="collapsed d-flex justify-content-between h3 text-decoration-none ' . $activeClass . '" href="?category=' . $categoryId . '">';
                            echo $categoryName;
                            echo '</a>';
                            echo '</li>';
                        }
                    } else {
                        // Ja nav ierakstu, izvada paziņojumu par tukšu tabulu
                        echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
                    }
                    ?>
                </ul>
            </div>
            <?php

            if ($selectedCategory != "") {
                // Ja ir izvēlēta kategorija, izvada produktu sarakstu
                echo '<div class="col-lg-9">';
                echo '<div class="row bg-light">';

                // Iegūst produktus no datubāzes atbilstoši izvēlētajai kategorijai
                $preceSQL = "SELECT prece.prece_ID, prece.Attela_prece,prece.Nosaukums_prece,prece.Cena
                      FROM prece WHERE ID_Kategorija = $selectedCategory;";
                $atlasa_prece = mysqli_query($conn, $preceSQL) or die("Nekorekts vaicājums");

                // Pārbauda vai ir iegūti produkti no datubāzes
                if (mysqli_num_rows($atlasa_prece) > 0) {
                    $count = 0;
                    while ($row = mysqli_fetch_assoc($atlasa_prece)) {
                        $count++;   // $count glabā skaitu, cik produkti ir jau izvadīti
                        ?>

                        <div class="col-md-4">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <?php

                                    $image_path = '';

                                    // Pārbauda vai attēla fails ir pieejams admin vai masters direktorijā
                                    if (file_exists('admin/' . $row['Attela_prece'])) {
                                        $image_path = 'admin/' . $row['Attela_prece'];
                                    } elseif (file_exists('masters/' . $row['Attela_prece'])) {
                                        $image_path = 'masters/' . $row['Attela_prece'];
                                    }

                                    // Parāda attēlu vai ziņu, ja attēls nav atrasts
                                    if ($image_path) {
                                        echo '<img src="' . $image_path . '"  title="Fotoattēls" class="card-img-top fixed-size-img-list img-fluid" alt="...">';
                                    } else {
                                        echo 'Attēls nav atrasts.';
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
                                    <?php echo $row['Nosaukums_prece']; ?>
                                    <p class="text-center mb-0">
                                        <?php echo $row['Cena']; ?>€
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($count % 3 == 0) {
                            // Pārtrauc esošo rindu un sāk jaunu rindu ik pēc 3 produktiem
                            echo '</div><div class="row bg-light">';
                        }
                    }
                } else {
                    // Ja nav iegūtu produktu, izvada paziņojumu par tukšu tabulu
                    echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
                }
                echo '</div></div>';
            }
            ?>

        </div>

    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</body>

</html>