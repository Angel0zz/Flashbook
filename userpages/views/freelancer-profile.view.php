
<?php require('./views/partials/head.php')?>
<?php 
    $id = $_GET['id'];
    include('./script/fetchCalendar.php');
    $sql = "SELECT * FROM `tb_freelancers` WHERE id = $id LIMIT 1";
    $result  = mysqli_query($con,$sql);
    $rows  = mysqli_fetch_assoc($result);  

    $vid_album = "SELECT * FROM tb_videos WHERE freelancerID = '$id'";
    $vid_album_run = mysqli_query($con,  $vid_album);

    $album = "SELECT * FROM tb_images WHERE freelancerID = '$id' And Archived ='0'";
    $album_run = mysqli_query($con,  $album);

    $vid_album2 = "SELECT * FROM tb_videos WHERE freelancerID = '$id'";
    $vid_album_run2 = mysqli_query($con,  $vid_album);

    require('../php/client-submit-review.php')
?>
    <?php require('./views/partials/nav.php')?>


    <main>
        
        <div class="heading">
        <p>Select The Perfect Visual Storyteller with Us!</p>
        </div>

    <?php
        if (mysqli_num_rows($vid_album_run) > 0) {
            $videos = [];
            while ($video = mysqli_fetch_assoc($vid_album_run)) {
                $videos[] = $video;
            }
        
            $main_video = $videos[0]; 
            ?>
            <div class="carousel-cont">
                <video src="../uploads/<?=$main_video['video']?>" class="slider" autoplay controls muted></video>
                
        
                <div class="vidgrp">
                    <ul>
                        <?php
           
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
        } else {

            ?>
            <div class="carousel-cont">
            <span onclick="goBack()" style="position:absolute;top:10%; right:94%; color:white; cursor:pointer; background-color: rgba(255, 255, 255, 0.4);"> < go back </span>
        
                <p>No videos available in this album.</p>
            </div>
            <?php
        }
    ?>        
        
        <div class="details-wrapper">

            <section class="profile-details">
                <section class="details_intro">
                    <img src="../img/<?php echo $rows['profile']?>" alt="" class ="profile_headshot">
          
                    <div class="profile_name">
                        <h1 class="name"><?php echo $rows['fname'] ," ", $rows['middle_name']  ," ", $rows['last_name'] ?></h1>
                        <button onclick="OpenGallery()">gallery</button>
                        <button onclick="handleBookNowClick()">Book now</button>
                    </div>
                </section>
        
                <section class="details-bio">
                
                    <section>
                        <h5>location:</h5>
                        <p ><?php echo $rows['region'] ," ", $rows['province']  ," ", $rows['city'] ?></p>
                        <h5>contact</h5>
                        <p><?php echo $rows['ContactNum']," , ", $rows['Freelancer_email'] ?></p>
                        <h5>specialize</h5>
                        <p class="bio"><?php echo $rows['role'] ?></p>
                    </section>


                    <p class="bio"> <?php echo $rows['about'] ?> </p>
                    
                    <section>
                        Freelancer Reviews!
                    </section>
                    <div class="reviews">
                        <?php
                        $review_query = "
                            SELECT r.*, u.email 
                            FROM tb_reviews r 
                            INNER JOIN tb_clientusers u 
                            ON r.clientId = u.id 
                            WHERE r.freelancerID = '$id' 
                            ORDER BY r.created_at DESC";
                        
                        $review_result = mysqli_query($con, $review_query);
                        
                        $avg_rating_query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM tb_reviews WHERE freelancerID = '$id'";
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
                    </div><br>
                    <section><button onclick="toggleReviewSection()">Rate this Freelancer</button></section>
                        
                    
                    <?php
       
                        $booking_check_query = "SELECT * FROM tb_appointment WHERE FreelancerID = '$id' AND userID = '$UserId' AND status = 'Completed'";
                        $booking_check_result = mysqli_query($con, $booking_check_query);
                        
 
                        $review_check_query = "SELECT * FROM tb_reviews WHERE freelancerID = '$id' AND clientId = '$UserId'";
                        $review_check_result = mysqli_query($con, $review_check_query);

                        if (mysqli_num_rows($booking_check_result) > 0) {

                            if (mysqli_num_rows($review_check_result) == 0) {
                                ?>
                           <section onclick="toggleReviewSection()">
                                <div id="reviewSection" class="review-section-bg">
                                    <section class="reviews-section" onclick="event.stopPropagation();">
                                        <h4>Leave a Review</h4>
                                        <form id="reviewForm" method="POST" action="">
                                            <input type="hidden" name="freelancerID" value="<?php echo $id; ?>">
                                            <input type="hidden" name="clientId" value="<?php echo $UserId; ?>">
                                            
                                            <label for="rating">Rating</label>
                                            <section class="star-rating">
                                                <span class="star" data-value="1">&#9733;</span>
                                                <span class="star" data-value="2">&#9733;</span>
                                                <span class="star" data-value="3">&#9733;</span>
                                                <span class="star" data-value="4">&#9733;</span>
                                                <span class="star" data-value="5">&#9733;</span>
                                            </section>
                                            <input type="hidden" name="rating" id="rating" value="">
                                            
                                            <textarea name="review" id="review" rows="4" cols="4" required style="width: 290px; height: 95px;"></textarea>
                                            <button type="submit" name="submit_review">Submit Review</button>
                                        </form>
                                    </section>
                                </div>
                            </section>

              
                              
                                <?php
                            } else {
                                echo "<p class='bio'>You have already submitted a review for this freelancer.</p>";
                            }
                        } else {
                            echo "<p class='bio'>You must book this freelancer before leaving a review.</p>";
                        }
                    ?>

                </section>

            </section>
        
            <section class="avail-calendar">

            <div id="calendar" class="calendar">

            <?php
 
            generateCalendar($currentMonth, $currentYear, $currentDate, $bookedDates);
            ?>

            </div>
    

        </div>
       




