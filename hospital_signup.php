<?php include('server.php')?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\mystyle1.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body id="h_">
    <div class="btn-user-homepage">
        <a href="homepage.php" ><img src="image/btn-user-homepage.png"></a>
    </div>

    <form action="hospital_signup.php" method="POST">
        <div class="h_form">
            <label class="label"><h1>Sign up</h1></label>
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
                <input type="text"      placeholder="Hospital Name"     name="hospital_name" required>
            </div>
            <div class="form-inputs">
                <input type="text"      placeholder="License Number"    name="hospital_license_number" required>
            </div>
            <div class="form-inputs">
                <input type="password"  placeholder="Password"          name="hospital_password_1" required>
            </div>
            <div class="form-inputs">
                <input type="password"  placeholder="Repeat Password"   name="hospital_password_2" required>
            </div>
            <div class="form-inputs">
                <input type="email"     placeholder="Email Address"     name="hospital_email" required>
            </div>
            <div class="form-inputs">
                <input type="text"      placeholder="Contact Number"    name="hospital_contact_number" required>
            </div>
            <div class="form-inputs">
                <input type="text"      placeholder="Hospital Address"    name="hospital_address" required>
            </div>
            
            
            
            
            <button type="submit" class="h_btn-reg" name="reg_hospital">SIGN UP</button>

            <div class="foot-lnk">
                <a href="hospital_login.php">Already Member?</a>
            </div>  

        </div>
    </form>

    
    <footer class="text-center">
        <a class="text-dark" href="admin_login.php">Admin Panel</a>
    </footer>

</body>

</html>