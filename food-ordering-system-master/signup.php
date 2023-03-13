<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
    <?php
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['name'])) {
        // removes backslashes
        $name = stripslashes($_REQUEST['name']);
        //escapes special characters in a string
        $name = mysqli_real_escape_string($con, $name);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $password=md5($password);
        $address=stripslashes($_REQUEST['address']);
        $address=mysqli_real_escape_string($con,$address);
        $phone=stripslashes($_REQUEST['phone']);
        $phone=mysqli_real_escape_string($con,$phone);
        $query    = "CALL insert_cust('$name','$email','$password','$address','$phone');";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='signup.php'>Sign Up</a> again.</p>
                  </div>";
        }
    }
    else{ ?>
        <div
        class="bg-image"
        style="background-color: black;">
          <div class="container">
              <div class="row">
                <div class="bg-image col" style="background-image: url('./images/signup.jpg'); height: 100vh; background-size: 100%; background-repeat: no-repeat;">

                </div>  
                <div class="col bg-white" style="margin:0 auto;">
                    <h2 style="text-align: center;">F O O D Z Y </h2>
                    <form class="signup" action="" method="post">
                        <div class="form-group">
                            <label for="Name">Full Name</label>
                            <input type="text" class="form-control" name="name" id="Name" aria-describedby="nameHelp" placeholder="Enter full name">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                          </div>
                          <hr>
                          <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                          </div>
                          <hr>
                          <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                          </div>
                          <hr>

                          <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                            
                          </div>
                          <hr>
                          <button type="submit" class="btn btn-primary">Sign-Up</button>
                    </form>
                    <hr>
                    <p style="text-align: center;">Already a user? <a href="login.php">Log In</a></p>
                  </div>
                  
              </div>
          </div>

        
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <?php } ?>
      </body>
</html>