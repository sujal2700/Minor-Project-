<?php
include 'connect.php';
session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    echo "<script>window.open('loginpage.php','_self')</script>";
}

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    echo "<script>window.open('loginpage.php','_self')</script>";
    exit;
}
if(isset($_POST['add_to_cart'])){
   $product_name=$_POST['product_name'];
   $product_price=$_POST['product_price'];
   $product_image=$_POST['product_image'];
   $product_quantity=$_POST['product_quantity'];
   
   $select_cart=mysqli_query($conn, "SELECT * FROM `cart` WHERE NAME='$product_name' AND USER_ID='$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart)>0){
      echo "<script>echo('PRODUCT ALREADY IN THE CART!')</script>";
   }
   else{
    mysqli_query($conn, "INSERT INTO `cart`(USER_ID,NAME,PRICE,IMAGE,QUANTITY) VALUES('$user_id','$product_name','$product_price','$product_image','$product_quantity')") or die('query failed');
    echo "<script>alert('PRODUCT ADDED TO CART!!')</script>";
   }

};
if(isset($_POST['update_cart'])){
  $update_quantity=$_POST['cart_quantity'];
  $update_id=$_POST['cart_id'];
  mysqli_query($conn, "UPDATE `cart` SET QUANTITY='$update_quantity' WHERE ID='$update_id'") or die('query failed');
  echo "<script>alert('CART QUANTITY UPDATED SUCCESFULLY!')</script>";
}
if(isset($_GET['remove'])){
  $remove_id=$_GET['remove'];
  mysqli_query($conn,"DELETE FROM `cart` WHERE ID='$remove_id' ")or die('QUERY FAILED');
  echo "<script>window.open('home.php','_self')</script>";
}
if(isset($_GET['delete_all'])){
  mysqli_query($conn,"DELETE FROM `cart` WHERE USER_ID='$user_id' ")or die('QUERY FAILED');
  echo "<script>window.open('home.php','_self')</script>";
}
?>
<html>
<head>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .container {
            padding: 0 20px;
            margin: 0 auto;
            max-width: 1200px;
            padding-bottom: 70px;
        }
        
        .container .user-profile {
            padding: 20px;
            text-align: center;
            border: var(--border);
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            border-radius: 5px;
            margin: 20px auto;
            max-width: 500px;
        }
        
        .container .user-profile p {
            margin-bottom: 15px;
            font-size: 25px;
            color: var(--black);
        }
        
        .container .user-profile p span {
            color: var(--red);
        }
        
        .container .user-profile .flex {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-end;
        }
        .container .products .box-container {
  display:flex;
  flex-wrap:wrap;
  gap:15px;
  justify-content: center;

}
.container .products .box-container .box{
    text-align:center;
    border-radius:5px;
    box-shadow:var(--box-shadow);
    border:var(--border);
    position:relative;
    padding:20px;
    background-color:var(--white);
    width:350px;

}
.container .products .box-container .box img{
    height:250px;

}
.container .heading{
    text-align:center;
    margin-bottom:20px;
    font-size:40px;
    text-transform:uppercase;
    color:var(--black);
    
}
.container .products .box-container .box .name{
  font-size:20px;
  color:var(--black);
  padding:5px 0; 
} 

.container .products .box-container .box .price{
  position:absolute;
  top:10px; left:20px;
  padding:5px 10px;
  border-radius:5px; 
  background-color:var(--orange);
  color:var(--white);
  font-size:20px; 
}
.container .products .box-container .box input[type="number"]{
   margin:10px 0;
   border:var(--border);
   width:100%;
   border-radius:5px;
   font-size:20px;
   color:var(--black);
   padding:12px 14px;
}
.container .shopping-cart table{
  width:100%;
  text-align:center;
  border-radius: 5px;
  box-shadow:var(--box-shadow);
  background-color:var(--white);

}
.container .shopping-cart table thead{
  background-color:var(--black);
}
.container .shopping-cart table thead th{
  padding:10px;
  color:var(--white);
  text-transform:capitalize;
  font-size:20px;
}
.container .shopping-cart table .table-bottom{
  background-color:var(--light-bg);
}
.container .shopping-cart table tr td{
  padding:10px;
  font-size:15px;
  color:var(--black);
}
.container .shopping-cart table tr td:nth-child(1){
  padding:0;
}
.container .shopping-cart table tr td input[type="number"]{
  width:50px;
  border:var(--border);
  padding:10px 10px;
  font-size:20px;
  color:var(--black);
}
.container .shopping-cart .cart-btn{
  margin-top:10px;
  text-align:center;
}
.container .shopping-cart .cart-btn .disabled{
  pointer-events:none;
  background-color:var(--red);
  opacity:.5;
  user-select:none;
}

