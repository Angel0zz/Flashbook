<?php
// user rating submit
if (isset($_POST['submit_review'])) {

    $rating = intval($_POST['rating']); // Get rating from the hidden input
    $review = mysqli_real_escape_string($con, $_POST['review']);

    $sql = "INSERT INTO tb_reviews (freelancerID, clientId, rating, review) VALUES ('$id ', '$UserId', '$rating', '$review')";
    if (mysqli_query($con, $sql)) {
        header("Location: freelancer-profile.php?id=$id&success=review insertd");
    } else {
        echo "<p>Failed to submit review. Please try again later.</p>";
    }
}
?>