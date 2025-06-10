<?php
include 'session.php';
include 'db.php';

$ids = array_keys($_SESSION['cart'] ?? []);
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart – Legendary Kits</title>
    <style>
        body {
            background: url('uploads/green-pitch.jpg') center/cover no-repeat fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .overlay {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(2px);
            min-height: 100vh;
            padding: 60px 30px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .btn {
            display: block;
            margin: 30px auto;
            padding: 10px 20px;
            text-decoration: none;
            background: #0077cc;
            color: white;
            border-radius: 5px;
            text-align: center;
            width: fit-content;
        }
    </style>
</head>
<body>

<div class="overlay">
    <h2>Your Cart</h2>

    <?php
    if ($ids) {
        $ids_str = implode(',', array_map('intval', $ids));
        $q = $conn->query("SELECT * FROM jerseys WHERE id IN($ids_str)");
        echo '<table>';
        echo '<tr><th>Item</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>';

        while ($j = $q->fetch_assoc()) {
            $qty = $_SESSION['cart'][$j['id']];
            $sub = $qty * $j['price'];
            $total += $sub;
            echo "<tr>
                    <td>{$j['player']} ({$j['year']})</td>
                    <td>$qty</td>
                    <td>₹{$j['price']}</td>
                    <td>₹$sub</td>
                  </tr>";
        }

        echo "<tr><td colspan='3'><strong>Total</strong></td><td><strong>₹$total</strong></td></tr>";
        echo '</table>';
    } else {
        echo "<p style='text-align:center;'>Your cart is empty.</p>";
    }
    ?>

    <a class="btn" href="dashboard_user.php">← Back to Shop</a>
</div>

</body>
</html>
