<?php
$pageTitle = "Admin Login";
require 'config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userIn = trim($_POST['username'] ?? '');
    $passIn = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$userIn]);
    $admin = $stmt->fetch();

    // NOTE: using plain text password to match your SQL seed (admin123)
    if ($admin && $passIn === $admin['password']) {
        $_SESSION['admin_id']       = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid login.";
    }
}

require 'header.php';
?>

<h1 class="mb-3">Admin Login</h1>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<form method="post" class="col-md-4">
  <div class="mb-2">
    <input name="username" class="form-control" placeholder="Username" required>
  </div>
  <div class="mb-3">
    <input name="password" type="password" class="form-control" placeholder="Password" required>
  </div>
  <button class="btn btn-primary w-100">Login</button>
</form>

<?php require 'footer.php'; ?>
