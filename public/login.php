<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = $db->prepare("SELECT * FROM " . ($role === 'admin' ? "Admin_users" : "Klanten") . " WHERE Gebruikersnaam = ? AND Wachtwoord = ?");
    $query->execute([$username, $password]);
    $user = $query->fetch();

    if ($user) {
        $_SESSION['user'] = $user;
        $_SESSION['role'] = $role;
        header('Location: dashboard.php');
    } else {
        echo "Ongeldige inloggegevens.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="username" placeholder="Gebruikersnaam" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="klant">Klant</option>
        </select>
        <button type="submit">Inloggen</button>
    </form>
</body>
</html>
