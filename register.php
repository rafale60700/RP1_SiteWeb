<?php
// register.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/session.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name             = trim($_POST['name']             ?? '');
    $email            = trim($_POST['email']            ?? '');
    $password         = $_POST['password']              ?? '';
    $confirm_password = $_POST['confirm_password']      ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse email invalide.';
    } elseif (strlen($password) < 9) {
        $error = 'Le mot de passe doit contenir au moins 9 caractères.';
    } elseif ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        try {
            $db   = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $error = 'Cet email est déjà utilisé.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

                if ($stmt->execute([$name, $email, $hashedPassword])) {
                    $userId = (int)$conn->lastInsertId();
                    // Le trigger after_user_insert crée user_profiles automatiquement
                    login($userId, $name, $email);
                    header('Location: /dashboard.php');
                    exit();
                }
            }
        } catch (Exception $e) {
            $error = 'Erreur lors de la création du compte.';
        }
    }
}

require_once __DIR__ . '/templates/header.php';
?>

<main class="container">
    <h1>Créer un compte</h1>
    <p>Rejoignez GSB-SHOP et accédez à nos formations et services exclusifs.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="name">Nom complet</label>
        <input type="text" id="name" name="name" placeholder="Votre nom" required
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="votre@email.com" required
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Au moins 9 caractères" required>

        <label for="confirm_password">Confirmer le mot de passe</label>
        <input type="password" id="confirm_password" name="confirm_password"
               placeholder="Confirmez votre mot de passe" required>

        <button class="btn" type="submit">Créer mon compte</button>
    </form>

    <p style="text-align:center; margin-top:20px;">
        Déjà un compte ?
        <a href="/login.php" style="color:#667eea; font-weight:600;">Se connecter</a>
    </p>
</main>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
