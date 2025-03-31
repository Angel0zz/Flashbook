<?php
   include("connection.php"); 
  
$search = isset($_POST['search']) ? mysqli_real_escape_string($con, $_POST['search']) : '';
$region = isset($_POST['region']) ? mysqli_real_escape_string($con, $_POST['region']) : '';
$province = isset($_POST['province']) ? mysqli_real_escape_string($con, $_POST['province']) : '';
$city = isset($_POST['city']) ? mysqli_real_escape_string($con, $_POST['city']) : '';

$query = "SELECT * FROM tb_freelancers WHERE Status = 'Active'";

if (!empty($search)) {
    $query .= " AND (fname LIKE '%$search%' OR last_name LIKE '%$search%' OR middle_name LIKE '%$search%')";
}
if (!empty($region)) {
    $query .= " AND region = '$region'";
}
if (!empty($province)) {
    $query .= " AND province = '$province'";
}
if (!empty($city)) {
    $query .= " AND city = '$city'";
}

$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $freelancer_id = $row['id'];
        
        // Fetch average rating and total reviews
        $avg_rating_query = "
            SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews 
            FROM tb_reviews 
            WHERE freelancerID = '$freelancer_id'";
        $avg_rating_result = mysqli_query($con, $avg_rating_query);
        $avg_rating_data = mysqli_fetch_assoc($avg_rating_result);
        
        $avg_rating = round($avg_rating_data['avg_rating'], 1);
        $total_reviews = $avg_rating_data['total_reviews'];

        echo "
        <div class='profile-card'>
            <div class='background-cont'>
                <img src='../img/{$row['profile']}' alt=''>
            </div>
            <div class='details-container'>
                <section class='heroContainer'>
                    <section class='heroProfile'>
                        <img src='../img/{$row['profile']}' alt=''>
                    </section>
                    <section class='heroName'>
                        {$row['fname']} {$row['middle_name']} {$row['last_name']}<br>
                        <span>Freelancer - Photographer</span>
                    </section>
                </section>
                <section class='aboutHero'>
                    {$row['about']}
                </section>
                <a href='./freelancer-profile.php?id={$row['id']}'>
                    <button>Check profile</button>
                </a>
                <section class='LinkContainer'>";
        
        // Display average rating and number of reviews
        if ($total_reviews > 0) {
            echo "<p>Average Rating: ";
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= round($avg_rating) ? '★' : '☆';
            }
            echo " ($avg_rating/5) based on $total_reviews reviews.</p>";
        } else {
            echo "<p>No reviews yet.</p>";
        }

        echo "
                </section>
            </div>
        </div>";
    }
} else {
    echo "<span style='font-size:20px;'>No freelancers found.</span>";
}
?>