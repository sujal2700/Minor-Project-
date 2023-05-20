<?php
 include 'connect.php';
 if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=md5($_POST['password']);
    $cpass=md5($_POST['cpassword']);
     
    if($cpass!==$pass){
        echo "<script>Passwords don't match!!</script>";
    }
    $select=mysqli_query($conn, "SELECT * FROM `users` where Email= '$email' AND  Password = '$pass'") or die ('query failed');

    if(mysqli_num_rows($select)>0){
        echo "<script>alert('User already exists!')</script>";
        echo "<script>window.open('register.php','_self')</script>";
    }
    else{
          mysqli_query($conn, "INSERT INTO `users` (Name, Email, Password) VALUES ('$name','$email','$pass')") or die ('query failed!');
          echo "<script>alert('Registration Successful!')</script>";
          echo "<script>window.open('login.php','_self')</script>";
    }

 }


?>


<html>
    <head>
        <link rel="stylesheet" href="styles/style.css">
        <title>Register Page</title>
</head>
<body>

   <div class="form-container">
    <form action="" method="post">
        <h3>Register Now</h3>
    <input type="text" name="name" placeholder="Enter Username" class="box" required>
    <input type="text" name="email" placeholder="Enter Email" class="box" required>
    <input type="password" name="password" placeholder="Enter Password" class="box" required>
    <input type="password" name="cpassword" placeholder="Confirm Password" class="box" required>
    <input type="submit" name="submit" class="btn" value="Register Now">
    <p>Already have an account? <a href="loginpage.php">Login Now</a></p>

</form>
   


</body>
</html>