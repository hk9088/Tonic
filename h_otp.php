<?php require_once "server.php"; ?>
<?php 
$h_mail = $_SESSION['Email'] ;
if(empty($_SESSION['Email'])){
  header('Location: hospital_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="css\hospital_home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div>
        <a href="hospital_login.php" ><img src="image/btn-hospital.png"></a>
    </div>
    <form action="h_otp.php" method="POST" autocomplete="off">
        <div class ="form" id="otp">
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
                <button type="submit" class="btn btn-success" name="h_check">check</button>
                
        </div>
    </form>


</body>

</html>