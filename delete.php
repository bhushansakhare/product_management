<?php
// Directory where files are stored
$uploadDirectory = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["filename"])) {
    $filename = $_GET["filename"];

    // Check if the file exists
    if (file_exists($uploadDirectory . $filename)) {
        // Attempt to delete the file
        if (unlink($uploadDirectory . $filename)) {
            echo "File '$filename' deleted successfully.";
        } else {
            echo "Error deleting file '$filename'.";
        }
    } else {
        echo "File '$filename' not found.";
    }
} else {
    echo "Invalid request.";
}
?>
