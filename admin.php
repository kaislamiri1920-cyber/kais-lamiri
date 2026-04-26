<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "freelance_orders";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Traitement de la confirmation
if (isset($_GET['confirm']) && is_numeric($_GET['confirm'])) {
    $id = $_GET['confirm'];
    $stmt = $conn->prepare("UPDATE commandes_freelance SET status = 'confirmed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo "<p style='color: green;'>Commande confirmée avec succès.</p>";
}

// Récupération des commandes
$sql = "SELECT * FROM commandes_freelance ORDER BY date_creation DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau Admin - Commandes Freelance</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 20px; 
            background: #f8f9fa;
            color: #2c3e50;
        }
        h1 { 
            color: #3498db; 
            text-align: center; 
            margin-bottom: 30px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td { 
            border: 1px solid #e9ecef; 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background-color: #3498db; 
            color: white;
        }
        .pending { 
            color: #e67e22; 
            font-weight: bold;
        }
        .confirmed { 
            color: #27ae60; 
            font-weight: bold;
        }
        a { 
            text-decoration: none; 
            color: #3498db; 
            font-weight: bold;
        }
        a:hover { 
            text-decoration: underline; 
        }
        p { 
            text-align: center; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>
    <h1>Panneau d'Administration - Commandes Freelance</h1>
    <p><a href="commande-freelance.php">Retour à la page de commande</a></p>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom Client</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Type Projet</th>
            <th>Délai</th>
            <th>Budget</th>
            <th>Préférence Contact</th>
            <th>Détails</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $status_class = $row['status'] == 'confirmed' ? 'confirmed' : 'pending';
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['nom_client']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['telephone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['type_projet']) . "</td>";
                echo "<td>" . htmlspecialchars($row['delai_souhaite']) . "</td>";
                echo "<td>" . htmlspecialchars($row['budget']) . "</td>";
                echo "<td>" . htmlspecialchars($row['preference_contact']) . "</td>";
                echo "<td>" . htmlspecialchars($row['details']) . "</td>";
                echo "<td class='$status_class'>" . ucfirst($row['status']) . "</td>";
                echo "<td>" . $row['date_creation'] . "</td>";
                if ($row['status'] == 'pending') {
                    echo "<td><a href='?confirm=" . $row['id'] . "'>Confirmer</a></td>";
                } else {
                    echo "<td>Confirmée</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12'>Aucune commande trouvée.</td></tr>";
        }
        ?>
    </table>
    <?php
    $conn->close();
    ?>
</body>
</html>