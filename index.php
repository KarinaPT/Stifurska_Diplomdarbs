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

<body>

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
                            <a class="nav-link" href="masters.php">Мастера</a>
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


    <!-- Start Banner Hero -->
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="./assets/img/start1.png" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                <h1 class="h1 text-success"><b>Kiriyena</b></h1>
                                <p class="text-black">
                                    Kiriyena это торговая площадка для уникальных вещей.
                                    Здесь можно найти множество необычных товаров, которые создают начинающие мастера.

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="./assets/img/start2.png" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1 text-dark "><b>Поддержка независимых мастеров</b></h1>
                                <h3 class="h2 text-black"></h3>
                                <p class="text-black">
                                    Kiriyena не супермаркет. Здесь миллионы людей продают то, что им нравится.
                                    А вы можете найти для себя что-то необычное и связаться с ними напрямую.

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="./assets/img/start3.png" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1 text-dark "><b>Становись одним из нас</b></h1>
                                <p class="text-black">
                                    На Kiriyena ты можешь разместить свою продукцию и начать свой пусть вместе с нами.
                                    Регестрируйся, знакомься с правилами и иди к своей цели.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>// Находим карусель по ее ID
            var carousel = document.getElementById('template-mo-zay-hero-carousel');

            // Запускаем автоматическое перелистывание каждые 5 секунд
            setInterval(function () {
                // Находим активный слайд
                var activeSlide = carousel.querySelector('.carousel-item.active');

                // Находим следующий слайд
                var nextSlide = activeSlide.nextElementSibling;

                // Если следующего слайда нет, то переключаем на первый слайд
                if (!nextSlide) {
                    nextSlide = carousel.querySelector('.carousel-item:first-child');
                }

                // Переключаем на следующий слайд
                activeSlide.classList.remove('active');
                nextSlide.classList.add('active');
            }, 5000); // переключение каждые 5 секунд</script>
    </div>
    <!-- End Banner Hero -->


    <!-- Start Categories of The Month -->
    <section class="container py-5 ">
        <div class="row text-center pt-3 ">
            <div class="col-lg-6 m-auto">
                <h1 class="h1 text-dark ">Kategoriju saraksts</h1>
                <p class="text-black">
                    Iepazīsties ar mūsu katalogu, tas palīdzēs atrast to, kas tev nepieciešams.
                </p>
            </div>
        </div>
        <div class="row ">
            <?php
            $kategorijaSQL = "SELECT * FROM kategorija";
            $atlasa_kategorija = mysqli_query($conn, $kategorijaSQL) or die("Nekorekts vaicājums");

            if (mysqli_num_rows($atlasa_kategorija) > 0) {
                while ($row = mysqli_fetch_assoc($atlasa_kategorija)) {
                    ?>
                    <div class="col-12 col-md-4 p-5 mt-3">
                        <a href="#"><img src=<?php echo $row['Kat_attela']; ?> class="rounded-circle img-fluid border"></a>
                        <h5 class="text-center mt-3 mb-3">
                            <?php echo $row['Nosaukums_kategorija']; ?>
                        </h5>
                        <p class="text-center"><a class="btn btn-success">Apskatīt</a></p>
                    </div>
                    <?php
                }
            } else {
                echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
            }
            ?>
        </div>

        <p align="right"><a class="btn btn-success" href="shop.php">Apskatīt visus</a></p>
        
    </section>
    <!-- End Categories of The Month -->


    <!-- Start Featured Product -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1 text-dark ">Mūsu pārdevēji</h1>
                    <p class="text-black">
                        Iepazīsties ar mūsu pārdevējiem, varbūt kāds no tiem tev patiks vairāk.
                    </p>
                </div>
            </div>
            <div class="row">
                <?php

                $pardevejsSQL = "SELECT pardevejs.Pardevejs_ID, pardevejs.Brenda_nosaukums,pardevejs.Apraksts, pardevejs.Attela_URL, COUNT(prece.Prece_ID) as Preces_skaits 
                FROM pardevejs 
                LEFT JOIN prece ON pardevejs.Pardevejs_ID = prece.ID_Pardevejs
                GROUP BY pardevejs.Pardevejs_ID";
                $atlasa_pardevejs = mysqli_query($conn, $pardevejsSQL) or die("Nekorekts vaicājums");

                if (mysqli_num_rows($atlasa_pardevejs) > 0) {
                    while ($row = mysqli_fetch_assoc($atlasa_pardevejs)) {
                        ?>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card h-100">
                                <a href="shop-single.html">
                                    <img src=<?php echo $row['Attela_URL']; ?> class="card-img-top" alt="...">
                                </a>
                                <div class="card-body">
                                    <a href="shop-single.html" class="h2 text-decoration-none text-dark">
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
                    echo "<tr><td colspan='4'>Tabulā nav ierakstu.</td></tr>";
                }
                ?>
            </div>
            <p align="right"><a class="btn btn-success" href="masters.php">Apskatīt visus</a></p>
        </div>
    </section>
    <!-- End Featured Product -->


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
    <!-- Подключаем библиотеку jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Подключаем плагин Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- End Script -->
</body>

</html>