<?php include('./views/partials/modals.php')?>

</main>
<?php include('./views/partials/booking-request-form.php')?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

    $(document).ready(function() {
    $('.view_data').click(function(e) {
    e.preventDefault();

    var album_id = $(this).closest('.album-card').find('.albumID').text();
    
    $.ajax({
    method:"POST",
    url:"regfunct.php",
    data:{
        'click_view_btn':true,
        'album_id':album_id,
    },
        success:function(response){
        //console.log(response);
            $('.Gallery').html(response);

            }
        });
    }); 
    });

    var currentSlide = 0;
    var totalSlides = 0;


    function openPopup(index, images) {
        currentSlide = index;
        totalSlides = images.length;

        var carouselContainer = document.querySelector(".carousel");
        carouselContainer.innerHTML = ''; 

 
        images.forEach(function(image, i) {
            var imgElement = document.createElement('img');
            imgElement.src = "../uploads/" + image;
            imgElement.classList.toggle("active", i === currentSlide);
            carouselContainer.appendChild(imgElement);
        });


        var prevArrow = document.createElement('a');
        prevArrow.classList.add('prev');
        prevArrow.innerHTML = "&#10094;";
        prevArrow.onclick = function() { changeSlide(-1, images); };
        carouselContainer.appendChild(prevArrow);

        var nextArrow = document.createElement('a');
        nextArrow.classList.add('next');
        nextArrow.innerHTML = "&#10095;";
        nextArrow.onclick = function() { changeSlide(1, images); };
        carouselContainer.appendChild(nextArrow);

        document.getElementById("imagePopup").style.display = "flex";
    }

    function closePopup() {
        document.getElementById("imagePopup").style.display = "none";
    }


    function showSlide(index, images) {
        var slides = document.querySelectorAll(".carousel img");
        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }
        slides.forEach(function(slide, i) {
            slide.classList.toggle("active", i === currentSlide);
        });
    }


    function changeSlide(direction, images) {
        showSlide(currentSlide + direction, images);
    }

</script>

<script>
    $(document).ready(function() {
        function setupNavigation() {
            $('.prev-month, .next-month').click(function(e) {
                e.preventDefault();
                var date = $(this).data('date');

                $.ajax({
                    url: '', 
                    type: 'GET',
                    data: { date: date },
                    success: function(response) {
                        $('.calendar').html(response);
                        setupNavigation(); 
                    },
                    error: function() {
                        alert('Error loading calendar. Please try again.');
                    }
                });
            });
        }

        setupNavigation(); 
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    let selectedRating = 0;

    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('hover');
            } else {
                star.classList.remove('hover');
            }
        });
    }

        stars.forEach(star => {
            star.addEventListener('mouseover', function () {
                const rating = this.getAttribute('data-value');
                highlightStars(rating);
            });
            star.addEventListener('mouseleave', function () {
                highlightStars(selectedRating);
            });

  
            star.addEventListener('click', function () {
                selectedRating = this.getAttribute('data-value');
                document.getElementById('rating').value = selectedRating;
                stars.forEach(s => s.classList.remove('selected'));
                highlightStars(selectedRating);
                stars.forEach((s, index) => {
                    if (index < selectedRating) {
                        s.classList.add('selected');
                    }
                });
            });
        });
    });


</script>

<script>

        const album = document.querySelector('.albums');
        const popup = document.querySelector('.popup-cont');
        const Gallery = document.querySelector('.gallery');
        const ImgAlbum = document.querySelector('.image-albums');
        const VidAlbum = document.querySelector('.video-album');
        function OpenGallery(){
            popup.classList.add('active');
            album.classList.add('active');
        }
        function OpenAlbum(){
            album.classList.remove("active");
            Gallery.classList.add("active");
        }
        function OpenImgAlbum(){
            ImgAlbum.classList.add('active');
            VidAlbum.classList.remove('active');
            document.getElementById("imgAlbum").style.fontWeight = "700";
            document.getElementById("vidAlbum").style.fontWeight = "normal";
            album.classList.add('active');
            Gallery.classList.remove('active');

          }

          function OpenVidAlbum(){
            ImgAlbum.classList.remove('active');
            VidAlbum.classList.add('active');
            document.getElementById("imgAlbum").style.fontWeight = "normal";
            document.getElementById("vidAlbum").style.fontWeight = "700";
            album.classList.add('active');
            Gallery.classList.remove('active');
          }
          popup.addEventListener('click', function(event) {

        if (event.target === popup) {
            Gallery.classList.remove('active');
            popup.classList.remove('active');
            album.classList.remove('active');
        }
            });


    const reviewSection = document.getElementById('reviewSection');

    function toggleReviewSection() {
      
        if (reviewSection.style.display === 'none' || reviewSection.style.display === '') {
            reviewSection.style.display = 'flex';  
        } else {
            reviewSection.style.display = 'none';  
        }
    }
    


</script>

<?php include('./views/partials/footer.php')?>

