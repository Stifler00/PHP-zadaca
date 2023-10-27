<?php
    // Baza podataka
    include("mysql_veza.php")
?>

<!doctype HTML>
<html lang="hr">
    <head>
        <link rel="stylesheet" href="css/style.css">
        <title>PHP 2</title>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="author" content="Jan Tovernić">
        <meta name="description" content="">
		<meta name="keywords" content="">
    </head>
    <body>
        <?php include "sadrzaji/meni.html"; ?>
        <main>
        <?php
            if (!isset($_GET['menu']) || $_GET['menu'] == 1) {include ("sadrzaji/pocetna.html"); }

            else if ($_GET['menu'] == 2) {include ("sadrzaji/onama.html"); }

            else if ($_GET['menu'] == 3) {include ("sadrzaji/kontakt.html"); }

            else if ($_GET['menu'] == 4) {include ("sadrzaji/galerija.html"); }

            else if ($_GET['menu'] == 5) {include ("sadrzaji/vijesti.html"); }
        ?>
        </main>
        <footer>
            Copyright &copy; <?php date("Y"); ?>, Jan Tovernić. Sva prava zadržana.
            <a href="https://github.com/Stifler00" target="_blank"><img src="Slike/github-bijeli.png" class="github"></a>
        </footer>
    </body>
</html>