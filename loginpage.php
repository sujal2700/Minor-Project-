<?php
session_start();
include 'connect.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = md5($_POST['password']);
    $select = mysqli_query($conn, "SELECT * FROM `users` where Email= '$email' AND  Password = '$pass'") or die ('query failed');
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['ID'];
        echo "<script>window.open('home.php','_self')</script>";
        exit; // Add this line to stop executing the remaining code
    } else {
        echo "<script>alert('Incorrect Password/Email!!')</script>";
        echo "<script>window.open('loginpage.php','_self')</script>";
        exit; // Add this line to stop executing the remaining code
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
            <h3>Login Now</h3>
            <input type="text" name="email" placeholder="Enter Email" class="box" required>
            <input type="password" name="password" placeholder="Enter Password" class="box" required>
            <input type="submit" name="submit" class="btn" value="Login">
            <p>Don't have an account? <a href="register.php">Register Now</a></p>
        </form>
    </div>
</body>
</html>
