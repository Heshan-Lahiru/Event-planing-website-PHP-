<?php
session_start();

$conn = new mysqli("localhost","root","","database");
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $compassword = $_POST['compassword'];
    $stmt = $conn->prepare("SELECT * FROM register_table WHERE name=? OR mail=?");
    $stmt->bind_param('ss', $name, $mail); // Correct string for two strings
$stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('User or email already exists');</script>";
        exit;
    }
    if ($password == $compassword) {
        // Hash the password using bcrypt
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);



    if($_FILES["image"]["error"] === 4){
        echo "<script>alert('Image doesn't exist')</script>";
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if(!in_array($imageExtension, $validImageExtensions)){
            echo "<script>alert('Invalid image format')</script>";
        } else if($fileSize > 1000000){
            echo "<script>alert('Image size is too large')</script>";
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;

            move_uploaded_file($tmpName, 'image/' . $newImageName);
            $query = "INSERT INTO register_table VALUES('','$name','$mail', '$newImageName','$hashedPassword')";
            mysqli_query($conn, $query);
            echo "<script>alert('Successfully added');
             document.location.href = 'login.php';</script>";
        }
    }
}
}
?>




<html>
    <head>
   <link rel="stylesheet" href="register.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/> </head>
    <body>
       <div class="wrapper">
       <form class="registration-form" action="" method="post"  enctype="multipart/form-data">
       <h1>Registration</h1>
       <div class="input-box">
        <input type="text" name="name" placeholder="Username" required>
        <i class='bx bxs-user'></i>
       </div>

       <div class="input-box">
        <input type="text" name="mail" placeholder="E-mail address" required>
        <i class='bx bx-envelope'></i>
       </div>

       <div class="input-box">
        <input type="password" name="password" placeholder="password" required>
        <i class='bx bxs-lock-open-alt' ></i>
    </div>
    <div class="input-box">
        <input type="password" name="compassword" placeholder="Re-enter password" required>
        <i class='bx bxs-lock-open-alt' ></i>
    </div>
    
    <div class="abc">
    <label for="image">Profile Image</label> 
          <i class="fa fa-2x fa-camera"></i>
          
      <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
    
      </div>
  

<br><br>

       <div class="remember-forgot">
        <label><input type="checkbox">Remember me</label>
    
    </div>
    <button type="submit" name="submit" class="btn">Register</button>
<div class="register-link">
<p>Do you have an account?
    <a href="login.php">login</a>
</p>
<div class="icons">
    <i class="fab fa-google"></i>
    <i class="fab fa-github"></i>
    <i class="fab fa-facebook"></i>
  </div>

</div>        
</form>
       </div> 
    </body>
</html>