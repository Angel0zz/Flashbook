<?php
include('../php/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_POST['image'];
    $albumID = $_POST['album_id'];

    // Remove the image from the server
    $filePath = '../uploads/' . $image;
    if (file_exists($filePath)) {
        unlink($filePath); // Deletes the file
    }

    // Now update the database
    $sql = "SELECT image FROM tb_images WHERE id = '$albumID' LIMIT 1";
    $result = mysqli_query($con, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $currentImages = json_decode($row['image'], true);
        // Remove the image from the array
        if (($key = array_search($image, $currentImages)) !== false) {
            unset($currentImages[$key]);
        }
        // Update the database with the new image list
        $updatedImages = json_encode(array_values($currentImages)); // Re-index array
        $updateSQL = "UPDATE tb_images SET image = '$updatedImages' WHERE id = '$albumID'";
        mysqli_query($con, $updateSQL);
    }
}
?>
