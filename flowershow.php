<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "database");

$user_id = $_SESSION['user_id'];

// Get user information from database
$sql = "SELECT name, image FROM register_table WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $image = $row['image'];
} else {
    // Handle unexpected situations (e.g., user not found)
    echo "Error: User not found.";
    exit();
}

?>


<?php


if (!isset($_SESSION['user_id'])) {
  // Redirect to login page if not logged in
  header("Location: login.php");
  exit();
}

$conn = new mysqli("localhost", "root", "", "database");

$user_id = $_SESSION['user_id'];

// Get user information (optional)
$sql = "SELECT name, image FROM register_table WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $row = $result->fetch_assoc();
  $username = $row['name'];
  $user_image = $row['image'];
} else {
  // Handle unexpected situations (e.g., user not found)
  echo "Error: User not found.";
  exit();
}

// Get user's unique items
$sql = "SELECT * FROM flower WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<?php

if(isset($_POST['submit'])){
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate and sanitize user input
if (!isset($_POST['item_id']) || !is_numeric($_POST['item_id'])) {
    echo "Invalid item ID.";
    exit();
}

$item_id = (int)$_POST['item_id']; // Sanitize to integer

$conn = new mysqli("localhost","root","","database");

// Prepare SQL statement with parameterized query to prevent SQL injection
$sql = "DELETE FROM items WHERE user_id = ? AND flower_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $_SESSION['user_id'], $item_id);

if ($stmt->execute()) {
    echo "Item deleted successfully.";
    // Optionally, redirect back to the user profile page after successful deletion:
    // header("Location: user.php");
} else {
    echo "Error deleting item: " . $conn->error;
}
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Page</title>
   
    <link href="user.css"rel="stylesheet"/>
  </head>
  <body>

    <main>
      <section class="glass">
        <div class="dashboard">
          <div class="user">
          <?php if ($image !== null): ?>
            <img style="width:100px;" src="image/<?php echo $image; ?>" alt="Profile Image">
            <?php else: ?>
        <p>No profile image uploaded.</p>
    <?php endif; ?>
            <h2 style="color:rgb(12, 7, 60);"><b><?php echo $name; ?></b></h2>
            <p style="font-size:1.5rem;">★★★..</p>
        </div>
        
          <div class="links">
            
          <a href="user.php"  style="text-decoration: none;"> <div class="link">
            <h2 style="color:white;">Menu</h2>
            </div></a> 
            <a href="#"  style="text-decoration: none;">  <div class="link">
                   <h2 style="color:white;">Cart</h2>
            </div></a>
            <a href="edituserpage.php" style="text-decoration: none;">  <div class="link">
              <img src="./images/upcoming.png" alt="" />
              <h2 style="color:white;">Edit</h2>
            </div></a>
            <a href="showcategoryinuser.php"  style="text-decoration: none;">  <div class="link">
              <img src="./images/library.png" alt="" />
              <h2 style="color:white;">items</h2>
            </div></a>
          </div>
          <div class="pro">
            <a href="logout.php" > <img style="width:60px" src="https://seekicon.com/free-icon-download/logout_1.png" alt="" /> </a>       </div>
       
        </div>
        <div class="games">
          <div class="status">
            <h1>Welcome <?php echo $name; ?> !</h1>
            
          </div>
          <div class="cards">
          <?php
    if ($result->num_rows > 0) {
      // Display items in a loop
      while ($row = $result->fetch_assoc()) {
        $item_id = $row['flower_id'];
        $item_name = $row['name'];
        $item_price = $row['price'];
        $item_location = $row['location'];
        $item_details = $row['details'];
        $item_image = $row['image'];
        
        ?>
            <div class="card">
<?php
 if ($item_image !== null) {
  echo "<img style='width:100px;' src='item_images/$item_image' alt='$item_name image'>";
}
?>              <div class="card-info">
                <h2><?php  echo "<h3>$item_name</h3>";  ?></h2>
                <p><?php echo "<p>Price: $$item_price</p>"; ?></p>
                <p><?php  echo "<p>Location: $item_location</p>"; ?></p>
                <p><?php  echo "<p>Details: $item_details</p>"; ?></p>
                <form action="" method="post">
                                        <input type="hidden" name="flower_id" value="<?php echo $item_id; ?>">
                                        <button style="background-color: blue;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;"
                                         class="delete-button" type="submit" name="submit">Delete</button>
              </div>
              <h2 class="percentage"></h2>
            </div>
            
            <?php  }} ?>
          </div>
        </div>
      </section>
    </main>
  
  </body>
</html>