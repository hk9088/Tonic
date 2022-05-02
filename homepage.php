<?php include('server.php')?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\mystyle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>


    <div class="btn-hospital">
        <a href="hospital_login.php" ><img src="image/btn-hospital.png"></a>
    </div>
    <div class="btn-admin">
        <a href="hospital_staff_login.php"><img src="image/btn-hospital-staff.png"></a>
    </div>


    <div class="covidbutton">
        <a href="#"
            onclick='window.open("https://www.worldometers.info/coronavirus/country/bangladesh/");return false;'>
            <img src="image/covid.png">
        </a>

    </div>
    <div class="btn-emergency_contacts">
        <a href="#" onclick='window.open("emergency_hospital_contacts.php");return false;'><img src="image/btn-emergency_contacts.png"></a>

    </div>

    <div class=form>
        <label class="label">
            <h1>Login</h1>
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
        <form action="homepage.php" method="POST">
            <div class="form-inputs">
                <input type="text"          placeholder="Username"  name="Username" required>
            </div>
            <div class="form-inputs">
                <input type="password"      placeholder="Password"  name="Password_1" required>
            </div>

            <button type="submit" class="btn-login" name="login_user">LOGIN</button>
            <label class="label-signup"><a href="signup.php">Sign up</a> </label>

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