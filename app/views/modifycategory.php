<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>modifier categorie</h1>
    <?php if (!empty($category)) { ?>
        <form action="<?= BASE_URL ?>/modificationcategory" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $category->getId() ?>">
            <p>Nom de la catégorie :
                <input type="text" name="nomcategory" value="<?= $category->getNomCategory() ?>" required>
            </p>
            <p>Changer la photo :
                <input type="file" name="img_path">
                <br>
                <img src="uploads/category/<?= $category->getImg() ?>" width="100">
            </p>
            <input type="submit" value="Mettre à jour">
        </form>
    <?php } ?>
</body>

</html>