<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Canteen Home</title></head>
<body>

<h2>Welcome to the canteen, <span style="color:red;"><?php echo htmlspecialchars($_SESSION['username']); ?></span></h2>

<p><a href="logout.php">Logout</a></p>

<h3>Here are the prices:</h3>
<ul>
    <li>Fishball - 30 PHP</li>
    <li>Kikiam - 40 PHP</li>
    <li>Corndog - 50 PHP</li>
</ul>

<form method="POST" action="">
    <label>Choose your order:</label>
    <select name="order">
        <option value="Fishball">Fishball</option>
        <option value="Kikiam">Kikiam</option>
        <option value="Corndog">Corndog</option>
    </select><br><br>

    <label>Quantity:</label>
    <input type="number" name="qty" min="1" value="1"><br><br>

    <label>Cash:</label>
    <input type="number" name="cash" min="0" step="1"><br><br>

    <button type="submit" name="submit">Submit</button>
</form>

<?php
if(isset($_POST['submit'])){
    $order = $_POST['order'];
    $qty = (int) $_POST['qty'];
    $cash = (int) $_POST['cash'];

    $prices = [
        "Fishball" => 30,
        "Kikiam" => 40,
        "Corndog" => 50
    ];

    if(!isset($prices[$order])){
        echo "<p style='color:red;'>Invalid item selected.</p>";
    } elseif($qty <= 0){
        echo "<p style='color:red;'>Quantity must be at least 1.</p>";
    } else {
        $total = $prices[$order] * $qty;
        echo "<p><b>Total Price:</b> $total PHP</p>";

        if($cash >= $total){
            $change = $cash - $total;
            echo "<p><b>Your change:</b> $change PHP</p>";
        } else {
            echo "<p style='color:red;'>Not enough cash!</p>";
        }
    }
}
?>

</body>
</html>
