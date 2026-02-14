<?php include 'includes/header.php'; ?>

<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/home">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/shop">Boutique</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Détails de l'objet</li>
                    </ol>
                </nav>
            </div>
        </div>
        
<?php if (isset($object)) { ?> 
        <div class="row g-4">
            <!-- Photos Section -->
            <div class="col-lg-6">
                <div class="position-relative">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($object->pictures as $index => $picture) {?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= BASE_URL ?>/uploads/object/<?= htmlspecialchars($picture->getPathImg()) ?>" 
                                         class="d-block w-100 rounded" 
                                         alt="Photo <?= htmlspecialchars($picture->getId()) ?>"
                                         style="height: 400px; object-fit: cover;">
                                </div>
                            <?php } ?>
                        </div>
                        
                        <!-- Boutons de navigation avec l'image -->
                        <button class="carousel-control-prev carousel-nav-custom" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <img src="<?= BASE_URL ?>/images/next.png" alt="Précédent" class="carousel-nav-img prev-img">
                            <span class="visually-hidden"></span>
                        </button>
                        <button class="carousel-control-next carousel-nav-custom" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <img src="<?= BASE_URL ?>/images/next.png" alt="Suivant" class="carousel-nav-img">
                            <span class="visually-hidden"></span>
                        </button>
                    </div>
                
                </div>
                
                <style>
                    .carousel-indicator-custom {
                        width: 12px;
                        height: 12px;
                        border-radius: 50%;
                        border: none;
                        background-color: #dee2e6;
                        transition: all 0.3s ease;
                    }
                    .carousel-indicator-custom.active,
                    .carousel-indicator-custom:hover {
                        background-color: #6c757d;
                    }
                    .carousel-indicator-custom:focus {
                        outline: none;
                        box-shadow: 0 0 0 2px rgba(108, 117, 125, 0.25);
                    }
                    
                    .carousel-nav-custom {
                        width: auto;
                        opacity: 1;
                        background: transparent;
                        border: none;
                    }
                    
                    .carousel-nav-img {
                        width: 50px;
                        height: 50px;
                        transition: all 0.3s ease;
                    }
                    
                    .carousel-nav-img.prev-img {
                        transform: rotate(180deg);
                    }
                    
                    .carousel-nav-custom:hover .carousel-nav-img {
                        opacity: 1;
                        transform: scale(1.1);
                    }
                    
                    .carousel-nav-custom:hover .prev-img {
                        transform: rotate(180deg) scale(1.1);
                    }
                </style>
            </div>

            <!-- Product Details Section -->
            <div class="col-lg-6">
                <h1 class="h2 mb-3 fw-bold text-dark"><?= htmlspecialchars($object->getObjName() ?? ''); ?></h1>
                
                <div class="mb-4">
                    <h3 class="h4 text-success fw-bold"><?= number_format($object->getPrix(), 2, ',', ' ') ?> Ar</h3>
                </div>

                <div class="mb-4">
                    <h5 class="fw-semibold mb-2">Catégorie</h5>
                    <span class="badge bg-primary fs-6"><?= htmlspecialchars($object->getCategoryName() ?? ''); ?></span>
                </div>

                <div class="mb-4">
                    <h5 class="fw-semibold mb-2">Description</h5>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($object->getDescript() ?? '')); ?></p>
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">Possesseur actuel</h6>
                    <p class="mb-0"><?= htmlspecialchars($object->getUserName() ?? ''); ?></p>
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button class="btn btn-warning btn-lg fw-semibold" type="button">
                        Echanger cet objet
                    </button>
                    <p id="exchange-message" class="text-success d-none">Proposition d'échange envoyée !</p>
                </div>
            </div>
        </div>

        <!-- Informations supplémentaires en bas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Informations supplémentaires</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">ID de l'objet</span>
                                    <span class="fw-semibold">#<?= htmlspecialchars($object->id ?? ''); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Catégorie de photos</span>
                                    <span class="fw-semibold">#<?= htmlspecialchars($object->getIdCategory() ?? ''); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Date de publication</span>
                                    <span class="fw-semibold">10 Février 2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Similar Products -->
    <div class="container-fluid py-5 bg-light">
        <div class="container">
            <h3 class="text-center mb-4">Produits similaires</h3>
            <div class="row g-4">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= BASE_URL ?>/img/product-4.jpg" class="card-img-top" alt="Produit 1">
                        <div class="card-body">
                            <h6 class="card-title">Laptop HP Pavilion</h6>
                            <p class="text-success fw-bold">1 800 000 Ar</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= BASE_URL ?>/img/product-5.jpg" class="card-img-top" alt="Produit 2">
                        <div class="card-body">
                            <h6 class="card-title">MacBook Air M2</h6>
                            <p class="text-success fw-bold">3 200 000 Ar</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= BASE_URL ?>/img/product-6.jpg" class="card-img-top" alt="Produit 3">
                        <div class="card-body">
                            <h6 class="card-title">Lenovo ThinkPad</h6>
                            <p class="text-success fw-bold">2 100 000 Ar</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= BASE_URL ?>/img/product-7.jpg" class="card-img-top" alt="Produit 4">
                        <div class="card-body">
                            <h6 class="card-title">ASUS ZenBook</h6>
                            <p class="text-success fw-bold">2 800 000 Ar</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>
    <?php include 'includes/footer.php'; ?>
</body>

</html>