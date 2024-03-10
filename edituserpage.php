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


$conn = new mysqli("localhost", "root", "", "database");

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    if (isset($_POST['submit'])) {

        // Check if all required fields are submitted
        if (isset($_POST['name']) && isset($_POST['mail']) && isset($_FILES['image']) && isset($_POST['password'])) {

            $name = $_POST['name'];
            $mail = $_POST['mail'];
            $image = $_FILES['image']; // File details
            $password = $_POST['password'];

            // Image upload validations
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $image_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

            if (!in_array($image_ext, $allowed_extensions)) {
                echo "Invalid image format. Please upload only jpg, jpeg, png, or gif images.";
                exit();
            }

            // Generate a unique filename to avoid conflicts
            $new_filename = $image['name'] ;

            // Upload the image to a designated directory
            $upload_dir = "image/"; // Change this to your desired upload directory
            $target_file = $upload_dir . $new_filename;

            if (move_uploaded_file($image['tmp_name'], $target_file)) {

                // Update password with hashing
                $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Recommended hashing approach

                $sql = "UPDATE register_table SET name=?, mail=?, image=?, password=? WHERE user_id=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssss", $name, $mail, $new_filename, $hashed_password, $user_id);

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: user.php");
                    exit();
                } else {
                    echo "Error updating data: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);

            } else {
                echo "Error uploading image: " . $image['error'];
            }

        } else {
            echo "Please fill in all required fields.";
        }

    } else {

        $sql = "SELECT name, mail, image FROM register_table WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $mail = $row['mail'];
                $current_image = $row['image']; // Store current image for display
            } else {
                echo "No data found for this user.";
            }
        } else {
            echo "Error selecting data: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);

} else {
    echo "<p>Please log in to edit your information.</p>";
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/> </head>
   
    <link href="user.css"rel="stylesheet"/>
    <link href="edituserpage.css"rel="stylesheet"/>
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
            <a href="help.php"  style="text-decoration: none;">  <div class="link">
              <img src="./images/library.png" alt="" />
              <h2 style="color:white;">Help</h2>
            </div></a>
          </div>
          <div class="pro">
            <a href="logout.php" > <img style="width:60px" src="https://seekicon.com/free-icon-download/logout_1.png" alt="" /> </a>       </div>
       
        </div>
        <div class="games">
          <div class="status">
            <h1>Welcome <?php echo $name; ?> !</h1>
            

            <?php
// Check if there are any errors from the PHP script
if (isset($errors) && !empty($errors)) {
    echo "<ul class='error'>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
}
?>
 

<form class="registration-form" action="" method="post" enctype="multipart/form-data">
<div class="input-box">

    <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
</div>
<div class="input-box">

    <input type="email" id="mail" name="mail" value="<?php echo isset($mail) ? $mail : ''; ?>">
</div>
<div class="abc">
<label for="image">Profile Image</label> 
          <i class="fa fa-2x fa-camera"></i>
    <input type="file" id="image" name="image" accept="image/*">

</div>
    
   
    <div class="input-box">
    <input type="password" id="password" name="password" placeholder="enter password">
    </div>
    <button type="submit" name="submit" class="btn">Update</button>
</form>
 

<center><div class="icons">
    <i class="fab fa-google"></i>
    <i class="fab fa-github"></i>
    <i class="fab fa-facebook"></i>
  </div></center>
          </div>
         
          </div>
          
        </div>
      </section>
    </main>
  
  </body>
</html>