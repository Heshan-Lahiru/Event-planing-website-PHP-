
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
  <link rel="stylesheet" href="item.css">
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
            <li><a style="color:black;" href="user.php">User Page </a></li>
            <li><a style="color:black;" href="logout.php">log out</a></li>
            
          </ul>

        </li>
        <li><a href="#"></a></li>
      </div>
    </ul>
  </nav>  <center> 
  <img style="width:20%; height:400px;" src="https://media.tenor.com/IVESrNXCzr0AAAAi/birthday-happy-birthday.gif">
</center> 

<!-- Card Div  -->
<div class="c">
<div class="cards">
<?php

$stmt = $conn->prepare("SELECT * FROM birthday");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
?>
 
    <div class="card card1">
            <div class="container">
            <img style="height:350px;" src="<?php echo "image/".$row['image'];?>">            </div>
            <div class="details">
                <h3><?php echo $row['name'];  ?></h3>
                <h3><?php echo $row['price'];  ?></h3>
                <h3><?php echo $row['location'];  ?></h3>
                <p><?php echo $row['details'];  ?></p>
            </div>
        </div>
      <?php }}  ?>
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
