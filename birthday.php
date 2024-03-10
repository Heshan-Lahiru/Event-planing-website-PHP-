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

// Process form submission if user is logged in
if (isset($_POST['submit'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $details = mysqli_real_escape_string($conn, $_POST['details']);

  // Check for image upload (optional)
  $image = null;
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $target_dir = "item_images/"; // Replace with your desired folder name
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image type (optional)
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    ) {
      $_SESSION['error'] = "Only JPG, JPEG, and PNG image formats are allowed.";
      exit(); // Stop further processing if image type is invalid
    }

    // Create the uploads directory if it doesn't exist
    if (!is_dir($target_dir)) {
      if (!mkdir($target_dir, 0777, true)) {
        $_SESSION['error'] = "Error creating uploads directory.";
        exit(); // Stop further processing if directory creation fails
      }
    }

    // Move the uploaded file to the uploads directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $image = basename($_FILES["image"]["name"]);
    } else {
      $_SESSION['error'] = "Sorry, there was an error uploading your image.";
      exit(); // Stop further processing on upload error
    }
  }

  // Check for duplicate item name before insertion
  $sql = "SELECT name FROM birthday WHERE name = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $name);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $_SESSION['error'] = "Item name already exists. Please choose a unique name.";
    exit(); // Stop further processing if item name is not unique
  }

  // Insert data into items table
  $sql = "INSERT INTO birthday (name, price, location, details, image, user_id) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssi", $name, $price, $location, $details, $image, $user_id);

  if ($stmt->execute()) {
    echo "<script>alert('Successfully added');
    document.location.href = 'user.php';</script>";
  } else {
    echo "<p style='color: red;'>Error: Could not add item.</p>";
  }

  // Close the prepared statement
  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Page</title>
   
    <link href="user.css"rel="stylesheet"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/> </head>
  
    <style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Poppins", sans-serif;
}


.wrapper{
    width:420px;
    background: transparent;
    border:2px solid rgba(255, 255, 255, .2);
    backdrop-filter:blur(20px);
    box-shadow:0 0  10px rgba(0,0,0, .2);
    color:#fff;
    border-radius:10px;
    padding: 30px 40px;
}
.wrapper h1{
    font-size:36px;
    text-align:center;
}
.wrapper .input-box{
    position: relative;
    width:100%;
    height:50px;
    
    margin:30px 0;
}
.input-box input {
    width:100%;
    height:100%;
    background: transparent;
    border:none;
    outline:none;
    border:2px solid rgba(255, 255, 255, .2);
    border-radius:40px;
    font-size:16px;
    color:black;
    padding:20px 45px 20px 20px;
}
.input-box textarea{
   
    background: transparent;
    border:none;
    outline:none;
    border:2px solid rgba(255, 255, 255, .2);
    border-radius:40px;
    font-size:16px;
    color:#fff;
    padding:20px 45px 20px 20px;
}

.input-box i{
    position: absolute;
    right:20px;
    top:50%;
    transform: translateY(-50%);
    font-size:20px;
}
.wrapper .remember-forgot{
    display:flex;
    justify-content: space-between;
    font-size:14.5px;
    margin: -15px 0 15px;
}
.remember-forgot label input{
    accent-color:#fff;
    margin-right:3px;
}
.remember-forgot a{
    color:#fff;
    text-decoration: none;
}
.remember-forgot a:hover{
    text-decoration:underline;
}
.wrapper .btn{
    width:100%;
    height:45px;
    background:#fff;
    border:none;
    outline:none;
    border-radius: 40px;
    box-shadow:0 0 10px rgba(0, 0, 0, .1);
    cursor:pointer;
    font-size:16px;
    color:#333;
    font-weight:600;
}
.wrapper .register-link{
    font-size:14.5px;
    text-align:center;
    margin:20px 0 15px;
}
.register-link p a{
    color:#fff;
    text-decoration: none;
    font-weight: 600;
}
.register-link p a:hover{
    text-decoration: underline;
}

  
  .icons i{
    color: #07001f;
    padding: 01.5rem 1.5rem;
    border-radius: 10px;
    margin-left: .9rem;
    font-size: 1.5rem;
    cursor: pointer;
    border: 0px solid #dfe9f5;
  }
  
  .icons i:first-child{
    color: green;
    
  }
  .icons i:last-child{
    color: blue;
  }
  input[type="file"]{
    display: none;
  }

  label{
    cursor:pointer;
  }
  
  #imageName{
    color:green;
  }
  .abc{
    height:50px;
    text-align:center;
    padding:3%;
    border:2px solid rgba(255, 255, 255, .2);
    border-radius:40px;  }
  </style>
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
            <a href="additem.php"  style="text-decoration: none;">  <div class="link">
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
    <!--  form -->
<center>
<div class="wrapper">
       <form class="registration-form" action="" method="post"  enctype="multipart/form-data">
       
       <h1>Wedding</h1>
       <div class="input-box">
        <input type="text" name="name" placeholder="event name" required>
       </div>
       <div class="input-box">
        <input type="text" name="price" placeholder="event price" required>
       </div>
       <div class="input-box">
        <input type="text" name="location" placeholder="event location" required>
       </div>

       <div class="input-box">
        <textarea placeholder="event details" name="details" rows="4" cols="30"></textarea>
       </div>

      <br><br><br><br>
    
    <div class="abc">
    <label for="image">event image</label> 
          <i class="fa fa-2x fa-camera"></i>
          
      <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
     </div>
<br><br>
    <button type="submit" name="submit" class="btn">uploard</button>
       
</form>
       </div> 
            </center>
         
          </div>
        </div>
      </section>
    </main>
  
  </body>
</html>