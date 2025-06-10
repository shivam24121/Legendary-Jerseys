<?php
include("session.php");
include("db.php");

if ($_SESSION['role'] != 'user') {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['action'])) {
    $id = intval($_POST['id']);
    if (!isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id] = 0;
    $_SESSION['cart'][$id]++;
    if ($_POST['action'] == 'buy') {
        header("Location: viewCart.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Legendary Kits – User Dashboard</title>
    <style>
        body {
            background: url('uploads/green-pitch.jpg') center/cover no-repeat fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .navbar h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .navbar .nav-links a {
            margin-left: 20px;
            text-decoration: none;
            color: #0077cc;
            font-weight: bold;
        }

        .overlay {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(2px);
            min-height: 100vh;
            padding: 100px 30px 30px 30px; 
        }

        h1 {
            text-align: center;
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

        .product a {
            display: block;
            margin-top: 5px;
            text-decoration: none;
            color: #0077cc;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>  LEGENDARY  JERSEYS  ⚽</h1>
    <div class="nav-links">
        <a href="viewCart.php">Cart (<?= count($_SESSION['cart'] ?? []) ?>)</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="overlay">
    <div class="container">
        <?php
        $result = $conn->query("SELECT * FROM jerseys");
        while ($j = $result->fetch_assoc()) {
            ?>
            <div class="product">
                <img src="uploads/<?= $j['image'] ?>" alt="<?= $j['player'] ?>">
                <h3><?= $j['player'] ?> (<?= $j['year'] ?>)</h3>
                <p>Team: <?= $j['team'] ?></p>
                <p>Price: ₹<?= $j['price'] ?></p>
                <a href="product.php?id=<?= $j['id'] ?>">View Details</a>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $j['id'] ?>">
                    <button name="action" value="add">Add to Cart</button>
                    <button name="action" value="buy">Buy Now</button>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
</div>

</body>
</html>
