<?php require('./adminComponents/Admin-head.php'); ?>
<?php
$photography_packages = "SELECT * FROM tb_offeredpackages Where type ='Photography'";
$photography_packages_run = mysqli_query($con,  $photography_packages);

$videography_packages = "SELECT * FROM tb_offeredpackages Where type ='Videography'";
$videography_packages_run = mysqli_query($con,  $videography_packages);

$bundle_packages = "SELECT * FROM tb_offeredpackages Where type ='Bundle'";
$bundle_packages_run = mysqli_query($con,  $bundle_packages);
?>

<div class="wrapper">
    <?php require('./adminComponents/Admin-sideBar.php'); ?>
    <div class="main">
        <div class="header">
            <section class='burger' id="toggleSidebar" >
            <div></div>
            <div></div>
            <div></div> 
            </section>
            <section class="Title"><span>Packages Management Module</span></section>
        </div>  

       <div class="packageContainer"> 
            <section class="header">
                <span style ='font-size:20px; color:#ffff ;'> Photography Packages</span> 
            </section>

            <?php if ($photography_packages_run && mysqli_num_rows($photography_packages_run) > 0): ?>
                <div class="cards" style='display:flex; flex-direction:row; justify-content:space-around;'>
                    <?php while ($row = mysqli_fetch_assoc($photography_packages_run)): ?>
                        <div class="card">
                            <div class="Cardheader" >
                                <span class="license"><?php echo htmlspecialchars($row['head']); ?></span>
                                <section style='display:flex; justify-content:center; color:black;'>  <h3>&#x20B1; <?php echo number_format($row['price'], 2); ?></h3> </section>
                            </div>
                         
                            <section style='display:flex; justify-content:center;'>
                                <button class="btn update-btn" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-head="<?php echo htmlspecialchars($row['head']); ?>" 
                                    data-price="<?php echo $row['price']; ?>" 
                                    data-feature="<?php echo htmlspecialchars($row['feature']); ?>">Update Package
                                </button>
                            </section>
                            <ul class="features">
                                <?php
                                $items = explode(',', $row["feature"]);
                                foreach ($items as $item) {
                                    echo "<li>&#10003; <a href='#'>" . htmlspecialchars(trim($item)) . "</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No packages available.</p>
            <?php endif; ?>
        </div>
        

        
        <div class="packageContainer">
            <section class="header">
                <span style ='font-size:20px; color:#ffff ;'> Videography Packages</span> 
            </section>
            
            <?php
                if ($videography_packages_run && mysqli_num_rows($videography_packages_run) > 0) { ?>
                <div class="cards" style='display:flex; flex-direction:row; justify-content:space-evenly;'>
                    <?php while ($row = mysqli_fetch_assoc($videography_packages_run)) {
                        ?>
                        <div class="card">
                            <div class="Cardheader" >
                                <span class="license"><?php echo htmlspecialchars($row['head']); ?></span>
                                <section style='display:flex; justify-content:center; color:black;'>  <h3>&#x20B1; <?php echo number_format($row['price'], 2); ?></h3> </section>
                            </div>
                         
                            <section style='display:flex; justify-content:center;'>
                                <button class="btn update-btn" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-head="<?php echo htmlspecialchars($row['head']); ?>" 
                                    data-price="<?php echo $row['price']; ?>" 
                                    data-feature="<?php echo htmlspecialchars($row['feature']); ?>">Update Package
                                </button>
                            </section>
                            <ul class="features">
                                <?php
                                $items = explode(',', $row["feature"]);
                                foreach ($items as $item) {
                                    echo "<li>&#10003; <a href='#'>" . htmlspecialchars(trim($item)) . "</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No packages available.</p>";
                }
            ?>
            </div>
        </div>
      
    <div class="packageContainer"> 
    <section class="header">
            <span style ='font-size:20px; color:#ffff ;'> Bundles </span> 
    </section>


            <?php
                if ($bundle_packages_run && mysqli_num_rows($bundle_packages_run) > 0) {?>
                 <div class="cards" style='display:flex; flex-direction:row; justify-content:space-around;'>
                 <?php
                    while ($row = mysqli_fetch_assoc($bundle_packages_run)) {
                        ?>
                                               <div class="card">
                            <div class="Cardheader" >
                                <span class="license"><?php echo htmlspecialchars($row['head']); ?></span>
                                <section style='display:flex; justify-content:center; color:black;'>  <h3>&#x20B1; <?php echo number_format($row['price'], 2); ?></h3> </section>
                            </div>
                         
                            <section style='display:flex; justify-content:center;'>
                                <button class="btn update-btn" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-head="<?php echo htmlspecialchars($row['head']); ?>" 
                                    data-price="<?php echo $row['price']; ?>" 
                                    data-feature="<?php echo htmlspecialchars($row['feature']); ?>">Update Package
                                </button>
                            </section>
                            <ul class="features">
                                <?php
                                $items = explode(',', $row["feature"]);
                                foreach ($items as $item) {
                                    echo "<li>&#10003; <a href='#'>" . htmlspecialchars(trim($item)) . "</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No bundles available.</p>";
                }
            ?>
                </div>
                
    </div>

    



        <!-- Modal for updating package -->

        <div id="updateModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Update Package</h2>
                <form id="updateForm" action="../php/admin_update_package.php" method="POST">
                    <input type="hidden" id="packageId" name="id">
                    <div>
                        <label for="head">Package Head</label>
                        <input type="text" id="packageHead" name="head" required>
                    </div>
                    <div>
                        <label for="price">Price</label>
                        <input type="number" id="packagePrice" name="price" required>
                    </div>
                    <div>
                        <label for="features">Features</label>
                        <textarea id="packageFeatures" name="features" required style='width: 360px; height: 101px;'></textarea>
                    </div>
                    <button type="submit">Update Package</button>
                </form>
            </div>
        </div>

    </div>
</div>









</body>
<script>
document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.querySelector('.wrapper').classList.toggle('collapse');
});
var modal = document.getElementById('updateModal');
var closeBtn = document.querySelector('.close');
var updateForm = document.getElementById('updateForm');

var updateButtons = document.querySelectorAll('.update-btn');
updateButtons.forEach(button => {
    button.addEventListener('click', function() {
        var packageId = this.getAttribute('data-id');
        var packageHead = this.getAttribute('data-head');
        var packagePrice = this.getAttribute('data-price');
        var packageFeatures = this.getAttribute('data-feature');

        document.getElementById('packageId').value = packageId;
        document.getElementById('packageHead').value = packageHead;
        document.getElementById('packagePrice').value = packagePrice;
        document.getElementById('packageFeatures').value = packageFeatures;
        modal.style.display = 'flex';
    });
});

closeBtn.addEventListener('click', function() {
    modal.style.display = 'none';
});

// Close the modal when clicking outside the modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};
function closeError() {
    document.getElementById('errorContainer').style.display = 'none';
}
function closeSuccess() {
    document.getElementById('successContainer').style.display = 'none';
}
setTimeout(closeError, 3000);
setTimeout(closeSuccess, 3000);
</script>



</html>
