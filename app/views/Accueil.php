<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>

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

                    <h3 class="text-center mb-4">Liste des Objets de l'utilisateur
                        <?= isset($_SESSION['user']->nom_user) ? htmlspecialchars($_SESSION['user']->nom_user) : '' ?>
                    </h3>

                    <a href="<?= BASE_URL ?>/ajoutobject" class="btn btn-primary btn-block">Ajouter object</a>

                    <?php if (isset($objects) && !empty($objects)) { ?>
                        <ul class="list-group">
                            <?php foreach ($objects as $item): ?>
                                <?php if (!is_array($item) || !isset($item['id'])) continue; ?>
                                <?php
                                    $itemPics = $pictures[$item['id']] ?? [];
                                    $firstPic = !empty($itemPics) ? $itemPics[0]->getPathImg() : null;
                                ?>
                                <li class="list-group-item d-flex align-items-center" id="det<?= $item['id'] ?>">
                                    <?php if ($firstPic): ?>
                                        <img src="uploads/object/<?= htmlspecialchars($firstPic) ?>" alt="" class="img-thumbnail me-3" style="width:80px; height:80px; object-fit:cover;">
                                    <?php else: ?>
                                        <div class="img-thumbnail me-3 d-flex align-items-center justify-content-center bg-light" style="width:80px; height:80px;">Aucune</div>
                                    <?php endif; ?>
                                    <div class="flex-grow-1">
                                        <?= htmlspecialchars($item['obj_name'] ?? ''); ?>
                                    </div>
                                    <a href="<?= BASE_URL ?>/details/<?= $item['id'] ?>" class="btn btn-primary btn-sm">Voir détails</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php } else { ?>
                        <p class="text-center mt-3">Vous n'avez aucun objet disponible.</p>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>

</body>

</html>