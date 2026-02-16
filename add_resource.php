<?php
$pageTitle = "Add Resource";
require 'config.php';
if (empty($_SESSION['admin_id'])) { header("Location: admin_login.php"); exit; }

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO resources
            (name, address, city, zip_code, phone, website, category_id, hours, description)
            VALUES
            (:name, :address, :city, :zip_code, :phone, :website, :category_id, :hours, :description)";
    $stmt = $pdo->prepare($sql);

    $ok = $stmt->execute([
        ':name'        => $_POST['name'] ?? '',
        ':address'     => $_POST['address'] ?? '',
        ':city'        => $_POST['city'] ?? '',
        ':zip_code'    => $_POST['zip_code'] ?? '',
        ':phone'       => $_POST['phone'] ?? null,
        ':website'     => $_POST['website'] ?? null,
        ':category_id' => (int)($_POST['category_id'] ?? 0),
        ':hours'       => $_POST['hours'] ?? null,
        ':description' => $_POST['description'] ?? null,
    ]);

    $msg = $ok ? "Added." : "Error.";
}

// categories
$cats = $pdo->query("SELECT id, category_name FROM categories ORDER BY category_name")->fetchAll();

require 'header.php';
?>
<h1>Add Resource</h1>
<?php if ($msg): ?><div class="alert alert-info"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

<form method="post" class="row g-3">
  <input name="name" class="form-control" placeholder="Name" required>
  <input name="address" class="form-control" placeholder="Address" required>
  <input name="city" class="form-control" placeholder="City" required>
  <input name="zip_code" class="form-control" placeholder="ZIP" required>

  <select name="category_id" class="form-select" required>
    <?php foreach($cats as $c): ?>
      <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['category_name'], ENT_QUOTES, 'UTF-8') ?></option>
    <?php endforeach; ?>
  </select>

  <input name="phone" class="form-control" placeholder="Phone">
  <input name="website" class="form-control" placeholder="Website">
  <input name="hours" class="form-control" placeholder="Hours">
  <textarea name="description" class="form-control" placeholder="Description"></textarea>

  <button class="btn btn-success mt-3">Save</button>
</form>

<?php require 'footer.php'; ?>
