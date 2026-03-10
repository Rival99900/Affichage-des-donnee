<?php
require "credentials.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$sql = "
SELECT 
    m.idMateriel,
    m.nom,
    m.annee,
    m.details,
    t.libelle AS type,
    p.nom AS parent
FROM MATERIEL m
JOIN TYPEE t ON m.idType = t.idType
LEFT JOIN MATERIEL p ON m.idParent = p.idMateriel
ORDER BY m.idMateriel;
";

$stmt = $pdo->query($sql);
$materiels = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <link rel="icon" type="image/png" href="Logo.png">
    <meta charset='UTF-8'>
    <title>Parc matériel</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        table { border-collapse: collapse; width: 100%; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #333; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        h1 { margin-bottom: 20px; }
    </style>
</head>
<body>

<h1>Liste du parc matériel</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Année</th>
        <th>Détails</th>
        <th>Type</th>
        <th>Appartient à</th>
    </tr>

    <?php foreach ($materiels as $m): ?>
    <tr>
        <td><?php echo $m['idMateriel'] ?></td>
        <td><?php echo $m['nom'] ?></td>
        <td><?php echo $m['annee'] ?></td>
        <td><?php echo $m['details'] ?? '—' ?></td>
        <td><?php echo $m['type'] ?></td>
        <td><?php echo $m['parent'] ?? '—' ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>

</html>





