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
            <a href="#"  style="text-decoration: none;">  <div class="link">
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
            
          </div>
          <div class="cards">
         
              <img style="width:60px;" src="https://uxwing.com/wp-content/themes/uxwing/download/communication-chat-call/help-message-icon.png" alt="" />
              <div class="card-info">
                <h2>Help Center</h2>
                <p style="height:390px;"> Overall, cats can make wonderful companions for
                     those seeking a loving and independent furry friend.
                     Many people appreciate their low-maintenance lifestyle 
                     and ability to entertain themselves.
                     Topic Sentence: This sentence introduces the main idea of the paragraph.
Supporting Sentences: These sentences provide details, examples, or explanations to support the topic sentence.
Concluding Sentence: This sentence summarizes the main points of the paragraph or provides a final thought.</p>
                <div class="progress"></div>
              </div>
              <h2 class="percentage"></h2>
           
           
            
          </div>
        </div>
      </section>
    </main>
  
  </body>
</html>