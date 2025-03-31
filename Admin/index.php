
<?php
include("../php/connection.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo2.png" type="image/png">
    <link rel="stylesheet" href="./adminCss/style.css">
    <title>Flashbook|Admin</title>
</head>
<body>
    <nav>
        <section>
            <a href="#nav"><img src="../assets/logo2.png" alt=""></a>
        </section>

    </nav>


<main>

    <div class="frm-container">
        <section class="logo"><img src="../assets/footer-logo.png" alt=""></section>
        <form action="../php/adminLogin.php" method="POST">
                <h2>Admin</h2>  
                <div class="input-box">
                    <input type="email" name="email" id="email" autocomplete ="off" placeholder="Email" required>
                </div>

                <div class="input-box">
                    <input type="password" name="password" id="password" autocomplete ="off" placeholder="password" required>
                </div>

                <div class="field ">
                      <button> Login</button>
                </div>
   
        </form>
    </div>          
    
</main>


    
    <footer>
        <div>
            <img src="../assets/logo2.png" alt="">

        </div>
        <p>2024 © All rights reserved,FlashBook</p>

</footer>

</body>
</html>