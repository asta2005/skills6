<?php
include 'db.php';

$query = $db->query("SHOW TABLES");
$tables = $query->fetchAll(PDO::FETCH_COLUMN);

echo "Beschikbare tabellen in database '$dbname':<br>";
foreach ($tables as $table) {
    echo "- $table<br>";
}
?>
