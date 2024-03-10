<?php
session_start();

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
$sql = "SELECT * FROM items WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $username; ?>'s Items</title>
  <link rel="stylesheet" href="style.css"> </head>

<body>

  <header>
    </header>

  <main>
    <h1><?php echo $username; ?>'s Unique Items</h1>

    <?php
    if ($result->num_rows > 0) {
      // Display items in a loop
      while ($row = $result->fetch_assoc()) {
        $item_id = $row['items_id'];
        $item_name = $row['name'];
        $item_price = $row['price'];
        $item_location = $row['location'];
        $item_details = $row['details'];
        $item_image = $row['image'];

        // Display each item's details (structure as needed)
        echo "<div class='item-container'>";
        if ($item_image !== null) {
          echo "<img src='item_images/$item_image' alt='$item_name image'>";
        }
        echo "<h3>$item_name</h3>";
        echo "<p>Price: $$item_price</p>";
        echo "<p>Location: $item_location</p>";
        if ($item_details !== null) {
          echo "<p>Details: $item_details</p>";
        }
        // Add buttons or links for further actions (optional)
        echo "</div>";
      }
    } else {
      echo "<p>You haven't added any items yet.</p>";
    }
    ?>
  </main>

  <footer>
    </footer>

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
