<?php
session_start();
require('db.php');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    $b=stripslashes($_POST['hidden_bid']);
    $b=mysqli_real_escape_string($con,$b);
    $r=stripslashes($_POST['hidden_rid']);
    $r=mysqli_real_escape_string($con,$r);
    $c=stripslashes($_POST['hidden_cid']);
    $c=mysqli_real_escape_string($con,$c);
    $total=stripslashes($_SESSION['total']);
    $total=mysqli_real_escape_string($con,$total);
    $query="CALL place_order('$total','$c','$b','$r');";
   
    $result=mysqli_query($con,$query) or die(mysql_error());
    $o_id="SELECT O_ID FROM PLACE_ORDER WHERE O_ID=@@Identity;";
    $res1=mysqli_query($con,$o_id);
    
    $res1=mysqli_fetch_assoc($res1);
    $o_id=$res1['O_ID'];

    if($result){
        foreach($_SESSION["shopping_cart"] as $keys=>$values){
            $id=$values['food_id'];
            $num=$values['num_items'];
            $q="CALL contain_food('$o_id','$id','$num');";
            $result=mysqli_query($con,$q);
        }

            
        echo '<script>alert("Your order has been placed successfully")</script>';
        
        echo '<script>window.location="index.php"</script>';
    }
}


?>