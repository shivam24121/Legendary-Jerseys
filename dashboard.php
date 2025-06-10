<?php
include 'session.php';
include 'db.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $deleteId = intval($_POST['id']);
    $conn->query("DELETE FROM jerseys WHERE id = $deleteId");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard – Legendary Kits</title>
    <style>
        body {
            background: url('uploads/green-pitch.jpg') center/cover no-repeat fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .overlay {
            background: rgba(255,255,255,0.95);
            padding: 30px;
            min-height: 100vh;
        }
        h1 {
            text-align: center;
        }
        .top-nav {
            text-align: right;
            margin-bottom: 20px;
        }
        .top-nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .product {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            background: #fff;
            box-shadow: 0 0 6px rgba(0,0,0,0.1);
        }
        .product img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }
        .product h3 {
            margin: 10px 0 5px;
        }
        .product p {
            margin: 5px 0;
        }
        .product form {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="overlay">
    <div class="top-nav">
        <a href="add_product.php">Add Jersey</a>
        <a href="logout.php">Logout</a>
    </div>

    <h1>Admin Dashboard – Manage Jerseys</h1>

    <div class="container">
        <?php
        $result = $conn->query("SELECT * FROM jerseys ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="product">
                <img src="uploads/<?= $row['image'] ?>" alt="<?= $row['player'] ?>">
                <h3><?= $row['player'] ?> (<?= $row['year'] ?>)</h3>
                <p>Team: <?= $row['team'] ?></p>
                <p>Price: $<?= $row['price'] ?></p>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button name="action" value="delete" onclick="return confirm('Delete this product?');">Delete</button>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
</div>
</body>
</html>
