<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kiriyena - Товары</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body class="bg-light">

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow bg-dark">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="index.php">
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
                            <a class="nav-link" href="shop.php">Товары</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="masters.php">Мастера</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contacts">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Наша политика</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login_master.php">Вход</a>
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
    <!-- Close Header -->

    <section class="bg-light">
        <div class="container pb-5">
            <?php
            require("admin/config.php");
            $Pardevejs_ID = $_GET['Pardevejs_ID'];
            $pardevejsSQL = "SELECT *
            FROM pardevejs
            WHERE Pardevejs_ID=$Pardevejs_ID";

            $atlasaPardevejs = mysqli_query($conn, $pardevejsSQL) or die("Nekorekts vaicājums");
            if (mysqli_num_rows($atlasaPardevejs) > 0) {
                while ($row = mysqli_fetch_assoc($atlasaPardevejs)) {
                    ?>
                    <div class="row">
                        <div class="col-lg-5 mt-5">
                            <div class="card mb-3">
                                <img class="card-img img-fluid-main" src=<?php echo $row['Attela_URL']; ?> alt="Card image cap"
                                    id="product-detail">
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
                                            <h5><b>Бренд:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>
                                                    <?php echo $row['Brenda_nosaukums']; ?>
                                                </strong></p>
                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5><b>Имя продавца:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>
                                                    <?php echo $row['Vards_pardevejs']; ?>
                                                </strong></p>
                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5><b>Почта:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>
                                                    <?php echo $row['E_pasts_pardevejs']; ?>
                                                </strong></p>
                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5><b>Номер телефона:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>
                                                    <?php echo $row['T_numurs_pardevejs']; ?>
                                                </strong></p>
                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5><b>Количество товаров:</b></h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-black"><strong>14</strong></p>
                                        </li>
                                    </ul>

                                    <h5><b>Описание:</b></h5>
                                    <p class="text-black">
                                        <?php echo $row['Apraksts']; ?>
                                    </p>

                                    <form action="" method="GET">
                                        <div class="row pb-3">
                                            <div class="col d-grid">
                                                <a href="https://mail.google.com/mail/?view=cm&to=<?php echo $row['E_pasts_pardevejs']; ?>"
                                                    target="_blank" class="btn btn-success btn-lg">
                                                    Связаться с продавцом
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



    <!-- Start Content -->
    <div class="container py-5 ">
        <div class="row">

            <div class="col-lg-3">
                <h1 class="h2 pb-4 text-dark">Ознакольмя с его товарами</h1>
            </div>

            <div class="col-lg-9">
                <!-- <div class="row">
                    <div class="col-md-6 pb-4">
                        <div class="d-flex">
                            <select class="form-control">
                                <option>Featured</option>
                                <option>A to Z</option>
                                <option>Item</option>
                            </select>
                        </div>
                    </div>
                </div>
            -->
                <div class="row bg-light">
                    <div class="row bg-light">
                        <?php
                        require("admin/config.php");
                        $prece = "SELECT *
        FROM prece
        JOIN pardevejs ON Pardevejs_ID = ID_Pardevejs
        WHERE Pardevejs_ID = $Pardevejs_ID";
                        $atlasaPrece = mysqli_query($conn, $prece) or die("Nekorekts vaicājums");
                        $count = 0;
                        if (mysqli_num_rows($atlasaPrece) > 0) {
                            while ($row = mysqli_fetch_assoc($atlasaPrece)) {
                                ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 product-wap rounded-0 ">
                                        <div class="card rounded-0">
                                            <img class="card-img rounded-0 img-fluid" src=<?php echo $row['Attela_prece']; ?>>
                                            <div
                                                class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                                <ul class="list-unstyled">
                                                    <li><a class="btn btn-success text-white mt-2" href="single.html"><i
                                                                class="far fa-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <a href="shop-single.html" class="h3 text-decoration-none">
                                                <?php echo $row['Nosaukums_prece']; ?>
                                            </a>
                                            <p class="text-center mb-0">
                                                <?php echo $row['Cena']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $count++;
                                if ($count % 3 == 0) {
                                    echo '</div><div class="row bg-light">';
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
    <!-- End Content -->

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

    <!-- Start Script -->

    <!-- End Script -->
</body>

</html>