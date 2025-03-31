<?php
include('connection.php');

$region = $_POST['region'];
$province = $_POST['province'];

// Modify the query based on your database schema
$sql = "SELECT * FROM tb_freelancers WHERE region = ? AND province = ? AND Status ='Active'";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $region, $province);
$stmt->execute();
$result = $stmt->get_result();

$options = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['id'] . '">' . htmlspecialchars($row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']) . '</option>';
    }
} else {
    $options .= '<option disabled selected>No photographers available in this location</option>';
}

echo $options;
$stmt->close();
?>