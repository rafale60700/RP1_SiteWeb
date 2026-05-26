<?php
// login.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/session.php';

if (isLoggedIn()) {
    header('Location: /dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        try {
            $db   = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                login((int)$user['id'], $user['name'], $user['email']);
                header('Location: /dashboard.php');
                exit();
            } else {
                $error = 'Email ou mot de passe incorrect.';
            }
        } catch (Exception $e) {
            $error = 'Erreur de connexion.';
        }
    }
}

require_once __DIR__ . '/templates/header.php';
?>

<main class="container">
    <h1>Connexion</h1>
    <p>Connectez-vous pour accéder à votre espace membre.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="votre@email.com" required
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>

        <button class="btn" type="submit">Se connecter</button>
    </form>

    <p style="text-align:center; margin-top:20px;">
        Pas encore de compte ?
        <a href="/register.php" style="color:#667eea; font-weight:600;">S'inscrire</a>
    </p>
</main>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
