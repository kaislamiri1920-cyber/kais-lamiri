<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Freelance | Kais Lamiri</title>
    <link rel="stylesheet" href="giminay.css">
</head>
<body>

<header>
    <h1>Commande de Travail Freelance</h1>
    <p>Des solutions web et techniques sur mesure pour vos projets.</p>
</header>

<div class="container">
    <div class="section">
        <h2>Pourquoi travailler avec moi ?</h2>
        <ul>
            <li>Développement web, systèmes et bases de données.</li>
            <li>Respect des délais et communication claire.</li>
            <li>Design professionnel et expérience utilisateur soignée.</li>
        </ul>
    </div>

    <div class="section">
        <h2>Services Freelance</h2>
        <div class="grid">
            <div class="card">
                <h3>Création de site</h3>
                <p>Sites vitrines, portfolios et landing pages responsives.</p>
            </div>
            <div class="card">
                <h3>Applications</h3>
                <p>Scripts, outils métier et interfaces de gestion sur mesure.</p>
            </div>
            <div class="card">
                <h3>Support technique</h3>
                <p>Maintenance, optimisation et déploiement de projets.</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Mes Coordonnées</h2>
        <p>Pour toute question ou urgence, contactez-moi :</p>
        <ul>
            <li><strong>Email :</strong> <a href="mailto:kaislamiri1920@gmail.com">kaislamiri1920@gmail.com</a></li>
            <li><strong>Téléphone :</strong> +33 6 00 00 00 00</li>
            <li><strong>Site web :</strong> <a href="https://votre-site.com" target="_blank">votre-site.com</a></li>
        </ul>
    </div>

    <div class="section">
        <h2>Commander un projet</h2>
        <p>Envoyez-moi votre demande avec le type de projet, le délai prévu et les fonctionnalités souhaitées.</p>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Connexion à la base de données
            $servername = "localhost";
            $username = "root"; // Utilisateur par défaut XAMPP
            $password = ""; // Mot de passe vide par défaut
            $dbname = "freelance_orders";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connexion échouée: " . $conn->connect_error);
            }

            // Récupération des données du formulaire
            $nom_client = $_POST['Nom'];
            $email = $_POST['Email'];
            $telephone = $_POST['Téléphone'];
            $type_projet = $_POST['Projet'];
            $delai_souhaite = $_POST['Délai'];
            $details = $_POST['Détails'];
            $budget = $_POST['Budget'];
            $preference_contact = $_POST['Préférence de contact'];

            // Préparation de la requête
            $stmt = $conn->prepare("INSERT INTO commandes_freelance (nom_client, email, telephone, type_projet, delai_souhaite, details, budget, preference_contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $nom_client, $email, $telephone, $type_projet, $delai_souhaite, $details, $budget, $preference_contact);

            if ($stmt->execute()) {
                echo "<div style='background-color: #e7f3e7; padding: 10px; border: 1px solid #c3e6c3; margin-bottom: 20px;'>";
                echo "<h3>Votre commande a été enregistrée avec succès !</h3>";
                echo "<p><strong>Vos coordonnées :</strong></p>";
                echo "<ul>";
                echo "<li>Nom : " . htmlspecialchars($nom_client) . "</li>";
                echo "<li>Email : " . htmlspecialchars($email) . "</li>";
                echo "<li>Téléphone : " . htmlspecialchars($telephone) . "</li>";
                echo "<li>Préférence de contact : " . htmlspecialchars($preference_contact) . "</li>";
                echo "</ul>";
                echo "<p>Votre commande est en attente de confirmation officielle. Nous vous contacterons dans un délai maximum de 48 heures pour valider les détails et établir un devis.</p>";
                echo "</div>";
            } else {
                echo "<p style='color: red;'>Erreur lors de l'enregistrement: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
        <form class="form-box" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="client-name">Nom du client</label>
                <input id="client-name" name="Nom" type="text" placeholder="Votre nom complet" required>
            </div>
            <div class="form-group">
                <label for="client-email">Email</label>
                <input id="client-email" name="Email" type="email" placeholder="Votre adresse email" required>
            </div>
            <div class="form-group">
                <label for="client-phone">Téléphone</label>
                <input id="client-phone" name="Téléphone" type="tel" placeholder="Numéro de téléphone" required>
            </div>
            <div class="form-group">
                <label for="contact-preference">Préférence de contact</label>
                <select id="contact-preference" name="Préférence de contact">
                    <option>Email</option>
                    <option>Téléphone</option>
                    <option>Les deux</option>
                </select>
            </div>
            <div class="form-group">
                <label for="project-type">Type de projet</label>
                <select id="project-type" name="Projet">
                    <option>Site web</option>
                    <option>Application</option>
                    <option>Maintenance / Support</option>
                    <option>Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="project-deadline">Délai souhaité</label>
                <input id="project-deadline" name="Délai" type="text" placeholder="Par exemple : 2 semaines">
            </div>
            <div class="form-group">
                <label for="project-budget">Budget estimé</label>
                <input id="project-budget" name="Budget" type="text" placeholder="Par exemple : 500-1000€">
            </div>
            <div class="form-group">
                <label for="project-details">Détails du projet</label>
                <textarea id="project-details" name="Détails" rows="5" placeholder="Décrivez votre besoin, fonctionnalités, budget, etc." required></textarea>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="Accepter les termes" required>
                    J'accepte les termes de service et la politique de confidentialité.
                </label>
            </div>
            <button type="submit" class="button">Envoyer la demande</button>
        </form>
        <div class="confirmation-note">
            <p><strong>Après l'envoi :</strong> Vous recevrez un email de confirmation. Je vous appellerai sous 24 heures pour discuter de votre projet et établir un devis détaillé.</p>
            <p>Pour toute urgence, contactez-moi directement à <a href="mailto:kaislamiri1920@gmail.com" style="color: var(--accent);">kaislamiri1920@gmail.com</a>.</p>
        </div>
    </div>
</div>

</body>
</html>