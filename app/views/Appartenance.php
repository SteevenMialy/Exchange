<?php include 'includes/header.php'; ?>

<body>

<!-- Breadcrumb -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="<?= BASE_URL ?>/home">Home</a>
                <a class="breadcrumb-item text-dark" href="<?= BASE_URL ?>/shop">Exchange</a>
                <span class="breadcrumb-item active">Appartenance</span>
            </nav>
        </div>
    </div>
</div>

<!-- Appartenance -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Offreur</th>
                        <th>Destinataire</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody class="align-middle">

<?php
$items = [];

if (!empty($echange)) {
    $items = (is_array($echange) && isset($echange[0])) ? $echange : [$echange];
}

if (!empty($items)) :
    foreach ($items as $prop) :

        $offeredUser   = $prop['offered_username'] ?? '';
        $requestedUser = $prop['requested_username'] ?? '';
        $dateRaw       = $prop['date_proposal'] ?? '';
        $status        = strtolower($prop['status'] ?? '');

        // Format date + heure
        $date = $dateRaw ? date('d/m/Y H:i:s', strtotime($dateRaw)) : '';

        // Badge statut
        switch ($status) {
            case 'accepted':
                $badge = 'success';
                $label = 'Accepté';
                break;
            case 'rejected':
                $badge = 'danger';
                $label = 'Refusé';
                break;
            default:
                $badge = 'warning';
                $label = 'En attente';
        }
?>
        <tr>
            <td><?= htmlspecialchars($offeredUser) ?></td>
            <td><?= htmlspecialchars($requestedUser) ?></td>
            <td><?= htmlspecialchars($date) ?></td>
            <td>
                <span class="badge badge-<?= $badge ?>">
                    <?= $label ?>
                </span>
            </td>
        </tr>
<?php
    endforeach;
else :
?>
        <tr>
            <td colspan="4" class="text-muted">Aucune information à afficher.</td>
        </tr>
<?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