@media(max-width:1200px){
   .container .shopping-cart{
    overflow-x:scroll;
    
   }
   .container .shopping-cart table{
    width:1000px;
   }
}
@media (max-width:450px){
  .container .heading{
    font-size:30px;
  }
  .container .products .box-container .box img{
     height:200px;
  }
}



    </style>
    <title>Shopping cart</title>
</head>
<body>
    <div class="container">
        <div class="user-profile">
            <?php
            $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE ID='$user_id'") or die('query failed');
            if (mysqli_num_rows($select_user) > 0) {
                $fetch_user = mysqli_fetch_assoc($select_user);
            }
            ?>
            <p> Username : <span><?php echo $fetch_user['Name']; ?> </span> </p>
            <p> Email : <span><?php echo $fetch_user['Email']; ?> </span> </p>
            <div class="flex">
                <a href="loginpage.php" class="btn">Login</a>
                <a href="register.php" class="option-btn">Register</a>
                <a href="home.php?logout=<?php echo $user_id ?>" onclick="return confirm('Are you sure you want to logout?');" class="delete-btn">Logout</a>
            </div>
        </div>

        <div class="products">
           <h1 class="heading">Latest Products</h1>
          <div class="box-container">
          <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while($fetch_product=mysqli_fetch_assoc($select_product))
            {
            ?>
            <form method="post" class="box" action="">
              <img src="images/<?php echo $fetch_product['Image']; ?>" alt="">
                 <div class="name"><?php echo $fetch_product['Name'];?></div>
                <div class="price"><?php echo $fetch_product['Price'];?></div>
                <input type="number" min="1" name="product_quantity" value="1">
                <input type="hidden" name="product_image" value="<?php  echo $fetch_product['Image']?>">
                <input type="hidden" name="product_name" value="<?php  echo $fetch_product['Name']?>">
                <input type="hidden" name="product_price" value="<?php  echo $fetch_product['Price']?>"> 
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
          </form>
          <?php  
            };
          };
            ?>
          </div>
          </div>

          <div class="shopping-cart">
        <h1 class="heading">Shopping Cart</h1>

        <table border="2">
          <thead>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>

        </thead>
        <tbody>
        <?php 
        $grand_total=0;
         $cart_query=mysqli_query($conn,"SELECT * FROM `cart` WHERE USER_ID='$user_id'") or die('query failed');
         if(mysqli_num_rows($cart_query)>0){
          while($fetch_cart=mysqli_fetch_assoc($cart_query)){
            ?>
           <tr>  <td><img src="images/<?php echo $fetch_cart['IMAGE']; ?>" height="100"   alt=""> </td>
                 <td><?php echo $fetch_cart['NAME'];?></td>
                 <td><?php echo $fetch_cart['PRICE'];?>/-</td>
                <td>
                       <form action="" method="post">
                      <input type="hidden" min="1" name="cart_id"  value="<?php echo $fetch_cart['ID'];  ?>">
                      <input type="number" min="1" name="cart_quantity"  value="<?php echo $fetch_cart['QUANTITY'];  ?>">
                      <input type="submit" name="update_cart" value="update" class="option-btn">
                    </form>
                </td>
                <td><?php echo $sub_total=(int)($fetch_cart['PRICE']*$fetch_cart['QUANTITY']);?>/-</td>
                <td><a href="home.php?remove=<?php echo $fetch_cart['ID'] ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">Remove</a></td>
          </tr>
            <?php 
              $grand_total=$grand_total+$sub_total;
          };
         };
         ?>
         <tr class="table-bottom">
          <td colspan="4">Grand Total: </td>
          <td><?php echo number_format($grand_total); ?>/-</td>
          <td><a href="home.php?delete_all" onclick="return confirm('Delete all from cart?');"  class="delete-btn <?php echo($grand_total>1)?'': 'disabled';?>">Delete All</a></td>
        </tr>
        ?>
        </tbody>
        </table>
        <div class="cart-btn">
          <a href="#" class="btn<?php echo($grand_total>1)?'': 'disabled';?>"> Proceed to Checkout </a>
        </div>
        </div>
    </div>
</body>
</html>
