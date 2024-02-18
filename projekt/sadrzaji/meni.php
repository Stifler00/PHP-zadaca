<?php
    session_start();

    if(isset($_SESSION["korisnicko_ime"])) {
        $logiran = true;
    } else {
        $logiran = false;
    }

?>

<header>
    <nav>
        <div class="slika"></div>
        <ul>
            <li><a href="?menu=1">Početna</a></li>
            <li><a href="?menu=2">O nama</a></li>
            <li><a href="?menu=3">Kontakt</a></li>
            <li><a href="?menu=4">Galerija</a></li>
            <li><a href="?menu=5">Vijesti</a></li>
            <li><a href="sadrzaji/sportske-novosti.php">Sportske novosti (API)</a></li>
            <div style="float: right; margin-right: 30px;">
            <?php if($logiran) { echo '
                <li><a href="?menu=administracija">Administracija</a></li>
                <li><a href="?menu=odjava">Odjava</a></li>';
            } else { echo '
                <li><a href="?menu=prijava">Prijava</a></li>
                <li><a href="?menu=registracija">Registracija</a></li>';
            } ?>
            </div>
        </ul>
    </nav>
</header>