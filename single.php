<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kiriyena - Дтали товара</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow bg-dark">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="index.html">
                Kiriyena
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between"
                id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="shop.html">Товары</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="masters.html">Мастера</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contacts">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Наша политика</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login_master.html">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login_admin.html"><i class="fa-solid fa-user-lock"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </nav>
    <!-- Close Header -->
    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <?php
            require("admin/config.php");
            $prece_ID = $_GET['prece_ID'];
            $preceSQL = "SELECT prece.prece_ID, prece.Nosaukums_prece, prece.Cena, prece.Statuss, prece.Apraksts_prece, prece.Attela_prece, prece.Ipatnibas_prece, 
            kategorija.Nosaukums_kategorija, 
            k_apakssadala.Nosaukums_sadala,
            pardevejs.Brenda_nosaukums
            FROM prece
            JOIN kategorija
            ON Kategorija_ID = prece.ID_Kategorija
            LEFT JOIN k_apakssadala
            ON Kapakssadala_ID = prece.IDKapakssadala
            LEFT JOIN pardevejs
            ON Pardevejs_ID = prece.ID_Pardevejs
            WHERE prece_ID=$prece_ID";
            $atlasaPrece = mysqli_query($conn, $preceSQL) or die("Nekorekts vaicājums");
            if (mysqli_num_rows($atlasaPrece) > 0) {
                while ($row = mysqli_fetch_assoc($atlasaPrece)) {
                    ?>
                    <div class="row">
                        <div class="col-lg-5 mt-5">
                            <div class="card mb-3">
                                <img class="card-img img-fluid-main" src=<?php echo $row['Attela_prece']; ?> alt="Card image cap"
                                    id="product-detail">
                            </div>
                        </div>
                        <div class="col-lg-7 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">


                                        <h1 class="h2 text-dark">
                                            <?php echo $row['Nosaukums_prece']; ?>
                                        </h1>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <h5><b>Cena:</b></h5>
                                            </li>
                                            <li class="list-inline-item">
                                                <p class="text-muted"><strong>
                                                        <?php echo $row['Cena']; ?>
                                                    </strong></p>
                                            </li>
                                        </ul>

                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <h5><b>Statuss:</b></h5>
                                            </li>
                                            <li class="list-inline-item">
                                                <p class="text-muted"><strong>
                                                        <?php echo $row['Statuss']; ?>
                                                    </strong></p>
                                            </li>
                                        </ul>

                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <h5><b>Brends:</b></h5>
                                            </li>
                                            <li class="list-inline-item">
                                                <p class="text-black"><strong>
                                                        <?php echo $row['Brenda_nosaukums']; ?>
                                                    </strong></p>
                                            </li>
                                        </ul>

                                        <h5><b>Apraksts:</b></h5>
                                        <p class="text-black">
                                            <?php echo $row['Apraksts_prece']; ?>
                                        </p>

                                        <h5><b>Īpašības:</b></h5>
                                        <ul class="list-unstyled pb-3">
                                            <?php echo $row['Ipatnibas_prece']; ?>
                                            </p>
                                        </ul>

                                        <h5><b>Piegāde:</b></h5>
                                        <p class="text-black">Lai uzzinātu par maksājuma un ātrās piegādes iespējām, lūdzu, sazinieties ar meistaru. 
                                            Ja jums ir papildu jautājumi, jūs varat sazināties arī ar pārdevēju
                                        </p>
                                        
                                        <?php
                }
            } else {
                echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
            }
            ?>
                                <form action="" method="GET">
                                    <div class="row pb-3">
                                        <div class="col d-grid">
                                            <button type="submit" class="btn btn-success btn-lg" name="submit"
                                                value="buy">Pirkt/Sazināties ar pārdevēju</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- Close Content -->



    <!-- Start Footer -->
    <footer class="bg-dark" id="tempaltemo_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-success border-bottom pb-3 border-light logo">Kiriyena</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <a class="text-decoration-none  ">Kiriyena — это международная торговая <br>площадка,
                            объединяющая людей,
                            которые<br> хотят создавать, продавать, покупать и коллекционировать уникальные вещи.
                            А еще<br> мы сообщество людей, которые заботятся о малом бизнесе, людях и нашей планете.
                        </a>
                    </ul>
                </div>
                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Uzņemums</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="shop.html">Товары</a></li>
                        <li><a class="text-decoration-none" href="masters.html">Мастера</a></li>
                        <li><a class="text-decoration-none" href="#">Наша политика</a></li>
                    </ul>
                </div>
                <div class="col-md-4 pt-5">
                    <h2 id="contacts" class="h2 text-light border-bottom pb-3 border-light">Контакты</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fa-solid fa-info brownicon"></i>
                            <a class="text-decoration-none">Если у Вас есть какие-то вопросы или Вы хотите что-то
                                уточнить, можете написать Нам или позвонить!</a>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone-flip brownicon"></i>
                            <a class="text-decoration-none">+3712945681</a>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope brownicon"></i>
                            <a class="text-decoration-none">infokiriyena@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="w-100  py-3">
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12">
                        <p class="text-center text-light">
                            Kiriyena &copy; 2023 Small start = Big deal <br>
                            Designed by <a rel="sponsored" href="#" target="_blank">Kiriyena</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->


</body>

</html>