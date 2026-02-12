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
                                    <button class="btn btn-primary btn-sm" id="details<?= $item['id_objet'] ?>">Voir détails</button>
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

    <script>
        document.querySelectorAll('[id^="details"]').forEach(button => {
            button.addEventListener('click', function() {

                const objId = this.id.replace('details', '');
                const li = document.getElementById('det' + objId);

                // Toggle du <p> si déjà présent
                let existing = li.querySelector('p.details');
                if (existing) {
                    existing.remove();
                    return;
                }

                // AJAX Fetch vers Flight PHP
                fetch('/objet/details/' + objId)
                    .then(response => response.json())
                    .then(data => {
                        const p = document.createElement('p');
                        p.classList.add('details', 'mt-2');
                        p.style.color = "blue";

                        if (data.error) {
                            p.textContent = data.error;
                        } else {
                            p.innerHTML = `
                        <strong>Description :</strong> ${data.description}
                    `;
                        }

                        li.appendChild(p);
                    })
                    .catch(err => console.error(err));
            });
        });
    </script>

    <?php include 'includes/footer.php'; ?>

</body>

</html>