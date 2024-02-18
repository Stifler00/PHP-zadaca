<?php
session_start();

// Provjeri je li korisnik prijavljen
if (!isset($_SESSION['korisnicko_ime'])) {
    header("Location: login.php");
    exit;
}

// Uključi vezu s bazom podataka
include("mysql_veza.php");

// Provjeri je li dostupan ID korisnika
if (!isset($_GET['id'])) {
    echo "ID korisnika nije pružen.";
    exit;
}

// Dohvati podatke o korisniku na temelju ID-a
$user_id = $_GET['id'];
$sql = "SELECT id, korisnicko_ime, email_adresa, rola, approved FROM korisnici WHERE id = ?";
if ($stmt = mysqli_prepare($db, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $korisnicko_ime, $email_adresa, $rola, $approved);
        mysqli_stmt_fetch($stmt);
    } else {
        echo "Korisnik nije pronađen.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Greška pri dohvaćanju podataka o korisniku: " . mysqli_error($db);
    exit;
}

// Provjeri ima li prijavljeni korisnik dopuštenje za uređivanje ovog korisnika
if ($_SESSION['rola'] !== 'administrator' && $_SESSION['id'] != $user_id) {
    echo "Pristup odbijen. Nemate dopuštenje za uređivanje ovog korisnika.";
    exit;
}

// Obradi podneseni obrazac za ažuriranje podataka o korisniku
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $email_adresa = $_POST['email_adresa'];
    $rola = $_POST['rola'];
    $approved = isset($_POST['approved']) ? 1 : 0;

    // Ažuriraj podatke o korisniku u bazi podataka
    $sql_update = "UPDATE korisnici SET korisnicko_ime = ?, email_adresa = ?, rola = ?, approved = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($db, $sql_update)) {
        mysqli_stmt_bind_param($stmt, "sssii", $korisnicko_ime, $email_adresa, $rola, $approved, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Korisnik uspješno ažuriran.";
        } else {
            echo "Greška pri ažuriranju korisnika: " . mysqli_error($db);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Greška pri pripremi SQL upita: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi korisnika</title>
    <link rel="stylesheet" href="./css/cms.css">
</head>
<body>
    <h1>Uredi korisnika</h1>
    <form method="post">
        <label for="korisnicko_ime">Korisničko ime:</label><br>
        <input type="text" id="korisnicko_ime" name="korisnicko_ime" value="<?php echo $korisnicko_ime; ?>" required><br>
        <label for="email_adresa">Email:</label><br>
        <input type="email" id="email_adresa" name="email_adresa" value="<?php echo $email_adresa; ?>" required><br>
        <?php if ($_SESSION['rola'] === 'administrator') : ?>
            <label for="rola">Uloga:</label><br>
            <select id="rola" name="rola" required>
                <option value="user" <?php echo ($rola == 'user') ? 'selected' : ''; ?>>Korisnik</option>
                <option value="editor" <?php echo ($rola == 'editor') ? 'selected' : ''; ?>>Urednik</option>
                <option value="administrator" <?php echo ($rola == 'administrator') ? 'selected' : ''; ?>>Administrator</option>
            </select><br>
            <label for="approved">Odobren:</label>
            <input type="checkbox" id="approved" name="approved" value="1" <?php echo ($approved == 1) ? 'checked' : ''; ?>><br>
        <?php endif; ?>
        <input type="submit" value="Ažuriraj">
    </form>
    <a href="cms.php">Natrag na CMS</a>
</body>
</html>
