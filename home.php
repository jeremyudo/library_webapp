<?php
   session_start();
   if (!isset($_SESSION['valid']) || $_SESSION['valid'] !== true) {
      header("Location: login.php");
      exit();
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to Our Library</title>
<link rel="stylesheet" href="styles/MainPage.css">
</head>
<body>
<div class="homeContent">
  <div class="topBar">
    <h1 class="welcome">Welcome to Our Library, <?php echo $_SESSION['FirstName'] . ' ' . $_SESSION['LastName']; ?></h1>
    <div class="accountTab">
      <a href="account.php">Account</a>
    </div>
  </div>
  <h1 class="searchText">Search for Resources</h1>
  <!-- Change form action to book_search_results.php -->
  <form class="searchForm" method="get" action="search_results_items.php">
    <input type="text" name="searchTerm" placeholder="Search books, digital media, etc..." value="<?php echo isset($_GET['searchTerm']) ? $_GET['searchTerm'] : ''; ?>">
    <button type="submit">Search</button>
  </form>
  <div class="topReads">
    <h2 class="topReadsText">Top Reads</h2>
    <div class="topReadsGallery">
      <?php
      $topReads = [
        ['id' => 1, 'imgSrc' => './images/book1.jpeg', 'title' => 'Book 1 Title'],
        ['id' => 2, 'imgSrc' => './images/book2.jpeg', 'title' => 'Book 2 Title'],
        ['id' => 3, 'imgSrc' => './images/book3.jpeg', 'title' => 'Book 3 Title']
      ];
      foreach ($topReads as $book) {
      ?>
      <div class="book">
        <img src="<?php echo $book['imgSrc']; ?>" alt="<?php echo $book['title']; ?>">
        <p><?php echo $book['title']; ?></p>
      </div>
      <?php
      }
      ?>
    </div>
  </div>
  <div class="info">
    <h1 class="aboutHead">About</h1>
    <p class="aboutText">Welcome to the University of Houston Library, your gateway to knowledge, innovation, and academic success. As an integral part of the esteemed University of Houston community, our library is dedicated to advancing scholarship, fostering creativity, and empowering individuals to excel in their academic and professional pursuits.

With a rich history spanning decades, our library offers extensive collections covering a wide array of subjects, both in print and digital formats. Our expert librarians and staff are committed to promoting information literacy and lifelong learning, providing personalized assistance and access to cutting-edge technologies.

Beyond serving as a repository of knowledge, we are a vibrant center for collaboration and innovation. Through partnerships with faculty, students, and external organizations, we facilitate interdisciplinary research, creative endeavors, and community engagement initiatives that enrich the intellectual life of our campus and beyond.

Whether you're conducting research, seeking scholarly resources, or exploring new ideas, we invite you to discover the wealth of resources and opportunities available at the University of Houston Library. Join us on a journey of discovery, exploration, and lifelong learning as we shape the future of education and scholarship together.

Welcome to your library.</p>
  </div>
  <div class="logout">
    <a href="logout.php">Logout</a>
  </div>
</div>
</body>
</html>
