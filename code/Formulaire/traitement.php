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

    function getUsersFromFile($file) {
        if (!file_exists($file)) {
            return [];
        }
        $data = file_get_contents($file); 
        $users = json_decode($data, true); 
        
        if (!is_array($users)) {
            $users = []; 
        }

        return $users;
    }

    function saveUserToFile($file, $user) {
        $users = getUsersFromFile($file); // Récupère les utilisateurs actuels
        $users[] = $user; // Ajoute le nouvel utilisateur
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT)); // Sauvegarde dans le fichier
    }

    function saveLogoToFile($file, $email, $logoPath) {
        $users = getUsersFromFile($file);
        foreach ($users as &$user) {
            if ($user['email'] === $email) {
                $user['logo'] = $logoPath; // Remplace le logo de l'utilisateur
                break;
            }
        }
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT)); // Sauvegarde les modifications
    }

    $userFile = 'user.json'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Traitement de l'inscription ou de la mise à jour du logo
        if (isset($_POST['update_logo'])) {
            // Vérification de la validité du fichier image téléchargé
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
                $targetDir = "img/"; 
                $targetFile = $targetDir . basename($_FILES['logo']['name']);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Vérification du type de fichier image
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($imageFileType, $allowedTypes)) {
                    move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile); // Déplace le fichier téléchargé dans le dossier img
                    // Met à jour le fichier JSON avec le nouveau chemin du logo
                    saveLogoToFile($userFile, $_POST['email'], $targetFile); 
                    echo "<h2>Logo mis à jour avec succès !</h2>";
                } else {
                    echo "<h2>Format de fichier non valide. Seules les images JPG, JPEG, PNG et GIF sont autorisées.</h2>";
                }
            } else {
                echo "<h2>Aucun fichier sélectionné ou erreur lors du téléchargement.</h2>";
            }
        } else {
            // Traitement de l'inscription
            $name = htmlspecialchars($_POST['name'] ?? '');
            $prenom = htmlspecialchars($_POST['prénom'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = htmlspecialchars($_POST['password'] ?? '');
            $message = htmlspecialchars($_POST['message'] ?? '');
            $of_age = isset($_POST['of_age']) ? 'Oui' : 'Non';

            $errors = [];

            if (empty($name)) $errors[] = 'Le champ "Nom" est obligatoire.';
            if (empty($prenom)) $errors[] = 'Le champ "Prénom" est obligatoire.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
            if (strlen($password) < 8) $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
            if (empty($message)) $errors[] = 'Le champ "Message" est obligatoire.';
            if ($of_age === 'Non') $errors[] = 'Vous devez être majeur.';

            if (!empty($errors)) {
                echo '<h1>Erreurs</h1><ul class="error">';
                foreach ($errors as $error) {
                    echo "<li>$error</li>";
                }
                echo '</ul>';
            } else {
                
                $users = getUsersFromFile($userFile);
                $existingUser = null;
                foreach ($users as $user) {
                    if ($user['email'] === $email) {
                        $existingUser = $user;
                        break;
                    }
                }

                if ($existingUser) {
                    $logo = $existingUser['logo'] ?? '';
                    echo '<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">';
                    if (!empty($logo)) {
                        echo '<img src="' . htmlspecialchars($logo) . '" alt="User Logo" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">';
                    } else {
                        echo '<div style="width: 150px; height: 150px; border-radius: 50%; background-color: #ccc; margin-bottom: 10px;"></div>';
                    }
                    echo '<div style="font-size: 20px; font-weight: bold;">' . htmlspecialchars($existingUser['name']) . ' ' . htmlspecialchars($existingUser['prenom']) . '</div>';
                    echo '<form method="POST" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="email" value="' . htmlspecialchars($existingUser['email']) . '">';
                    echo '<input type="file" name="logo" accept="image/*">';
                    echo '<button type="submit" name="update_logo">Modifier le logo</button>';
                    echo '</form>';
                    echo '</div>';
                } else {
                    $newUser = [
                        'name' => $name,
                        'prenom' => $prenom,
                        'email' => $email,
                        'message' => $message,
                        'password' => password_hash($password, PASSWORD_BCRYPT),
                        'of_age' => $of_age,
                        'logo' => "img/logo.jpg"
                    ];
                    saveUserToFile($userFile, $newUser);

                    echo '<h1>Bienvenue ' . $name . ' ' . $prenom . '!</h1>';
                    echo '<img src="' . htmlspecialchars($newUser['logo']) . '" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">';
                }
            }
        }
    } else {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit; 
    }
    ?>



    </div>
</body>

</html>
