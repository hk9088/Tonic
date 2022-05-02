<?php require_once "server.php"; ?>
<?php 
$email = $_SESSION['Email'] ;
if(empty($_SESSION['Email'])){
  header('Location: homepage.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="css\mystyle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <form action="otp.php" method="POST" autocomplete="off">
        <div class ="form">
            <label class="label">
                <h3 class="text-center">Code Verification</h3>
            </label>
            <?php 
                    if(isset($_SESSION['info'])){
                        ?>
            <div class="alert alert-success text-center">
                <?php echo $_SESSION['info']; ?>
            </div>
            <?php
                    }
            ?>
            <?php
                    if(count($errors) > 0){
                        ?>
            <div class="alert alert-danger text-center">
                <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
            </div>
            <?php
                    }
                    ?>
            <div class="form-inputs">
                <input type="number" name="otp" placeholder="Enter verification code" required>
            </div>
                <button type="submit" class="form-control-button" name="check">check</button>
                
            
        </div>
    </form>


</body>

</html>