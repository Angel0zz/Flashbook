
<?php require('./adminComponents/Admin-head.php'); ?>
<?php
// Fetch the total number of clients
$clientResult = $con->query("SELECT COUNT(*) as total FROM tb_clientusers");
$clientCount = $clientResult->fetch_assoc()['total'];

// Fetch the total number of appointments
$appointmentResult = $con->query("SELECT COUNT(*) as total FROM tb_appointment");
$appointmentCount = $appointmentResult->fetch_assoc()['total'];

$paymentResult = $con->query("SELECT SUM(Payment_Amount) as total FROM tb_appointment WHERE Payment_Status IN ('Confirmed', 'PartiallyPaid')");
$paymentTotal = $paymentResult->fetch_assoc()['total'];

if ($paymentTotal === null) {
    $paymentTotal = 0;
}
//fetch payment status are verifying
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
            <section class="Title"><span>Payments</span></section>
        </div>  

        <div class="card-Data-Container">

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
                    <div class="title"><section>Recent Payments</section></div>
                    
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
                                <form action="../php/admin-Verify-payment.php" method ='POST'>
                                <input type="hidden" name="bookingID" value="<?php echo $row['bookingID']; ?>">
                                <button type="submit" name="action" value="confirm">Confirm</button>
                                <button type="submit" name ='action' value='partial'>Partial</button>
                                <button type="submit" name='action' value='invalid'>Invalid</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>

                   
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="DataContainer">
                <div class="appointments">
                    <div class="title">Payment Records</div>

                    <!-- Search Form -->
                    <form method="GET" action="" style="display: flex; justify-content: right; margin-bottom: 10px;">
                        <input type="text" name="search_reference" placeholder="Search by Payment Reference" value="<?php echo isset($_GET['search_reference']) ? htmlspecialchars($_GET['search_reference']) : ''; ?>" style="margin-right: 10px; padding: 5px;"/>
                        <button type="submit" style="padding: 5px 10px;">Search</button>
                    </form>

                    <?php
                    // Capture search input
                    $search_reference = isset($_GET['search_reference']) ? mysqli_real_escape_string($con, $_GET['search_reference']) : '';

                    // Modify SQL query to include a WHERE clause if searching for Payment_Reference
                    $sqlFetchPendingAppointments = "
                    SELECT a.*, f.fname, f.middle_name, f.last_name 
                    FROM tb_appointment a 
                    INNER JOIN tb_freelancers f ON a.FreelancerID = f.id
                    ";

                    // Add condition to search by Payment_Reference if the search input is not empty
                    if (!empty($search_reference)) {
                        $sqlFetchPendingAppointments .= " WHERE a.Payment_Reference LIKE '%$search_reference%' ";
                    }

                    // Add ordering logic
                    $sqlFetchPendingAppointments .= "
                    ORDER BY 
                        CASE 
                            WHEN a.payment_status = 'Confirmed' THEN 1
                            WHEN a.payment_status = 'PartiallyPaid' THEN 2
                            WHEN a.payment_status = 'Unpaid' THEN 3
                            ELSE 4
                        END
                    ";

                    $resultA = mysqli_query($con, $sqlFetchPendingAppointments);
                    ?>

                    <table style="font-size:12px;">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Freelancer</th>
                                <th>Ref. number</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>

                            <?php while ($row = mysqli_fetch_array($resultA)) { 

                                $clientName = htmlspecialchars($row['Fname'] . ' ' . $row['Lname']);
                                $freelancerFullName = htmlspecialchars($row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo $clientName; ?></td>
                                <td><?php echo $freelancerFullName; ?></td> <!-- Displaying the freelancer's full name -->
                                <td><?php echo htmlspecialchars($row['Payment_Reference']); ?></td>
                                <td><?php echo htmlspecialchars($row['Payment_Amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['Payment_Status']); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
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
</html>