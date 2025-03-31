
<?php require('./adminComponents/Admin-head.php'); ?>
<div class="wrapper">
    <?php require('./adminComponents/Admin-sideBar.php'); ?>

    <?php
    $freelancer = null;

    if (isset($_GET['freelancer_id'])) {
        $freelancer_id = $_GET['freelancer_id'];
    
        // Fetch freelancer details (name and email)
        $sql = "SELECT * FROM tb_freelancers WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $freelancer_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $freelancer = $result->fetch_assoc();
        }
    
        $stmt->close();
    }
    ?>
    <div class="main">
        <div class="header">
            <section class='burger' id="toggleSidebar" >
            <div></div>
            <div></div>
            <div></div> 
            </section>
            <section class="Title"><span>Freelancer</span></section>
        </div>  


        <div class="Container">
            
            <div class="ApplicationFormContainer">
                <div class="applicationHeading">
                <img src="../assets/logo2.png" alt="">
                </div>
                <div class="heroContainer">
                    <?php if (!empty($freelancer['profile'])): ?>
                    <img src="../img/<?php echo htmlspecialchars($freelancer['profile']); ?>" alt="Freelancer Profile Picture">
                    <?php else: ?>
                        <p><strong>Profile Picture:</strong> No profile picture available.</p>
                    <?php endif; ?>
                    <?php if (!empty($freelancer['image'])): ?>
                    <img src="../img/<?php echo htmlspecialchars($freelancer['image']); ?>" alt="Freelancer Profile Picture">
                    <?php else: ?>
                        <p><strong>Profile Picture:</strong> No profile picture available.</p>
                    <?php endif; ?>
            
                </div>
                <div class="detailsCont">
                <p><strong>Name: </strong> <?php echo htmlspecialchars($freelancer['fname'] . ' ' .$freelancer['middle_name'] . ' '.$freelancer['last_name']); ?></p>
                <p> <strong>Location Address:</strong> <?php echo htmlspecialchars($freelancer['region'] . ' ' .$freelancer['province'] . ' '.$freelancer['city']); ?> </p>
                <p> <strong>Email: </strong> <?php echo htmlspecialchars($freelancer['Freelancer_email']); ?></p>
                <p> <strong>Contact Number:</strong> <?php echo htmlspecialchars($freelancer['ContactNum']); ?></p>
                <p> <strong>Portfolio: </strong><?php echo htmlspecialchars($freelancer['link']); ?></p>
                <p> <strong>About me: </strong><?php echo htmlspecialchars($freelancer['about']); ?></p>
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