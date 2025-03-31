<?php require('./views/partials/head.php')?>
<?php require('./views/partials/nav.php'); 
if (isset($_POST['cancel'])) {
    $id = $_POST['appointmentId'];
    
    $updateQuery = "UPDATE tb_appointment SET status = 'Cancelled' WHERE id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, 'i', $id);

    if (!mysqli_stmt_execute($updateStmt)) {
        die("Error updating status: " . mysqli_error($con));
    }

    header("Location: ./appointments.php?success=Appointment Cancelled.");
    exit(); 
}
?>


<main>
    <div class="dashboardContainer">  
        <div class="headTitle"><p>Appointment Request</p></div>

        <!-- Status Filter Form -->
        <div class="Appointment-container">
                <form method="GET">
                    <label for="statusFilter">Filter by Status:</label>
                    <select name="statusFilter" id="statusFilter" onchange="this.form.submit()">
                        <option value="">-- All --</option>
                        <option value="Accepted" <?php if(isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Accepted') echo 'selected'; ?>>Accepted</option>
                        <option value="Declined" <?php if(isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Declined') echo 'selected'; ?>>Declined</option>
                        <option value="Pending" <?php if(isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Completed" <?php if(isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Completed') echo 'selected'; ?>>Completed</option>
                        <option value="Cancelled" <?php if(isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </form>
            <table>
                <thead>
                    <tr>
                        <th>Request status</th>
                        <th>Payment Status</th>
                        <th>Photographer / Videographer Name</th>
                        <th>Schedule Date</th>
                        <th>Location</th>
                        <th>Package & Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        
                    $statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '';

    
                    $sql = "SELECT p.*, f.fname, f.middle_name, f.last_name, f.ContactNum, f.Freelancer_email, op.head, op.price
                            FROM tb_appointment p
                            JOIN tb_freelancers f ON p.FreelancerID = f.id
                            JOIN tb_offeredpackages op ON p.PackageID = op.id
                            WHERE p.userID = '$UserId'";

                    if (!empty($statusFilter)) {
                        $sql .= " AND p.status = '$statusFilter'";
                    }

                    $sql .= " ORDER BY CASE 
                                WHEN p.status = 'Accepted' THEN 1 
                                WHEN p.status = 'Pending' THEN 2 
                                WHEN p.status = 'Completed' THEN 3
                                WHEN p.status = 'Cancelled' THEN 4
                                ELSE 5 
                            END, p.date DESC";

                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        $freelancerName = htmlspecialchars($row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                        $rowColor = 
                        ($row['status'] == 'Accepted') ? 'background-color: #A1C6E7;' : 
                        (($row['status'] == 'Declined') ? 'background-color: #FFB2B2;' : 
                        (($row['status'] == 'Completed') ? 'background-color: #cce5ff;' : 
                        (($row['status'] == 'Cancelled') ? 'background-color: #FF9999;' : 
                        'background-color: #FFD9B3;')));
                    ?>
                    <tr >
                        <td > <span style="padding:10px; border-radius:10px;<?php echo $rowColor; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                        <td> <?php echo htmlspecialchars($row['Payment_Status']); ?></td>
                        <td><?php echo $freelancerName; ?></td>
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
                            data-declineReason="<?php echo htmlspecialchars($row['decline_reason']); ?>"
                            data-appointmentId="<?php echo htmlspecialchars($row['id']); ?>"
                            data-created_at="<?php echo htmlspecialchars($row['created_at']); ?>"
                            data-venueAdd="<?php echo htmlspecialchars($row['EventPlaceAddress']); ?>"
                            data-venue="<?php echo htmlspecialchars($row['Venue']); ?>"
                            
                            style='margin-bottom:5px;'>
                            
                                View details & Pay
                            </button>
                            <?php if ($row['status'] == 'Pending') { ?>
                                <button type="button" onclick="openCancelModal(<?php echo $row['id']; ?>)">Cancel</button>
                            <?php }?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php 

if (isset($_POST['passPayment'])) {
    $referenceNum = $_POST['referenceNum'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $appointmentId = $_POST['appointmentId'] ?? ''; // Get appointment ID from form

    if (!empty($referenceNum) && !empty($amount) && !empty($appointmentId)) {
        $referenceNum = mysqli_real_escape_string($con, $referenceNum);
        $amount = mysqli_real_escape_string($con, $amount);
        $appointmentId = mysqli_real_escape_string($con, $appointmentId);
        $sql = "UPDATE tb_appointment
                SET Payment_Amount = '$amount', Payment_Reference = '$referenceNum', Payment_Status = 'Verifying'
                WHERE id = '$appointmentId'";

        if (mysqli_query($con, $sql)) {
            $_SESSION['success'] = 'Payment Sent';
            header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to the same page
            exit();
            
        } else {
            echo "<script>alert('Failed to update payment details. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Please enter both reference number and amount.');</script>";
    }
}
ob_end_flush();
?>

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
                <span class="content"id="popup-EventPlace"></span> ,<span class="content"id="popup-Venue"></span>
                <div class="MoreDetails">
                    <span>More Event Details:</span><br>
                    <span class="content" id="popup-details"></span>
                </div>


                <div class="info">
                    <span>Payment Method Available:</span>GCASH
                </div>
                
                <div class="PaymentContainer">
                    <img src="../assets/Qr.png" alt="">
                  
                    <section style="text-align: center;"> 
                        <form action="" method='POST'>
                          
                        <p>Enter reference number and Amount Sent<p>
                        <input type="text" name='referenceNum' id='referenceNum' placeholder="Reference Number" required>

                        <input type="text" name="amount" id="amount" placeholder="Amount Sent" required><br>

                        <!-- Hidden field to store appointment ID -->
                        <input type="hidden" name="appointmentId" id="appointmentId">

                        <button type="submit" name='passPayment' id='passPayment' >Submit</button>
                        </form>
                        <span style='font-size:80%;'>note: You are Required to pay A Security Fee to Confirm Your Booking</span>
                    </section>
                </div>
                <div class="reason" style='color:red; display:none;'>
                    <span>Decline Reason:</span><span id="popup-reason" class='content'></span>
                </div>


        </div>
    </div>

    <div class="cancel-booking-bg-container" id="cancelModal" >
    <div class="confirm-form-container">
        <p>Do you really want to cancel this booking?</p>
        <span style='font-size:12px; color:gray;'>note: Downpayment Cannot be Refunded</span>
        <div class="actionContainer">
            <form id="cancel-booking-form" action="" method="POST">
                <input type="hidden" name="appointmentId" id="cancel-appointment-id" />
                <button type="submit" name="cancel">Yes</button>
            </form>
            <button onclick='closeCancelModal()'>No</button>
        </div>
    </div>
</div>

<script>
    function openCancelModal(appointmentId) {
    document.getElementById('cancel-appointment-id').value = appointmentId;
    document.getElementById('cancelModal').style.display = 'flex';
}

function closeCancelModal() {
    document.getElementById('cancelModal').style.display = 'none';
}
   function openAppointmentCard() {
    const AppointmentCard = document.querySelector('.AppointmentCard-modal-container');
    AppointmentCard.style.display = "flex";
    AppointmentCard.addEventListener('click', function (event) {
        if (event.target === AppointmentCard) {
            AppointmentCard.style.display = "none";
        }
    });
    const declineReason = document.querySelector('.reason');
    var statusElement = document.getElementById('popup-status');
    var paymentStatusElement = document.getElementById('popup-Paymentstatus');
    const paymentSection = document.querySelector('.PaymentContainer');
    
    // Reset styles
    statusElement.style.backgroundColor = '';
    statusElement.style.color = '';
    paymentStatusElement.style.backgroundColor = '';
    paymentStatusElement.style.color = '';

    // Apply styles based on the status
    if (statusElement.textContent === 'Accepted') {
        statusElement.style.backgroundColor = 'rgb(198, 255, 179)';
        statusElement.style.color = 'black';
        paymentSection.style.display = 'flex'; 
    } else if (statusElement.textContent === 'Declined') {
        statusElement.style.backgroundColor = '#ff9999';
        statusElement.style.color = 'black';
        paymentSection.style.display = 'none'; 
        declineReason.style.display='flex';
    } else if (statusElement.textContent === 'Pending') {
        statusElement.style.backgroundColor = '#ffd9b3';
        statusElement.style.color = 'black';
        paymentSection.style.display = 'flex'; // Ensure payment section is visible if Pending
    }else if (statusElement.textContent === 'Cancelled') {
        statusElement.style.backgroundColor = '#ff9999';
        statusElement.style.color = 'black';
        paymentSection.style.display = 'none'; 
        declineReason.style.display='flex';
    }

    // Hide payment section based on payment status
    if (statusElement.textContent !== 'Declined' && statusElement.textContent !== 'Cancelled') { // Check payment status if not Declined or Cancelled
    if (paymentStatusElement.textContent === 'Paid' || paymentStatusElement.textContent === 'Confirmed' || paymentStatusElement.textContent === 'Verifying') {
        paymentSection.style.display = 'none';
        paymentStatusElement.style.backgroundColor = 'rgb(198, 255, 179)';
        paymentStatusElement.style.color = 'black';
    } else if (paymentStatusElement.textContent === 'Verifying') {
        paymentStatusElement.style.backgroundColor = '#ffd9b3';
        paymentStatusElement.style.color = 'black';
    } else {
        paymentStatusElement.style.backgroundColor = '#ff9999';
        paymentStatusElement.style.color = 'black';
        paymentSection.style.display = 'flex';
    }
}
}

    const viewButtons = document.querySelectorAll('button[onclick="openAppointmentCard()"]');
    viewButtons.forEach(function(button) {
        button.addEventListener('click', function() {
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
            // Set the hidden appointment ID
            document.getElementById('appointmentId').value = button.getAttribute('data-appointmentId');

            openAppointmentCard();
        });
    });

</script>

<?php require_once('./views/partials/footer.php')?>
