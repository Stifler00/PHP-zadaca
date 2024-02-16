<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API</title>
    <link rel="stylesheet" href="../css/api.css">
</head>

<body>
<h1>API</h1>
    <form method="GET">
        <label for="group">Odaberite grupu za koju želite dobiti tablicu rezultata:</label>
        <select name="group" id="group">
            <option value="A">Grupa A</option>
            <option value="B">Grupa B</option>
            <option value="C">Grupa C</option>
            <option value="D">Grupa D</option>
            <option value="E">Grupa E</option>
            <option value="F">Grupa F</option>
            <option value="G">Grupa G</option>
            <option value="H">Grupa H</option>
        </select>
        <button type="submit">Potvrdi</button>
    </form>

<?php
// Provjera da li je grupa odabrana
if(isset($_GET['group'])) {
    // Generiraj API url
    $apiUrl = "https://livescore-api.com/api-client/leagues/table.json?key=3TPRFI8np5qqYnjQ&secret=5NisV87RABg0q9Qu3FmIou6NAwdyTxoZ&competition_id=244&group=" . $_GET['group'];

    // Dohvaćanje podataka sa API-ja
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Provjera da li je API response uspješan
    if(isset($data['success']) && $data['success'] == true) {
        if(isset($data['data']['table']) && count($data['data']['table']) > 0) {
            // Zaglavlje tablice
            echo "<h2>UEFA Liga Prvaka 2024 - Grupa " . $_GET['group'] . "</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Tim</th><th>Rank</th><th>Bodovi</th><th>Utakmice</th><th>Gol razlika</th><th>Postignuti golovi</th><th>Primljeni golovi</th><th>Gubitci</th><th>Nerješeno</th><th>Pobjede</th></tr>";

            // Petlja kroz sve podatke API-ja
            foreach($data['data']['table'] as $team) {
                echo "<tr>";
                echo "<td>" . $team['name'] . "</td>";
                echo "<td>" . $team['rank'] . "</td>";
                echo "<td>" . $team['points'] . "</td>";
                echo "<td>" . $team['matches'] . "</td>";
                echo "<td>" . $team['goal_diff'] . "</td>";
                echo "<td>" . $team['goals_scored'] . "</td>";
                echo "<td>" . $team['goals_conceded'] . "</td>";
                echo "<td>" . $team['lost'] . "</td>";
                echo "<td>" . $team['drawn'] . "</td>";
                echo "<td>" . $team['won'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Nema dostupnih podataka za grupu " . $_GET['group'];
        }
    } else {
        echo "API je trenutno nedostupan. Pokušajte malo kasnije.";
    }
}
?>

<a href="../index.php" class="gumb-nazad">Povratak na glavnu stranicu</a>

</body>