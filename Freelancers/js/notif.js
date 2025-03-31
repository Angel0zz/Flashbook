document.addEventListener('DOMContentLoaded', function() {
    const menu = document.querySelector(".menu");
    const navMenu = document.querySelector(".links");
    
    menu.addEventListener("click", () => {
        navMenu.classList.toggle("active");
    });
});


function closeError() {
    document.getElementById('errorContainer').style.display = 'none';
}
function closeSuccess() {
    document.getElementById('successContainer').style.display = 'none';
}
setTimeout(closeError, 3000);
setTimeout(closeSuccess, 3000);
//notification 
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
  
    $(document).ready(function() {

function showUnreadNotification(option = '') {
    $.ajax({
        url: 'fetch.php',
        method: 'POST',
        data: { option: option },
        dataType: 'json',
        success: function(data) {
            $('.notif-item-container').html(data.notification);
            if (data.unreadNotification > 0) {
                $('.count').html(data.unreadNotification);
            } else {
                $('.count').html(data.unreadNotification); // Clear the count if there are no unread notifications
            }
        }
    });
} 

$(document).on('click', '.notif', function() {

    $.ajax({
        url: 'fetch.php', // Path to your PHP script
        method: 'POST',
        data: { option: 'updateAll' },  // Flag to indicate all notifications should be updated
        success: function(response) {
            // Log the full response for debugging
            console.log("Response from update: ", response);
        },
        error: function(xhr, status, error) {
            console.error("AJAX error: " + error);
        }
    });

    showUnreadNotification();
});


showUnreadNotification();
});

