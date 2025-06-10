<?php
include("session.php");
include("db.php");

if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM jerseys WHERE id = $id");

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($row['player']) ?> – Details</title>
    <style>
        body {
            background: url('uploads/green-pitch.jpg') center/cover no-repeat fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .overlay {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(2px);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 6px;
        }

        .card h1 {
            margin-top: 20px;
            font-size: 24px;
        }

        .card p {
            margin: 10px 0;
            font-size: 16px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #0077cc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="overlay">
    <div class="card">
        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['player']) ?>">
        <h1><?= htmlspecialchars($row['player']) ?> (<?= $row['year'] ?>)</h1>
        <p><strong>Team:</strong> <?= htmlspecialchars($row['team']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
        <p><strong>Price:</strong> ₹<?= number_format($row['price'], 2) ?></p>
        <a class="back-link" href="<?= $_SESSION['role'] === 'admin' ? 'dashboard.php' : 'dashboard_user.php' ?>">← Back</a>
    </div>
</div>

</body>
</html>
