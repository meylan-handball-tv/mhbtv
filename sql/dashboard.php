<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['dispo'] as $date => $value) {
        $stmt = $pdo->prepare("REPLACE INTO disponibilites (user_id, date, disponible) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $date, 1]);
    }
}

function getUpcomingSaturdays($n = 8) {
    $weekends = [];
    $today = new DateTime();
    $today->modify('next saturday');

    for ($i = 0; $i < $n; $i++) {
        $weekends[] = $today->format('Y-m-d');
        $today->modify('+1 week');
    }
    return $weekends;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes disponibilités</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?></h2>
  <form method="post">
    <h3>Mes disponibilités pour les prochains week-ends</h3>
    <?php foreach (getUpcomingSaturdays() as $date): ?>
      <label>
        <input type="checkbox" name="dispo[<?= $date ?>]"> 
        <?= (new DateTime($date))->format('d/m/Y') ?>
      </label><br>
    <?php endforeach; ?>
    <br>
    <button type="submit">Enregistrer mes disponibilités</button>
  </form>
  <br>
  <a href="logout.php">Déconnexion</a>
</body>
</html>
