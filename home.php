
<?php
session_start();

$conn = new mysqli("localhost", "root", "", "database");

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Slider</title>
  <link rel="stylesheet" href="home2.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/> </head>
    

  <style>
  


  </style>
</head>
<body>
<nav class="navbar">
     <div class="logo">
     <i class='bx bx-registered'></i>
Event Planning
     </div>
    <ul class="nav-links">
      <div class="menu">

        <li><a href="home.php">Home</a></li>
        <li><a href="#">People</a></li>


        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>

        <li class="services">
          <a href="#"><img style="width:50px;"  src="https://static.vecteezy.com/system/resources/previews/019/879/186/original/user-icon-on-transparent-background-free-png.png"></i></a>

          <!-- DROPDOWN MENU -->
          <ul class="dropdown">
            <li><a style="color:black;" href="showcategoryforitem.php">User Page </a></li>
            <li><a style="color:black;" href="logout.php">log out</a></li>
            
          </ul>

        </li>
        <li><a href="#"></a></li>
      </div>
    </ul>
  </nav>   
<section>
  <div class="slider">
    <div class="slide">
      <img src="https://www.internationalbrandequity.com/wp-content/uploads/2022/04/event-management-guide.jpg" alt="Image 1">
    </div>
    <div class="slide">
      <img src="https://fiverr-res.cloudinary.com/images/q_auto,f_auto/gigs/338302761/original/fe873f84a76a12aa292c179dd7888fea25f52473/be-your-virtual-wedding-planner-and-designer.png" alt="Image 2">
    </div>
    <div class="slide">
      <img src="https://media.licdn.com/dms/image/C511BAQGbhmQ7bCJ1Iw/company-background_10000/0/1584038311428/page3_eventss_cover?e=2147483647&v=beta&t=-XbtJ1vsaQqpVy_s9p2oVbhIgb6iq5T-EjJyU_fnYB0" alt="Image 3">
    </div>
    <button class="prev-btn">&#8249;</button>
    <button class="next-btn">&#8250;</button>
  </div>

  <script>
    const slides = document.querySelectorAll('.slide');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

let currentSlide = 0;

function showSlide(slideIndex) {
  slides.forEach((slide, index) => {
    slide.classList.remove('active');
    if (index === slideIndex) {
      slide.classList.add('active');
    }
  });
}

showSlide(currentSlide);

function nextSlide() {
  currentSlide = (currentSlide + 1) % slides.length;
  showSlide(currentSlide);
}

function prevSlide() {
  currentSlide = (currentSlide - 1 + slides.length) % slides.length;
  showSlide(currentSlide);
}

prevBtn.addEventListener('click', prevSlide);
nextBtn.addEventListener('click', nextSlide);

const autoPlayInterval = setInterval(nextSlide, 3000); 


  </script>
<div class="hellow">

<h1>Event Management</h1>
</div>
<div class="b">

</div>
<div class="video-container">
    <video width="100" height="200" controls>
      <source src="https://media.istockphoto.com/id/1171792404/video/guests-throwing-petals-over-couple-outside-church.mp4?s=mp4-640x640-is&k=20&c=9twiELzcsNBqwjAh5zDZfi9CLNtNGL3pFwKscDtsOPQ=
" type="video/mp4">
    </video>
</div>

<!-- div box searchbar  -->
<div class="d">
<div class="topnav1">
<input type="text" placeholder="Search.." id="find" name="find">
 
  <a href="#home">Wedding   
  <img style="width:50px;" src="https://pngimg.com/d/wedding_PNG19483.png">

  </a>
  <a href="#about">funeral
  <img style="width:50px;" src="https://cdn-icons-png.flaticon.com/512/5339/5339355.png">

  </a>
  <a href="#contact">birthday
  <img style="width:50px;" src="https://png.pngtree.com/png-clipart/20221122/ourmid/pngtree-happy-birthday-text-effect-png-image_241348.png">
  </a>
  </a>
  <a href="#contact">Party
  <img style="width:50px;" src="https://www.pikpng.com/pngl/b/122-1224435_632-x-691-4-dancing-party-people-png.png">
  </a>
  </a>
  <a href="#contact">sounds
  <img style="width:50px;" src="https://png.pngtree.com/png-clipart/20230102/ourmid/pngtree-cartoon-speaker-png-image_6548480.png">
  </a>
  </a>
  <a href="#contact">stages
  <img style="width:50px;" src="https://spaces-cdn.clipsafari.com/3tmip7a1bpotmfsaeritypvxdopa">
  </a>
  <a href="#contact">flowers
  <img style="width:50px;" src="https://png.pngtree.com/png-clipart/20211226/original/pngtree-cute-cartoon-flower-png-image_6977886.png">
  </a>
  <a href="#contact">architectures
  <img style="width:50px;" src="https://i.pinimg.com/originals/20/43/ed/2043edd9dca5f5b3f513b3b6aee801f9.png">
  </a>
  <a href="#contact">Bulbs
  <img style="width:50px;" src="https://png.pngtree.com/png-clipart/20230417/original/pngtree-light-bulb-cartoon-doodle-glowing-creative-png-image_9059588.png">
  </a>
  
</div>

</div>


<!-- Card Div  -->
<div class="c">
<div class="cards">
<?php

$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $itemLinks = array(
        "wedingone.php", // Link for the first item
        "funaralone.php",     // Link for the second item
        "birthdayone.php",   // Link for the third item
        "partyone.php",
        "flowerone.php",
        "stageone.php"
    );

    $i = 0; // Index for the link array
    while ($row = $result->fetch_assoc()) {
        $link = (isset($itemLinks[$i])) ? $itemLinks[$i] : "#"; // Handle potential missing links

        echo '<a href="' . $link . '">';
        echo '<div class="card card1">';
        echo '<div class="container">';
        echo '<img style="height:350px;" src="image/' . $row['image'] . '">';
        echo '</div>';
        echo '<div class="details">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['details'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</a>';

        $i++; // Increment the index for the next link
    }
} else {
    echo "No categories found in the database.";
}

?>

  </div>

    <footer>
<div class="footer">
  <div class="contain">
  <div class="col">
    <h2>Company</h2>
    <ul>
      <li>About us</li>
      <li> Our Mission</li>
      <li>Services</li>
    </ul>
  </div>
  <div class="col">
    <h2>Products</h2>
    <ul>
      <li>SEO</li>
      <li>Content Development</li>
      <li>Digital Marketing</li>
    </ul>
  </div>
  <div class="col">
    <h2>Team</h2>
    <ul>
      <li>HR Team</li>
      <li>Finance Team</li>
      <li>Content Team</li>
    </ul>
  </div>
  <div class="col">
    <h2>Resources</h2>
    <ul>
      <li>Webmail</li>
      <li>Web templates</li>
      <li>Email templates</li>
    </ul>
  </div>
  <div class="col">
    <h2>Contact</h2>
    <ul>
      <li>+94 7641 65833</li>
      <li>033 2212 31111</li>
      <li>lahiruheshan454@gmail.com</li>
    </ul>
  </div>
  <div class="col address">
    <h2>Address </h2>
    <ul>
      <li>Sri lanka,Galle</li>
  </ul>
  </div>
<div class="clearfix"></div>
</div>
</div>
</footer>


</body>
</html>
