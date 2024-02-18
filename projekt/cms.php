<?php
// Pokreni sesiju i provjeri je li korisnik prijavljen
session_start();
if (!isset($_SESSION['korisnicko_ime'])) {
    header("Location: index.php?menu=prijava");
    exit;
}

// MySQL podatci
include("mysql_veza.php");

// Dohvati ulogu korisnika
$uloga_korisnika = $_SESSION['rola'];

// Definiraj dozvole na temelju uloge korisnika
$dozvole = [];
if ($uloga_korisnika === 'administrator') {
    $dozvole = [
        'manage_users' => true,
        'add_news' => true,
        'edit_news' => true,
        'delete_news' => true,
        'approve_news' => true,
        'archive_news' => false
    ];
} elseif ($uloga_korisnika === 'editor') {
    $dozvole = [
        'manage_users' => false,
        'add_news' => true,
        'edit_news' => true,
        'delete_news' => false,
        'approve_news' => false,
        'archive_news' => true
    ];
} elseif ($uloga_korisnika === 'user') {
    $dozvole = [
        'manage_users' => false,
        'add_news' => true,
        'edit_news' => false,
        'delete_news' => false,
        'approve_news' => false,
        'archive_news' => false
    ];
}

// Upravljaj upravljanjem korisnika
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && $dozvole['manage_users']) {
    $user_id = $_POST['user_id'];
    
    // Obavi odgovarajuću radnju na temelju poslanog obrasca
    if (isset($_POST['delete'])) {
        // Obriši korisnika
        $sql = "DELETE FROM korisnici WHERE id = ?";
        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            echo "Korisnik uspješno obrisan.";
        } else {
            echo "Greška pri brisanju korisnika: " . mysqli_error($db);
        }
    } elseif (isset($_POST['approve'])) {
        // Odobri korisnika
        $sql = "UPDATE korisnici SET approved = 1, rola = 'user' WHERE id = ?";
        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            echo "Korisnik uspješno odobren.";
        } else {
            echo "Greška pri odobravanju korisnika: " . mysqli_error($db);
        }
    } elseif (isset($_POST['edit'])) {
        // Preusmjeri na stranicu za uređivanje korisnika
        header("Location: edit_user.php?id=$user_id");
        exit;
    }
}

// Upravljaj dodavanjem vijesti
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['naslov'], $_FILES['slika'], $_POST['tekst']) && $dozvole['add_news']) {
    $naslov = $_POST['naslov'];
    $slika = $_FILES['slika']['name']; // Ime datoteke
    $slika_tmp = $_FILES['slika']['tmp_name']; // Privremeno ime datoteke
    $tekst = $_POST['tekst'];
    $arhiva = isset($_POST['arhiva']) ? 1 : 0; // Ako je odabrana potvrdna kućica, postavi arhiva na 1, inače 0
    
    // Premjesti prenesenu datoteku u odredišnu mapu
    $upload_directory = "./Slike/";
    $upload_file = $upload_directory . basename($slika);
    move_uploaded_file($slika_tmp, $upload_file);
    
    // Umetni vijest u bazu podataka
    $sql = "INSERT INTO vijesti (naslov, naslovna_slika, sadrzaj, datum, arhivirano) VALUES (?, ?, ?, NOW(), ?)";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $naslov, $slika, $tekst, $arhiva);
        if (mysqli_stmt_execute($stmt)) {
            // Dohvati ID umetnute vijesti
            $news_id = mysqli_insert_id($db);
            echo "Vijest uspješno dodana.";
            
            // Stvori novu datoteku za vijest u mapi "objave"
            $file_content = generateFileContent($db, $news_id, $naslov, $tekst);
            $file_name = "objave/vijest-$news_id.php";
            file_put_contents($file_name, $file_content);
        } else {
            echo "Greška pri dodavanju vijesti: " . mysqli_error($db);
        }
    } else {
        echo "Greška pri pripremi SQL upita: " . mysqli_error($db);
    }
}

