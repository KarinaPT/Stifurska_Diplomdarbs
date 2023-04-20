<?php 
// Проверка наличия отправленной формы
if(isset($_POST['submit'])){

   // Подключение к базе данных
   include 'admin/config.php';
   // Начало сессии
   session_start();
   $E_pasts_pardevejs = mysqli_real_escape_string($conn, $_POST['E_pasts_pardevejs']);// Получение значения поля "E_pasts_pardevejs" из формы и защита от SQL-инъекций с помощью функции
   $Parole_pardevejs = md5($_POST['Parole_pardevejs']); // Получение значения поля "Parole" из формы и хэширование пароля с помощью функции md5() для безопасного хранения в базе данных

   // Формирование запроса на выборку пользователей из базы данных, где значение поля "E_pasts_pardevejs" равно введенному пользователем e-mail, а значение поля "Parole_pardevejs" равно хэшу введенного пароля
   $select = " SELECT * FROM pardevejs WHERE E_pasts_pardevejs = '$E_pasts_pardevejs' && Parole_pardevejs = '$Parole_pardevejs' ";

   // Выполнение запроса на выборку пользователей из базы данных с помощью функции mysqli_query() и сохранение результата выполнения в переменной $result.
   $result = mysqli_query($conn, $select);

   // Проверка наличия данных о пользователе в базе
   if(mysqli_num_rows($result) > 0){

      // Получение данных о пользователе
      $row = mysqli_fetch_array($result);
      // Проверка, является ли пользователь продавцом, через роль
      if($row['Loma'] == 'Pārdevējs'){

      // Если пользователь является продавцом, сохранение его имени в сессии и перенаправление на страницу статистики
         $_SESSION['user_name'] = $E_pasts_pardevejs;
         header('location:masters/about_me.php');

      }
   }else{
       // Если пользователь с введенными данными не найден, добавление ошибки в массив ошибок
      $error[] = 'Nepareizs e-pasts vai parole!';
   }
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Мета данные  -->
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pārdevēja pieteikšanās forma</title><!--заголовок страницы -->
    <!--подключение таблицы стилей для страницы административной панели -->
   <!--подключение иконки для вкладки браузера -->
   <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">
   <link rel="stylesheet" href="admin/css/css.css">
   <link rel="stylesheet" href="assets/css/login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
   <!-- (header) веб-страницы административной панели -->
   <header>
      <a class="logo">Pārdevēja pieteikšanās forma</a><!--логотип административной панели (Название) -->
      <nav class="navbar"><!-- навигационное меню: 
                                    ссылка на страницу статистики и профиля, 
                                    ссылка на страницу всех товаров,
                                    ссылка на страницу всех продавцов ,
                                    ссылка на страницу категорий товаров -->
          <a href="shop.html">Preces</a>
          <a href="masters.html">Pārdevēji</a>
          <a href="#" class="active"></i>Pieslēgties</a>
          <a href="login_admin.php"><i class="fa-solid fa-user-lock"></i></a><!--ссылка на страницу выхода из административной панели с иконкой.  "Актирная"-->
      </nav>
  </header>
   
   <div class="form-container">

      <form action="" method="post">
         <h3>Pieslēgties</h3>
         <?php
         // Проверка наличия ошибок и вывод их на страницу
          if(isset($error)){
            foreach($error as $error){
                echo '<span class="error-msg">'.$error.'</span>';
            };
            };
         ?>
         <input type="email" name="E_pasts_pardevejs" required placeholder="E-pasts"><!--  поле для ввода e-mail адреса пользователя, обязательное для заполнения, с подсказкой "E-pasts" внутри поля.-->
         <input type="password" name="Parole_pardevejs" required placeholder="Parole"><!--  поле для ввода пароля, обязательное для заполнения, с подсказкой "Parole" внутри поля. Введенный текст скрыт символами звездочек или точек. -->
         <input type="submit" name="submit" value="Pieslēgties" class="form-btn"> <!-- кнопка отправки формы с названием "Pieslēgties"-->
      </form>

   </div>

</body>
</html>