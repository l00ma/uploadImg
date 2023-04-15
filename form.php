<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload a file</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <form action="result.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="imageUpload">Upload a profile image</label>
            <input type="file" name="avatar" id="imageUpload" />
        </div>
        <div>
            <label for="nom">LastName :</label>
            <input type="text" id="nom" name="user_name" required>
        </div>
        <div>
            <label for="prenom">FirstName :</label>
            <input type="text" id="prenom" name="user_firstname" required>
        </div>
        <div>
            <button name="send">Send</button>
    </form>

</body>

</html>