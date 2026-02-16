<?php
$pageTitle = "Search Resources - Community Health Connect";
require 'config.php';

// Handle search
$city        = trim($_GET['city'] ?? '');
$zip         = trim($_GET['zip'] ?? '');
$category_id = trim($_GET['category_id'] ?? '');

$sql = "
    SELECT r.*, c.category_name
    FROM resources r
    JOIN categories c ON r.category_id = c.id
    WHERE 1=1
";

$params = [];

if ($city !== "") {
    $sql .= " AND r.city LIKE :city";
    $params[':city'] = "%{$city}%";
}
if ($zip !== "") {
    $sql .= " AND r.zip_code LIKE :zip";
    $params[':zip'] = "%{$zip}%";
}
if ($category_id !== "") {
    $sql .= " AND r.category_id = :category_id";
    $params[':category_id'] = (int)$category_id;
}

$sql .= " ORDER BY r.name";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$result = $stmt->fetchAll();

// Fetch categories for dropdown
$categories = $pdo->query("
  SELECT DISTINCT id, category_name
  FROM categories
  ORDER BY category_name
")->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<h1 class="mb-2">Search Community Resources</h1>
<p class="text-muted mb-4">
  Use location and category filters to find clinics, food pantries, shelters, mental health services, and more.
</p>

<div class="card search-card mb-4">
  <div class="card-body">
    <form method="get" class="row g-3">
      <div class="col-md-4">
        <label class="form-label">City</label>
        <input type="text" name="city" class="form-control"
               value="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>"
               placeholder="e.g. Montclair">
      </div>

      <div class="col-md-4">
        <label class="form-label">ZIP Code</label>
        <input type="text" name="zip" class="form-control"
               value="<?= htmlspecialchars($zip, ENT_QUOTES, 'UTF-8'); ?>"
               placeholder="e.g. 07043">
      </div>

      <div class="col-md-4">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
  <option value="">All Categories</option>

  <?php foreach ($categories as $c): ?>
    <option value="<?= (int)$c['id'] ?>"
      <?= (!empty($_GET['category_id']) && (int)$_GET['category_id'] === (int)$c['id']) ? 'selected' : '' ?>>
      <?= htmlspecialchars($c['category_name']) ?>
    </option>
  <?php endforeach; ?>
</select>

      </div>

      <div class="col-12 d-flex justify-content-end gap-2">
        <a href="search_resources.php" class="btn btn-outline-secondary btn-sm">Clear</a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-search-heart me-1"></i> Search
        </button>
      </div>
    </form>
  </div>
</div>

<?php if (count($result) > 0): ?>
  <div class="list-group">
    <?php foreach ($result as $row): ?>
      <a href="resource_detail.php?id=<?= (int)$row['id'] ?>"
         class="list-group-item list-group-item-action result-item d-flex justify-content-between align-items-start">
        <div>
          <div class="fw-semibold"><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></div>
          <div class="small text-muted">
            <?= htmlspecialchars($row['city'], ENT_QUOTES, 'UTF-8'); ?> • <?= htmlspecialchars($row['zip_code'], ENT_QUOTES, 'UTF-8'); ?>
          </div>
          <div class="small mt-1"><?= htmlspecialchars($row['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <span class="badge rounded-pill"><?= htmlspecialchars($row['category_name'], ENT_QUOTES, 'UTF-8'); ?></span>
      </a>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="alert alert-warning">No resources found. Try adjusting your search filters.</div>
<?php endif; ?>

<?php require 'footer.php'; ?>
