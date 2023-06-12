<?php
require("config.php"); 
session_start(); 
if (isset($_SESSION['admin_name'])) { 
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preču administrācija</title> 
        <link rel="stylesheet" href="css/css.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png" />
    </head>

    <body>
        <header>
            <a class="logo">Administrēšanas panelis</a>
            <nav class="navbar"> 
                <a href="statistics.php">Statistika/Profils</a>
                <a href="all_products.php" class="active">Preces / Apraksts</a>
                <a href="all_masters.php">Pārdevēji</a>
                <a href="category.php">Kategorijas</a>
                <a href="../logout.php"><i class="fa-solid fa-right-to-bracket"></i> Iziet</a>
            </nav>
        </header>

        <section id="description">
            <h1>Detalizēts preču apraksts</h1> 
            <div class="box-container">
                <div class='box'>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        require("config.php"); 

                        // Iegūstam preces ID no ievades formas
                        $prece_ID = $_POST['Apskatīt']; 
                       
                         // SQL vaicājums, lai izgūtu informāciju par preces ierakstu, kurām prece_ID=$prece_ID"
                        $par_preceSQL = "SELECT prece.prece_ID, prece.Nosaukums_prece, prece.Cena, prece.Statuss, prece.Apraksts_prece, prece.Attela_prece, prece.Ipatnibas_prece, 
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
                        $atlasa_apraksts = mysqli_query($conn, $par_preceSQL) or die("Nekorekts vaicājums"); 
                        
                        // Attēlojam informāciju par preces ierakstu
                        while ($row = mysqli_fetch_assoc($atlasa_apraksts)) { 
                
                            $image_path = '';

                              // Noteikam attēla ceļu
                            if (file_exists($row['Attela_prece'])) {
                                $image_path = $row['Attela_prece'];
                            } elseif (file_exists('../masters/' . $row['Attela_prece'])) {
                                $image_path = '../masters/' . $row['Attela_prece'];
                            }

                             // Attēlojam informāciju par preces ierakstu
                            echo " 
                            <img src='{$image_path}' title='Fotoattēls' class='fixed-size-img-prof'>
                            <h3>{$row['Nosaukums_prece']}</h3>
                            <p><b>Cena: </b>{$row['Cena']}€</p>
                            <p><b>Statuss: </b>{$row['Statuss']}</p>
                            <p><b>Pārdevējs: </b>{$row['Brenda_nosaukums']}</p>
                            <p><b>Apraksts: </b>{$row['Apraksts_prece']}</p> 
                            <p><b>Īpatnības: </b>{$row['Ipatnibas_prece']}</p>
                            <p><b>Kategorija: </b>{$row['Nosaukums_kategorija']}</p>
                            <p><b>Kategoriju apakšsadaļa: </b>{$row['Nosaukums_sadala']}</p>
                            ";
                        }
                    } else {
                        echo "Tabula nav datu ko attēlot"; 
                    }
                    ?>
                    <input type="button" onclick="history.back();" title='Preces' value="Atpakaļ" class="btn ">
                </div>

            </div>
        </section>

        <?php include 'footer_adm.php'; ?>
        <?php
}
?>
</body>

</html>