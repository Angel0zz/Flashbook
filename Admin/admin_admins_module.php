<?php require('./adminComponents/Admin-head.php'); ?>
<?php
$sql = "SELECT * FROM tb_admin WHERE role = 'Admin' ORDER BY Status ASC";

$result = mysqli_query($con, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>
<div class="wrapper">
    <?php require('./adminComponents/Admin-sideBar.php'); ?>
    <div class="main">
        <div class="header">
            <section class='burger' id="toggleSidebar">
                <div></div>
                <div></div>
                <div></div>
            </section>
            <section class="Title"><span>Admin Management Module</span></section>
        </div>  
        
        <section class="addAdminContainer">
            Add Admin
            <form action="../php/add-admin.php" method='POST'>
                new admin email
                <input type="text" name='Addemail' required>
                <label for="">new admin Password</label>
                <input type="password" name='Addpassword' required>
                <label for="">Your PassKey</label>
                <input type="password" name='passKey' required>
                <button>Add</button>
            </form>
        </section>

        <!-- Button to Open Announcement Modal -->


        <!-- Announcement Creation Modal -->
        <div id="announcementModal" class="modal" style="display:none; ">
            <div class="modal-content" >
                <span class="close" id="modalCloseAnnouncement">&times;</span>
                <form action="../php/admin-announcement.php" method='POST' style="display:flex; flex-direction:column;">
                    <h3>Create An announcement</h3>
                    <label for="announcementTitle">Title</label>
                    <input type="text" name='announcementTitle' required>
                    <label for="announcementContent">Paragraph 1</label>
                    <textarea name="announcementContentLine1" required style="height: 38px; width: 350px;"></textarea>

                    <label for="announcementContent">Paragraph 2</label>
                    <textarea name="announcementContentLine2" required style="height: 38px; width: 350px;"></textarea>

                    <label for="announcementContent">Paragraph3<ntent</label>
                    <textarea name="announcementContent" required style="height: 138px; width: 350px;"></textarea><br>
                    
                    <button type="submit">Create Announcement</button>
                </form>
            </div>
        </div>

        <div class="Container">
            <div class="ListContainer">
                <div class="RecentPayments">
                    <div class="title"><section>Admin</section></div>
                    
                    <table>
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['adminID']); ?></td>
                                <td><?php echo htmlspecialchars($row['adminEmail']); ?></td>
                                <td><?php echo htmlspecialchars($row['adminPassword']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td><?php echo htmlspecialchars($row['Status']) == '0' ? 'Active' : 'Disabled'; ?></td>

                                <td>
                                    <form class="actionForm">
                                        <input type='hidden' name='admin_id' value='<?php echo htmlspecialchars($row['adminID']); ?>'>
                                        <?php
                                            if($row['Status'] =='0'){
                                                echo "<button type='button' name='action' value='disable' onclick='showConfirmation(\"disable\", \"" . htmlspecialchars($row['adminID']) . "\")'>disable</button>";
                                            } else{
                                                echo "<button type='button' name='action' value='enable' onclick='showConfirmation(\"enable\", \"" . htmlspecialchars($row['adminID']) . "\")'>enable</button>";
                                            }
                                        ?>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>  
                        </tbody>
                    </table>
                </div> <br>
                <button id="openAnnouncementModal">Create Announcement</button>
            </div>

            <div class="DataContainer">
                <div class="newClients">
                    <div class="title">Freelancers Pending Application  
                        <a href="./admin_freelancer_module.php"><button>View All</button></a>
                    </div>
                    <table>
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" id="modalClose">&times;</span>
        <p id="modalMessage">Are you sure you want to proceed?</p>
        <button id="confirmButton">Yes</button>
        <button id="cancelButton">No</button>
    </div>
</div>

<script>
let currentForm;

function showConfirmation(action, adminID) {
    currentForm = { action, adminID };
    document.getElementById('modalMessage').innerText = `Are you sure you want to ${action} this admin?`;
    document.getElementById('confirmationModal').style.display = 'block';
}

// Open Announcement Modal
document.getElementById('openAnnouncementModal').addEventListener('click', function() {
    document.getElementById('announcementModal').style.display = 'flex';
});

// Close Announcement Modal
document.getElementById('modalCloseAnnouncement').addEventListener('click', function() {
    document.getElementById('announcementModal').style.display = 'none';
});

// Confirm Button for Admin Actions
document.getElementById('confirmButton').addEventListener('click', function() {
    if (currentForm) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../php/admin-disable.php';

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = currentForm.action;

        const adminIdInput = document.createElement('input');
        adminIdInput.type = 'hidden';
        adminIdInput.name = 'admin_id';
        adminIdInput.value = currentForm.adminID;

        form.appendChild(actionInput);
        form.appendChild(adminIdInput);
        document.body.appendChild(form);
        form.submit();
    }
});

// Cancel and Close Confirmation Modal
document.getElementById('cancelButton').addEventListener('click', function() {
    document.getElementById('confirmationModal').style.display = 'none';
});

// Close Confirmation Modal
document.getElementById('modalClose').addEventListener('click', function() {
    document.getElementById('confirmationModal').style.display = 'none';
});

// Toggle Sidebar
document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.querySelector('.wrapper').classList.toggle('collapse');
});

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

<style>
.modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width:400px;
    height:auto;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

</body>
</html>
