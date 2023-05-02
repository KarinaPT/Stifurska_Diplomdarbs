<?php

@include 'admin/config.php'; // включает файл конфигурации базы данных.

session_start(); //начинает новую сессию.
session_unset(); //удаляет все переменные сессии.
session_destroy();//  уничтожает текущую сессию.

header('location:index.php'); //перенаправляет пользователя на страницу index.php.

?>