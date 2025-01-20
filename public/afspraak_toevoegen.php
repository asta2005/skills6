<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $klanten_id = $_POST['klanten_id'];
    $dag = $_POST['dag'];
    $tijdslot_id = $_POST['tijdslot_id'];
    $papierformaten_id = $_POST['papierformaten_id'];
    $extra_info = $_POST['extra_info'];
    $admin_bewerkt_id = $_SESSION['user']['Id'];
    $status_id = 1; // Standaard status

    $query = $db->prepare("INSERT INTO Tijdsloten (Klanten-id, Dag, Tijdslot-id, Papierformaten-id, Extra info, Admin-bewerkt-id, Status-id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $query->execute([$klanten_id, $dag, $tijdslot_id, $papierformaten_id, $extra_info, $admin_bewerkt_id, $status_id]);

    echo "Afspraak toegevoegd!";
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Afspraak toevoegen</title>
</head>
<body>
    <form method="POST">
        <label>Klant ID:</label>
        <input type="number" name="klanten_id" required>
        <label>Dag:</label>
        <input type="date" name="dag" required>
        <label>Tijdslot ID:</label>
        <input type="number" name="tijdslot_id" required>
        <label>Papierformaten ID:</label>
        <input type="number" name="papierformaten_id" required>
        <label>Extra info:</label>
        <textarea name="extra_info"></textarea>
        <button type="submit">Toevoegen</button>
    </form>
</body>
</html>
