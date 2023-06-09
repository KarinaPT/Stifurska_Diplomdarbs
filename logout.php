<?php

@include 'admin/config.php'; // Iekļauj konfigurācijas failu (DB)

session_start(); // Sāk jaunu sesiju vai atjauno esošo
session_unset(); // Notīra sesijas mainīgos
session_destroy(); // Izbeidz sesiju un iznīcina sesijas datus

header('location:index.php'); // Novirza uz index.php lapu

?>