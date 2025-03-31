<?php

$currentDate = date('Y-m-d');

// Fetch the current or selected date
$date = isset($_GET['date']) ? $_GET['date'] : $currentDate;
$timestamp = strtotime($date);

// Get the current month and year from the timestamp
$currentMonth = date('m', $timestamp);
$currentYear = date('Y', $timestamp);

// Function to fetch booked dates for the current month and year
function fetchBookedDates($con, $currentMonth, $currentYear) {
    $userId = $_SESSION['id'];
    $bookedDates = [];
    // Updated query to fetch both date and Event_type
    $result = $con->query("SELECT date, Event_type FROM tb_appointment 
                           WHERE status = 'accepted' 
                           AND MONTH(date) = '$currentMonth' 
                           AND YEAR(date) = '$currentYear' 
                           AND freelancerID = '$userId'");

    while ($row = $result->fetch_assoc()) {
        $bookedDates[$row['date']] = $row['Event_type']; // Store date as key and Event_type as value
    }
    return $bookedDates;
}

// Function to generate the calendar table
// Function to generate the calendar table
function generateCalendar($currentMonth, $currentYear, $currentDate, $bookedDates) {
    $firstDayOfMonth = date('w', strtotime("$currentYear-$currentMonth-01"));
    $totalDaysOfMonth = date('t', strtotime("$currentYear-$currentMonth-01"));

    // Generate the previous and next month
    $prevMonth = date('Y-m-d', strtotime('-1 month', strtotime("$currentYear-$currentMonth-01")));
    $nextMonth = date('Y-m-d', strtotime('+1 month', strtotime("$currentYear-$currentMonth-01")));
    
    // Calendar Navigation
    echo "<div style='background-color: #10182fcc; color:white;'>
    <section>Availability Calendar</section> " . date('F Y', strtotime("$currentYear-$currentMonth-01")) . "
    <section>
        <button class='prev-month' data-date='$prevMonth'>Prev Month</button> | 
        <button class='next-month' data-date='$nextMonth'>Next Month</button>
    </section> </div>"; 

    // Start calendar table
    echo "<table>";
    echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";
    echo "<tr>";

    // Fill empty cells before the first day
    for ($i = 0; $i < $firstDayOfMonth; $i++) {
        echo "<td></td>";
    }

    // Display days of the month
    for ($day = 1; $day <= $totalDaysOfMonth; $day++) {
        if (($i % 7) == 0) {
            echo "</tr><tr>"; // Start a new row for each week
        }

        $dayFormatted = "$currentYear-$currentMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT);
        $isBooked = isset($bookedDates[$dayFormatted]) ? 'booked' : '';
        $pastClass = (strtotime($dayFormatted) < strtotime($currentDate)) ? 'past-date' : '';

        // Generate the calendar cell with booking or disabled options
        echo "<td class='$isBooked $pastClass' >";
        if (isset($bookedDates[$dayFormatted])) {
            $eventType = $bookedDates[$dayFormatted]; // Get the event type for the booked date
            echo "<span class='disabled'>$day <br> <span style='font-size:8px; '>($eventType)</span></span>"; // Display day and event type
        } elseif (strtotime($dayFormatted) < strtotime($currentDate)) {
            echo "<span class='past-date'>$day</span>";
        } else {
            echo "<span>$day</span>";
        }
        echo "</td>";
        $i++;
    }

    // Fill empty cells after the last day
    while (($i % 7) != 0) {
        echo "<td></td>";
        $i++;
    }

    echo "</tr></table>";
}



// Function to handle booking form display and submission

// Fetch booked dates for the current month
$bookedDates = fetchBookedDates($con, $currentMonth, $currentYear);
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $timestamp = strtotime($date);
    $currentMonth = date('m', $timestamp);
    $currentYear = date('Y', $timestamp);
    
    // Fetch booked dates for the current month
    $bookedDates = fetchBookedDates($con, $currentMonth, $currentYear);
    
    // Output only the calendar
    generateCalendar($currentMonth, $currentYear, $currentDate, $bookedDates);
    exit; // Prevent the rest of the page from loading
}
?>

