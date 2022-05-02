<?php include('server.php')?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\mystyle1.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body id="h_">

    <div class="btn-user-homepage">
        <a href="homepage.php" ><img src="image/btn-user-homepage.png"></a>
    </div>
    <div class="btn-admin">
        <a href="hospital_staff_login.php" ><img src="image/btn-hospital-staff.png"></a>
    </div>
    <div class=h_form>
        <label class="label">
            <h1>Hosptial Admin</h1>
        </label>
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
        <form action="hospital_login.php" method="POST">
            <div class="form-inputs">
                <input type="text"          placeholder="Email"  name="h_email" required>
            </div>
            <div class="form-inputs">
                <input type="password"      placeholder="Password"  name="h_Password" required>
            </div>

            <button type="submit" class="h_btn-login" name="login_hospital">LOGIN</button>
            <label class="label-signup"><a href="hospital_signup.php">Sign up</a> </label>

            <div class="foot-lnk">
                <br><a href="">Forgot Password?</a></br>
            </div>
        </form>
    </div>
    <footer class="text-center">
        <a class="text-dark" href="admin_login.php">Admin Panel</a>
    </footer>

</body>

</html>