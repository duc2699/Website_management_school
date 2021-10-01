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
const submenu = document.getElementById("sidebar-submenu");
const arrowDown = document.getElementById("fa-angle-right");

const showSubmenu = () => {
  if (submenu.style.display === "block") {
    submenu.style.display = "none";
    arrowDown.style.transform = "unset";
  } else {
    submenu.style.display = "block";
    arrowDown.style.transform = "rotate(90deg)";
  }
};
const selectedform = document.getElementById("selectedform");
const showChecked = () => {
  selectedform.style.display = "block";
};
const offChecked = () => {
  selectedform.style.display = "none";
};

// POPUP CONFIRM DELETE
var modal = document.getElementById("myModal");

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

// BTN showmore articles page
var animateButton = function (e) {
  e.preventDefault;
  //reset animation
  e.target.classList.remove("animate");

  e.target.classList.add("animate");
  setTimeout(function () {
    e.target.classList.remove("animate");
  }, 300);
};

var bubblyButtons = document.getElementsByClassName("bubbly-button");

for (var i = 0; i < bubblyButtons.length; i++) {
  bubblyButtons[i].addEventListener("click", animateButton, false);
}

// Dropdown role user
var wrapdrd = document.getElementById("wrapper__drd");
var roleuser = document.getElementById("role__user");
const showDrd = () => {
  wrapdrd.style.display = wrapdrd.style.display === "none" ? "block" : "none";
};

window.onclick = function (event) {
  if (event.target == wrapdrd) {
    wrapdrd.style.display = "none";
  }
};

// POPUP FORM SUBMIT
var formsubmit = document.getElementById("id01");

const showForm = () => {
  formsubmit.style.display = "block";
};

const offForm = () => {
  formsubmit.style.display = "none";
};
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == formsubmit) {
    formsubmit.style.display = "none";
  }
};

// CHECK TERMS AND CONDITIONS
var agreecheck = document.getElementById("agree");
var tcsumbit = document.getElementById("tcsubmit");
var wrpsmbtn = document.getElementById("wrapper__popup-btn");
function ctCheck() {
  if (agreecheck.checked == true) {
    wrpsmbtn.insertAdjacentHTML(
      "afterbegin",
      '<button id="tcsubmit" name="submit" type="button" class="btn btn-success tcsubmit">Submit</button>'
    );
    tcsumbit.style.display = "inline-block";
  } else {
    document.getElementById("tcsubmit").remove();
    tcsumbit.style.display = "none";
  }
}

