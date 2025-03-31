<?php require('./views/partials/head.php')?>
    <?php require('./views/partials/nav.php');
    
    $vid_album = "SELECT * FROM tb_videos WHERE freelancerID = '$userId'";
    $vid_album_run = mysqli_query($con,  $vid_album);

    ?>
    <main>

    <?php
        // Check if there are videos
        if (mysqli_num_rows($vid_album_run) > 0) {
            // Fetch all videos into an array
            $videos = [];
            while ($video = mysqli_fetch_assoc($vid_album_run)) {
                $videos[] = $video;
            }

            // Display the main video (first video in the array)
            $main_video = $videos[0]; // First video for the main display
            ?>
            <div class="carousel-cont">
                <video src="../uploads/<?=$main_video['video']?>" class="slider" autoplay controls muted></video>
                <div class="vidgrp">
                    <ul>
                        <?php
                        // Loop through the videos to create the list items
                        foreach ($videos as $video) {
                            ?>
                            <li onclick="videoslider('../uploads/<?=$video['video']?>')">
                                <video src="../uploads/<?=$video['video']?>"></video>
                                <p><?= $video['name'] ?></p>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>
        
        <div class="details-wrapper">

            <section class="profile-details">
                <section class="details_intro">
                    <img src="../img/<?php echo $profile?>" alt="" class ="profile_headshot">
          
                    <div class="profile_name">
                        <h1 class="name"><?php echo $fullName ?></h1>
                         <button id="showFreelancerCard">profile Card</button>
                    </div>
                </section>
        
                <section class="details-bio">
                
                    <section>
                        <h5>location:</h5>
                        <p ><?php echo $location?></p>
                        <h5>specialize</h5>
                        <p class="bio"><?php echo $role ?></p>
                    </section>
                    <p class="bio"> <?php echo $about ?> </p>
        
                    <section>
                        Reviews
                    </section>
                    <div class="reviews">
                        <?php
                        $review_query = "
                            SELECT r.*, u.email 
                            FROM tb_reviews r 
                            INNER JOIN tb_clientusers u 
                            ON r.clientId = u.id 
                            WHERE r.freelancerID = '$userId' 
                            ORDER BY r.created_at DESC";
                        
                        $review_result = mysqli_query($con, $review_query);
                        
                        $avg_rating_query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM tb_reviews WHERE freelancerID = '$userId'";
                        $avg_rating_result = mysqli_query($con, $avg_rating_query);
                        $avg_rating_data = mysqli_fetch_assoc($avg_rating_result);

                        if ($avg_rating_data['total_reviews'] > 0) {
                            $avg_rating = round($avg_rating_data['avg_rating'], 1);
                            $total_reviews = $avg_rating_data['total_reviews'];
                            
                            echo "<p>Average Rating: ";
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= round($avg_rating) ? '★' : '☆'; 
                            }
                            echo " ($avg_rating/5) based on $total_reviews reviews.</p>";
                        } else {
                            echo "<p>No reviews yet.</p>";
                        }
                        
                        function hideEmail($email) {
                            $parts = explode("@", $email);
                            $masked = substr($parts[0], 0, 1) . '***@' . $parts[1]; 
                            return $masked;
                        }
                        
                        if (mysqli_num_rows($review_result) > 0) {
                            while ($review = mysqli_fetch_assoc($review_result)) {
                                ?>
                                <div class="review-item">
                                    <h4><?php echo hideEmail($review['email']); ?> </h4>
                                    <h5>(Rating:
                                         <span>
                                            <?php for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $review['rating'] ? '★' : '☆';
                                            } ?>
                                         </span>
                                    )</h5>
                                    <p><?php echo $review['review']; ?></p>
                                    <p><small><?php echo date("F j, Y", strtotime($review['created_at'])); ?></small></p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </section>
            </section>
        
        
        
        
            <!--Date-->
            <section class="avail-calendar">
                <div id="calendar" class="calendar">

                <?php
                // Generate the calendar
                generateCalendar($currentMonth, $currentYear, $currentDate, $bookedDates);
                ?>
                
                </div>
                    ``
                    <?php
                    // Fetch current date
                    $currentDate = date('Y-m-d');

                    // Build the SQL query to get upcoming events for the freelancer
                    $sql = "SELECT p.*, f.fname, f.middle_name, f.last_name, op.head, p.location, p.date, p.Event_time, p.event_type
                            FROM tb_appointment p
                            JOIN tb_freelancers f ON p.FreelancerID = f.id
                            JOIN tb_offeredpackages op ON p.PackageID = op.id
                            WHERE p.FreelancerID = '$userId' 
                            AND p.date >= '$currentDate' 
                            AND p.status = 'accepted'
                            ORDER BY p.date ASC";  // Order by the nearest date

                    $result = mysqli_query($con, $sql);
                    ?>

                    <section class="upcomingsContainer">
                        <div class="title">Upcoming Events</div>
                        <div class="upcomings">
                            <?php 
                            while ($row = mysqli_fetch_array($result)) {
                                // Concatenate the client's full name
                                $clientName = $row['Fname'].' '.$row['Mname'].' '.$row['Lname'] ;
                                $event = $row['event_type'];
                                $location = $row['location'];
                                $date = $row['date'];
                                $timeA = $row['Event_time'];
                            ?>
                            <div class="upcoming-item">
                                <section style='display:flex; justify-content:space-between;'>
                                    <span>Client Name: <?php echo htmlspecialchars($clientName); ?></span>
                                    <span>Event: <?php echo htmlspecialchars($event); ?></span>
                                </section>
                                <section class='details'>
                                    <span>Location: <?php echo htmlspecialchars($location); ?></span><br>
                                    <span>Event Date: <?php echo htmlspecialchars($date); ?></span><br>
                                    <span>Event Start: <?php echo htmlspecialchars($timeA); ?></span>
                                </section>
                            </div>
                            <?php } ?>
                        </div>
                    </section>``
                
            </section>
                        
        </div>
       



    
</section>
<?php require('./views/partials/profilecard.php')?>
</main>


<script>
 //====================freelancer profile script
 function videoslider(links){
            document.querySelector('.slider').src=links; 
 }
</script>
<script>
$(document).ready(function() {
    function setupNavigation() {
        $('.prev-month, .next-month').click(function(e) {
            e.preventDefault();
            var date = $(this).data('date');

            $.ajax({
                url: '', // Current page URL
                type: 'GET',
                data: { date: date },
                success: function(response) {
                    $('.calendar').html(response);
                    setupNavigation(); // Re-setup navigation after content load
                },
                error: function() {
                    alert('Error loading calendar. Please try again.');
                }
            });
        });
    }

    setupNavigation(); // Initial setup
});
</script>
<?php require('./views/partials/popups.php')?>
<?php require('./views/partials/footer.php')?>