// Upravljaj uređivanjem vijesti
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_news'], $_POST['news_id']) && $dozvole['edit_news']) {
    $news_id = $_POST['news_id'];
    // Preusmjeri na stranicu za uređivanje vijesti
    header("Location: edit_news.php?id=$news_id");
    exit;
}

// Upravljaj brisanjem vijesti
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_news'], $_POST['news_id']) && $dozvole['delete_news']) {
    $news_id = $_POST['news_id'];
    // Obriši vijest
    $sql = "DELETE FROM vijesti WHERE id = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $news_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Vijest uspješno obrisana.";
        } else {
            echo "Greška pri brisanju vijesti: " . mysqli_error($db);
        }
    } else {
        echo "Greška pri pripremi SQL upita: " . mysqli_error($db);
    }
}

// Upravljaj odobravanjem vijesti od strane administratora
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve_news']) && $dozvole['approve_news']) {
    $news_id = $_POST['news_id'];
    // Odobri vijest
    $sql = "UPDATE vijesti SET approved = 1 WHERE id = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $news_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Vijest uspješno odobrena.";
        } else {
            echo "Greška pri odobravanju vijesti: " . mysqli_error($db);
        }
    } else {
        echo "Greška pri pripremi SQL upita: " . mysqli_error($db);
    }
}

// Dohvati korisnike ako korisnik ima dozvolu
if ($dozvole['manage_users']) {
    // Dohvati korisnike
    $sql_users = "SELECT id, korisnicko_ime, email_adresa, rola, approved FROM korisnici";
    $result_users = mysqli_query($db, $sql_users);
}

// Dohvati vijesti ako korisnik ima dozvolu
if ($dozvole['add_news'] || $dozvole['edit_news'] || $dozvole['delete_news'] || $dozvole['approve_news'] || $dozvole['archive_news']) {
    // Dohvati vijesti
    $sql_news = "SELECT id, naslov, naslovna_slika, datum, arhivirano, approved FROM vijesti";
    $result_news = mysqli_query($db, $sql_news);
}

// Funkcija za generiranje sadržaja datoteke s PHP kodom za dohvaćanje vijesti
function generateFileContent($db, $news_id, $naslov, $tekst) {
    // Počni sastavljati PHP sadržaj
    $sadrzaj = "<?php\n";
    $sadrzaj .= "include(\"../mysql_veza.php\");\n\n";
    
    // SQL upit za dohvaćanje vijesti iz baze podataka
    $sadrzaj .= "\$sql_upit = \"SELECT naslov, datum, sadrzaj, naslovna_slika FROM vijesti WHERE id = $news_id\";";
    $sadrzaj .= "\$rezultat = mysqli_query(\$db, \$sql_upit);";
    $sadrzaj .= "\$redak = mysqli_fetch_assoc(\$rezultat);";
    
    // PHP kod za prikaz vijesti
    $sadrzaj .= "?>\n";
    $sadrzaj .= "<!doctype HTML>\n";
    $sadrzaj .= "<html lang=\"hr\">\n";
    $sadrzaj .= "<head>\n";
    $sadrzaj .= "<link rel=\"stylesheet\" href=\"../css/objava.css\">\n";
    $sadrzaj .= "<title><?php echo \$naslov; ?></title>\n";
    $sadrzaj .= "<meta charset=\"UTF-8\" name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\">\n";
    $sadrzaj .= "</head>\n";
    $sadrzaj .= "<body>\n";
    $sadrzaj .= "<div class=\"sadrzaj-objave\">\n";
    $sadrzaj .= "<img src=\"<?php echo htmlspecialchars(\"../Slike/\".\$redak['naslovna_slika']); ?>\" alt=\"Naslovna slika\">\n";
    $sadrzaj .= "<h2><?php echo htmlspecialchars(\$redak['naslov']); ?></h2>\n";
    $sadrzaj .= "<time datetime=\"<?php echo htmlspecialchars(\$redak['datum']); ?>\"><?php echo htmlspecialchars(\$redak['datum']); ?></time>\n";
    $sadrzaj .= "<p><?php echo nl2br(htmlspecialchars(\$redak['sadrzaj'])); ?></p>\n";
    $sadrzaj .= "<a href=\"../index.php?menu=5\">Nazad na sve vijesti!</a>\n";
    $sadrzaj .= "</div>\n";
    $sadrzaj .= "</body>\n";
    
    return $sadrzaj;
}

