<?php 
session_start();
require("db.php");
$rating=$_POST['rating'];
$rest=$_POST['rest'];
$branch=$_POST['branch'];
$c_id=$_SESSION['c_id'];
$remarks=$_POST['remarks'];
$q="SELECT R_ID FROM `RESTAURANT` WHERE R_NAME='$rest' ;";
$res=mysqli_query($con,$q);
$d=mysqli_fetch_assoc($res);
$rest=$d['R_ID'];
$query="SELECT Branch_id FROM `BRANCH` WHERE Branch_location='$branch';";
$res=mysqli_query($con,$query);
$d=mysqli_fetch_assoc($res);
$branch=$d['Branch_id'];

$q1="SELECT * FROM `RESTAURANT` WHERE R_ID='$rest' AND B_ID='$branch';";
$res=mysqli_query($con,$q1);
if(mysqli_num_rows($res)!=0){
$query="INSERT INTO `FEEDBACK` (Rating,Remarks,C_ID,R_ID,B_ID) VALUES ('$rating','$remarks','$c_id','$rest','$branch');";
$result=mysqli_query($con,$query); 
if($result){   
echo '<script>alert("Feedback given ")</script>';
echo '<script>window.location="index.php"</script>';
}
else{
    echo '<script>alert("The restaurant does not exist")</script>';
echo '<script>window.location="feedback.php"</script>';
}
}
else{
echo '<script>alert("The restaurant does not exist")</script>';
echo '<script>window.location="feedback.php"</script>';
}
?>