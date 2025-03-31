<?php require('./views/partials/head.php')?>

<?php 
if (isset($_POST['complete'])) {
    $id = $_POST['appointmentId'];
    
    $updateQuery = "UPDATE tb_appointment SET status = 'Completed' WHERE id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, 'i', $id);

    if (!mysqli_stmt_execute($updateStmt)) {
        die("Error updating status: " . mysqli_error($con));
    }

    header("Location: ./dashboard.php?success=Appointment marked as completed.");
    exit(); 
}
if (isset($_POST['approve'])) {
    $id = $_POST['appointmentId'];
    $clientID = $_POST['clientID'];
    $title = 'Appointment Request Accepted';
    $message = 'Your request has been accepted. Check the appointment page and pay a to confirm the booking.';
    $ftitle = 'You Accepted A Request';
    $fmessage = 'Accepted a request. ';
    $queryMessage = "INSERT INTO testing_notification 
    (notif_Title, notif_content, clientID, freelancer_notif_title, freelancer_notif_content, freelancerID) 
    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $queryMessage);
    mysqli_stmt_bind_param($stmt, 'ssissi', $title, $message, $clientID, $ftitle, $fmessage, $userId);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error inserting notification on approve: " . mysqli_error($con));
    }

    $updateQuery = "UPDATE tb_appointment SET status = 'Accepted' WHERE id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, 'i', $id);

    if (!mysqli_stmt_execute($updateStmt)) {
        die("Error updating status: " . mysqli_error($con));
    }

    header("Location: ./dashboard.php?success=Appointment request accepted ");
    exit(); 
}