?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Admin Panel</title>
    <link rel="stylesheet" href="./css/cms.css">
</head>
<body>
    <?php if ($dozvole['manage_users']) : ?>
    <h1>Upravljanje korisnicima</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Korisničko ime</th>
            <th>Email</th>
            <th>Uloga</th>
            <th>Odobren</th>
            <th>Akcija</th>
        </tr>
        <?php while ($redak = mysqli_fetch_assoc($result_users)) : ?>
            <tr>
                <td><?php echo $redak['id']; ?></td>
                <td><?php echo $redak['korisnicko_ime']; ?></td>
                <td><?php echo $redak['email_adresa']; ?></td>
                <td><?php echo $redak['rola']; ?></td>
                <td><?php echo $redak['approved'] ? 'Da' : 'Ne'; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="user_id" value="<?php echo $redak['id']; ?>">
                        <button type="submit" name="edit">Uredi</button>
                        <button type="submit" name="delete">Obriši</button>
                        <?php if (!$redak['approved']) : ?>
                            <button type="submit" name="approve">Odobri</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
    
    <?php if ($dozvole['add_news'] || $dozvole['edit_news'] || $dozvole['delete_news'] || $dozvole['approve_news'] || $dozvole['archive_news']) : ?>
    <!-- Obrazac za dodavanje vijesti -->
    <h1>Dodaj novi članak</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="naslov">Naslov:</label><br>
        <input type="text" id="naslov" name="naslov" required><br>
        <label for="slika">Slika:</label><br>
        <input type="file" id="slika" name="slika" accept="image/*" required><br>
        <label for="tekst">Tekst:</label><br>
        <textarea id="tekst" name="tekst" rows="4" required></textarea><br>
        <label for="arhiva">Arhiva:</label>
        <input type="checkbox" id="arhiva" name="arhiva" value="1"><br>
        <!-- Dodatna polja za više slika ako je potrebno -->
        <input type="submit" name="add_news" value="Dodaj vijest">
    </form>

    <!-- Popis vijesti -->
    <h1>Članci</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Naslov</th>
            <th>Slika</th>
            <th>Datum</th>
            <th>Arhivirano</th>
            <th>Odobreno</th>
            <th>Akcija</th>
        </tr>
        <?php while ($vijest = mysqli_fetch_assoc($result_news)) : ?>
            <tr>
                <td><?php echo $vijest['id']; ?></td>
                <td><?php echo $vijest['naslov']; ?></td>
                <td><img src="<?php echo "./Slike/" . $vijest['naslovna_slika']; ?>" alt="Slika članka" width="100"></td>
                <td><?php echo $vijest['datum']; ?></td>
                <td><?php echo $vijest['arhivirano'] ? 'Da' : 'Ne'; ?></td>
                <td><?php echo $vijest['approved'] ? 'Da' : 'Ne'; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="news_id" value="<?php echo $vijest['id']; ?>">
                        <button type="submit" name="edit_news">Uredi</button>
                        <button type="submit" name="delete_news">Obriši</button>
                        <?php if (!$vijest['approved'] && $dozvole['approve_news']) : ?>
                            <button type="submit" name="approve_news">Odobri</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
    
    <a href="./index.php">Napusti CMS panel</a> ili <a href="./racun/odjava.php">Odjavi se</a>
    
</body>
</html>
