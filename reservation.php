<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";

if (isset($_POST['reserver'])) {
    $conn = new mysqli("localhost", "root", "", "aeroport");

    if ($conn->connect_error) {
        $message = "Erreur de connexion : " . $conn->connect_error;
    } else {
        $nom = $conn->real_escape_string($_POST['nom']);
        $email = $conn->real_escape_string($_POST['email']);
        $date = $conn->real_escape_string($_POST['date']);
        $destination = $conn->real_escape_string($_POST['destination']);
        $passagers = (int) $_POST['passagers'];

        $sql = "INSERT INTO reservations (nom, email, date_depart, destination, passagers)
                VALUES ('$nom', '$email', '$date', '$destination', $passagers)";

        if ($conn->query($sql) === TRUE) {
            $message = "Réservation enregistrée avec succès !";
        } else {
            $message = "Erreur : " . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>
    <div class="banner">
        <h1 class="animated-title">Bienvenue sur la page de réservation</h1>
        <img src="aeroport.jpg" alt="Aéroport">
    </div>

    <form method="POST" action="reservation.php" class="formulaire">
        <input type="text" name="nom" placeholder="Nom complet" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="date" name="date" required>
        <input type="text" name="destination" placeholder="Destination" required>
        <input type="number" name="passagers" placeholder="Nombre de passagers" min="1" required>
        <button type="submit" name="reserver">Réserver</button>
    </form>

    <?php if (!empty($message)): ?>
    <div class="popup" id="popup">
        <div class="popup-content">
            <p><?php echo $message; ?></p>
            <button onclick="document.getElementById('popup').style.display='none';">OK</button>
        </div>
    </div>
    <?php endif; ?>

    <script>
        setTimeout(() => {
            const pop = document.getElementById("popup");
            if (pop) pop.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>
