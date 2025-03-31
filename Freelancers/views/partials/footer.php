<footer>
<div>
    <img src="../assets/footer-logo.png" alt="">

</div>
<p>2024 © All rights reserved,FlashBook</p>

</footer>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    //dashboard
const viewButtons = document.querySelectorAll('.view');
const popup = document.getElementById('popup-det-card');
const closeButton = document.getElementById('closeButton');

viewButtons.forEach(button => {
    button.addEventListener('click', () => {
        popup.style.display = 'flex';
    });
});

closeButton.addEventListener('click', () => {
    popup.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target == popup) {
        popup.style.display = 'none';
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const menu = document.querySelector(".menu");
    const navMenu = document.querySelector(".links");
    
    menu.addEventListener("click", () => {
        navMenu.classList.toggle("active");
    });
});


</script>


<script>
         const popupCont = document.querySelector('.popup-cont');
          const createAlbum = document.querySelector('.create-album');
          const createVideoAlbum = document.querySelector('.create-video-album');
          const Gallery = document.querySelector('.Gallery');
          const LogoutBox = document.querySelector('.logout-box');
          
          const Archives = document.querySelector('.Archives');
          const ImgAlbum = document.querySelector('.image-Album');
          const VidAlbum = document.querySelector('.video-Album');
          
          function OpenArchives(){
            Archives.classList.add('active');
            ImgAlbum.classList.remove('active');
            VidAlbum.classList.remove('active');
            document.getElementById("Archives").style.fontWeight = "700";
            document.getElementById("imgAlbum").style.fontWeight = "normal";
            document.getElementById("vidAlbum").style.fontWeight = "normal";
          }

          function OpenImgAlbum(){
      
            ImgAlbum.classList.add('active');
            VidAlbum.classList.remove('active');
            Archives.classList.remove('active');
            document.getElementById("Archives").style.fontWeight = "normal";
            document.getElementById("imgAlbum").style.fontWeight = "700";
            document.getElementById("vidAlbum").style.fontWeight = "normal";
          }

          function OpenVidAlbum(){
            ImgAlbum.classList.remove('active');
            VidAlbum.classList.add('active');
            Archives.classList.remove('active');
            document.getElementById("Archives").style.fontWeight = "normal";
            document.getElementById("imgAlbum").style.fontWeight = "normal";
            document.getElementById("vidAlbum").style.fontWeight = "700";
          }

function Logout(){
  popupCont.classList.add('active');
  LogoutBox.classList.add('active');
  createAlbum.classList.remove('active');
  Gallery.classList.remove('active');
}
function CloseLogoutBox(){
  popupCont.classList.remove('active');
  LogoutBox.classList.remove('active');
}
function CreateAlbum() {
  popupCont.classList.add('active');
  createAlbum.classList.add('active');
  createVideoAlbum.classList.remove('active');
  LogoutBox.classList.remove('active');
  Gallery.classList.remove('active');
}
function CreateVidAlbum(){
    popupCont.classList.add('active');
    createVideoAlbum.classList.add('active');
  LogoutBox.classList.remove('active');
  Gallery.classList.remove('active');
  createAlbum.classList.remove('active');
}

function CloseAlbum(){
popupCont.classList.remove('active');
createAlbum.classList.remove('active');
}
function OpenGallery(){
  popupCont.classList.add('active');
  Gallery.classList.add('active');
}
function CloseGallery() {
  popupCont.classList.remove('active');
  Gallery.classList.remove('active');
}     

function closeAlertMessage(){
    const alert = document.querySelector('.alert');
    alert.style.display='none';
}
popupCont.addEventListener('click', function(event) {
  // Check if the click event was on the popup container itself
  if (event.target === popupCont) {
      CloseGallery();
      CloseAlbum();
      CloseLogoutBox();
  }
});


  $(document).ready(function() {
    $('.view_data').click(function(e) {
    e.preventDefault();

// Find the closest .album-card parent and then find the .albumID within it
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

 </script>
 <script>
    var currentSlide = 0;
        var totalSlides = <?php echo count($currentImages); ?>;

        function openPopup(index) {
            currentSlide = index;
            showSlide(currentSlide);
            document.getElementById("imagePopup").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("imagePopup").style.display = "none";
        }

        function showSlide(index) {
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

        function changeSlide(direction) {
            showSlide(currentSlide + direction);
        }
</script>


</body>


</html>