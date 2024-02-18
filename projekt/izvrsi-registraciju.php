<?php
    include("mysql_veza.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "SELECT id FROM korisnici WHERE email_adresa = ? OR korisnicko_ime = ?";

        if($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_email_adresa, $param_korisnicko_ime);

            // Postavi parametre
            $param_email_adresa = $_POST["email"];
            $param_korisnicko_ime = $_POST["korisnicko_ime"];

            // Pokušaj izvršiti statement
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1) {
                    echo("Korisnik s ovom email adresom ili korisničkim imenom je već registriran!");
                } else {
                    $sql2 = "INSERT INTO korisnici (korisnicko_ime, ime, prezime, email_adresa, drzava, grad, ulica, datum_rodjenja, lozinka) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    if($stmt2 = mysqli_prepare($db, $sql2)) {
                        mysqli_stmt_bind_param($stmt2, "sssssssis", $param_korisnik, $param_ime, $param_prezime, $param_email, $param_drzava, $param_grad, $param_ulica, $param_datum_rodjenja, $param_lozinka);
                        $param_korisnik = $param_korisnicko_ime;
                        $param_email = $param_email_adresa;
                        $param_ime = $_POST["ime"];
                        $param_prezime = $_POST["prezime"];
                        $param_drzava = $_POST["country"];
                        $param_grad = $_POST["grad"];
                        $param_ulica = $_POST["ulica"];
                        $param_datum_rodjenja = date("Y-m-d", strtotime($_POST["datum"]));
                        $param_lozinka = password_hash($_POST["lozinka"], PASSWORD_BCRYPT);

                        if(mysqli_stmt_execute($stmt2)) {
                            header("location: http://localhost/zadaca/php4/index.php?menu=prijava");
                        } else {
                            printf("Greška prilikom izvršavanja sql upita: %s.\n", mysqli_stmt_error($stmt2));
                        }

                        mysqli_stmt_close($stmt2);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
?>