<?php include 'includes/header.php'; ?>

<body>
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="<?= BASE_URL ?>/home">Home</a>
                    <span class="breadcrumb-item active">Exchange</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Left: user's object + chosen object -->
            <div class="col-lg-5 mb-30">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">objet à échanger</span></h5>
                <div class="bg-light p-4">
                    <form action="" method="post">
                        <?php if (isset($object) && !empty($object)) { ?>
                            <?php
                            $firstPic = isset($object->pictures[0])
                                ? $object->pictures[0]->getPathImg()
                                : null;
                            ?>

                            <div class="d-flex align-items-center object-item" data-prix="<?= $object->getPrix() ?>" id="det<?= $object->id ?>">
                                <?php if ($firstPic): ?>
                                    <img src="<?= BASE_URL ?>/uploads/object/<?= htmlspecialchars($firstPic) ?>" alt="" class="img-thumbnail me-3" style="width:90px;height:90px;object-fit:cover;">
                                <?php else: ?>
                                    <div class="img-thumbnail me-3 d-flex align-items-center justify-content-center bg-light" style="width:90px;height:90px;">Aucune</div>
                                <?php endif; ?>

                                <div class="flex-grow-1">
                                    <div class="font-weight-semi-bold mb-1"><?= htmlspecialchars($object->getObjName()); ?></div>
                                    <div class="text-muted">Prix : <?= htmlspecialchars($object->getPrix()); ?> <span class="result">€</span></div>
                                </div>
                            </div>

                            <input type="hidden" name="idobject" value="<?= $object->id ?>">

                            <button type="submit" class="btn btn-primary btn-block mt-3">Échanger</button>
                        <?php } else { ?>
                            <p class="text-center mb-0">Pas d'objet à échanger.</p>
                        <?php } ?>
                    </form>
                </div>

                <h5 class="section-title position-relative text-uppercase mb-3 mt-4"><span class="bg-secondary pr-3">Objet d'echange</span></h5>
                <div class="bg-light p-4 mb-30" id="objectChosenContainer">
                    <p class="text-center mb-0">Pas d'objet choisi</p>
                </div>
            </div>

            <!-- Right: scrollable list -->
            <div class="col-lg-7">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Liste des objets</span></h5>
                <div class="bg-light p-4 mb-30">
                    <?php if (isset($objectsNotBelonged) && !empty($objectsNotBelonged)) { ?>
                        <div class="overflow-auto" style="max-height: 560px;">
                            <ul class="list-group">
                                <?php foreach ($objectsNotBelonged as $item): ?>
                                    <?php
                                    $firstPic = (isset($item->pictures[0]) ? ($item->pictures[0])->getPathImg() : null);
                                    ?>
                                    <li class="list-group-item d-flex align-items-center" id="det<?= $item->id ?>">
                                        <?php if ($firstPic): ?>
                                            <img src="<?= BASE_URL ?>/uploads/object/<?= htmlspecialchars($firstPic) ?>" alt="" class="img-thumbnail me-3" style="width:80px; height:80px; object-fit:cover;">
                                        <?php else: ?>
                                            <div class="img-thumbnail me-3 d-flex align-items-center justify-content-center bg-light" style="width:80px; height:80px;">Aucune</div>
                                        <?php endif; ?>

                                        <div class="flex-grow-1">
                                            <div class="font-weight-semi-bold"><?= htmlspecialchars($item->getObjName() ?? ''); ?></div>
                                        </div>

                                        <div class="ml-3 d-flex flex-column" style="gap: 8px;">
                                            <button type="button" class="btn btn-sm btn-outline-dark details-btn" data-id="<?= $item->id ?>">Voir détails</button>
                                            <a class="btn btn-sm btn-primary choosen-btn" data-id="<?= $item->id ?>" href="<?= BASE_URL ?>/exchange/chossen/<?= $item->id ?>">Choisir</a>
                                        </div>
                                    </li>

                                    <li class="list-group-item d-none" id="detailsRow<?= $item->id ?>">
                                        <div class="text-muted small">Chargement...</div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <p class="text-center mb-0">Pas d'objet.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>

    <script>
        window.BASE_URL = "<?= BASE_URL ?>";
    </script>
    <script src="<?= BASE_URL ?>/js/objectchossen.js"></script>

</body>

</html>