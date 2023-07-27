
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My website</title>
  <link rel="stylesheet" href="../cssfolder/optinola.css">
  
</head>
<body>
  <!-- Top banner -->
<div class="top-banner">
  <div class="container">

    <div class="small-bold-text banner-text">"Cast your vote from anywhere, anytime with our secure and convenient online voting system."</div>
  </div>  
</div>
<!-- Navbar -->

<nav>
  <div class="container main-nav flex">
   <a href="optionalhome.html" class="company-logo">
    <h1> Govote</h1> 
    </a>  
    <div class="nav-links">
     <ul class="flex" id="navbar">
      <li><a href="optionalhome.php" class="hover-links">Home</a></li>
      <li><a href="../Admin/candidate.php" class="hover-links">Candidates</a></li>
      <li><a href="../Admin/noticeshow.php" class="hover-links">Notice</a></li>
      <li><a href="login_page.php" class="hover-links secondary-btn">Sign in</a></li>
      <li><a href="Register-page.php" class="hover-links primary-btn">Sing up</a></li>
     </ul>
     <div class="activeBar">
      <img src="../images/menu.png" class="menu-icon">
    </div>
    </div>
   
  </div>
 
</nav>
<!-- header section -->
<header>
 <div class="container header-section flex">
  <div class="header-left">
    <h1>Online voting system</h1>
    <p>An online voting system is a software platform that allows groups to securely conduct votes and elections.
      High-quality online voting systems balance ballot security, accessibility, and the overall requirements of
      an organization's voting event.</p>
      <a href="login_page.php" class="primary-btn get-start-btn">Get Started</a>
  </div>
  <div class="img-slider">
  <div class="header-right">
    <img src="../images/bb.jpg" alt="" id="slider" class="main_slider">
  </div>
  </div>
 </div>
 <div id="popupContainer">
  <div id="popupContent">
    <h2>Welcome to Our Website</h2>
    <p>Thank you for visiting our website. We hope you have a great experience!</p>
    <button id="closePopup">Close</button>
  </div>
</div>
<div class="custom-shape-divider-bottom-1688894802">
  <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
  </svg>
</div>

</header>

<script>
  
var imgId = document.getElementsByClassName('main_slider')[0];
console.log(imgId)
var imgList= ['./img/1.jpg', './img/2.jpg', './img/3.jpg',  './img/4.jpg'];
let imgNo = 0;

let carouselId =setInterval(sliderOne,1000);

function sliderOne(){
  if(imgNo<imgList.length)
    {
        imgId.setAttribute('src', imgList[imgNo]);
        imgNo++;
    }
    else
    {
        imgNo=0;
    }
}
imgId.addEventListener("mouseover", function(){
  clearInterval(carouselId)
})

imgId.addEventListener("mouseout", function(){
  carouselId =setInterval(sliderOne,1000);
    
})
// for popup
const closeButton = document.getElementById('closePopup');
const popupContainer = document.getElementById('popupContainer');

function showPopup() {
  popupContainer.style.display = 'block';
}

function hidePopup() {
  popupContainer.style.display = 'none';
}

closeButton.addEventListener('click', hidePopup);

// Set the time interval in milliseconds (e.g., 5000 = 5 seconds)
const interval = 3000;

// Show the popup after the specified delay
setTimeout(showPopup, interval);


// for menu

var MenuItems=document.getElementById("navbar");
// MenuItems.style.maxHeight ="0px";
  var MenuTog = document.querySelector(".activeBar");
  MenuTog.addEventListener("click",function(){
    MenuItems.classList.toggle("menuOpen")
  })

</script>

</body>
</html>