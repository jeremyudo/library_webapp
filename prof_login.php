<?php
   ob_start();
   session_start();
?>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="prof_login.css">
   <title>Staff Login</title>
</head>
<body>
   <h2 class="enterId">Professor Login</h2> 
   <?php
      $msg = '';
      
      // Database connection
      $con = mysqli_connect('library-db.mysql.database.azure.com', 'alinabangash', 'libdb123!', 'library');
      if (!$con) {
         die('Could not connect: ' . mysqli_connect_error());
      }

      if (isset($_POST['login']) && !empty($_POST['Username']) && !empty($_POST['Password'])) {
         $username = $_POST['Username'];
         $password = $_POST['Password'];
         
         // Fetch staff record from database
         $query = "SELECT * FROM prof WHERE ProfID = '$username'";
         $result = mysqli_query($con, $query);
         $row = mysqli_fetch_assoc($result);
         
         if ($row) {
            // Verify password
            if ($row['Password'] === $password) {
               $_SESSION['staff_logged_in'] = true;
               $_SESSION['staff_username'] = $username;
               // Redirect to staff panel
               header("Location: prof_home.php");
               exit();
            } else {
               $msg = "Invalid password";
            }
         } else {
            $msg = "Staff with this StaffID does not exist";
         }
      }

      mysqli_close($con);
   ?>

   <h4 style="margin-left:10rem; color:red;"><?php echo $msg; ?></h4>
   <br/><br/>
   <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div>
         <label for="Username">Professor ID:</label>
         <input type="text" name="Username" id="Username">
      </div>
      <div>
         <label for="Password">Password:</label>
         <input type="password" name="Password" id="Password">
      </div>
      <section style="margin-left:2rem;">
         <button class="loginButton" type="submit" name="login">Login</button>
      </section>
   </form>

   <div class="signIn">
      <a style="text-decoration:none; color: black;font-weight: normal" href="login.php" title="signIn">Sign In</a>
   </div>
   <p class="cleanSession"> 
      <a href="logout.php" title="Logout">Click here to clean Session</a>
   </p>
</body>
</html>
