<?php 
session_start();
if(!isset($_SESSION['username'])){
header("Location:login.php");
}
require("db.php");


?>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>        
<body style="background-color:black;">
<div class="container">        
<form class="text-center border border-light p-5 m-5" action="fres.php" method="post" style="background-image:url(./images/feedback.jpg);">

    <p class="h4 mb-4" style="color:yellow;"><b>Feedback</b></p>

    
    <input type="text" id="defaultRestaurant" class="form-control mb-4" name="rest" placeholder="Restaurant Name">

    
    <input type="text" id="defaultBranch" class="form-control mb-4" name="branch" placeholder="Branch">

    
    <label style="color:black;"><b>Rating</b></label>
    <input type="number" id="rating" name="rating" min="1" max="5">

    
    <br/>
    <br/>
    <!-- Message -->
    <div class="form-group">
        <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3" placeholder="Message" name="remarks"></textarea>
    </div>

    <br/>
    

    <!-- Send button -->
    <button class="btn btn-info btn-block" type="submit">Send</button>

</form>
</div>
</body>
</html>