if (isset($_POST['delete'])) {
    $id = $_POST['appointmentId'];
    $clientID = $_POST['clientID'];
    $declineReason = $_POST['declineReason'];

    $title = 'Appointment Request Declined';
    $message = $declineReason;

    $ftitle = 'You Declined A Request';
    $fmessage = 'Declined a request. ';

    // Prepared statement for inserting notification on delete
    $queryMessage = "INSERT INTO testing_notification 
    (notif_Title, notif_content, clientID, freelancer_notif_title, freelancer_notif_content, freelancerID) 
    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $queryMessage);
    mysqli_stmt_bind_param($stmt, 'ssissi', $title, $message, $clientID, $ftitle, $fmessage, $userId);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error inserting notification on delete: " . mysqli_error($con));
    }

    // Update the status and decline reason in tb_appointment
    $select = "UPDATE tb_appointment SET status = 'Declined', decline_reason = ? WHERE id = ?";
    $deleteStmt = mysqli_prepare($con, $select);
    mysqli_stmt_bind_param($deleteStmt, 'si', $declineReason, $id);

    if (!mysqli_stmt_execute($deleteStmt)) {
        die("Error updating status: " . mysqli_error($con));
        
    } else {
        header("Location: ./dashboard.php?error=Appointment request has been declined.");
        exit(); // Ensure the script stops here
    }
}


 ?>
    <?php require('./views/partials/nav.php')?>
    
    <main>
    <div class="Appointmentscontainer">
        <section class="Details">
        <div class="dashboardContainer">
        <div class="headTitle">      <p>Appointment Request</p></div>
        <table>
                <thead>
                    <tr>
                        <th>
                            Request Status
                            <form method="GET" style="display: inline;">
                                <select name="requestStatusFilter" id="requestStatusFilter" onchange="this.form.submit()" style='width: 50%;'>
                                    <option value="">-- All --</option>
                                    <option value="accepted" <?php if(isset($_GET['requestStatusFilter']) && $_GET['requestStatusFilter'] == 'accepted') echo 'selected'; ?>>Accepted</option>
                                    <option value="declined" <?php if(isset($_GET['requestStatusFilter']) && $_GET['requestStatusFilter'] == 'declined') echo 'selected'; ?>>Declined</option>
                                    <option value="pending" <?php if(isset($_GET['requestStatusFilter']) && $_GET['requestStatusFilter'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="completed" <?php if(isset($_GET['requestStatusFilter']) && $_GET['requestStatusFilter'] == 'completed') echo 'selected'; ?>>Completed</option>
                                </select>
                            </form>
                        </th>
                        <th>Payment Status</th>
                        <th>Client Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Package & Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Initialize the status filter values from GET request
                $statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '';
                $requestStatusFilter = isset($_GET['requestStatusFilter']) ? $_GET['requestStatusFilter'] : '';

                // Build the SQL query based on the selected filters
                $sql = "SELECT p.*, f.fname, f.middle_name, f.last_name, f.ContactNum, f.Freelancer_email, op.head, op.price
                        FROM tb_appointment p
                        JOIN tb_freelancers f ON p.FreelancerID = f.id
                        JOIN tb_offeredpackages op ON p.PackageID = op.id
                        WHERE p.FreelancerID = '$userId'";

                // Append filters if values are selected
                if (!empty($statusFilter)) {
                    $sql .= " AND p.status = '$statusFilter'";
                }
                if (!empty($requestStatusFilter)) {
                    $sql .= " AND p.status = '$requestStatusFilter'";
                }

                // Order by status and then by date
                $sql .= " ORDER BY CASE 
                            WHEN p.status = 'pending' THEN 1 
                            WHEN p.status = 'accepted' THEN 2 
                            WHEN p.status = 'declined' THEN 4 
                            WHEN p.status = 'completed' THEN 3
                            ELSE 5 
                          END, p.date DESC"; 

                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    // Concatenate freelancer name
                    $freelancerName = $row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
                    $rowColor = 
                    ($row['status'] == 'Accepted') ? 'background-color: #A1C6E7;' : // Soft light blue
                    (($row['status'] == 'Declined') ? 'background-color: #FFB2B2;' : // Light red
                    (($row['status'] == 'Completed') ? 'background-color: #cce5ff;' : // Light blue
                    (($row['status'] == 'Cancelled') ? 'background-color: #FFCCCB;' : // Light pink
                    'background-color: #FFD9B3;')));
                ?>
                    <tr>
                        <td > <span style="padding:10px; border-radius:10px;<?php echo $rowColor; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                        <td><?php echo htmlspecialchars($row['Payment_Status']); ?></td>
                        <td><?php echo htmlspecialchars($row['Fname'].' '.$row['Mname'].' '.$row['Lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td><?php echo htmlspecialchars($row['head'] . ' - P' . number_format($row['price'], 2)); ?></td>
                        <td>
                            <button onclick="openAppointmentCard()" 
                                    data-freelancerName="<?php echo $freelancerName; ?>"
                                    data-freelanceremail="<?php echo htmlspecialchars($row['Freelancer_email']); ?>"
                                    data-freelancercontact="<?php echo htmlspecialchars($row['ContactNum']); ?>"
                                    data-clientName="<?php echo htmlspecialchars($row['Fname'].' '.$row['Mname'].' '.$row['Lname']); ?>"
                                    data-clientContact="<?php echo htmlspecialchars($row['contactNum']); ?>"
                                    data-clientEmail="<?php echo htmlspecialchars($row['Client_email']); ?>"
                                    data-location="<?php echo htmlspecialchars($row['location']); ?>"
                                    data-package="<?php echo htmlspecialchars($row['head']); ?>"
                                    data-price ="<?php echo number_format($row['price'], 2) ?>"
                                    data-time="<?php echo htmlspecialchars($row['Event_Time']); ?>"
                                    data-event="<?php echo htmlspecialchars($row['Event_type']); ?>"
                                    data-date="<?php echo htmlspecialchars($row['date']); ?>"
                                    data-details="<?php echo htmlspecialchars($row['details']); ?>"
                                    data-paymentStatus="<?php echo htmlspecialchars($row['Payment_Status']); ?>"
                                    data-status="<?php echo htmlspecialchars($row['status']); ?>"
                                    data-appointmentId="<?php echo htmlspecialchars($row['id']); ?>"
                                    data-created_at="<?php echo htmlspecialchars($row['created_at']); ?>"
                                    data-venueAdd="<?php echo htmlspecialchars($row['EventPlaceAddress']); ?>"
                                    data-venue="<?php echo htmlspecialchars($row['Venue']); ?>"
                                    data-declineReason="<?php echo htmlspecialchars($row['decline_reason']); ?>">
                                View
                            </button> 
                            <?php if ($row['status'] == 'Pending') { ?>
                                <button type="button" onclick="confirmBooking(<?php echo $row['id']; ?>, <?php echo $row['userID']; ?>)">Accept</button>
                                <button type="button" onclick="declineBooking(<?php echo $row['id']; ?>, <?php echo $row['userID']; ?>)">Decline</button>
                            <?php } elseif ($row['status'] == 'Accepted') { ?>
                                <button type="button" onclick="completeBooking(<?php echo $row['id']; ?>)">Complete</button>
                                <section style="color: green;">Accepted</section>
                            <?php } elseif ($row['status'] == 'Completed') { ?>
                                <section style="color: blue;">Completed</section> 
                            <?php } elseif ($row['status'] == 'Declined') { ?>
                                <section style="color: red;">Declined</section>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
                </section>
            <section class="avail-calendar">
                <div class="calendar" id="calendar">
                    <?php
                    generateCalendar($currentMonth, $currentYear, $currentDate, $bookedDates);
                    ?>
                </div><br>

                <?php
                // Fetch current date
                $currentDate = date('Y-m-d');

                // Build the SQL query to get upcoming events for the freelancer
                $sql = "SELECT p.*, f.fname, f.middle_name, f.last_name, op.head, p.location, p.date, p.Event_time, p.event_type
                        FROM tb_appointment p
                        JOIN tb_freelancers f ON p.FreelancerID = f.id
                        JOIN tb_offeredpackages op ON p.PackageID = op.id
                        WHERE p.FreelancerID = '$userId' 
                        AND p.date >= '$currentDate' 
                        AND p.status = 'accepted'
                        ORDER BY p.date ASC";  // Order by the nearest date

                $result = mysqli_query($con, $sql);
                ?>

                <section class="upcomingsContainer">
                    <div class="title">Upcoming Events</div>
                    <div class="upcomings">
                        <?php 
                        while ($row = mysqli_fetch_array($result)) {
                            // Concatenate the client's full name
                            $clientName = $row['Fname'].' '.$row['Mname'].' '.$row['Lname'] ;
                            $event = $row['event_type'];
                            $location = $row['location'];
                            $date = $row['date'];
                            $timeA = $row['Event_time'];
                        ?>
                        <div class="upcoming-item">
                            <section style='display:flex; justify-content:space-between;'>
                                <span>Client Name: <?php echo htmlspecialchars($clientName); ?></span>
                                <span>Event: <?php echo htmlspecialchars($event); ?></span>
                            </section>
                            <section class='details'>
                                <span>Location: <?php echo htmlspecialchars($location); ?></span><br>
                                <span>Event Date: <?php echo htmlspecialchars($date); ?></span><br>
                                <span>Event Start: <?php echo htmlspecialchars($timeA); ?></span>
                            </section>
                        </div>
                        <?php } ?>
                    </div>
                </section>

            </section>
    </div>
</main>


<div class="AppointmentCard-modal-container">
        <div class="AppointmentCard">
                <div class="head">
                    <img src="../assets/footer-logo.png" alt="">
                    <section >Date Created:<span class="content" id="popup-created_at"></span></section>
                </div>
                <div class="body">
                    <section>
                        <ul>
                            <li><span>Client Details</span></li>
                            <li>Name:<span class="content" id='popup-name'></span><p></p></li>
                            <li>Contact Number:<span class="content" id="popup-clientContact"></span></li>
                            <li>Email:<span class="content" id="popup-clientEmail"></span></li>
                        </ul>
                    </section>
                    <section>
                        <ul>
                            <li><span>Freelancer Details</span></li>
                            <li>Name: <span class="content" id="popup-Freelancer-name"></span></li>
                            <li>Contact Number: <span class="content" id="popup-freelancercontact"></span></li>
                            <li>Email: <span class="content" id="popup-Freelanceremail"></span></li>
                        </ul>
                    </section>
                </div>
                <div class="statusCont">
                    <section>Request Status:  <span class="content" id='popup-status'></span></section>
                    <Section>Payment Status:    <span class="content" id='popup-Paymentstatus'></span></Section>
                </div>
                <div class="details">
                    <table>
                        <thead>
                            <th>Event Date</th>
                            <th>Event Time</th>
                            <th>Event Type</th>

                            <th>Package</th>
                            <th>Price</th>
                        </thead>

                        <tbody>
                            <td><span class="content" id="popup-date"></span></td>
                            <td><span class="content" id="popup-time"></span></td>
                            <td><span class="content" id="popup-event"></span></td>

                            <td> <span class="content" id="popup-package"></span></td>
                            <td>P<span class="content" id="popup-price"></span></td>
                        </tbody>
                    </table>
                </div>
                <span>Venue Address</span>
                <div class="content" id="popup-location"></div>
                <span class="content"id="popup-EventPlace"></span> ,<span class="content"id="popup-Venue">as</span>

                <div class="MoreDetails">
                    <span>More Event Details:</span><br>
                    <span class="content" id="popup-details"></span>
                </div>

                    <span>Note:</span><br>
                    <span class="content" style ='font-size:10px;'>"Once the payment status is marked as paid/confirmed, the admin will process your payment to your designated Gcash account."</span>
 
         
        </div>
    </div>



    <div class="confirm-booking-bg-container" >
        <div class="confirm-form-container">
            <p>Do you realy accept this booking?</p>
            <div class="actionContainer">
                <form id="confirm-booking-form" action="" method="POST">
                <input type="hidden" name="appointmentId" id="confirm-appointment-id" />
                <input type="hidden" name="clientID" id="confirm-client-id" />
                    <button type="submit" name="approve">Yes</button>
                </form>
                <button onclick='closeConfirmModal()'>No</button>
            </div>
        </div>
    </div>

    <div class="decline-booking-bg-container" >
        <div class="confirm-form-container">
            <p>Do you Want to Decline this booking?</p>
            <p>Reason:</p>
            <div class="actionContainer">
                <form id="confirm-booking-form" action="" method="POST">
                <input type="hidden" name="appointmentId" id="decline-appointment-id" />
                <input type="hidden" name="clientID" id="decline-client-id" />
                <textarea name="declineReason" id="declineReason" style='width: 348px; height: 115px; padding-inline:8px;font-family:poppins;'></textarea><br>
                    <button type="submit" name="delete" >submit</button>
                    <span onclick='closedeclineModal()'>Cancel</span>
                    </form>

            </div>
        </div>
    </div>

    <div class="complete-booking-bg-container">
    <div class="confirm-form-container">
        <p>Do you really want to mark this booking as complete?</p>
        <div class="actionContainer">
            <form id="complete-booking-form" action="" method="POST">
                <input type="hidden" name="appointmentId" id="complete-appointment-id" />
                <button type="submit" name="complete">Yes</button>
            </form>
            <button onclick='closeCompleteModal()'>No</button>
        </div>
    </div>
</div>


<script>
    function declineBooking(appointmentId, clientId) {
        document.getElementById("decline-appointment-id").value = appointmentId;
        document.getElementById("decline-client-id").value = clientId;
        document.querySelector(".decline-booking-bg-container").style.display = "flex";
    }
    function closedeclineModal() {
        document.querySelector(".decline-booking-bg-container").style.display = "none";
    }

    function confirmBooking(appointmentId,clientId) {
        document.getElementById("confirm-appointment-id").value = appointmentId;
        document.getElementById("confirm-client-id").value = clientId;
        document.querySelector(".confirm-booking-bg-container").style.display = "flex";
    }

    function closeConfirmModal() {
        document.querySelector(".confirm-booking-bg-container").style.display = "none";
    }

    function completeBooking(appointmentId) {
    document.getElementById("complete-appointment-id").value = appointmentId;
    document.querySelector(".complete-booking-bg-container").style.display = "flex"; 
    }

    function closeCompleteModal() {
        document.querySelector(".complete-booking-bg-container").style.display = "none"; 
    }


    function openAppointmentCard() {
        const AppointmentCard = document.querySelector('.AppointmentCard-modal-container');
        AppointmentCard.style.display = "flex";
        AppointmentCard.addEventListener('click', function (event) {
            if (event.target === AppointmentCard) {
                AppointmentCard.style.display = "none";
            }
        });

        var statusElement = document.getElementById('popup-status');
        var paymentStatusElement = document.getElementById('popup-Paymentstatus');

        // Reset styles
        statusElement.style.backgroundColor = '';
        statusElement.style.color = '';
        paymentStatusElement.style.backgroundColor = '';
        paymentStatusElement.style.color = '';

        // Apply styles based on the status
        if (statusElement.textContent === 'Accepted') {
            statusElement.style.backgroundColor = 'rgb(198, 255, 179)';
            statusElement.style.color = 'black';
        } else if (statusElement.textContent === 'Declined') {
            statusElement.style.backgroundColor = '#ff9999';
            statusElement.style.color = 'black';
        } else if (statusElement.textContent === 'Pending') {
            statusElement.style.backgroundColor = '#ffd9b3';
            statusElement.style.color = 'black';
        }
    }

// Select all the buttons ng modal
const viewButtons = document.querySelectorAll('button[onclick="openAppointmentCard()"]');
viewButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        // Setter ng content ng modal/ containers / span
        document.getElementById('popup-Freelancer-name').textContent = button.getAttribute('data-freelancerName');
            document.getElementById('popup-freelancercontact').textContent = button.getAttribute('data-freelancercontact');
            document.getElementById('popup-Freelanceremail').textContent = button.getAttribute('data-Freelanceremail');
            document.getElementById('popup-name').textContent = button.getAttribute('data-clientName');
            document.getElementById('popup-clientContact').textContent = button.getAttribute('data-clientContact');
            document.getElementById('popup-clientEmail').textContent = button.getAttribute('data-clientEmail');
            document.getElementById('popup-location').textContent = button.getAttribute('data-location');
            document.getElementById('popup-package').textContent = button.getAttribute('data-package');
            document.getElementById('popup-price').textContent = button.getAttribute('data-price');
            document.getElementById('popup-time').textContent = button.getAttribute('data-time');
            document.getElementById('popup-date').textContent = button.getAttribute('data-date');
            document.getElementById('popup-event').textContent = button.getAttribute('data-event');
            document.getElementById('popup-details').textContent = button.getAttribute('data-details');
            document.getElementById('popup-Paymentstatus').textContent = button.getAttribute('data-paymentStatus');
            document.getElementById('popup-status').textContent = button.getAttribute('data-status');
            document.getElementById('popup-created_at').textContent = button.getAttribute('data-created_at');
            document.getElementById('popup-EventPlace').textContent = button.getAttribute('data-venueAdd');
            document.getElementById('popup-Venue').textContent = button.getAttribute('data-venue');
            document.getElementById('popup-reason').textContent = button.getAttribute('data-declineReason');

        // Open  modal
        openAppointmentCard();
    });
});
</script>



<script>//calendar only
   
        $(document).ready(function() {
            function setupNavigation() {
                $('.prev-month, .next-month').click(function(e) {
                    e.preventDefault();
                    var date = $(this).data('date');

                    $.ajax({
                        url: '', // Current page URL
                        type: 'GET',
                        data: { date: date },
                        success: function(response) {
                            $('.calendar').html(response);
                            setupNavigation(); // Re-setup navigation after content load
                        },
                        error: function() {
                            alert('Error loading calendar. Please try again.');
                        }
                    });
                });
            }

            setupNavigation(); // Initial setup
        });


</script>
<?php require('./views/partials/popups.php')?>
    <?php require('./views/partials/footer.php')?>