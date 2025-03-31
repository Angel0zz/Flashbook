<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

const popupCont = document.querySelector('.popup-cont');
const createAlbum = document.querySelector('.create-album');
const Gallery = document.querySelector('.Gallery');
const LogoutBox = document.querySelector('.logout-box');

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
  LogoutBox.classList.remove('active');
  Gallery.classList.remove('active');
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
    url:"code.php",
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

//carousel

