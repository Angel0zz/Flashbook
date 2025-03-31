
<div class="logoutModal">
      <div class="logout-box">      
        Are you Sure you want to <span style ="color:#8b49f5; font-weight: 700;" >Logout?</span><br>
        <a href="../php/FreelancerLogout.php"><button class ="create accept">Logout</button></a>
        <button type="button" name="cancel" class="cancel delete" onclick="CloseLogoutBox()">Cancel</button>
    </div>
</div>
<footer>
<div>
    <img src="../assets/logo2.png" alt="">
</div>
<p>2024 © All rights reserved,FlashBook</p>
</footer>

<script src="scripts.js"></script>
<script>
     
    const logout = document.querySelector(".logoutModal");
      const lgbox = document.querySelector('.logout-box');
      function Logout(){
        logout.classList.add('active');
        lgbox.classList.add('active');
      }
      function CloseLogoutBox(){
        logout.classList.remove('active');
        lgbox.classList.remove('active');
      }

      function toggleFAQ(element) {
    const allAnswers = document.getElementsByClassName('faq-answer');

    const answer = element.querySelector('.faq-answer');


  if (answer.style.display === 'block') {
      answer.style.display = 'none';
      element.classList.remove('faq-active'); 
      const arrow = element.querySelector('.dropdown-arrow');
      arrow.textContent = '▼';
      return; 
  }

  // Hide all other answers
  for (let i = 0; i < allAnswers.length; i++) {
      allAnswers[i].style.display = 'none'; 
  }

  const allFAQs = document.getElementsByClassName('faq');
  for (let i = 0; i < allFAQs.length; i++) {
      allFAQs[i].classList.remove('faq-active'); 
  }


  answer.style.display = 'block';
  element.classList.add('faq-active');
}

</script>


<script>
    const nextButton = document.querySelector('.btn-next');
    const prevButton = document.querySelector('.btn-prev');
    const steps = document.querySelectorAll('.step');
    const form_steps = document.querySelectorAll('.form-step');
    let active = 1;

    nextButton.addEventListener('click', ()=>{
        active++;
        if(active > steps.length){
            active = steps.length;
        }
        updateProgress();
    });

    prevButton.addEventListener('click',()=>{
        active--;
        if(active < 1){
            active = 1;
        }
        updateProgress();
    });

    const updateProgress = ()=>{

        steps.forEach((step, i)=>{
            if(i == (active-1)){
                step.classList.add('active');
                form_steps[i].classList.add('active');
        
            }else{
                step.classList.remove('active');
                form_steps[i].classList.remove('active')
            }
        });

        if(active === 1){
            prevButton.disabled = true;
        }else if (active === steps.length){
            nextButton.disabled = true;
        }else{
            prevButton.disabled = false;
            nextButton.disabled = false;
        }
    }


</script>

<script>  
//notification 
    $(document).ready(function() {
    function showUnreadNotification() {
        $.ajax({
            url: 'fetch.php',
            method: 'POST',
            data: { option: '' }, // Just fetch notifications without marking them
            dataType: 'json',
            success: function(data) {
                $('.notif-item-container').html(data.notification);
                $('.count').html(data.unreadNotification > 0 ? data.unreadNotification : '0'); // Show 0 if no unread notifications
            }
        });
    }

    showUnreadNotification(); // Initial fetch of notifications
});

$(document).on('click', '.notif-item', function() {
    const notifId = $(this).data('id');
    console.log("Clicked notification ID: ", notifId); // Debug log

    $.ajax({
        url: 'fetch.php',
        method: 'POST',
        data: { option: 'markAsRead', notifId: notifId },
        success: function(response) {
            console.log("Notification marked as read: ", response);
            showUnreadNotification(); // Refresh notifications only after success
        },
        error: function(xhr, status, error) {
            console.error("AJAX error: " + error);
        }
    });
});

function openNotif() {
  const notifbox = document.querySelector('.notification-box');

  if (notifbox.style.display === 'block') {
    notifbox.style.display = 'none'; // Close if it's open
  } else {
    notifbox.style.display = 'block'; // Open if it's closed

    // Add an event listener for clicking outside
    setTimeout(() => {
      document.addEventListener('click', function(event) {
        if (!notifbox.contains(event.target)) {
          notifbox.style.display = 'none'; // Close notification box
        }
      }, { once: true }); // Ensure the event listener only runs once
    }, 0); // Delay to allow the current click to finish
  }

}




function closeError() {
    document.getElementById('errorContainer').style.display = 'none';
}
function closeSuccess() {
    document.getElementById('successContainer').style.display = 'none';
}
setTimeout(closeError, 3000);
setTimeout(closeSuccess, 3000);
</script>

</body>

</html>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll('.nav-link');
    const currentPage = window.location.pathname.split('/').pop();
    links.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active'); 
        }

        link.addEventListener('click', function() {
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active'); 
            localStorage.setItem('activeLink', this.getAttribute('href')); 
        });
    });
    const activeLinkHref = localStorage.getItem('activeLink');
    if (activeLinkHref) {
        links.forEach(link => {
            if (link.getAttribute('href') === activeLinkHref) {
                link.classList.add('active'); 
            }
        });
    }
});



</script>