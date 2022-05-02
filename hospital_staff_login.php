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
    <div class="btn-hospital">
        <a href="hospital_login.php" ><img src="image/btn-hospital.png"></a>
    </div>
    <div class=h_form>
        <label class="label">
            <h1>Hosptial Staff</h1>
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
        <form action="hospital_staff_login.php" method="POST">
            <div class="form-inputs">
                <input type="text"          placeholder="Hospital Email"  name="h_email" required>
            </div>
            <div class="form-inputs">
                <input type="text"          placeholder="Username"  name="s_username" required>
            </div>
            <div class="form-inputs">
                <input type="password"      placeholder="Password"  name="s_password" required>
            </div>

            <button type="submit" class="h_btn-login" name="login_hospital_staff">LOGIN</button>

        </form>
    </div>
    <footer class="text-center">
        <a class="text-dark" href="admin_login.php">Admin Panel</a>
    </footer>

</body>

</html>