<?php
$pageTitle = "Manage Resources";
require 'config.php';

if (empty($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// ----------------------------
// Handle DELETE (admin-only)
// ----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];

    // Optional basic guard (prevents accidental 0 deletes)
    if ($deleteId > 0) {
        $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
        $stmt->execute([$deleteId]);
    }
}

// ----------------------------
// Fetch resources for display
// ----------------------------
$sql = "
    SELECT 
        r.id,
        r.name,
        r.city,
        r.zip_code,
        c.category_name
    FROM resources r
    JOIN categories c ON r.category_id = c.id
    ORDER BY r.name ASC
";
$res = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<h1 class="mb-3">Manage Resources</h1>

<a href="add_resource.php" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle me-1"></i> Add Resource
</a>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>ZIP</th>
                        <th>Category</th>
                        <th style="width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($res)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No resources found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($res as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['city'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['zip_code'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['category_name'] ?? '') ?></td>
                            <td>
                                <a class="btn btn-sm btn-primary"
                                   href="edit_resource.php?id=<?= (int)$r['id'] ?>">
                                    Edit
                                </a>

                                <form method="post" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this resource?');">
                                    <input type="hidden" name="delete_id" value="<?= (int)$r['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
