<?php require('./adminComponents/Admin-head.php'); ?>
<?php
$freelancerResult = $con->query("SELECT COUNT(*) as total FROM tb_freelancers");
$freelancerCount = $freelancerResult->fetch_assoc()['total'];

$clientResult = $con->query("SELECT COUNT(*) as total FROM tb_clientusers");
$clientCount = $clientResult->fetch_assoc()['total'];

$appointmentResult = $con->query("SELECT COUNT(*) as total FROM tb_appointment");
$appointmentCount = $appointmentResult->fetch_assoc()['total'];

$paymentResult = $con->query("SELECT SUM(Payment_Amount) as total FROM tb_appointment WHERE Payment_Status = 'Confirmed'");
$paymentTotal = $paymentResult->fetch_assoc()['total'];

if ($paymentTotal === null) {
    $paymentTotal = 0;
}
$sql = "SELECT p.id AS bookingID, p.Payment_Status, p.Fname, p.Mname,p.Lname, 
               f.fname AS freelancer_fname, f.middle_name AS freelancer_mname, f.last_name AS freelancer_lname, 
               p.Payment_Reference, p.Payment_Amount 
        FROM tb_appointment p
        JOIN tb_freelancers f ON p.FreelancerID = f.id
        WHERE p.Payment_Status = 'Verifying'
        ORDER BY p.date DESC";

$result = mysqli_query($con, $sql);

?>

<div class="wrapper">

    <?php include('./adminComponents/Admin-sideBar.php'); ?>
    <div class="main">
        <div class="header">
            <section class='burger' id="toggleSidebar" >
            <div></div>
            <div></div>
            <div></div> 
            </section>
            <section class="Title"><span>Dashboard</span></section>
        </div>  

        <div class="card-Data-Container">
            <div class="card">
                <section class='title'>Freelancers</section>
                <section class='data'><span><?php echo $freelancerCount; ?></span>
                    <i class="fa-solid fa-users"></i></section>
            </div>
            <div class="card">
                <section class='title'>Client Registered</section>
                <section class='data'><span><?php echo $clientCount; ?></span>
                    <i class="fa-solid fa-user"></i></section>
            </div>
            <div class="card">
                <section class='title'>Booking Through Website</section>
                <section class='data'><span><?php echo $appointmentCount; ?></span>
                    <i class="fa-solid fa-calendar-check"></i></section>
            </div>
        

       

            <div class="card">
                <section class='title'>Total Payment Recieved</section>
                <section class='data'><span><?php echo number_format($paymentTotal); ?></span>
                    <i class="fa-solid fa-money-bill"></i></section>
            </div>
        </div>

        <div class="Container">

            <div class="ListContainer">
                <div class="RecentPayments">
                    <div class="title"><section>Recent Payments</section><a href="./admin_Payments_Module.php"><button>View All</button></a></div>
                    
                    <table>
                        <tbody>
                            <tr>
                                <th>BookingID</th>
                                <th>Payment status</th>
                                <th>Client</th>
                                <th>Freelancer</th>
                                <th>Reference No.</th>
                                <th>Amount</th>
                                <th>action</th>
                            </tr>
                        <?php while ($row = mysqli_fetch_array($result)) { 
                            $freelancerName = htmlspecialchars($row['freelancer_fname'] . ' ' . $row['freelancer_mname'] . ' ' . $row['freelancer_lname']);
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['bookingID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Payment_Status']); ?></td>
                            <td><?php echo htmlspecialchars($row['Fname'] . ' ' . $row['Lname']); ?></td>
                            <td><?php echo $freelancerName; ?></td>
                            <td><?php echo htmlspecialchars($row['Payment_Reference']); ?></td>
                            <td><?php echo number_format($row['Payment_Amount']); ?></td>
                            <td>
                            <form id="paymentForm-<?php echo $row['bookingID']; ?>" action="../php/admin-Verify-payment.php" method='POST'>
                                <input type="hidden" name="bookingID" value="<?php echo $row['bookingID']; ?>">
                                <button type="button" class="openModal" data-action="confirm" data-id="<?php echo $row['bookingID']; ?>">Confirm</button>
                                <button type="button" class="openModal" data-action="partial" data-id="<?php echo $row['bookingID']; ?>">Partial</button>
                                <button type="button" class="openModal" data-action="invalid" data-id="<?php echo $row['bookingID']; ?>">Invalid</button>
                            </form>
                            </td>
                        </tr>
                        <?php } ?>

                   
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="DataContainer">
                <div class="newClients">
                    <div class="title">Freelancers Pending Application <a href="./admin_freelancer_module.php"><button style='height:30px; font-size:13px;'>View All</button></a> </div>
                    <?php
                            // Fetch freelancers with status 'Pending'
                        $sqlFetchPendingFreelancer = "SELECT id, fname, middle_name, last_name, status 
                                FROM tb_freelancers 
                                WHERE status = 'Pending'";

                        $resultF = mysqli_query($con, $sqlFetchPendingFreelancer);
                        ?>

                        <table>
                            <tbody>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>

                                <?php while ($row = mysqli_fetch_array($resultF)) { 
                                    $fullName = htmlspecialchars($row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo $fullName; ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                      
                </div>
            </div>
        </div>
    </div>

</div>

<div id="confirmationModal" class="modal" style='display:none;'>
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <p>Are you sure you want to proceed with this action?</p>
        <button id="confirmAction">Yes</button>
        <button id="cancelAction">No</button>
    </div>
</div>

    

</body>

<script>

function closeError() {
    document.getElementById('errorContainer').style.display = 'none';
}
function closeSuccess() {
    document.getElementById('successContainer').style.display = 'none';
}
setTimeout(closeError, 3000);
setTimeout(closeSuccess, 3000);
document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.querySelector('.wrapper').classList.toggle('collapse');
});
</script>

<script>
let currentAction; // Store the current action
let currentBookingID; // Store the current booking ID

document.querySelectorAll('.openModal').forEach(button => {
    button.addEventListener('click', function() {
        currentAction = this.getAttribute('data-action');
        currentBookingID = this.getAttribute('data-id');

        document.getElementById('confirmationModal').style.display = 'flex';
    });
});

document.getElementById('confirmAction').onclick = function() {
    const form = document.getElementById(`paymentForm-${currentBookingID}`);
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = currentAction; // Set the action based on the button clicked
    form.appendChild(actionInput);
    form.submit(); // Submit the form
};

document.getElementById('closeModal').onclick = function() {
    document.getElementById('confirmationModal').style.display = 'none';
};

document.getElementById('cancelAction').onclick = function() {
    document.getElementById('confirmationModal').style.display = 'none';
};

// Close modal if the user clicks outside of it
window.onclick = function(event) {
    const modal = document.getElementById('confirmationModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};
</script>
</html>