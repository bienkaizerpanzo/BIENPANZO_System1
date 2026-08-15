<?php

require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/PetRepository.php';

$repository = new PetRepository(new Database());
$id = (int) ($_GET['id'] ?? 0);
$pet = $repository->findById($id);

if ($pet === null) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repository->delete($id);
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Pet</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f7f7f7; }
        .box { background: white; padding: 20px; max-width: 500px; border-radius: 8px; }
        button {
            background: #d94a4a;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            margin-right: 10px;
        }
        a { display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="box">
        <h1>Delete Pet</h1>
        <p>Are you sure you want to delete <strong><?= htmlspecialchars($pet['pet_name']) ?></strong>?</p>

        <form method="POST">
            <button type="submit">Yes, Delete</button>
            <a href="index.php">Cancel</a>
        </form>
    </div>
</body>
</html>
