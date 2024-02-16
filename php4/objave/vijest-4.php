<?php
include("../mysql_veza.php");

$sql_query = "SELECT naslov, datum, sadrzaj, naslovna_slika FROM vijesti WHERE id = 4";$result = mysqli_query($db, $sql_query);$row = mysqli_fetch_assoc($result);?>
<!doctype HTML>
<html lang="hr">
<head>
<link rel="stylesheet" href="../css/objava.css">
<title><?php echo $naslov; ?></title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
</head>
<body>
<div class="sadrzaj-objave">
<img src="<?php echo htmlspecialchars("../Slike/".$row['naslovna_slika']); ?>" alt="Naslovna slika">
<h2><?php echo htmlspecialchars($row['naslov']); ?></h2>
<time datetime="<?php echo htmlspecialchars($row['datum']); ?>"><?php echo htmlspecialchars($row['datum']); ?></time>
<p><?php echo nl2br(htmlspecialchars($row['sadrzaj'])); ?></p>
<a href="../index.php?menu=5">Nazad na sve vijesti!</a>
</div>
</body>
