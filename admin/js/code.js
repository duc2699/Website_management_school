// Scroll header
const bg = document.getElementById("navbar");

const changeBackground = () => {
  if (window.scrollY >= 40) {
    bg.style.backgroundColor = "rgb(35, 89, 144, 0.8)";
  } else {
    bg.style.backgroundColor = "transparent";
  }
};

window.addEventListener("scroll", changeBackground);

// Show submenu
function showSubmenu(menu, arr) {
  const submenu = document.getElementById(menu);
  const arrowDown = document.getElementById(arr);
  if (submenu.style.display === "block") {
    submenu.style.display = "none";
    arrowDown.style.transform = "unset";
  } else {
    submenu.style.display = "block";
    arrowDown.style.transform = "rotate(90deg)";
  }
}
const selectedform = document.getElementById("selectedform");
const showChecked = () => {
  selectedform.style.display = "block";
};
const offChecked = () => {
  selectedform.style.display = "none";
};

var modal = document.getElementById("popup");

const showPopup = () => {
  modal.style.display = "block";
};

const offPopup = () => {
  modal.style.display = "none";
};
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

// Dropdown role user
var wrapdrd = document.getElementById("wrapper__drd");
var roleuser = document.getElementById("role__user");
const showDrd = () => {
  wrapdrd.style.display = wrapdrd.style.display === "none" ? "block" : "none";
};


// Users Online
function loadUsersOnline() {
  $.get("functions.php?onlineusers=result", function (data) {
    $(".useronline").text(data);
  });
}

setInterval(function () {
  loadUsersOnline();
}, 500);

$(document).ready(function(){
  ClassicEditor
  .create( document.querySelector( '#description' ) )
  .catch( error => {
      console.error( error );
  } );
});