<?php include 'includes/header.php'; ?>

<body>

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="<?= BASE_URL ?>/home">Home</a>
                    <a class="breadcrumb-item text-dark" href="<?= BASE_URL ?>/shop">Exchange</a>
                    <span class="breadcrumb-item active">Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mine</th>
                            <th>Other's</th>
                            <th>Date</th>
                            <th>Price difference</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php foreach ($propositions as $prop) { ?>
                            <tr>
                                <!-- proposition recue -->
                                <?php if ($statusUser == 1) { ?>
                                    <td class="align-middle">
                                        <img src="<?= BASE_URL ?>/uploads/object/<?= $prop->getObjectOffered()->pictures[0]->getPathImg() ?? "default.webp" ?>" alt="" style="width: 50px;">
                                        <?= $prop->getObjectOffered()->getObjName() ?>
                                    </td>
                                    <td class="align-middle">
                                        <img src="<?= BASE_URL ?>/uploads/object/<?= $prop->getObjectRequested()->pictures[0]->getPathImg() ?? "default.webp" ?>" alt="" style="width: 50px;">
                                        <?= $prop->getObjectRequested()->getObjName() ?>
                                    </td>
                                    <td class="align-middle"><?= $prop->getDateProposal() ?></td>
                                    <?php $pricediff = $prop->getObjectOffered()->getPrix() - $prop->getObjectRequested()->getPrix(); ?>
                                    <td class="align-middle <?= $pricediff < 0 ? 'text-danger' : 'text-success' ?>">
                                        <?= $pricediff ?> $
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info" onclick="seedetails(<?= $prop->id ?>)"><i class="fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-sm btn-success ml-2" onclick="acceptProposal(<?= $prop->id ?>)"><i class="fa fa-check"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger ml-2" onclick="refuseProposal(<?= $prop->id ?>)"><i class="fa fa-times"></i></button>
                                        </div>
                                    </td>
                                <!-- proposition envoyée -->
                                <?php } else { ?>
                                    <td class="align-middle">
                                        <img src="<?= BASE_URL ?>/uploads/object/<?= $prop->getObjectRequested()->pictures[0]->getPathImg() ?? "default.webp" ?>" alt="" style="width: 50px;">
                                        <?= $prop->getObjectRequested()->getObjName() ?>
                                    </td>
                                    <td class="align-middle">
                                        <img src="<?= BASE_URL ?>/uploads/object/<?= $prop->getObjectOffered()->pictures[0]->getPathImg() ?? "default.webp" ?>" alt="" style="width: 50px;">
                                        <?= $prop->getObjectOffered()->getObjName() ?>
                                    </td>
                                    <td class="align-middle"><?= $prop->getDateProposal() ?></td>
                                    <?php $pricediff = $prop->getObjectRequested()->getPrix() - $prop->getObjectOffered()->getPrix(); ?>
                                    <td class="align-middle <?= $pricediff < 0 ? 'text-danger' : 'text-success' ?>">
                                        <?= $pricediff ?> $
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info" onclick="seedetails(<?= $prop->id ?>)"><i class="fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-sm btn-success ml-2" onclick="acceptProposal(<?= $prop->id ?>)"><i class="fa fa-check"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger ml-2" onclick="refuseProposal(<?= $prop->id ?>)"><i class="fa fa-times"></i></button>
                                        </div>
                                    </td>
                                <?php }?>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <!-- <form class="mb-30" action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form> -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="">
                                <h6 class="font-weight-medium"><span class="fa fa-eye"></span> Total arrival pending</h6>
                            </a>
                            <h6 class="font-weight-medium">0</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="">
                                <h6 class="font-weight-medium"><span class="fa fa-eye"></span> Total proposition waiting</h6>
                            </a>
                            <h6 class="font-weight-medium">0</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="">
                                <h6 class="font-weight-medium"><span class="fa fa-eye"></span> Total accepted</h6>
                            </a>
                            <h6>0</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="">
                                <h6 class="font-weight-medium"><span class="fa fa-eye"></span> Total refused</h6>
                            </a>
                            <h6 class="font-weight-medium">0</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total Exchanges</h5>
                            <h5>0</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">See all history</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


    <script>
        function acceptProposal(id) {
            if (confirm("Êtes-vous sûr d'accepter cette proposition ?")) {
                fetch("<?= BASE_URL ?>/propose/accept/" + id, {
                    method: "GET"
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert("Erreur lors de l'acceptation de la proposition.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Erreur lors de l'acceptation de la proposition.");
                });
            }
        }

        function refuseProposal(id) {
            if (confirm("Êtes-vous sûr de refuser cette proposition ?")) {
                fetch("<?= BASE_URL ?>/propose/refuse/" + id, {
                    method: "GET"
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert("Erreur lors du refus de la proposition.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Erreur lors du refus de la proposition.");
                });
            }
        }

        function seedetails(id) {
            window.location.href = "<?= BASE_URL ?>/propose/details/" + id;
        }
    </script>
    
    <?php include 'includes/footer.php'; ?>

</body>

</html>