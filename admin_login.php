<?php
   ob_start();
   session_start();
?>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login</title>
</head>
<body>
   <h2 style="margin-left:10rem; margin-top:5rem;">Admin Login</h2> 
   <?php
      $msg = '';
      
      // Hardcoded admin credentials
      $admin_username = 'admin';
      $admin_password = 'password';

      if (isset($_POST['login']) && !empty($_POST['Username']) && !empty($_POST['Password'])) {
         $username = $_POST['Username'];
         $password = $_POST['Password'];
         // Check if provided username and password match hardcoded admin credentials
         if ($username === $admin_username && $password === $admin_password) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            // Redirect to admin panel
            header("Location: admin_home.php");
            exit();
         } else {
            $msg = "Invalid username or password";
         }
      }
   ?>

   <h4 style="margin-left:10rem; color:red;"><?php echo $msg; ?></h4>
   <br/><br/>
   <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div>
         <label for="Username">Username:</label>
         <input type="text" name="Username" id="Username">
      </div>
      <div>
         <label for="Password">Password:</label>
         <input type="password" name="Password" id="Password">
      </div>
      <section style="margin-left:2rem;">
         <button type="submit" name="login">Login</button>
      </section>
   </form>
</body>
</html>
