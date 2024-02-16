<?php
    define("DB_SERVER", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "php-zadaca");

	$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($db === false) {
        die("Doslo je do greske prilikom povezivanja na bazu podataka: ". mysqli_connect_error());
    }
?>