<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout object</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Font Awesome -->
    <link href="lib/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-center py-5">
            <div class="col-md-8">
                <div class="card shadow p-4">

                    <h3 class="text-center mb-4">Ajout d'un objet pour l'utilisateur
                        <?= isset($listob['nom_user']) ? htmlspecialchars($_SESSION["user"]->username) : '' ?>
                    </h3>

                  <form action="<?= BASE_URL ?>/ajoutobjectfonc" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="obj_name" class="form-label">Nom de l'objet</label>
                            <input type="text" class="form-control" id="obj_name" name="obj_name" required>
                        </div>

                        <!-- Categorie -->
                        <div class="mb-3">
                            <label for="id_category" class="form-label">Catégorie</label>
                            <select class="form-select" id="id_category" name="id_category" required>
                                <option value="">Sélectionnez une catégorie</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category->id) ?>">
                                        <?= htmlspecialchars($category->getNomCategory()) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="descript" class="form-label">Description</label>
                            <textarea class="form-control" id="descript" name="descript" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix</label>
                            <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
                        </div>

                        <div class="mb-3">
                            <label for="photos" class="form-label">Photo(s) de l'objet</label>
                            <input type="file" class="form-control" id="photos" name="photos[]" accept="image/*" multiple required>
                            <small class="text-muted">Vous pouvez sélectionner plusieurs images à la fois.</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Ajouter l'objet</button>

                  </form>


                </div>
            </div>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>

</body>

</html>