<<?php
$pageTitle = "Resource Detail";
require 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("
  SELECT r.*, c.category_name
  FROM resources r
  JOIN categories c ON r.category_id = c.id
  WHERE r.id = ?
");
$stmt->execute([$id]);
$resource = $stmt->fetch();

require 'header.php';
?>

<?php if (!$resource): ?>
  <div class="alert alert-danger">Resource not found.</div>
<?php else: ?>
  <div class="card shadow-sm mb-4 border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      <h1 class="h3 mb-2"><?= htmlspecialchars($resource['name'], ENT_QUOTES, 'UTF-8') ?></h1>
      <div class="text-muted mb-3">
        <span class="badge bg-light text-dark border"><?= htmlspecialchars($resource['category_name'], ENT_QUOTES, 'UTF-8') ?></span>
      </div>

      <div class="row g-3">
        <div class="col-md-6">
          <div class="small text-muted">Address</div>
          <div class="fw-semibold">
            <?= htmlspecialchars($resource['address'], ENT_QUOTES, 'UTF-8') ?><br>
            <?= htmlspecialchars($resource['city'], ENT_QUOTES, 'UTF-8') ?>, <?= htmlspecialchars($resource['zip_code'], ENT_QUOTES, 'UTF-8') ?>
          </div>
        </div>

        <div class="col-md-6">
          <div class="small text-muted">Contact</div>
          <div class="fw-semibold">
            <?php if (!empty($resource['phone'])): ?>
              <div><i class="bi bi-telephone me-1"></i><?= htmlspecialchars($resource['phone'], ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <?php if (!empty($resource['website'])): ?>
              <div><i class="bi bi-globe2 me-1"></i><a href="<?= htmlspecialchars($resource['website'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">Website</a></div>
            <?php endif; ?>
          </div>
        </div>

        <?php if (!empty($resource['hours'])): ?>
          <div class="col-12">
            <div class="small text-muted">Hours</div>
            <div><?= htmlspecialchars($resource['hours'], ENT_QUOTES, 'UTF-8') ?></div>
          </div>
        <?php endif; ?>

        <?php if (!empty($resource['description'])): ?>
          <div class="col-12">
            <div class="small text-muted">Description</div>
            <div><?= nl2br(htmlspecialchars($resource['description'], ENT_QUOTES, 'UTF-8')) ?></div>
          </div>
        <?php endif; ?>
      </div>

      <div class="mt-4 d-flex gap-2">
        <a class="btn btn-outline-secondary" href="search_resources.php"><i class="bi bi-arrow-left me-1"></i>Back to search</a>
        <?php if (!empty($_SESSION['admin_id'])): ?>
          <a class="btn btn-primary" href="edit_resource.php?id=<?= (int)$resource['id'] ?>"><i class="bi bi-pencil-square me-1"></i>Edit</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php require 'footer.php'; ?>
