<?php
    $sql = "SELECT kod_drzave, naziv_drzave FROM drzave";
    $rezultat = mysqli_query($db, $sql);
    $drzave = array();

    while($red = mysqli_fetch_assoc($rezultat)) {
        $drzave[] = array(
            "kod_drzave" => $red["kod_drzave"],
            "naziv_drzave" => $red["naziv_drzave"]
        );
    }
?>

<h1>Registracija</h1>
    <form method="post" action="izvrsi-registraciju.php">
        <label for="ime" ><b>Ime *</b></label>
        <input type="text" name="ime" id="ime" placeholder="Vaše ime" required>
        
        <label for="prezime"><b>Prezime *</b></label>
        <input type="text" name="prezime" id="prezime" placeholder="Vaše prezime" required>
        
        <label for="email"><b>E-mail *</b></label>
        <input type="email" name="email" id="email" placeholder="Vaš E-mail" required>

        <label for="country"><b>Država:</b></label>
        <select name="country" id="country">
            <?php
            foreach($drzave as $drzava) {
                echo "<option value=\"{$drzava['kod_drzave']}\">{$drzava['naziv_drzave']}</option>";
            }
            ?>
        </select>

        <label for="email"><b>Grad *</b></label>
        <input type="text" name="grad" id="grad" placeholder="Vaš grad" required>

        <label for="ulica"><b>Ulica *</b></label>
        <input type="text" name="ulica" id="ulica" placeholder="Vaša ulica" required>

        <label for="datum"><b>Datum rođenja *</b></label>
        <input type="date" name="datum" id="datum" placeholder="Vaš datum rođenja" required>

        <label for="korisnicko_ime"><b>Korisničko ime *</b></label>
        <input type="text" name="korisnicko_ime" id="korisnicko_ime" placeholder="Vaše korisničko ime" required>

        <label for="lozinka"><b>Lozinka *</b></label>
        <input type="password" name="lozinka" id="lozinka" placeholder="Vaša lozinka" required>

        <input type="submit" value="Registriraj se">
    </form>  