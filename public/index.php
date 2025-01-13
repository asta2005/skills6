<?php
// Haal de databaseconfiguratie uit de omgevingsvariabelen
$host = getenv('DB_HOST'); // Naam van de service in docker-compose.yml (mariadb)
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USERNAME');
$db_password = getenv('DB_PASSWORD');
$db_port = 3306; // Standaard MariaDB/MySQL-poort

// Controleer of de omgevingsvariabelen aanwezig zijn
if (!$host || !$db_name || !$db_user || !$db_password) {
    die('Fout: Omgevingsvariabelen voor de database zijn niet correct ingesteld.');
}

// Maak verbinding met de database
$mysqli = new mysqli($host, $db_user, $db_password, $db_name, $db_port);

// Controleer de verbinding
if ($mysqli->connect_error) {
    die('Databaseverbinding mislukt: ' . $mysqli->connect_error);
}

// SQL-query om gegevens op te halen
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
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
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
