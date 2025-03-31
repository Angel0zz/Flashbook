<?php include('./views/partials/head.php')?>
    <?php include('./views/partials/nav.php')?>
<?php

?>

<main>
        <div class="FContainer">
            <section class="txtCont">
                <p ><span >Book your Photographer with ease,</span>  <span style ="color:#99CCFF; font-size:200%;">Cherish Moments Forever.</span></p>
                <p>Flashbook makes it easier than ever to book your photographer or Videographer, capture The Important Moments of your life. choose and book your prefered Photographers/ videographers with us! </p>
                <button onclick="handleBookNowClick()">Book Now</button>
           
              </section>
            <section class="imgCont">

                <div class="wrapper">
                    <div class="itemLeft item1"><img src="../design-assets/kosuni1.png" alt=""></div>
                    <div class="itemLeft item2"><img src="../design-assets/kosuni2.jpg" alt=""></div>
                    <div class="itemLeft item3"><img src="../design-assets/kosuni4.jpg" alt=""></div>
                    <div class="itemLeft item4"><img src="../design-assets/kosuni3.JPG" alt=""></div>
                    <div class="itemLeft item5"><img src="../design-assets/kosuni5.jpg" alt=""></div>
                    <div class="itemLeft item6"><img src="../design-assets/kosuni6.jpg" alt=""></div>
                    <div class="itemLeft item7"><img src="../design-assets/ObraNiJuanImg25.png" alt=""></div>
                    <div class="itemLeft item8"><img src="../design-assets/ObraNiJuanImg27.png" alt=""></div>
                </div>
                  <div class="wrapper">
                    <div class="itemRight item1"><img src="../design-assets/ObraNiJuanImg17.png" alt=""></div>
                    <div class="itemRight item2"><img src="../design-assets/ObraNiJuanImg18.png" alt=""></div>
                    <div class="itemRight item3"><img src="../design-assets/ObraNiJuanImg19.png" alt=""></div>
                    <div class="itemRight item4"><img src="../design-assets/ObraNiJuanImg20.png" alt=""></div>
                    <div class="itemRight item5"><img src="../design-assets/ObraNiJuanImg21.png" alt=""></div>
                    <div class="itemRight item6"><img src="../design-assets/ObraNiJuanImg22.png" alt=""></div>
                    <div class="itemRight item7"><img src="../design-assets/ObraNiJuanImg5.png" alt=""></div>
                    <div class="itemRight item8"><img src="../design-assets/ObraNiJuanImg7.png" alt=""></div>
                  </div>
                  <div class="wrapper">
                    <div class="itemLeft item1"><img src="../design-assets/ObraNiJuanImg1.png" alt=""></div>
                    <div class="itemLeft item2"><img src="../design-assets/ObraNiJuanImg3.png" alt=""></div>
                    <div class="itemLeft item3"><img src="../design-assets/ObraNiJuanImg4.png" alt=""></div>
                    <div class="itemLeft item4"><img src="../design-assets/ObraNiJuanImg2.png" alt=""></div>
                    <div class="itemLeft item5"><img src="../design-assets/ObraNiJuanImg5.png" alt=""></div>
                    <div class="itemLeft item6"><img src="../design-assets/ObraNiJuanImg6.png" alt=""></div>
                    <div class="itemLeft item7"><img src="../design-assets/ObraNiJuanImg7.png" alt=""></div>
                    <div class="itemLeft item8"><img src="../design-assets/ObraNiJuanImg8.png" alt=""></div>
                  </div>
                  <div class="wrapper">
                    <div class="itemRight item1"><img src="../design-assets/ObraNiJuanImg17.png" alt=""></div>
                    <div class="itemRight item2"><img src="../design-assets/ObraNiJuanImg18.png" alt=""></div>
                    <div class="itemRight item3"><img src="../design-assets/ObraNiJuanImg19.png" alt=""></div>
                    <div class="itemRight item4"><img src="../design-assets/ObraNiJuanImg20.png" alt=""></div>
                    <div class="itemRight item5"><img src="../design-assets/ObraNiJuanImg21.png" alt=""></div>
                    <div class="itemRight item6"><img src="../design-assets/ObraNiJuanImg22.png" alt=""></div>
                    <div class="itemRight item7"><img src="../design-assets/ObraNiJuanImg5.png" alt=""></div>
                    <div class="itemRight item8"><img src="../design-assets/ObraNiJuanImg7.png" alt=""></div>
                  </div>
                  <div class="wrapper">
                    <div class="itemLeft item1"><img src="../design-assets/ObraNiJuanImg10.png" alt=""></div>
                    <div class="itemLeft item2"><img src="../design-assets/ObraNiJuanImg9.png" alt=""></div>
                    <div class="itemLeft item3"><img src="../design-assets/ObraNiJuanImg11.png" alt=""></div>
                    <div class="itemLeft item4"><img src="../design-assets/ObraNiJuanImg12.png" alt=""></div>
                    <div class="itemLeft item5"><img src="../design-assets/ObraNiJuanImg13.png" alt=""></div>
                    <div class="itemLeft item6"><img src="../design-assets/ObraNiJuanImg14.png" alt=""></div>
                    <div class="itemLeft item7"><img src="../design-assets/ObraNiJuanImg15.png" alt=""></div>
                    <div class="itemLeft item8"><img src="../design-assets/ObraNiJuanImg16.png" alt=""></div>
                  </div>
            </section>
        </div>


        <div class="Preview-Container">
        <?php
            $vid_album = "
                SELECT v.*, f.fname 
                FROM tb_videos v 
                JOIN tb_freelancers f ON v.freelancerID = f.id"; 
    
            $vid_album_run = mysqli_query($con, $vid_album);
            if (mysqli_num_rows($vid_album_run) > 0) {
                $videos = [];
                while ($video = mysqli_fetch_assoc($vid_album_run)) {
                    $videos[] = $video;
                }
    
                shuffle($videos);
    
                $main_video = $videos[0]; 
                ?>
            <section class="vidCont">
                <video src="../uploads/<?=$main_video['video']?>" class="slider" autoplay controls muted></video>
                <p>Captured by: <?=$main_video['fname']?></p>
            </section>
            <?php
        }
        ?>


            <section class="txtCont">
                <p class="head">Hire a Local <span>Freelancers</span> , Anywhere in the <span>Philippines!</span></p>
                <p class="content">Capture stunning moments through photography and videography. Whether you’re planning a wedding, an event, or a promotional shoot, you can connect with talented professionals who know the best locations and have an eye for detail. 
                    Enjoy personalized service and unique perspectives that highlight the beauty of your special moments while supporting local creatives in the thriving Filipino photography and videography scene!</p>
            </section>
        </div>

        <div class="SContainer">
            <h1 id="howItWorksHeading">How it Works</h1>
            <div class="HowtoContainer">
            
              <section class="steps-part-one">
                <ul>
                  <li>
                    <div> <i class="fa-regular fa-calendar-check"></i></div>
                    <div><span>1.Browse and Select Freelancer for your Shoot</span><p>Find a Freelancer in your Chosen Destination, Check their availability</p></div>
                  </li>
                  <li>
                    <div> <i class="fa-regular fa-bookmark"></i></div>
                    <div><span>2.Select a Freelancer , Request Your Date and Book your Shoot
                    </span><p>whithin 24-48 hours, you'll be notified if your Photographer or videographer accepted your Booking request. if not, we can help you fine another. Once accepted , you can pay the Downpayment for Security fee and Officially Confirm your booking and Reserve you Shoot</p>
                    </div>
                  </li>
                </ul>
              </section>
              <section class="steps-part-two">
                <ul>
                  <li>
                    <div><i class="fa-sharp fa-solid fa-camera"></i></div>
                    <div><span>3.Photo Shoot Day!</span><p>Meet up with your Photographer or Videographer and then it's all about having fun on you session!</p>
                    </div>
                  </li>
                  <li>
                    <div><i class="fa-regular fa-folder-open"></i></div>
                    <div><span>4.Recieve Your Photos</span><p>Within five days after your shoot, you will receive your beautiful gallery in your Email. </p>
                    </div>
                  </li>
                </ul>
              </section>

            </div>
            <section style='margin:auto;' >   <a href="./freelancers.php" ><button style='width:50%;' >Find a Photographer</button></a></section>
            <div class="wrapper">
                <div class="itemLeft item1"><img src="../design-assets/kosuni1.png" alt=""></div>
                <div class="itemLeft item2"><img src="../design-assets/kosuni2.jpg" alt=""></div>
                <div class="itemLeft item3"><img src="../design-assets/kosuni4.jpg" alt=""></div>
                <div class="itemLeft item4"><img src="../design-assets/kosuni3.JPG" alt=""></div>
                <div class="itemLeft item5"><img src="../design-assets/kosuni5.jpg" alt=""></div>
                <div class="itemLeft item6"><img src="../design-assets/kosuni6.jpg" alt=""></div>
                <div class="itemLeft item7"><img src="../design-assets/ObraNiJuanImg25.png" alt=""></div>
                <div class="itemLeft item8"><img src="../design-assets/ObraNiJuanImg27.png" alt=""></div>
            </div>
        </div>
            <div class='aboutAnchor' id="About"></div>

        <div class="AboutUsContainer" >
                <section class="head">
                  <span style="font-size:25px;font-weight: 400; color:#80B3FF;">About Us</span>
                  <p>FlashBook, a centralized cloud-based booking system with portfolio customization for photographers and videographers.
                  FlashBook is here to give you a seamless booking system and to search your chosen professionals.</p>
                </section>
                <section class="body">
                  <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
                  <dotlottie-player class="lottie" src="https://lottie.host/6d51a7e3-bf89-4ef2-ad9a-cc285d3c7559/HWgIrIPKNm.json" 
                  background="transparent" speed="1" style="width: 120%; height: 120%; position: relative; right: 20%;" loop autoplay></dotlottie-player>    
                </section>
        </div>
        
        <div class="FaqContainer" id="faq">
            <section class="head">
              <dotlottie-player src="https://lottie.host/c1f39f30-cde8-48d4-8cf0-c848b6849099/wUrFxLqJB2.json"
               background="transparent" speed="1" style="width: 120%; height: 120%;position: relative; top: -20%; left:-5%;" loop autoplay></dotlottie-player>
              </section>
            <section class="body">
              
              <div class="faq-section">
                <span style="font-size:25px;font-weight: 400; color:#437fbb;">Frequently Asked Questions</span>
                <div class="faq" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        What is Flashbook?
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    <div class="faq-answer">Flashbook is a centralized cloud-based booking system that you can use to book professionals and see their works from our website.</div>
                </div>
                <div class="faq" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        How to book professionals?
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    <div class="faq-answer">Just pick what kind of professional you need, review their profile and portfolio, and choose the events you need them for. Each place has professionals available for you.</div>
                </div>
                <div class="faq" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        How to make payment on your website?
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    <div class="faq-answer">When the professional accepts your booking, you will be notified by the admin and the professional. You need to pay 50% as a down payment, and the remaining balance should be given to the professional you booked.</div>
                </div>
                <div class="faq" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        Is there any penalty for rescheduling or cancelling?
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    <div class="faq-answer">Rescheduling the event has no penalty, but if you cancel the booking, there is no refund on your first payment.</div>
                </div>
              </div> 
            </section>
        </div>   

    </main>
  

    <?php include_once('./views/partials/booking-request-form.php')?>



<?php include('./views/partials/footer.php')?>