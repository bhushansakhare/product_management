<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$dbname = "product_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update"])) {
        $product_id = $_POST["product_id"];
        $new_name = $_POST["new_name"];
        $new_price = $_POST["new_price"];

        $sql = "UPDATE products SET name='$new_name', price='$new_price' WHERE id='$product_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $product_id = $_GET["id"];

        $sql = "SELECT id, name, price FROM products WHERE id='$product_id'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $product = $row;
        } else {
            echo "Product not found.";
            exit;
        }
    } else {
        echo "Invalid request.";
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="post">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        New Name: <input type="text" name="new_name" value="<?php echo $product['name']; ?>" required><br>
        New Price: <input type="number" name="new_price" step="0.01" value="<?php echo $product['price']; ?>" required><br>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
