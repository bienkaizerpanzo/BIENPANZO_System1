<?php

require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/PetRepository.php';

$repository = new PetRepository(new Database());
$pets = [];
$error = null;

try {
    $pets = $repository->findAll();
} catch (RuntimeException $e) {
    $error = $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Clinic Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f7f7f7; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { color: #333; }
        .actions { margin-bottom: 20px; }
        a.button {
            display: inline-block;
            background: #2d6cdf;
            color: white;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 6px;
            margin-right: 10px;
        }
        a.button:hover { background: #1e4fa8; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th { background: #f0f0f0; font-weight: bold; }
        tr:nth-child(even) { background: #fafafa; }
        tr:hover { background: #f5f5f5; }
        .actions-cell { text-align: center; }
        a.action-link {
            display: inline-block;
            padding: 6px 10px;
            margin: 0 4px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        a.edit {
            background: #4CAF50;
            color: white;
        }
        a.edit:hover { background: #45a049; }
        a.delete {
            background: #f44336;
            color: white;
        }
        a.delete:hover { background: #da190b; }
        .empty-state {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            color: #666;
        }
        .error {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pet Clinic Management System</h1>

        <?php if ($error): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="actions">
            <a class="button" href="create.php">Add New Pet</a>
        </div>

        <?php if (empty($pets) && !$error): ?>
            <div class="empty-state">
                <p>No pets found. <a href="create.php">Create the first pet</a>.</p>
            </div>
        <?php elseif (!empty($pets)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Pet ID</th>
                        <th>Pet Name</th>
                        <th>Pet Type</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Owner Name</th>
                        <th>Contact Number</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pets as $pet): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $pet['id']) ?></td>
                            <td><?= htmlspecialchars($pet['pet_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($pet['pet_type'] ?? '') ?></td>
                            <td><?= htmlspecialchars($pet['breed'] ?? '') ?></td>
                            <td><?= htmlspecialchars((string) ($pet['age'] ?? '')) ?></td>
                            <td><?= htmlspecialchars($pet['gender'] ?? '') ?></td>
                            <td><?= htmlspecialchars($pet['owner_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($pet['contact_number'] ?? '') ?></td>
                            <td><?= htmlspecialchars($pet['status'] ?? '') ?></td>
                            <td class="actions-cell">
                                <a class="action-link edit" href="edit.php?id=<?= (int) $pet['id'] ?>">Edit</a>
                                <a class="action-link delete" href="delete.php?id=<?= (int) $pet['id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
