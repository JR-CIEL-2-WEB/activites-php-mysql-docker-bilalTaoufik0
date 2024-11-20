<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du Formulaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
        }

        .success {
            color: #28a745;
            font-size: 14px;
        }

        .data-row {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .data-row:last-child {
            border-bottom: none;
        }

        .data-label {
            font-weight: bold;
            color: #495057;
        }

        .data-value {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name'] ?? '');
            $prenom = htmlspecialchars($_POST['prénom'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = htmlspecialchars($_POST['password'] ?? '');
            $message = htmlspecialchars($_POST['message'] ?? '');
            $of_age = isset($_POST['of_age']) ? 'Oui' : 'Non';

            $errors = [];

            // Validation des champs
            if (empty($name)) $errors[] = 'Le champ "Nom" est obligatoire.';
            if (empty($prenom)) $errors[] = 'Le champ "Prénom" est obligatoire.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
            if (strlen($password) < 8) $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
            if (empty($message)) $errors[] = 'Le champ "Message" est obligatoire.';
            if ($of_age === 'Non') $errors[] = 'Vous devez être majeur.';

            // Affichage des erreurs ou des données
            if (!empty($errors)) {
                echo '<h1>Erreurs</h1>';
                echo '<ul class="error">';
                foreach ($errors as $error) {
                    echo "<li>$error</li>";
                }
                echo '</ul>';
            } else {
                echo '<h1>Données Reçues</h1>';
                echo '<div class="data-row"><span class="data-label">Nom :</span> <span class="data-value">' . $name . '</span></div>';
                echo '<div class="data-row"><span class="data-label">Prénom :</span> <span class="data-value">' . $prenom . '</span></div>';
                echo '<div class="data-row"><span class="data-label">Email :</span> <span class="data-value">' . $email . '</span></div>';
                echo '<div class="data-row"><span class="data-label">Message :</span> <span class="data-value">' . $message . '</span></div>';
                echo '<div class="data-row"><span class="data-label">Majeur :</span> <span class="data-value">' . $of_age . '</span></div>';
                echo '<div class="data-row"><span class="data-label">Mot de passe :</span> <span class="data-value">(non affiché pour des raisons de sécurité)</span></div>';
            }
        } else {
            echo '<h1>Accès non autorisé</h1>';
            echo '<p class="error">Veuillez soumettre le formulaire pour accéder à cette page.</p>';
        }
        ?>
    </div>
</body>

</html>
