<?php
// Database connection configuration
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$dbname = "product_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CREATE - Add a new product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create"])) {
        $name = $_POST["name"];
        $price = $_POST["price"];
        $sql = "INSERT INTO products (name, price) VALUES ('$name', '$price')";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// READ - Retrieve all products
$sql = "SELECT id, name, price FROM products";
$result = $conn->query($sql);

// DELETE - Delete a product
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["delete"])) {
        $product_id = $_GET["delete"];
        $sql = "DELETE FROM products WHERE id='$product_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
</head>
<body>
    <h2>Create Product</h2>
    <form method="post">
        Name: <input type="text" name="name" required><br>
        Price: <input type="number" name="price" step="0.01" required><br>
        <input type="submit" name="create" value="Create">
    </form>

    <h2>Products</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td><a href='edit.php?id=" . $row["id"] . "'>Edit</a></td>";
                echo "<td><a href='index.php?delete=" . $row["id"] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No products found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
