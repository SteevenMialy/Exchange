<?php include 'includes/header.php'; ?>

<body>

    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-center py-5">
            <div class="col-md-8">
                <div class="card shadow p-4">

                    <h3 class="text-center mb-4">Liste des Objets de l'utilisateur
                        <?= isset($listob['nom_user']) ? htmlspecialchars($listob['nom_user']) : '' ?>
                    </h3>

                    <?php if (isset($lisob) && !empty($lisob)) { ?>
                        <ul class="list-group">
                            <?php foreach ($lisob as $item): ?>
                                <li class="list-group-item d-flex align-items-center" id="det<?= $item['id_objet'] ?>">
                                    <img src="/uploads/<?= htmlspecialchars($item["photo"]) ?>" alt="" class="img-thumbnail me-3" style="width:80px; height:80px; object-fit:cover;">
                                    <div class="flex-grow-1">
                                        <?= htmlspecialchars($item['nom_objet']); ?>
                                    </div>
                                    <a href="<?= BASE_URL ?>/details/<?= $item['id_objet'] ?>" class="btn btn-primary btn-sm" >Voir détails</a>
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