<?php
$errors = [];
$fileName = "";
// Je vérifie si le formulaire est soumis comme d'habitude
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Securité en php
    $data = array_map('trim', $_POST);
    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
    $uploadDir = 'public/uploads/';
    // Je récupère l'extension du fichier
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client (mais d'autre stratégies de nommage sont possibles)
    $uploadFile = $uploadDir . uniqid("img_") . '.' . $extension;
    // Les extensions autorisées
    $authorizedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    // Le poids max géré par PHP par défaut est de 2M
    // Ici on choisi 1Mo
    $maxFileSize = 1048576;

    // Je sécurise et effectue mes tests
    if (!isset($data['user_name']) || empty($data['user_name'])) {
        $errors[] = 'Lastname is mandatory';
    }

    if (!isset($data['user_firstname']) || empty($data['user_firstname'])) {
        $errors[] = 'Firstname is mandatory';
    }

    /****** Si l'extension est autorisée *************/
    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg, Jpeg, Png ou Webp!';
    }

    /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 2Mo!";
    }

    /****** Si je n'ai pas d"erreur alors j'upload *************/
    if (empty($errors)) {
        // on déplace le fichier temporaire vers le nouvel emplacement sur le serveur. Ça y est, le fichier est uploadé
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        $fileName = $uploadFile;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File posted</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="errorPanel">
        <?php
        if (!empty($errors)) { ?>
            <p>Errors found: </p>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php } else { ?>
            <div>
                <ul>
                    <li>LastName : <span><?= htmlentities($data['user_name']) ?></span></li>
                    <li>FirstName: <span><?= htmlentities($data['user_firstname']) ?></span></li>
                </ul>
                <img src="<?php echo $fileName ?>" alt="image">
            </div>
        <?php } ?>
    </div>
</body>

</html>