<?php
include("session.php");
include("db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard_user.php");
    exit;
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player = $_POST['player'];
    $year = intval($_POST['year']);
    $team = $_POST['team'];
    $price = floatval($_POST['price']);
    $desc = $_POST['description'];

    // Handle image upload
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imagePath = 'uploads/' . basename($imageName);

    if (move_uploaded_file($imageTmp, $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO jerseys (player, year, team, description, image, price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssd", $player, $year, $team, $desc, $imageName, $price);

        if ($stmt->execute()) {
            $msg = "Jersey added successfully!";
        } else {
            $msg = "Database error: " . $stmt->error;
        }
    } else {
        $msg = "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Jersey – Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('uploads/green-pitch.jpg') center/cover no-repeat fixed;
            margin: 0;
            padding: 0;
        }

        .container {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(2px);
            max-width: 600px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        form input, form textarea, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background: #0077cc;
            color: white;
            font-weight: bold;
        }

        .msg {
            text-align: center;
            color: green;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #0077cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Jersey</h2>
        <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="player" placeholder="Player Name" required>
            <input type="number" name="year" placeholder="Year" required>
            <input type="text" name="team" placeholder="Team" required>
            <input type="number" step="0.01" name="price" placeholder="Price in ₹" required>
            <textarea name="description" placeholder="Jersey Description" required></textarea>
            <input type="file" name="image" required>
            <button type="submit">Add Jersey</button>
        </form>
        <a href="dashboard.php">← Back to Admin Dashboard</a>
    </div>
</body>
</html>
