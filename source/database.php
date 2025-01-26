<?php
$host = 'mariadb'; // De hostnaam is de naam van je database container
$dbname = 'omarkahouach'; // Je database naam
$username = 'omar'; // Je database gebruiker
$password = 'khaled'; // Je wachtwoord

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Verbonden met de database!";
} catch (PDOException $e) {
    echo "Fout bij verbinden met de database: " . $e->getMessage();
}
