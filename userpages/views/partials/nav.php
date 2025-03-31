<nav >
        <section>
            <a href="./"><img src="../assets/logo2.png" alt=""></a>
        </section>
        <div class="menu" >
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>

        </div>
        <div class="menu" style='position:relative;right:10%;top:35%;' >
        <i class="fa fa-bell notif" onclick="openNotif()" style="font-size:20px;color:white;">
            <span  class ="count"style="background-color: #f76565; border-radius:100%; padding-inline:3px;padding-block:1px;font-size:12px; position:relative; right:40%; top:-10px;">
            </span></i>
        </div>

        <section class="links">
            <section class="nav-menu">
                <a href="./" class="nav-link">Home</a>
                <a href="./index.php#About" class="nav-link">About Us</a>
                <a href="./bundles.php" class="nav-link">Pricing</a>
                <a href="./freelancers.php" class="nav-link">Freelancers</a>
                <a href="./messagesPage.php" class="nav-link">Chat</a>
                <a href="./appointments.php" class="nav-link">My Bookings</a>
                <a href="./profile.php" class="nav-link">My Profile</a>
            </section>

            <i class="fa fa-bell notif" onclick="openNotif()" style="font-size:20px;color:white;">
            <span  class ="count"style="background-color: #f76565; border-radius:100%; padding-inline:3px;padding-block:1px;font-size:12px; position:relative; right:30%; top:-10px;">
            </span></i>
            <button id="logoutBtn" onclick="Logout()">Logout</button>
        </section>
        

        <div class="notification-box" >
            <section class="head">Notifications</section>
            <div class="notif-item-container"></div>
        </div>
    </nav>
    <?php
if (isset($_SESSION['success'])) {
    $msg = $_SESSION['success'];
    echo "
    <div class='successContainer' id='successContainer'>
        <section>
            <img src='../assets/footer-logo.png' alt=''> <span style='font-weight: 700; color: #4A8CFF; '>Success!</span><button onclick='closeSuccess()' class='closeError'>&times;</button>
        </section>
    <p>$msg</p>

    </div>
    ";
    unset($_SESSION['success']); 
} elseif (isset($_GET['success'])) {
    $msg = $_GET['success'];
    echo "
    <div class='successContainer' id='successContainer'>
     <section>
            <img src='../assets/footer-logo.png' alt=''> <span style='font-weight: 700; color: #4A8CFF; '>Success!</span><button onclick='closeSuccess()' class='closeError'>&times;</button>
        </section>
        <p>$msg</p>

    </div>
    ";
} elseif (isset($_GET['error'])) {
    $msg = $_GET['error'];
    echo "
    <div class='errorContainer' id='errorContainer'>
      <section>
            <img src='../assets/footer-logo.png' alt=''> <span style='font-weight: 700; color: #4A8CFF; '>Success!</span><button onclick='closeSuccess()' class='closeError'>&times;</button>
        </section>
        <p>$msg</p>
    </div>
    ";
}
?>



    </div>