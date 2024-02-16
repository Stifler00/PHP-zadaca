<?php
    include("mysql_veza.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "SELECT korisnicko_ime, lozinka, rola, approved FROM korisnici WHERE email_adresa = ?";

        if($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email_adresa);

            // Postavi parametre
            $param_email_adresa = $_POST["email"];

            // Pokušaj izvršiti statement
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $korisnicko_ime, $hashirani_password, $rola, $approved);

                    if(mysqli_stmt_fetch($stmt)) {
                        // Provjeri password
                        if($approved) {
                            if(password_verify($_POST["lozinka"], $hashirani_password)) {
                                // Ispravan pass
                                session_start();
                                $_SESSION["korisnicko_ime"] = $korisnicko_ime;
                                $_SESSION["rola"] = $rola;

                                // Redirect na index
                                echo "<h1>Uspješna prijava! Preusmjeravanje...</h1>";
                                header("Refresh:3; url=http://localhost/zadaca/php4/cms.php", true, 303);
                            } else { echo "Neispravna lozinka!"; }
                        } else { echo "Nemate pravo prijave!"; }
                    }
                } else { echo "Korisnik s ovom email adresom nije registriran!"; }
            } else { echo "Greška prilikom izvršavanja SQL upita: ". mysqli_error($db); }
            mysqli_stmt_close($stmt);
        }
    }
?>