<?php require('./views/partials/head.php')?>
<?php require('./views/partials/nav.php')?>

<main>
  <div class="B-Page-Head">
    <section><span>Freelancers</span></section>
    <section><p>Our handpicked team of talented freelancer photographers and videographers is dedicated to capturing your unique moments with artistry and precision. Whether it’s a wedding, event, or promotional shoot, our curated professionals ensure that every shot beautifully reflects your story.</p></section>
  </div>
  
  <div class="Freelancer-cards-container">
    <div class="filterContainer">
      <form method="POST" id="filterForm">
        <Section>
        <label for="search">Search Name:</label>
        <input type="text" name="search" id="search" style='background-color:#d9f5f7; height:25px; width:100px;' placeholder="Search by name." /><br>
        </Section>
        <section>
            <label for="region">Filter:</label>
            <select name="region" id="region">
                <option disabled selected>Region</option>
                <?php  
                $sql = "SELECT * FROM region";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <option value="<?php echo $row['region_name']; ?>"><?php echo $row['region_name']; ?></option>
                <?php } ?>
            </select>

            <select name="province" id="province">
                <option value="" disabled selected>Province</option>
            </select>

            <select name="city" id="city">
                <option value="" disabled selected>City</option>
            </select>
        </section>

      </form>

    </div>

    <div class="cardsContainer">
      <?php
      $query = "SELECT * FROM tb_freelancers WHERE Status ='Active'";
      if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
          $search = mysqli_real_escape_string($con, trim($_POST['search']));
          $query .= " AND (fname LIKE '%$search%' OR last_name LIKE '%$search%' OR middle_name LIKE '%$search%')";
      }

      if (isset($_POST['submit'])) {
          if (!empty($_POST['region'])) {
              $region = mysqli_real_escape_string($con, $_POST['region']);
              $query .= " AND region = '$region'";
          }
          if (!empty($_POST['province'])) {
              $province = mysqli_real_escape_string($con, $_POST['province']);
              $query .= " AND province = '$province'";
          }
          if (!empty($_POST['city'])) {
              $city = mysqli_real_escape_string($con, $_POST['city']);
              $query .= " AND city = '$city'";
          }
      }

      $result = mysqli_query($con, $query);
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              $freelancer_id = $row['id'];
              $avg_rating_query = "
                  SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews 
                  FROM tb_reviews 
                  WHERE freelancerID = '$freelancer_id'";
              $avg_rating_result = mysqli_query($con, $avg_rating_query);
              $avg_rating_data = mysqli_fetch_assoc($avg_rating_result);
              ?>
              <div class="profile-card">
                  <div class="background-cont">
                      <img src="../img/<?php echo $row['profile']; ?>" alt="">
                  </div>

                  <div class="details-container">
                      <section class="heroContainer">
                          <section class="heroProfile">
                              <img src="../img/<?php echo $row['profile']; ?>" alt="">
                          </section>

                          <section class="heroName">
                              <?php echo $row['fname'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']; ?><br>
                              <span>Freelancer - Photographer</span>
                          </section>
                      </section>

                      <section class="aboutHero">
                          <?php echo $row['about']; ?>
                      </section>

                      <a href="./freelancer-profile.php?id=<?php echo $row['id']; ?>">
                          <button>Check profile</button>
                      </a>

                      <section class="LinkContainer">
                          <?php
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
                          ?>
                      </section>
                  </div>
              </div>
          <?php
          }
      } else {
          echo "<span style='font-size:20px;'>No freelancers found.</span>";
      }
      ?>
    </div>
  </div>



  <div class="Preview-Container" d>
            <section class="txtCont" style='text-align:center;'>
                <p class="head">Hire a Local <span>Freelancers</span> , Anywhere in the <span>Philippines!</span></p>
                <p class="content">Capture stunning moments through photography and videography. Whether you’re planning a wedding, an event, or a promotional shoot, you can connect with talented professionals who know the best locations and have an eye for detail. 
                    Enjoy personalized service and unique perspectives that highlight the beauty of your special moments while supporting local creatives in the thriving Filipino photography and videography scene!</p>
            </section>
        </div>
  <div class="SContainer">
    
    <h2>How it Works</h2>
    <div class="HowtoContainer">
      <section class="steps-part-one">
        <ul>
          <li>
            <div><i class="fa-regular fa-calendar-check"></i></div>
            <div><span>1. Browse and Select Freelancer for your Shoot</span><p>Find a Freelancer in your Chosen Destination, Check their availability</p></div>
          </li>
          <li>
            <div><i class="fa-regular fa-bookmark"></i></div>
            <div><span>2. Select a Freelancer, Request Your Date and Book your Shoot</span><p>Within 24-48 hours, you'll be notified if your Photographer or Videographer accepted your Booking request. If not, we can help you find another. Once accepted, you can pay the Downpayment for Security fee and Officially Confirm your booking and Reserve your Shoot.</p></div>
          </li>
        </ul>
      </section>
      <section class="steps-part-two">
        <ul>
          <li>
            <div><i class="fa-sharp fa-solid fa-camera"></i></div>
            <div><span>3. Photo Shoot Day!</span><p>Meet up with your Photographer or Videographer and then it's all about having fun on your session!</p></div>
          </li>
          <li>
            <div><i class="fa-regular fa-folder-open"></i></div>
            <div><span>4. Receive Your Photos</span><p>Within five days after your shoot, you will receive your beautiful gallery in your Email.</p></div>
          </li>
        </ul>
      </section>
    </div>

  </div>
  
</main>

<script>
$(document).ready(function() {
    // Fetch the filtered results whenever there's a change
    function fetchFreelancers() {
        var search = $('#search').val();
        var region = $('#region').val();
        var province = $('#province').val();
        var city = $('#city').val();

        $.ajax({
            type: 'POST',
            url: '../php/fetch_freelancers.php',  // Create this PHP script to handle the filtering logic
            data: {
                search: search,
                region: region,
                province: province,
                city: city
            },
            success: function(data) {
                // Replace the content of the cardsContainer with the new filtered freelancers
                $('.cardsContainer').html(data);
            },
            error: function() {
                alert('Error fetching freelancers.');
            }
        });
    }

    // Trigger filtering when the search input is updated
    $('#search').on('input', function() {
        fetchFreelancers();
    });

    // Trigger filtering when the region, province, or city dropdowns change
    $('#region, #province, #city').on('change', function() {
        fetchFreelancers();
    });

    // Fetch provinces when region is selected
    $('#region').change(function() {
        var regionId = $(this).val();
        $.ajax({
            type: 'POST',
            url: '../php/fetchprovince.php',
            data: { id: regionId },
            success: function(data) {
                $('#province').html(data);
                // Automatically clear the city dropdown
                $('#city').html('<option value="" disabled selected>City</option>');
                fetchFreelancers();
            },
            error: function() {
                alert('Error fetching provinces.');
            }
        });
    });

    // Fetch cities when province is selected
    $('#province').change(function() {
        var provinceId = $(this).val();
        $.ajax({
            type: 'POST',
            url: '../php/fetchcity.php',
            data: { id: provinceId },
            success: function(data) {
                $('#city').html(data);
                fetchFreelancers();
            },
            error: function() {
                alert('Error fetching cities.');
            }
        });
    });

});

</script>


<?php require_once('./views/partials/footer.php')?>
