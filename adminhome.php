
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

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Admin panal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'><link rel="stylesheet" href="adminhome.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="dashboard">
	<aside class="search-wrap">
		<div class="search">
			<label for="search">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/></svg>
				<input type="text" id="search">
			</label>
		</div>
		
		<div class="user-actions">
			<button>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13.094 2.085l-1.013-.082a1.082 1.082 0 0 0-.161 0l-1.063.087C6.948 2.652 4 6.053 4 10v3.838l-.948 2.846A1 1 0 0 0 4 18h4.5c0 1.93 1.57 3.5 3.5 3.5s3.5-1.57 3.5-3.5H20a1 1 0 0 0 .889-1.495L20 13.838V10c0-3.94-2.942-7.34-6.906-7.915zM12 19.5c-.841 0-1.5-.659-1.5-1.5h3c0 .841-.659 1.5-1.5 1.5zM5.388 16l.561-1.684A1.03 1.03 0 0 0 6 14v-4c0-2.959 2.211-5.509 5.08-5.923l.921-.074.868.068C15.794 4.497 18 7.046 18 10v4c0 .107.018.214.052.316l.56 1.684H5.388z"/></svg>
			</button>
			<button>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 21c4.411 0 8-3.589 8-8 0-3.35-2.072-6.221-5-7.411v2.223A6 6 0 0 1 18 13c0 3.309-2.691 6-6 6s-6-2.691-6-6a5.999 5.999 0 0 1 3-5.188V5.589C6.072 6.779 4 9.65 4 13c0 4.411 3.589 8 8 8z"/><path d="M11 2h2v10h-2z"/></svg>
			</button>
		</div>
	</aside>
	
	<header class="menu-wrap">
		<figure class="user">
			<div class="user-avatar">
      <?php if ($image !== null): ?>
            <img src="image/<?php echo $image; ?>" alt="Profile Image">
            <?php else: ?>
        <p>No profile image uploaded.</p>
    <?php endif; ?>			</div>
			<figcaption>
      <?php echo $name; ?>
			</figcaption>
		</figure>
	
		<nav>
			<section class="dicover">
				<h3>Home</h3>
				
				<ul>
					<li>
						<a href="adminhome.php">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6.855 14.365l-1.817 6.36a1.001 1.001 0 0 0 1.517 1.106L12 18.202l5.445 3.63a1 1 0 0 0 1.517-1.106l-1.817-6.36 4.48-3.584a1.001 1.001 0 0 0-.461-1.767l-5.497-.916-2.772-5.545c-.34-.678-1.449-.678-1.789 0L8.333 8.098l-5.497.916a1 1 0 0 0-.461 1.767l4.48 3.584zm2.309-4.379c.315-.053.587-.253.73-.539L12 5.236l2.105 4.211c.144.286.415.486.73.539l3.79.632-3.251 2.601a1.003 1.003 0 0 0-.337 1.056l1.253 4.385-3.736-2.491a1 1 0 0 0-1.109-.001l-3.736 2.491 1.253-4.385a1.002 1.002 0 0 0-.337-1.056l-3.251-2.601 3.79-.631z"/></svg>
							Users
						</a>
					</li>
					
					<li>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.353 2.355-6.049-.002-8.416zm-1.412 7.002L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002 1.563 1.571 1.564 4.025.002 5.588z"/></svg>
							Aprove items
						</a>
					</li>
					
					<li>
						<a href="Addcategories.php">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.707 2.293A.996.996 0 0 0 12 2H3a1 1 0 0 0-1 1v9c0 .266.105.52.293.707l9 9a.997.997 0 0 0 1.414 0l9-9a.999.999 0 0 0 0-1.414l-9-9zM12 19.586l-8-8V4h7.586l8 8L12 19.586z"/><circle cx="7.507" cy="7.505" r="1.505"/></svg>
							Add Categories
						</a>
					</li>
					
					<li>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5.707 19.707L12 13.414l4.461 4.461L14.337 20H20v-5.663l-2.125 2.124L13.414 12l4.461-4.461L20 9.663V4h-5.663l2.124 2.125L12 10.586 5.707 4.293 4.293 5.707 10.586 12l-6.293 6.293z"/></svg>
							Add Category items
						</a>
					</li>
				</ul>
			</section>
		
			<section class="tools">
				<h3>Tools</h3>
				
				<ul>
					<li>
						<a href="#" class="active">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/></svg>
							delete categories
						</a>
					</li>
					
					<li>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 7L11 7 11 11 7 11 7 13 11 13 11 17 13 17 13 13 17 13 17 11 13 11z"/><path d="M12,2C6.486,2,2,6.486,2,12s4.486,10,10,10c5.514,0,10-4.486,10-10S17.514,2,12,2z M12,20c-4.411,0-8-3.589-8-8 s3.589-8,8-8s8,3.589,8,8S16.411,20,12,20z"/></svg>
							delete items
						</a>
					</li>
					
					<li>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 4H3a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1zm-1 14H4V9.227l7.335 6.521a1.003 1.003 0 0 0 1.33-.001L20 9.227V18zm0-11.448l-8 7.11-8-7.111V6h16v.552z"/></svg>
							Messages
						</a>
					</li>
				</ul>
			</section>
			
			<section class="dicover">
				<h3>Finance</h3>
				
				<ul>
					<li>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20,9l-4-4v3H9c-2.757,0-5,2.243-5,5s2.243,5,5,5h3v-2H9c-1.654,0-3-1.346-3-3s1.346-3,3-3h7v3L20,9z"/></svg>
							Buy
						</a>
					</li>
					
					<li>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15,8H8V5L4,9l4,4v-3h7c1.654,0,3,1.346,3,3s-1.346,3-3,3h-3v2h3c2.757,0,5-2.243,5-5S17.757,8,15,8z"/></svg>
							Sell
						</a>
					</li>
					
					<li>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21,3h-4V2h-2v1H9V2H7v1H3C2.447,3,2,3.447,2,4v17c0,0.553,0.447,1,1,1h18c0.553,0,1-0.447,1-1V4C22,3.447,21.553,3,21,3z M7,5v1h2V5h6v1h2V5h3v3H4V5H7z M4,20V10h16v10H4z"/><path d="M11,15.586l-1.793-1.793l-1.414,1.414l2.5,2.5C10.488,17.902,10.744,18,11,18s0.512-0.098,0.707-0.293l5-5l-1.414-1.414 L11,15.586z"/></svg>
							Invoice
						</a>
					</li>
					
					<li>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 12h2v3h-2z"/><path d="M21 7h-1V4a1 1 0 0 0-1-1H5c-1.206 0-3 .799-3 3v11c0 2.201 1.794 3 3 3h16a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1zM5 5h13v2H5.012C4.55 6.988 4 6.805 4 6s.55-.988 1-1zm15 13H5.012C4.55 17.988 4 17.805 4 17V8.833c.346.115.691.167 1 .167h15v9z"/></svg>
							Wallet
						</a>
					</li>
				</ul>
			</section>
		</nav>
	</header>
	
	<main class="content-wrap">
		<header class="content-head">
			
		</header>
    <section class="person-boxes">
    <?php

