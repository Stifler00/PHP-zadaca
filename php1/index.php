<!doctype HTML>
<html lang="hr">
    <head>
        <link rel="stylesheet" href="style.css">
        <title>PHP 1</title>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="author" content="Jan Tovernić">
        <meta name="description" content="">
		<meta name="keywords" content="">
    </head>
    <body>
        <?php include "meni.html"; ?>
        <main>
        <?php
            if (!isset($_GET['menu']) || $_GET['menu'] == 1) {include ("pocetna.html"); }

            else if ($_GET['menu'] == 2) {include ("onama.html"); }

            else if ($_GET['menu'] == 3) {include ("kontakt.html"); }

            else if ($_GET['menu'] == 4) {include ("galerija.html"); }

            else if ($_GET['menu'] == 5) {include ("vijesti.html"); }
        ?>
        </main>
        <footer>
            Copyright &copy; 2023, Jan Tovernić. Sva prava zadržana.
            <a href="https://github.com/Stifler00" target="_blank"><img src="Slike/github-bijeli.png" class="github"></a>
        </footer>
    </body>
</html>