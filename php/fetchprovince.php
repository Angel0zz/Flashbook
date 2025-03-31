<?php
include('connection.php');

// Sanitize input
$location_id = mysqli_real_escape_string($con, $_POST['id']);

// Debugging - Check if data is received
if (empty($location_id)) {
    echo 'No region selected';
    exit;
} else {
    echo 'Region ID received: ' . $location_id . '<br>';
}

// Check if the location ID is not empty
$loc_sql = "SELECT * FROM province WHERE region_name = '$location_id'";
$loc_result = mysqli_query($con, $loc_sql);

// Debugging - Check if query returns results
if ($loc_result) {
    $output = '<option value="" disabled selected>Select Province</option>';
    while ($row = mysqli_fetch_assoc($loc_result)) {
        $output .= '<option value="'. $row['province_name'] . '">' . $row['province_name'] . '</option>';
    }
    echo $output;
} else {
    echo 'Query failed: ' . mysqli_error($con);
}
?>