<?php
ob_start();
require_once("../php/connection.php");
if (isset($_POST['RequestBook'])) {
    $UserId = $_SESSION['id'];
    $Fname = $_POST['Fname'];
    $Mname = $_POST['Mname'];
    $Lname = $_POST['Lname'];
    $areaCode = $_POST['areaCode'];
    $contact = $_POST['areaCode'] . $_POST['contactnum'];
    $email = $_POST['email']; 
    $location = $_POST['region'] . ' , ' . $_POST['province'] . ' , ' . $_POST['city'];
    $eventPlaceAddress = $_POST['blk'] ;
    $venue = $_POST['venue']; 
    $freelancer = $_POST['freelancer']; 
    $package = $_POST['package']; 
    $date = $_POST['date']; 
    $time  = $_POST['time'];
    $timeFormatted = date("g:i A", strtotime($time));
    $eventType = $_POST['eventType'];
    $details = $_POST['details']; 
    $status = "pending";
    $paymentstatus = "Unpaid";

    // Notification messages
    $title = 'Appointment Request Submitted';
    $message = 'Your request has been submitted and is waiting for approval.'; 
    $ftitle = 'New Booking Request';
    $fmessage = 'New booking request. Check your Appointment page.';

    if (empty($Fname) || empty($contact) || empty($email) || empty($location) || empty($freelancer) || empty($date)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode("Please fill up all fields"));
        exit();
    } elseif (!is_numeric($contact) || strlen($contact) !== 13) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode("Contact must be a valid 10-digit number"));
        exit();
    } else {
        $sql = "INSERT INTO `tb_appointment` (`userID`, `FreelancerID`, `PackageID`, `Fname`, `Mname`, `Lname`, `Client_email`, `contactNum`, `location`,`EventPlaceAddress`,`Venue`, `date`, `Event_Time`, `Event_type`, `details`, `status`, `Payment_Status`) 
                VALUES ('$UserId', '$freelancer', '$package', '$Fname', '$Mname', '$Lname', '$email', '$contact', '$location','$eventPlaceAddress','$venue','$date', '$timeFormatted', '$eventType', '$details', '$status', '$paymentstatus')";
        
        if (mysqli_query($con, $sql)) {
            $queryMessage = "INSERT INTO testing_notification (notif_Title, notif_content, clientID, freelancer_notif_title, freelancer_notif_content, freelancerID) 
                             VALUES ('$title', '$message', '$UserId', '$ftitle', '$fmessage', '$freelancer')";
            mysqli_query($con, $queryMessage);

        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode("Error in submitting the form. Please try again."));
            exit();
        }
    }
}
ob_end_flush();
?>

