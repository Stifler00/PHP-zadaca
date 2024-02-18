<?php
// Fetch approved news articles from the database
$sql = "SELECT * FROM vijesti WHERE approved = 1";
$result = mysqli_query($db, $sql);

// Check if there are any approved news articles
if (mysqli_num_rows($result) > 0) {
    // Loop through each row of the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Truncate the news content to a certain number of characters
        $short_content = substr($row['sadrzaj'], 0, 200); // Adjust the number of characters as needed

        // Display each news article dynamically
?>
        <div class="objava">
            <a href="objave/vijest-<?php echo $row['id']; ?>.php" target="_blank"><img src="<?php echo "./Slike/". $row['naslovna_slika']; ?>"></a>
            <div>
                <a href="objave/vijest-<?php echo $row['id']; ?>.php" target="_blank"><h2><?php echo $row['naslov']; ?></h2></a>
                <p><?php echo $short_content; ?>... <a href="objave/vijest-<?php echo $row['id']; ?>.php" target="_blank">Pročitaj više!</a></p>
                <time datetime="<?php echo $row['datum']; ?>"><?php echo date('d. M Y.', strtotime($row['datum'])); ?></time>
            </div>
        </div>
<?php
    }
} else {
    // Display a message if no approved news articles are found
    echo "<p>Trenutno nema odobrenih vijesti.</p>";
}
?>
