<?php
// Pokreni sesiju i provjeri je li korisnik prijavljen
session_start();
if (!isset($_SESSION['korisnicko_ime'])) {
    header("Location: index.php?menu=prijava");
    exit;
}

// Uključi vezu s bazom podataka
include("mysql_veza.php");

// Provjeri ulogu korisnika
if ($_SESSION['rola'] === 'user') {
    echo "Pristup odbijen. Samo administratori mogu pristupiti ovoj stranici.";
    exit;
}

// Inicijaliziraj varijable
$id = $naslov = $slika = $tekst = $arhiva = '';

// Provjeri je li postavljen ID vijesti
if (isset($_GET['id'])) {
    // Pripremi i izvrši upit za dohvaćanje detalja vijesti
    $sql = "SELECT id, naslov, naslovna_slika, sadrzaj, arhivirano FROM vijesti WHERE id = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $naslov, $slika, $tekst, $arhiva);
                mysqli_stmt_fetch($stmt);
            } else {
                echo "Vijest nije pronađena.";
                exit;
            }
        } else {
            echo "Greška pri izvršavanju upita: " . mysqli_error($db);
            exit;
        }
    } else {
        echo "Greška pri pripremi upita: " . mysqli_error($db);
        exit;
    }
}

// Obradi podneseni obrazac
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_news'])) {
    $id = $_POST['id'];
    $naslov = $_POST['naslov'];
    $tekst = $_POST['tekst'];
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;

    // Provjeri je li prenesena nova datoteka s slikom
    if ($_FILES['slika']['name'] != '') {
        $slika = $_FILES['slika']['name']; // Naziv datoteke
        $slika_tmp = $_FILES['slika']['tmp_name']; // Privremeni naziv datoteke

        // Premjesti prenesenu datoteku u odredišni direktorij
        $upload_directory = "./Slike/";
        $upload_file = $upload_directory . basename($slika);
        move_uploaded_file($slika_tmp, $upload_file);
    }

    // Ažuriraj vijest u bazi podataka
    $sql = "UPDATE vijesti SET naslov = ?, naslovna_slika = ?, sadrzaj = ?, arhivirano = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssi", $naslov, $slika, $tekst, $arhiva, $id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Vijest je uspješno ažurirana.";
        } else {
            echo "Greška pri ažuriranju vijesti: " . mysqli_error($db);
        }
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
    <title>Uredi vijest</title>
    <link rel="stylesheet" href="./css/cms.css">
</head>
<body>
    <h1>Uredi vijest</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="naslov">Naslov:</label><br>
        <input type="text" id="naslov" name="naslov" value="<?php echo $naslov; ?>" required><br>
        <label for="slika">Slika:</label><br>
        <input type="file" id="slika" name="slika" accept="image/*"><br>
        <label for="tekst">Tekst:</label><br>
        <textarea id="tekst" name="tekst" rows="4" required><?php echo $tekst; ?></textarea><br>
        <label for="arhiva">Arhiva:</label>
        <input type="checkbox" id="arhiva" name="arhiva" value="1" <?php if ($arhiva == 1) echo 'checked'; ?>><br>
        <input type="submit" name="update_news" value="Ažuriraj vijest">
    </form>
    <a href="cms.php">Natrag na CMS</a>
</body>
</html>
