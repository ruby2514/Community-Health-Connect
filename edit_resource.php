<?php
$pageTitle = "Edit Resource";
require 'config.php';
if (empty($_SESSION['admin_id'])) { header("Location: admin_login.php"); exit; }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Load resource
$stmt = $pdo->prepare("SELECT * FROM resources WHERE id = ?");
$stmt->execute([$id]);
$res = $stmt->fetch();
if (!$res) die("Not found");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE resources SET
              name=:name,
              address=:address,
              city=:city,
              zip_code=:zip_code,
              phone=:phone,
              website=:website,
              category_id=:category_id,
              hours=:hours,
              description=:description
            WHERE id=:id";
    $stmt2 = $pdo->prepare($sql);

    $ok = $stmt2->execute([
        ':name'        => $_POST['name'] ?? '',
        ':address'     => $_POST['address'] ?? '',
        ':city'        => $_POST['city'] ?? '',
        ':zip_code'    => $_POST['zip_code'] ?? '',
        ':phone'       => $_POST['phone'] ?? null,
        ':website'     => $_POST['website'] ?? null,
        ':category_id' => (int)($_POST['category_id'] ?? 0),
        ':hours'       => $_POST['hours'] ?? null,
        ':description' => $_POST['description'] ?? null,
        ':id'          => $id,
    ]);

    $msg = $ok ? "Updated." : "Error.";

    // Refresh resource data after update
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE id = ?");
    $stmt->execute([$id]);
    $res = $stmt->fetch();
}

$cats = $pdo->query("SELECT id, category_name FROM categories ORDER BY category_name")->fetchAll();

require 'header.php';
?>
<h1>Edit Resource</h1>
<?php if ($msg): ?><div class="alert alert-info"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

<form method="post" class="row g-3">
  <input name="name" class="form-control" value="<?= htmlspecialchars($res['name'], ENT_QUOTES, 'UTF-8') ?>" required>
  <input name="address" class="form-control" value="<?= htmlspecialchars($res['address'], ENT_QUOTES, 'UTF-8') ?>" required>
  <input name="city" class="form-control" value="<?= htmlspecialchars($res['city'], ENT_QUOTES, 'UTF-8') ?>" required>
  <input name="zip_code" class="form-control" value="<?= htmlspecialchars($res['zip_code'], ENT_QUOTES, 'UTF-8') ?>" required>

  <select name="category_id" class="form-select" required>
    <?php foreach($cats as $c): ?>
      <option value="<?= (int)$c['id'] ?>" <?= ((int)$c['id'] === (int)$res['category_id']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($c['category_name'], ENT_QUOTES, 'UTF-8') ?>
      </option>
    <?php endforeach; ?>
  </select>

  <input name="phone" class="form-control" value="<?= htmlspecialchars($res['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
  <input name="website" class="form-control" value="<?= htmlspecialchars($res['website'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
  <input name="hours" class="form-control" value="<?= htmlspecialchars($res['hours'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
  <textarea name="description" class="form-control"><?= htmlspecialchars($res['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

  <button class="btn btn-primary mt-3">Update</button>
</form>

<?php require 'footer.php'; ?>
