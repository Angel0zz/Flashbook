
<?php require('./adminComponents/Admin-head.php'); ?>
<div class="wrapper">
    <?php require('./adminComponents/Admin-sideBar.php'); ?>
    <div class="main">
        <div class="header">
            <section class='burger' id="toggleSidebar" >
            <div></div>
            <div></div>
            <div></div> 
            </section>
            <section class="Title"><span>Freelancers Module</span></section>
        </div>  


        <div class="Container">

            <div class="ListContainer">
            <div class="RecentPayments">
    <div class="title"><section>Freelancers</section></div>
    
    <!-- Search Form -->
    <form method="GET" action="" style="display: flex; justify-content: right; margin-bottom: 10px;">
        <input type="text" name="search" placeholder="Search by name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Search</button>
    </form>
    
    <table>
        <tbody>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th style ='font-size:13px;'>Contact Num / Gcash Number</th>
                <th>Area</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            // Fetch freelancers with status 'Approved'
            $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
            $sql = "SELECT *
                    FROM tb_freelancers 
                    WHERE (Status = 'Active' OR Status = 'Disabled') 
                    AND (fname LIKE '%$searchTerm%' OR middle_name LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%')
                    ORDER BY 
                        CASE 
                            WHEN status = 'Active' THEN 1
                            WHEN status = 'Disabled' THEN 3
                            ELSE 2 
                        END";

            $result = mysqli_query($con, $sql);
            ?>
                                        
            <?php while ($row = mysqli_fetch_array($result)) { 
                $fullName = htmlspecialchars($row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo $fullName; ?></td>
                <td><?php echo htmlspecialchars($row['Freelancer_email']); ?></td>
                <td><?php echo htmlspecialchars($row['ContactNum']); ?></td>
                <td><?php echo htmlspecialchars($row['region']); ?></td>
                <td>
                   <?php echo htmlspecialchars($row['Status']); ?>
                </td>
                <td>
                    <form method="POST" action="../php/admin-dissable-freelancer.php"> 
                        <input type="hidden" name="freelancer_id" value="<?php echo $row['id']; ?>">
                        <?php if ($row['Status'] === 'Disabled') { ?>
                            <button type="submit" name='submit' value='enable'>Enable</button>
                        <?php } elseif ($row['Status'] === 'Active') { ?>
                            <button type="submit" name='submit' value='disable'>Disable</button>
                        <?php } ?>                                 
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


                <div class="RecentPayments">
                    <div class="title"><section>Pending Applications</section></div>
                    
                    <table>
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Num</th>
                                <th>Location</th>
                                <th>Sample Portfolio</th>
                                <th>action</th>
                            </tr>
                            <?php
                            // Fetch freelancers with status 'Approved'
                            $sql = "SELECT *
                                    FROM tb_freelancers
                                    WHERE status = 'Pending'";

                            $result = mysqli_query($con, $sql);
                            ?>
                                            
                            <?php while ($row = mysqli_fetch_array($result)) { 
                                $fullName = htmlspecialchars($row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                            ?>
                          <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo $fullName; ?></td>
                                <td><?php echo htmlspecialchars($row['Freelancer_email']); ?></td>
                                <td><?php echo htmlspecialchars($row['ContactNum']); ?></td>
                                <td><?php echo htmlspecialchars($row['region']); ?></td>
                                <td>
                                    <a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank">View Portfolio</a>
                                </td>
                                <td>
                                <form method="POST" action="../php/admin-freelancer-approval.php">
                                    <input type="hidden" name="freelancer_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action"  value='viewDetails' onclick="openDetailsTab()">View</button>
                                    <button type="submit" name="action" value="approve">Approve</button>
                                    <button type="submit" name="action" value="decline" >Decline</button>
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
        <div class="title">Disabled Freelancers </div>
        <?php
        // Fetch appointments with status 'Pending' and join with freelancers to get their names
                $sql = "SELECT *
                FROM tb_freelancers
                WHERE status = 'Disabled'";

        $result = mysqli_query($con, $sql);
        ?>

        <table>
            <tbody>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>Role</th>
    
                    <th>Status</th>
                </tr>
                <?php  while ($row = mysqli_fetch_array($result))  { 
                $fullName = htmlspecialchars($row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo $fullName; ?></td>
                    <td><?php echo htmlspecialchars($row['Freelancer_email']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td><?php echo htmlspecialchars($row['Status']); ?></td>
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