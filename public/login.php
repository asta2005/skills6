<?php
// Start de sessie
session_start();

// Vereis de databaseverbinding
require_once('../source/database.php');  // Zorg ervoor dat het pad naar database.php klopt

// Als het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verkrijg de gegevens van het formulier
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validatie: Controleer of de velden niet leeg zijn
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Alle velden zijn verplicht!";
        header("Location: login.php");
        exit;
    }

    // Verifieer de gebruikersgegevens in de database
    if (isset($pdo)) {  // Controleer of $pdo goed is geïnitialiseerd
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Sla de gebruiker op in de sessie
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            $_SESSION['success'] = "Welkom, " . $user['username'] . "! Je bent succesvol ingelogd.";

            // Redirect op basis van rol
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $_SESSION['error'] = "Ongeldige gebruikersnaam of wachtwoord!";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Kan geen verbinding maken met de database.";
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container">
    <div class="login-box">
        <h2>Inloggen</h2>

        <!-- Meldingen weergeven -->
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            echo "<p style='color:green;'>" . $_SESSION['success'] . "</p>";
            unset($_SESSION['success']);
        }
        ?>

        <!-- Inlogformulier -->
        <form action="login.php" method="POST">
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Inloggen</button>
        </form>

        <p class="cta">Geen account? <a href="register.php">Registreren</a></p>
    </div>
</div>
</body>
</html>