<div class="bk-frm-container" id="bk-frm-container">
    <div class="bk-n-ad">
        <h3>Book now!</h3>
        <p>The Best Way to Book Your Professional Photographer for Business or Personal Photoshoots on Flashbook</p>
    </div>

    <div class="form-box">
        <div class="progress">
            <div class="logo"><h1>Booking</h1></div>
            <ul class="progress-steps">
                <li class="step active"><span>1</span><p>Your Details</p></li>
                <li class="step"><span>2</span><p>Event Details</p></li>
                <li class="step last-step"><span>3</span><p>Confirm</p></li>
            </ul>
        </div>
        <form id="booking-form" action="#" method="POST" autocomplete="off">
            <div class="form-one form-step active">
                <h2>Personal Details</h2>
                <p>Fill in the Form below and let us know a few details</p>
                <label> (First Name | Middle Name | Last Name) <span style="color:red;">*</span></label>
                <div class='nameContainer' style='display:flex; flex-direction:row;'>
                    <input type="text" name="Fname" id="Fname" value='<?php echo $UserFname; ?>' required>
                    <input type="text" name="Mname" id="Mname" value='<?php echo $UserMname; ?>'required>
                    <input type="text" name="Lname" id="Lname" value='<?php echo $UserLname; ?>' required>
                </div>

                <div>
                    <label>Contact number <span style="color:red;">*</span></label>
                    <section class="numregcont" style="display:flex; position: relative;">
                        <input type="text" name="areaCode_display" id="areaCode" value="+63" readonly style="width:25px;" disabled>
                        <input type="hidden" name="areaCode" value="+63">
                        <input type="number" name="contactnum" id="contactnum" oninput="limitInput(this)" required style="width:100%; padding-inline:3px;">
                    </section>
                </div>
                <div>
                    <label>Email <span style="color:red;">*</span></label>
                    <input type="email" name="email" id="email" placeholder="e.g. email@gmail.com" required value='<?php echo $email; ?>' >
                </div> 
            </div>

            <div class="form-two form-step">
                <h2>Event Details</h2>
                <section class='selectFreelancersCont'>
                    <span>Freelancer</span>
                    <div>
                        <label>Region <span style="color:red;">*</span></label>
                        <select name="region" id="region" required>
                            <option disabled selected>Select Location</option>
                            <?php 
                            $sql = "SELECT * FROM region";
                            $result = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <option value="<?php echo $row['region_name']; ?>"><?php echo $row['region_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <label>Province <span style="color:red;">*</span></label>
                        <select name="province" id="province" required>
                            <option disabled selected>Select region first</option>
                        </select>
                    </div>
                    <div>
                        <label>City <span style="color:red;">*</span></label>
                        <select name="city" id="city" required>
                            <option disabled selected>Select province first</option>
                        </select>
                    </div>
                    
                    <div>
                        <label>Freelancer <span style="color:red;">*</span></label>
                        <select name="freelancer" id="freelancer" required>
                            <option disabled selected>Select region and province first</option>
                        </select>
                    </div>

                    <div>
                        <label>Package <span style="color:red;">*</span></label>
                        <select name="package" id="package" required>
                            <option disabled selected>Select package</option>
                            <?php 
                            $sql = "SELECT * FROM tb_offeredpackages";
                            $result = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['head'] . '- P' . number_format($row['price'], 2); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </section>
                
                <section class='selectFreelancersCont'>
                    <span>Event Details</span>
                    <div>   
                        <label>Venue Address<span style="color:red;">*</span></label>
                        <section style ='font-size:12px;'> House No. /  Lot No. /  Street /  Baranggay</section>
                        <input type="text" name="blk" id="blk"  required>
           
                    </div>
                    <div>
                        <label>Venue Name <span style="color:red;">*</span></label>
                        <input type="text" name="venue" id="venue" required>
                    </div>

                    <div>
                        <label>Event Type <span style="color:red;">*</span></label>
                        <select name='eventType' id='eventType' required> 
                            <option disabled selected>Select event type</option>
                            <option value="Birthday">Birthday</option>
                            <option value="Debut">Debut</option>
                            <option value="Wedding">Wedding</option>
                            <option value="Funeral">Funeral</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <section style="display:flex; gap:1em;">
                            <section>
                                <label>Date of event <span style="color:red;">*</span></label>
                                <input type="date" name="date" id="date" required>
                            </section>
                            <section>
                                <label>Time of Start of event <span style="color:red;">*</span></label>
                                <input type="time" name="time" id="time" required>
                            </section>
                        </section>
                    </div>
                    <div>
                        <label>More details of the event</label>
                        <section style ='font-size:12px;'>Provide as much detail as possible. (Exact Venue / Event Details / Time)</section>
                        <textarea name="details" id="details" rows="6"></textarea>
                    </div>
                </section>

            </div>

            <div class="form-three form-step">
                <h2>Confirm booking Request</h2>
                <p>"By pressing submit, you are confirming your booking request, accepting our terms and conditions, agreeing to our privacy policy, 
                and acknowledging that all the information provided is accurate to the best of your knowledge." </p>
            </div>

            <div class="error-message" style="color: red; display: none;"></div>
            
            <div class="btn-group">
                <button type="button" class="btn-prev" disabled>Back</button>
                <button type="button" class="btn-next" disabled>Next step</button>
                <button type="submit" class="btn-submit" name="RequestBook" id="RequestBook">Submit</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch provinces when region is selected
        $('#region').change(function() {
            var regionId = $(this).val();
            $.ajax({
                type: 'POST',
                url: '../php/fetchprovince.php',
                data: { id: regionId },
                success: function(data) {
                    $('#province').html(data);
                },
                error: function() {
                    alert('Error fetching provinces.');
                }
            });
        });

        // Fetch cities and photographers when province is selected
        $('#province').change(function() {
            var provinceId = $(this).val();
            $.ajax({
                type: 'POST',
                url: '../php/fetchcity.php',
                data: { id: provinceId },
                success: function(data) {
                    $('#city').html(data);
                },
                error: function() {
                    alert('Error fetching cities.');
                }
            });

            $.ajax({
                type: 'POST',
                url: '../php/fetchphotographers.php',
                data: { region: $('#region').val(), province: provinceId },
                success: function(data) {
                    $('#freelancer').html(data);
                },
                error: function() {
                    alert('Error fetching photographers.');
                }
            });
        });
    });

    function setMinDate() {
        const dateInput = document.getElementById('date');
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0]; 
        dateInput.setAttribute('min', formattedDate);
        setMinTime(); 
    }

    function setMinTime() {
        const dateInput = document.getElementById('date');  
        const timeInput = document.getElementById('time');
        const selectedDate = new Date(dateInput.value);
        const now = new Date();
        timeInput.value = ""; 

        if (selectedDate.toDateString() === now.toDateString()) {
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const currentTime = `${hours}:${minutes}`;
            timeInput.setAttribute('min', currentTime);
            if (timeInput.value < currentTime) {
                timeInput.value = currentTime; 
            }
        } else {
            timeInput.removeAttribute('min');
        }
    }

    function validateTimeInput() {
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        const selectedDate = new Date(dateInput.value);
        const now = new Date();
        if (selectedDate.toDateString() === now.toDateString()) {
            const currentTime = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
            if (timeInput.value < currentTime) {
                timeInput.value = currentTime;
            }
        }
    }

    function limitInput(input) {
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
        if (input.value < 9) {
            input.value = 9;
        }
    }
        function checkFormOneInputs() {
    const inputs = document.querySelectorAll('.form-one input[required], .form-one select[required]');
    const nextButton = document.querySelector('.btn-next');
    
    const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
    nextButton.disabled = !allFilled; 
}

