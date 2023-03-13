<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    
     <?php if(isset($_SESSION['username'])){ ?>
      <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <span style="color: gold; float:left;"> Hello,Welcome <?php $name=implode(',',$_SESSION['username']);
              echo $name;
              ?></span>
            </li>
           
            </ul>
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php" style="color: gold;">Home<span class="sr-only"></span></a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="logout.php" style="color: gold;">Log out</a>
            </li>
              
              <li class="nav-item">
                <a class="nav-link" href="feedback.php" style="color: gold;">Feedback</a>
              </li>
            </ul>
        </div>
      </nav>
      
      <?php } 
      else { ?>
      
      <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php" style="color: gold;">Home <span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signup.php" style="color: gold;">Sign Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php" style="color: gold;">Log in</a>
            </li>
            </ul>
            <ul class="navbar-nav mr-auto">
              
              <li class="nav-item">
                <a class="nav-link" href="feedback.php" style="color: gold;">Feedback</a>
              </li>
            </ul>
        </div>
      </nav>
      <?php } ?>

      
       
      
        

      <div
      class="bg-image p-5 text-center shadow-1-strong rounded mb-5 text-white"
      style="
        background-image: url('./images/bgimg.jpg');
        height: 70vh; backdrop-filter: blur(10%); background-repeat: no-repeat; background-size: 100% ;">
        <h1 style="color:black; text-align: center;">F O O D Z Y</h1>
        <br/>
        <h2 style="color:rgba(52, 16, 255, 0.932); text-align: center;font-weight: bold; font-style: italic;">I know once people get connected to real food, they never change back</h2>
        <h3 style="color:orchid; text-align: center;">– Alice Waters</h3>
        <br/>
        <div class="row input-group">
          <div class="col-6" style="margin: 0 auto;">
          <form class="form" method="post" action="restdata.php">
          <input type="search" name="hotel" class="form-control rounded" placeholder="Search for restaurant" aria-label="Search"
          aria-describedby="search-addon" />
          <br/>
          <button type="submit" class="btn btn-primary" name="search">Search</button>
          </form>
        </div>
        </div>
  
  
  </div>
    