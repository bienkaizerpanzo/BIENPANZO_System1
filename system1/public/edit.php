<?php

require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/ApiClient.php';
require_once __DIR__ . '/../app/PetRepository.php';

$repository = new PetRepository(new Database());
$id = (int) ($_GET['id'] ?? 0);
$pet = $repository->findById($id);
$petTypes = ApiClient::fetchPetTypes();

if ($pet === null) {
    header('Location: index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petName = trim($_POST['pet_name'] ?? '');
    $selectedPetTypeId = (int) ($_POST['pet_type_id'] ?? 0);
    $petTypeName = ApiClient::getPetTypeNameById($petTypes, $selectedPetTypeId);
    $breed = trim($_POST['breed'] ?? '');
    $age = (int) ($_POST['age'] ?? 0);
    $gender = trim($_POST['gender'] ?? '');
    $ownerName = trim($_POST['owner_name'] ?? '');
    $contactNumber = trim($_POST['contact_number'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($petName === '') {
        $errors[] = 'Pet name is required.';
    }

    if ($selectedPetTypeId <= 0) {
        $errors[] = 'Pet type is required.';
    }

    if ($ownerName === '') {
        $errors[] = 'Owner name is required.';
    }

    if ($contactNumber === '') {
        $errors[] = 'Contact number is required.';
    }

    if (empty($errors)) {
        $repository->update($id, [
            'pet_name' => $petName,
            'pet_type_id' => $selectedPetTypeId,
            'pet_type' => $petTypeName,
            'breed' => $breed,
            'age' => $age,
            'gender' => $gender,
            'owner_name' => $ownerName,
            'contact_number' => $contactNumber,
            'status' => $status,
        ]);

        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f7f7f7; }
        .form-box { background: white; padding: 20px; max-width: 600px; border-radius: 8px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 10px 16px; background: #2d6cdf; color: white; border: none; border-radius: 6px; }
        .errors { color: red; }
        a { display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="form-box">
        <h1>Edit Pet</h1>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Pet Name</label>
            <input type="text" name="pet_name" value="<?= htmlspecialchars($_POST['pet_name'] ?? $pet['pet_name']) ?>" required>

            <label>Pet Type</label>
            <select name="pet_type_id" required>
                <option value="">Select a pet type</option>
                <?php
                    $currentPetTypeId = (int) ($_POST['pet_type_id'] ?? $pet['pet_type_id'] ?? 0);
                    foreach ($petTypes as $petType):
                        $optionValue = (int) ($petType['id'] ?? 0);
                        $optionLabel = htmlspecialchars($petType['name'] ?? '');
                        $selected = $currentPetTypeId === $optionValue ? 'selected' : '';
                ?>
                    <option value="<?= $optionValue ?>" <?= $selected ?>><?= $optionLabel ?></option>
                <?php endforeach; ?>
            </select>

            <label>Breed</label>
            <input type="text" name="breed" value="<?= htmlspecialchars($_POST['breed'] ?? $pet['breed']) ?>">

            <label>Age</label>
            <input type="number" name="age" min="0" value="<?= htmlspecialchars((string) ($_POST['age'] ?? $pet['age'])) ?>">

            <label>Gender</label>
            <select name="gender" required>
                <option value="">Select gender</option>
                <option value="Male" <?= ((($_POST['gender'] ?? $pet['gender']) === 'Male') ? 'selected' : '') ?>>Male</option>
                <option value="Female" <?= ((($_POST['gender'] ?? $pet['gender']) === 'Female') ? 'selected' : '') ?>>Female</option>
            </select>

            <label>Owner Name</label>
            <input type="text" name="owner_name" value="<?= htmlspecialchars($_POST['owner_name'] ?? $pet['owner_name']) ?>" required>

            <label>Contact Number</label>
            <input type="text" name="contact_number" value="<?= htmlspecialchars($_POST['contact_number'] ?? $pet['contact_number']) ?>" required>

            <label>Status</label>
            <select name="status">
                <option value="Active" <?= ((($_POST['status'] ?? $pet['status']) === 'Active') ? 'selected' : '') ?>>Active</option>
                <option value="Recovered" <?= ((($_POST['status'] ?? $pet['status']) === 'Recovered') ? 'selected' : '') ?>>Recovered</option>
                <option value="Pending" <?= ((($_POST['status'] ?? $pet['status']) === 'Pending') ? 'selected' : '') ?>>Pending</option>
            </select>

            <button type="submit">Update Pet</button>
        </form>

        <a href="index.php">Back to Pet List</a>
    </div>
</body>
</html>
