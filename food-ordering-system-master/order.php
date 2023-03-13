
<?php
require('header.php');
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}

?>
<?php 
require('db.php');
if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "food_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                  'food_id'=>$_GET["id"],  
                  'food_name'=>$_POST["hidden_name"],  
                  'food_price'=>$_POST["hidden_price"],  
                  'food_quantity'=>$_POST["hidden_quantity"],
                  'num_items'=>$_POST['num_items']  
                );  
                $_SESSION["shopping_cart"][$count] = $item_array;  
           }  
           else  
           {  
               header("Refresh:5;Location:order.php?rid=".$_GET['rid']."&bid=".$_GET['bid']);
               
                echo '<script>alert("Item Already Added")</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'food_id'=>$_GET["id"],  
                'food_name'=>$_POST["hidden_name"],  
                'food_price'=>$_POST["hidden_price"],  
                'food_quantity'=>$_POST["hidden_quantity"],
                'num_items'=>$_POST['num_items']  
           );  
           $_SESSION["shopping_cart"][0]=$item_array;  
      }  
 }  
 if(isset($_GET["action"]))  
 {  
      if($_GET["action"]=="delete")  
      {  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($values["food_id"]==$_GET["id"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     header("Refresh:5;Location:order.php?rid=".$_GET['rid']."&bid=".$_GET['bid']);
                     echo '<script>alert("Item Removed")</script>';  
                      
                }  
           }  
      }  
 }  
$b=$_GET['bid'];
$r=$_GET['rid'];
$query="SELECT Sl_No FROM `offers_food` WHERE R_ID='$r' AND B_ID='$b'";
$result=mysqli_query($con,$query) or die(mysql_error());

?>
<div class="container">
<div class="row">
    <?php while($data=mysqli_fetch_assoc($result)){
        $food=$data['Sl_No'];
        $qfood="SELECT * FROM FOOD WHERE Sl_No='$food'";
        $rfood=mysqli_query($con,$qfood) or die(mysql_error());
        $foodres=mysqli_fetch_assoc($rfood);

    
    ?>
    <div class="col-4">
      <form method="post" action="order.php?rid=<?php echo $r?>&bid=<?php echo $b?>&action=add&id=<?php echo $food ?>">
    <div class="card">
  <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
    <img src="./images/indian.jpg" class="img-fluid"/>
    <a href="#!">
      <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
    </a>
  </div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $foodres['Food_Name']?></h5>
    <p class="card-text">Quantity: <?php echo $foodres['Quantity']?>g Price:Rs<?php echo $foodres['Price']?> </p>
   <span> Num_Items: <input type="text" name="num_items" class="form-control" value="1" />  
    <input type="hidden" name="hidden_name" value="<?php echo $foodres["Food_Name"]; ?>" />  
    <input type="hidden" name="hidden_price" value="<?php echo $foodres["Price"]; ?>" />
    <input type="hidden" name="hidden_quantity" value="<?php echo $foodres["Quantity"]; ?>" />

    <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
  </div>
    </form>
</div>
    </div>
    <?php } ?>

    

</div>
<br>

<h3>Order Details</h3>  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="10%">Num_Items</th>  
                               <th width="20%">Price</th>  
                               <th width="15%">Total</th>
                               <th width="20%">Quantity(For one item)</th>  
                               <th width="5%">Action</th>  
                          </tr>  
                          <?php   
                          if(!empty($_SESSION["shopping_cart"]))  
                          {  
                               $total = 0;  
                               foreach($_SESSION["shopping_cart"] as $keys => $values)  
                               {  
                          ?>  
                          <tr>  
                               <td><?php echo $values["food_name"]; ?></td>  
                               <td><?php echo $values["num_items"]; ?></td>  
                               <td>Rs <?php echo $values["food_price"]; ?></td>  
                               <td>Rs <?php echo number_format($values["num_items"] * $values["food_price"], 2); ?></td>  
                               <td><?php echo $values["food_quantity"]; ?>g</td>
                               
                               <td><a href="order.php?rid=<?php echo $_GET['rid']?>&bid=<?php echo $_GET['bid']?>&action=delete&id=<?php echo $values["food_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                          </tr>  
                          <?php  
                                    $total = $total + ($values["num_items"] * $values["food_price"]);  
                                    $_SESSION['total']=$total;
                               }  
                          ?>  
                          <tr>  
                               <td colspan="3" align="right">Total</td>  
                               <td align="right">Rs <?php echo number_format($total, 2); ?></td>  
                               <td></td>  
                          </tr>  
                          <?php  
                          }  
                          ?>  
                     </table>  
                </div> 
                <?php  if(!empty($_SESSION["shopping_cart"]))
                {
                     
                
                ?>
               
               <div class="container" style="margin:0 auto;">
               <form method="post" action="placeOrder.php">
              
               <input type="hidden" name="hidden_rid" value=<?php echo $_GET['rid'] ?>/>
               <input type="hidden" name="hidden_bid" value=<?php echo $_GET['bid'] ?>/>
               <input type="hidden" name="hidden_cid" value=<?php echo $_SESSION['c_id'] ?>/>
               <input type="hidden" name="hidden o_price" value=<?php echo $_SESSION['total']?>/>
               <input type="submit" name="placed_order" class="btn btn-success" value="Place Order"/>
               </form>     
          </div> 
                    <?php }
                    
                    ?>
          </div>    
<br/>
<br/>


<?php require('footer.php')?>