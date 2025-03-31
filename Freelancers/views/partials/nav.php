<nav >
        <section >
        <a href="./myPortfolio.php"  style='display:flex;'><img src="../assets/logo2.png" alt=""> <span style ='Color:#fff; position:relative; left:100px;top:15px;'>|Freelancers</span> </a>
        </section>
        <div class="menu" >
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <div class="menu" style='position:relative;right:10%;top:35%;' >
        <i class="fa fa-bell notif" onclick="openNotif()" style="font-size:20px;color:white;">
            <span  class ="count"style="background-color: #f76565; border-radius:100%; padding-inline:3px;padding-block:1px;font-size:12px; position:relative; right:-20%; top:-35px;">
            </span></i>
        </div>

        <section class="links">
            <section class="nav-menu">
                <a href="./myPortfolio.php" >Portfolio Profile</a>
                <a href="./gallery.php">Gallery</a>
                <a href="./messagePage.php">Messages</a>
                <a href="./dashboard.php" >Appointment</a>
            </section>

            <i class="fa fa-bell notif" onclick="openNotif()" style="font-size:20px;color:white;">
            <span  class ="count"style="background-color: #f76565; border-radius:100%; padding-inline:5px; position:relative; right:30%; top:-10px;">
            </span></i>

            <button onclick="Logout()">logout</button>
        </section> 
        <div class="notification-box" >
            <section class="head">Notifications</section>
            <div class="notif-item-container"></div>
        </div>
</nav>

<?php
    if (isset($_GET['success'])) {
        $msg = $_GET['success'];
        echo "
   <div class='successContainer' id='successContainer'>
     <section>
            <img src='../assets/footer-logo.png' alt=''> <span style='font-weight: 700; color: #4A8CFF; '>Success!</span><button onclick='closeSuccess()' class='closeError'>&times;</button>
        </section>
        <p>$msg</p>

    </div>
    ";
      }else  if (isset($_GET['error'])) {
        $msg = $_GET['error'];
        echo "
        <div class='errorContainer' id='errorContainer' >
             <p>$msg</p>
            <button onclick='closeError()' class='closeError' >&times</button>
        </div>
        ";

    } 
?>
