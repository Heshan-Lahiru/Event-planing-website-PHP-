<?php
session_start();


$conn = new mysqli("localhost","root","","database");

if (isset($_POST["submit"])) {
    $mail = $_POST["mail"];
    $password = $_POST["password"];

    $sql = "SELECT password, user_id FROM register_table WHERE mail = ?"; // Use prepared statements
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            $mail = strstr($mail, '@', true); // Extract username
            $_SESSION['user_id'] = $row['user_id']; // Store userid in session

            switch ($mail) {
                case 'Admin':
                    $_SESSION['mail'] = $mail;
                    header("Location: adminhome.php");
                    exit();
                default:
                    $_SESSION['mail'] = $mail;
                    header("Location: home.php");
                    exit();
            }
        } else {
            $error = "Incorrect password. Please try again."; // Set error message
        }
    } else {
        $error = "Username not found. Please check and try again."; // Set error message
    }
    $stmt->close();
}
?>


<html>
    <head>
   <link rel="stylesheet" href="login.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    
    <body>
       <div class="wrapper">
        <form class="registration-form" action="" method="POST">
       <h1>login</h1>
       <div class="input-box">
        
        <input type="text" name="mail" placeholder="mail" required>
        <i class='bx bxs-user'></i>
       </div>
       <div class="input-box">
        <input type="password" name="password" placeholder="password" required>
        <i class='bx bxs-lock-open-alt' ></i>
    </div>
       <div class="remember-forgot">
        <label><input type="checkbox">Remember me</label>
    <a href="#">Fogot Password?</a>  
    </div>
    <button type="submit" name="submit" class="btn">Login</button>
<div class="register-link">
<p>Dont have an account?
    <a href="register.php">Register</a>
</p>

</div>        
</form>
       </div> 
    </body>
</html>