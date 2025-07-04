<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

$users = $pdo->query("SELECT id, username FROM users")->fetchAll(PDO::FETCH_ASSOC);
$dispos = $pdo->query("SELECT * FROM disponibilites")->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin – Disponibilités</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Tableau des disponibilités</h2>
  <table border="1" cellpadding="8">
    <thead>
      <tr>
        <th>Utilisateur</th>
        <?php foreach (range(0, 7) as $i): ?>
          <th><?= (new DateTime("next saturday +$i week"))->format('d/m') ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user['username']) ?></td>
          <?php for ($i = 0; $i < 8; $i++): 
            $date = (new DateTime("next saturday +$i week"))->format('Y-m-d');
            $available = isset($dispos[$user['id']]) && in_array($date, array_column($dispos[$user['id']], 'date'));
          ?>
            <td><?= $available ? "✅" : "—" ?></td>
          <?php endfor; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <br>
  <a href="logout.php">Déconnexion</a>
</body>
</html>