function checkFormTwoInputs() {
    const inputs = document.querySelectorAll('.form-two input[required], .form-two select[required]');
    const nextButton = document.querySelector('.btn-next');
    

    const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
    nextButton.disabled = !allFilled;
}


document.querySelector('.btn-next').addEventListener('click', () => {

    document.querySelector('.form-one').classList.remove('active');
    document.querySelector('.form-two').classList.add('active');
    checkFormTwoInputs();
});

document.querySelector('.btn-prev').addEventListener('click', () => {
    // Move to form one
    document.querySelector('.form-two').classList.remove('active');
    document.querySelector('.form-one').classList.add('active');
    checkFormOneInputs();
});


document.querySelectorAll('.form-one input[required], .form-one select[required]').forEach(input => {
    input.addEventListener('input', checkFormOneInputs);
});


document.querySelectorAll('.form-two input[required], .form-two select[required]').forEach(input => {
    input.addEventListener('input', checkFormTwoInputs);
});


document.addEventListener('DOMContentLoaded', () => {
    setMinDate(); 
    document.getElementById('date').addEventListener('change', setMinTime); 
    document.getElementById('time').addEventListener('input', validateTimeInput); 
    checkFormOneInputs(); 
});

    document.getElementById('booking-form').addEventListener('submit', function(event) {
        const email = document.getElementById('email').value;
        const contactnum = document.getElementById('contactnum').value;

        for (const input of this.querySelectorAll('input[required], select[required], textarea[required]')) {
            if (!input.value) {
                alert('Please fill in all required fields.');
                event.preventDefault();
                return;
            }
        }


        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            event.preventDefault(); 
            return;
        }

   
        if (!/^\d{10}$/.test(contactnum)) {
            alert('Contact number must be numeric and 10 digits long.');
            event.preventDefault(); 
            return;
        }
    });
</script>
