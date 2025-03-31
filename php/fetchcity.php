<?php
   include("connection.php");
 
  // Sanitize input
  $city_id = mysqli_real_escape_string($con, $_POST['id']);

  // Debugging - Check if data is received
  if (empty($city_id)) {
      echo 'No province selected or invalid data';
      exit;
  } else {
      echo 'Province ID received: ' . $city_id . '<br>';
  }
  
  // Query to fetch cities based on the selected province
  $loc_sql = "SELECT * FROM cities WHERE province_name = '$city_id'";
  $loc_result = mysqli_query($con, $loc_sql);
  
  // Debugging - Check if the query returns results
  if ($loc_result) {
      $output = '<option value="" disabled selected>Select Location</option>';
      while ($city_row = mysqli_fetch_assoc($loc_result)) {
          $output .= '<option value="'. $city_row['city_name'] .'">' . $city_row['city_name'] . '</option>';
      }
      echo $output;
  } else {
      echo 'Query failed: ' . mysqli_error($con);
  }
  ?>