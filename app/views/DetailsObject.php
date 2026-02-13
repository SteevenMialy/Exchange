<?php include 'includes/header.php'; ?>

<body>

    <div class="container py-5">
        <h2 class="mb-4 text-uppercase">Details</h2>

        <div class="card mb-4">
            <div class="card-body">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Photos</label>
                        <img src="<?= '/uploads/' . htmlspecialchars($details['photo'] ?? '') ?>" alt="">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nom de l'objet</label>
                        <input type="text" name="obj_name" class="form-control" value="<?= htmlspecialchars($details['obj_name'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prix</label>
                        <input type="number" step="0.01" name="prix" class="form-control" value="<?= htmlspecialchars((string) ($details['prix'] ?? '')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ID utilisateur</label>
                        <input type="number" name="id_user" class="form-control" value="<?= htmlspecialchars((string) ($details['id_user'] ?? ($_SESSION['user']->id ?? $_SESSION['user']['id'] ?? ''))) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">ID catégorie</label>
                        <input type="number" name="id_category" class="form-control" value="<?= htmlspecialchars((string) ($details['id_category'] ?? '')) ?>">
                    </div>



                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="descript" class="form-control" rows="4"><?= htmlspecialchars($details['descript'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="bg-light p-4">
                        <img src="img/vendor-1.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-2.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-3.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-4.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-5.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-6.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-7.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->

    <?php include 'includes/footer.php'; ?>
</body>

</html>