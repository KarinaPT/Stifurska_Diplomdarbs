<?php
require("admin/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kiriyena Shop </title>
    </title>
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

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#templatemo_main_nav"
                aria-controls="templatemo_main_nav" aria-expanded="false" aria-label="Toggle navigation">
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
    <div class="container py-5 ">
        <div class="row">

            <div class="col-lg-3">
                <h1 class="h2 pb-4 text-dark">Pārdevēji</h1>
                <p class="mb-0">Šeit jūs varat atrast un uzzināt vairāk par izvēlēto pārdevēju</p>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    
                </div>
                <div class="row bg-light">
                    <?php
                    $pardevejs = "SELECT *
                            FROM pardevejs ";
                    $atlasa_pardevejs = mysqli_query($conn, $pardevejs) or die("Nekorekts vaicājums");
                    if (mysqli_num_rows($atlasa_pardevejs) > 0) {
                        while ($row = mysqli_fetch_assoc($atlasa_pardevejs)) {
                            ?>
                            <div class="col-md-4 ">
                                <div class="card mb-4 product-wap rounded-0 ">
                                    <div class="card rounded-0">
                                        <img class="card-img rounded-0 img-fluid" src=<?php echo $row['Attela_URL']; ?>>
                                        <div
                                            class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                            <ul class="list-unstyled">
                                                <li><a class="btn btn-success text-white mt-2" href="info_masters.php?Pardevejs_ID=<?php echo $row['Pardevejs_ID']; ?>"><i class="far fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a href="shop-single.html" class="h3 text-decoration-none">
                                            <?php echo $row['Brenda_nosaukums']; ?>
                                        </a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Подключаем плагин Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</body>

</html>