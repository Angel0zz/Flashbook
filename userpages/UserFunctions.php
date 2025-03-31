<?php
$id = $_SESSION['id'];

$queryQ = mysqli_query($con,"SELECT * FROM tb_clientusers Where id = $id");

while($result = mysqli_fetch_assoc($queryQ)){
$email = $result['email'];
$UserFname = $result['first_name'];
$UserMname = $result['middle_name'];
$UserLname = $result['last_name'];
$UserContact =$result['Client_number'];
$UserPassword =$result['password'];
$UserProfilepic =$result['picture'];
$CId =$result['UchatId'];
$UserId = $result['id'];
}

$dash_photographers_query = "SELECT * From tb_freelancers";
$dash_photographers_query_run = mysqli_query($con, $dash_photographers_query );

//packages==========================================================
$photography_packages = "SELECT * FROM tb_offeredpackages Where type ='Photography'";
$photography_packages_run = mysqli_query($con,  $photography_packages);

$videography_packages = "SELECT * FROM tb_offeredpackages Where type ='Videography'";
$videography_packages_run = mysqli_query($con,  $videography_packages);

$bundle_packages = "SELECT * FROM tb_offeredpackages Where type ='Bundle'";
$bundle_packages_run = mysqli_query($con,  $bundle_packages);
//end of packages================================================================


//display freelancer gallery
function displayPortfolioGallery($con, $id) {
    $sql = "SELECT Pf FROM tb_freelancers WHERE id = '$id'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $filesArray = json_decode(mysqli_fetch_assoc($result)['Pf'], true);

        if (!empty($filesArray)) {
            echo "<div class='portfolio-gallery'>";
            foreach ($filesArray as $file) {
                $imagePaths = "../img/$file";
                echo file_exists($imagePaths) ?
                    "<img src='$imagePaths' alt='User Image' class='portfolio-image'>" :
                    "<p>Image not found: " . htmlspecialchars($file) . "</p>";
            }
            echo "</div>";
        } else {
            echo "No files uploaded yet.";
        }
    } else {
        echo "User not found in database.";
    }
}


//display freelancer slides
function displayUserSlides($con, $id) {
    $result = mysqli_query($con, "SELECT Pf FROM tb_freelancers WHERE id = '$id'");

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $filesArray = json_decode($row['Pf'], true);

        if (!empty($filesArray)) {
            foreach (array_slice($filesArray, 0, 6) as $file) {
                $imagePaths = "../img/$file";
                echo file_exists($imagePaths) ?
                    "<div class='slides' style='--img:url(\"$imagePaths\")'></div>" :
                    "<div class='slides'>Image not found: " . htmlspecialchars($file) . "</div>";
            }
        } else {
            echo "<div class='slides'>No files uploaded yet.</div>";
        }
    } else {
        echo "<div class='slides'>User not found in database.</div>";
    }
}


//bundles function ===================================================================================
function generatePhotographyPackages($photography_packages_run) {
    if ($photography_packages_run && mysqli_num_rows($photography_packages_run) > 0) {
        while ($row = mysqli_fetch_assoc($photography_packages_run)) {
            ?>
            <div class="card">
                <div class="header">
                    <span class="license"><?php echo htmlspecialchars($row['head']); ?></span>
                    <h2>&#x20B1; <?php echo number_format($row['price'], 2); ?></h2>
                    <a href="javascript:void(0);" class="btn" 
                       onclick="handleBookNowClick(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['head']); ?>', <?php echo $row['price']; ?>)">
                        REQUEST NOW
                    </a>
                </div>
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
}



function generateVideographyPackages($videography_packages_run) {
    if ($videography_packages_run && mysqli_num_rows($videography_packages_run) > 0) {
        while ($row = mysqli_fetch_assoc($videography_packages_run)) {
            ?>
            <div class="card">
                <div class="header">
                    <span class="license"><?php echo htmlspecialchars($row['head']); ?></span>
                    <h2>&#x20B1; <?php echo number_format($row['price'], 2); ?></h2>
                    <a href="javascript:void(0);" class="btn" 
                       onclick="handleBookNowClick(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['head']); ?>', <?php echo $row['price']; ?>)">
                        REQUEST NOW
                    </a>
                </div>
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
}



function generateBundlePackages($bundle_packages_run) {
    if ($bundle_packages_run && mysqli_num_rows($bundle_packages_run) > 0) {
        while ($row = mysqli_fetch_assoc($bundle_packages_run)) {
            ?>
            <div class="card">
                <div class="header">
                    <span class="license"><?php echo htmlspecialchars($row['head']); ?></span>
                    <h2>&#x20B1; <?php echo number_format($row['price'], 2); ?></h2>
                    <a href="javascript:void(0);" class="btn" 
                       onclick="handleBookNowClick(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['head']); ?>', <?php echo $row['price']; ?>)">
                        REQUEST NOW
                    </a>
                </div>
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
}

// End of bundles function ===================================================================================


function endSessionAndRedirect($redirectUrl) {
    // Start the session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();

    // Redirect to the specified URL
    header("Location: $redirectUrl");
    exit();
}
if (isset($_POST['logout'])) {
    endSessionAndRedirect('../index.php');
}




?>

