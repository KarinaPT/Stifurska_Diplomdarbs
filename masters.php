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
    <div class="container py-5 ">
        <div class="row">

            <div class="col-lg-3">
                <h1 class="h2  text-dark">Pārdevēji</h1>
                <p class="mb-0">Šeit jūs varat atrast un uzzināt vairāk par izvēlēto pārdevēju</p>
            </div>

            <div class="col-lg-9">
                <div class="row">

                </div>
                <div class="row bg-light">
                    <?php
                    // Izvēlas visus pardevējus no datubāzes tabulas
                    $pardevejs = "SELECT *
                            FROM pardevejs ";
                    $atlasa_pardevejs = mysqli_query($conn, $pardevejs) or die("Nekorekts vaicājums");

                    // Pārbauda vai ir atrasti ieraksti
                    if (mysqli_num_rows($atlasa_pardevejs) > 0) {
                        while ($row = mysqli_fetch_assoc($atlasa_pardevejs)) {
                            ?>
                            <div class="col-md-4 ">
                                <div class="card mb-4 product-wap rounded-0 ">
                                    <div class="card rounded-0">
                                        <?php
                                        // Noteikta attēla ceļš
                                        $image_path = '';

                                        // Pārbauda vai attēla fails ir pieejams admin, root vai masters direktorijā
                                        if (file_exists('admin/' . $row['Attela_URL'])) {
                                            $image_path = 'admin/' . $row['Attela_URL'];
                                        } elseif (file_exists('masters/' . $row['Attela_URL'])) {
                                            $image_path = 'masters/' . $row['Attela_URL'];
                                        } elseif (file_exists($row['Attela_URL'])) {
                                            $image_path = $row['Attela_URL'];
                                        }

                                        // Attēla attēlošana vai ziņa, ja attēls nav atrasts
                                        if ($image_path) {
                                            echo '<img src="' . $image_path . '" title="Fotoattēls" class="card-img-top" alt="...">';
                                        } else {
                                            echo 'Attēls nav atrasts.';
                                        }
                                        ?>
                                        <div
                                            class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                            <ul class="list-unstyled">
                                                <li><a title="Apskatīt" class="btn btn-success text-white mt-2"
                                                        href="info_masters.php?Pardevejs_ID=<?php echo $row['Pardevejs_ID']; ?>"><i
                                                            class="far fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                            <?php echo $row['Brenda_nosaukums']; ?>
                                    </div>
                                </div>
                            </div>
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

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</body>

</html>