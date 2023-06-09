<?php

$server_vards = "localhost:3306";  // Servera nosaukums un ports
$lietotajvards = "root"; // Lietotājvārds
$parole = ""; // Parole
$db_vards = "kiriyena_db"; // Datu bāzes nosaukums

$conn = mysqli_connect($server_vards,$lietotajvards, $parole, $db_vards); // Izveido savienojumu ar datu bāzi


?>