$stmt = $conn->prepare("SELECT * FROM register_table");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
?>
  		
				<div class="person-box">
					<div class="box-avatar">
						<img src="<?php echo "image/". $row['image'];  ?>">
					</div>
					
					<div class="box-bio">
						<h2 class="bio-name"><?php echo $row['name'];  ?></h2>
						<p class="bio-position"><?php echo $row['mail'];  ?></p>
					</div>
					
					<div class="box-actions">
						<button>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6.855 14.365l-1.817 6.36a1.001 1.001 0 0 0 1.517 1.106L12 18.202l5.445 3.63a1 1 0 0 0 1.517-1.106l-1.817-6.36 4.48-3.584a1.001 1.001 0 0 0-.461-1.767l-5.497-.916-2.772-5.545c-.34-.678-1.449-.678-1.789 0L8.333 8.098l-5.497.916a1 1 0 0 0-.461 1.767l4.48 3.584zm2.309-4.379c.315-.053.587-.253.73-.539L12 5.236l2.105 4.211c.144.286.415.486.73.539l3.79.632-3.251 2.601a1.003 1.003 0 0 0-.337 1.056l1.253 4.385-3.736-2.491a1 1 0 0 0-1.109-.001l-3.736 2.491 1.253-4.385a1.002 1.002 0 0 0-.337-1.056l-3.251-2.601 3.79-.631z"/></svg>
						</button>
						
						<button>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 18H6V6h7V4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-8h-2v7z"/><path d="M17.465 5.121l-6.172 6.172 1.414 1.414 6.172-6.172 2.12 2.121L21 3h-5.657z"/></svg>
						</button>
						
						<button>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 3C6.486 3 2 6.364 2 10.5c0 2.742 1.982 5.354 5 6.678V21a.999.999 0 0 0 1.707.707l3.714-3.714C17.74 17.827 22 14.529 22 10.5 22 6.364 17.514 3 12 3zm0 13a.996.996 0 0 0-.707.293L9 18.586V16.5a1 1 0 0 0-.663-.941C5.743 14.629 4 12.596 4 10.5 4 7.468 7.589 5 12 5s8 2.468 8 5.5-3.589 5.5-8 5.5z"/></svg>
						</button>
						
						<button>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 8L17 8 17 11 14 11 14 13 17 13 17 16 19 16 19 13 22 13 22 11 19 11zM3 20h10c.553 0 1-.447 1-1v-.5c0-2.54-1.212-4.651-3.077-5.729C11.593 12.063 12 11.1 12 10c0-2.28-1.72-4-4-4s-4 1.72-4 4c0 1.1.407 2.063 1.077 2.771C3.212 13.849 2 15.96 2 18.5V19C2 19.553 2.448 20 3 20zM6 10c0-1.178.822-2 2-2s2 .822 2 2-.822 2-2 2S6 11.178 6 10zM8 14c2.43 0 3.788 1.938 3.977 4H4.023C4.212 15.938 5.57 14 8 14z"/></svg>
						</button>
					</div>
				</div>
				
		
      <?php
      }}  ?>
      	</section>
		</div>
	</main>
</div>

  
</body>
</html>
