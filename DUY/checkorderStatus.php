<?php include('server.php');
if (isset($_POST['logout_user'])){
    $_SESSION=array();
    $_POST = array();
    session_destroy();
}
$name="User";
$cno="cno";
$ono=$_GET['ono'];
$modifyarrayIndex=array();
if(isset($_SESSION['success'])) {
    if(isset($_SESSION['cname'])){
        $name=$_SESSION['cname'];
    }
    if(isset($_SESSION['cno'])){
        $cno=$_SESSION['cno'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Index Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/OnlineShoppingSystem/style.css">
  <style>
</style>
</head>
<body style="background-color:powderblue;">
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <a class="my-0 mr-md-auto font-weight-normal" href="/OnlineShoppingSystem/index.php">Online Shopping System<a>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 " href="/OnlineShoppingSystem/index.php">Features</a> 
        <a class="p-2 " href="/OnlineShoppingSystem/checkorder.php">Check Order Status</a> 
        <a class="p-2 " href="/OnlineShoppingSystem/viewcart.php">Check Out</a> 
        <a class="p-2 " href="/OnlineShoppingSystem/viewcart.php">View/Edit Cart</a> 
        <?php
         echo "<a class='p-2' href='/OnlineShoppingSystem/updateuser.php'>$name</a>";
        ?>
      </nav>
      <form method ="post" class ="form-control" id="search" action="/OnlineShoppingSystem/search.php"style ="
            width: 275px;
            height: 40px;
            padding: 0px;
            border: 0px;
            background: white;
            border-radius: 5px;">
            <input class="form-group" type="text" placeholder="search" name="search" formmethod="post" >
            <?php //<a class="btn btn-outline-primary mt-md-0 " href="/OnlineShoppingSystem/logout.php" name="logout">Logout</a> ?>
            <button class="btn btn-outline-success" form="search" type="submit" formaction="/OnlineShoppingSystem/search.php">Search</button>     
     </form>
        
     <form method ="post" class ="form-control" id="logout" action="/OnlineShoppingSystem/search.php"style ="
            width: 75px;
            height: 40px;
            padding: 0px;
            border: 0px;
            background: white;
            border-radius: 5px;">
            <input class="btn btn-outline-primary mt-md-0 "  form="logout" type="submit" value="logout" id ="form2" name = "logout">
       </form>
       
    </div>

<?php
$dbconnection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$parts_query= "SELECT p.pno, p.pname, p.price, od.qty FROM orders as o, parts as p, odetails as od 
WHERE o.cno = '$cno' AND o.ono = '$ono' AND o.ono = od.ono AND p.pno = od.pno";
$result=mysqli_query($dbconnection, $parts_query);
$num=mysqli_num_rows($result);   
?>
<div class="container">
<?php echo "<h1 align='center'>Welcome $name<p>Your Invoice Order# $ono</p></h1>"; ?> 
 <div class="jumbotron" style="
    margin: 0px auto;
    padding: 20px;
    border: 1px solid #B0C4DE;
    background: #f5f5f5;
    border-radius: 0px 0px 10px 10px;">

 
 <table class="table table-bordered">
 <thead>
   <tr>
     <th scope="col">MOVIE#</th>
     <th scope="col">Movie</th>
     <th scope="col">Price</th>
     <th scope="col">QTY</th>
     <th scope="col">$Total</th>
   </tr>
 </thead>
 <tbody>
 <?php
    $i=0;
    $totalprice=0;
    while ($i < $num) {
    $assoarray = mysqli_fetch_assoc($result);
    $movienum=$assoarray['pno'];
    $moviename=$assoarray['pname'];
    $movieprice=$assoarray['price'];
    $movieQTY=$assoarray['qty'];
    $totalcurrent=0;
    $totalcurrent=($movieprice*$movieQTY);
    $totalprice+=$totalcurrent;
    ?>
    
    <?php echo "<tr>"; ?>   
     <?php echo  "<td>$movienum</td>"; ?>
     <?php echo  "<td>$moviename</td>"; ?>
     <?php echo  "<td>$movieprice</td>";?>
     <?php echo  "<td>$movieQTY</td>";?>
     <?php echo  "<td>$totalcurrent</td>";?>
    <?php echo "</tr> ";?>
    <?php
    $i++;    
    }
    ?>
    <tr>
      <td colspan="4"> </td>
      <?php echo  "<td colspan='1'>$totalprice</td>"; ?> 
    </tr>
 </tbody>
 </table>
 <?php 
$dbconnection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$parts_query= "select street, city, state, zip, phone from customers where cno='$cno'";
$result=mysqli_query($dbconnection, $parts_query);
$num=mysqli_num_rows($result); 
$assoarray = mysqli_fetch_assoc($result);
$street=$assoarray['street'];
$city=$assoarray['city'];
$state=$assoarray['state'];
$zip=$assoarray['zip'];
$phone=$assoarray['phone'];
?>
<div>
<p> <h4>Shipping Address: </h4><?php echo"$street $city, $state $zip";?></p>
<p> <h4>Phone: </h4><?php echo"$phone";?></p>
</div>
  </div>
</div>
</body>
</html>
<?php

}
else {
echo"<script>location.href='/OnlineShoppingSystem/WebsiteLogin.php'</script>";
}
?>