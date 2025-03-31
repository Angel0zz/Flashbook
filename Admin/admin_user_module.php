<?php require('./adminComponents/Admin-head.php'); ?>
<div class="wrapper">
    <?php require('./adminComponents/Admin-sideBar.php'); ?>
    <div class="main">
        <div class="header">
            <section class='burger' id="toggleSidebar">
                <div></div>
                <div></div>
                <div></div> 
            </section>
            <section class="Title"><span>Client Module</span></section>
        </div>  

        <div class="Container">
            <div class="ListContainer">
                <div class="RecentPayments">
                    <div class="title"><section>Client Users</section></div>

                    <!-- Search Form -->
                    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                        <form method="GET" action="" style="display: flex; align-items: center;">
                            <input type="text" name="search" placeholder="Search by email, first name, or last name" 
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                                style="padding: 5px; font-size: 14px;" />
                            <button type="submit" style="font-size: 12px; padding: 5px 10px; margin-left: 10px;">Search</button>
                        </form>
                    </div>

                    <table>
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Contact Number</th>
                                <th>Bookings Count</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

                            $sql = "
                            SELECT u.*, COUNT(a.userID) AS appointment_count
                            FROM tb_clientusers u
                            LEFT JOIN tb_appointment a ON u.id = a.userID";

                            if (!empty($search)) {
                                $sql .= " WHERE u.email LIKE '%$search%' OR u.first_name LIKE '%$search%' OR u.last_name LIKE '%$search%'";
                            }

                            $sql .= " GROUP BY u.id";

                            $result = mysqli_query($con, $sql);
                            ?>
                                                
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Client_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['appointment_count']); ?></td>
                                <td>
                                    <button class="btn update-btn" 
                                        data-id="<?php echo $row['id']; ?>"
                                        data-email="<?php echo htmlspecialchars($row['email']); ?>" 
                                        data-first_name="<?php echo htmlspecialchars($row['first_name']); ?>" 
                                        data-last_name="<?php echo htmlspecialchars($row['last_name']); ?>" 
                                        data-contact_number="<?php echo htmlspecialchars($row['Client_number']); ?>">Edit
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>

        </div>

        <!-- Modal for editing freelancer details -->
        <div id="editModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Client Details</h2>

                <form id="editForm" action="../php/admin_edit_clientDetails.php" method="POST" onsubmit="return validatePasswords() && validateContactNumber()">
                    <input type="hidden" id="userId" name="id">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="userEmail" name="Newemail" required>
                    </div>
                    
                    <div>
                        <label for="first_name">First Name</label>
                        <input type="text" id="userFirstname" name="Newfirst_name" required>
                    </div>
                    
                    <div>
                        <label for="last_name">Last Name</label>
                        <input type="text" id="userLastname" name="Newlast_name" required>
                    </div>
                    
                    <div>
                        <label for="contact_number">Contact Number</label>
                        <input type="number" id="userContactNumber" name="Newcontact_number"   maxlength="13">
                    </div>
                    <div id="contactError" style="color: red; display: none;">Please enter a valid contact number.</div>
                    <div>
                        <label for="newPassword">Password</label>
                        <input type="password" id="newPassword" name="newPassword" >
                    </div>
                    
                    <div>
                        <label for="ConfirmnewPassword">Confirm New Password</label>
                        <input type="password" id="ConfirmnewPassword" name="ConfirmnewPassword" >
                    </div>
                    <div id="passwordError" style="color: red; display: none;">Passwords do not match.</div>
                    <div>
                        <label for="adminKey">Admin Key</label>
                        <input type="password" name="adminKey" required>
                    </div>

                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>

    </div>
</div>

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

// Modal functionality
var modal = document.getElementById('editModal');
var closeBtn = document.querySelector('.close');

var updateButtons = document.querySelectorAll('.update-btn');
updateButtons.forEach(button => {
    button.addEventListener('click', function() {
        var userId = this.getAttribute('data-id');
        var userEmail = this.getAttribute('data-email');
        var userFirstname = this.getAttribute('data-first_name');
        var userLastname = this.getAttribute('data-last_name');
        var userContactNumber = this.getAttribute('data-contact_number');

        document.getElementById('userId').value = userId;
        document.getElementById('userEmail').value = userEmail;
        document.getElementById('userFirstname').value = userFirstname;
        document.getElementById('userLastname').value = userLastname;
        document.getElementById('userContactNumber').value = userContactNumber;

        modal.style.display = 'flex';
    });
});

closeBtn.addEventListener('click', function() {
    modal.style.display = 'none';
});

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

</script>
<script>
function validatePasswords() {
    const password = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('ConfirmnewPassword').value;
    const errorMessage = document.getElementById('passwordError');

    if (password !== confirmPassword) {
        errorMessage.style.display = 'block'; 
        return false; 
    } else {
        errorMessage.style.display = 'none'; 
    }
    return true;
}

function validateContactNumber() {
    const contactNumber = document.getElementById('userContactNumber').value;
    const contactError = document.getElementById('contactError');


    const regex = /^\+\d{12}$/;

    if (!regex.test(contactNumber)) {
        contactError.style.display = 'block'; 
        return false;
    } else {
        contactError.style.display = 'none'; 
    }
    return true; 
}
</script>

</body>
</html>
