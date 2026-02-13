<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Inserer une nouvelle Categorie</h1>
    <form action="<?=BASE_URL?>/insertioncategory" method="POST" enctype="multipart/form-data">
        <p>Nom du Categorie : <input type="text" name="nomcategory" id="nomcategory"></p>
        <p>Selectionner une photo : <input type="file" name="img_path" id="img_path"></p>
        <input type="submit" value="valider">
    </form>
</body>
</html>