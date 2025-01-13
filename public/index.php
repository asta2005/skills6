<?php
// Databaseconfiguratie via omgeving (zoals opgegeven in je docker-compose.yml)
$host = 'mariadb'; // Naam van de service in docker-compose.yml
$db_name = getenv('DB_NAME'); // Haalt de database-naam op uit omgevingsvariabelen
$db_user = getenv('DB_USERNAME'); // Haalt de gebruikersnaam op
$db_password = getenv('DB_PASSWORD'); // Haalt het wachtwoord op
$db_port = 3306; // Standaard MariaDB/MySQL-poort

// Maak verbinding met de database
$mysqli = new mysqli($host, $db_user, $db_password, $db_name, $db_port);

// Controleer de verbinding
if ($mysqli->connect_error) {
    die('Databaseverbinding mislukt: ' . $mysqli->connect_error);
}

// Haal gegevens op uit de Tijdsloten-tabel en voeg informatie toe via JOIN
$sql = "
    SELECT 
        t.Id AS Tijdslot_ID,
        t.Dag,
        ts.Tijdstip,
        p.Papierformaat,
        s.Status,
        k.Naam AS KlantNaam,
        t.Extra_info,
        a.Naam AS AdminNaam
    FROM Tijdsloten t
    JOIN Tijdstippen ts ON t.`Tijdslot-id` = ts.Id
    JOIN Papierformaten p ON t.`Papierformaten-id` = p.Id
    JOIN Status s ON t.`Status-id` = s.Id
    JOIN klanten k ON t.`Klanten-id` = k.Id
    LEFT JOIN Admin_users a ON t.`Admin-bewerkt-id` = a.Id
    ORDER BY t.Dag ASC
";

// Voer de query uit
$result = $mysqli->query($sql);

// Controleer of er resultaten zijn
if ($result && $result->num_rows > 0) {
    echo "<h1>Tijdsloten Overzicht</h1>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Tijdslot ID</th>
            <th>Dag</th>
            <th>Tijdstip</th>
            <th>Papierformaat</th>
            <th>Status</th>
            <th>Klantnaam</th>
            <th>Extra Info</th>
            <th>Beheerd door (Admin)</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Tijdslot_ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Dag']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Tijdstip']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Papierformaat']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['KlantNaam']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Extra_info']) . "</td>";
        echo "<td>" . htmlspecialchars($row['AdminNaam'] ?? 'Niet toegewezen') . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Geen tijdsloten gevonden.</p>";
}

// Sluit de databaseverbinding
$mysqli->close();
?>
