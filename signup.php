<?php include('server.php')?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\mystyle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <form action="signup.php" method="POST">
        
        <div class="form">
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
                <input type="text"      placeholder="Username"          name="Username" required>
            </div>
            <div class="form-inputs">
                <input type="password"  placeholder="Password"          name="Password_1" required>
            </div>
            <div class="form-inputs">
                <input type="password"  placeholder="Repeat Password"   name="Password_2" required>
            </div>
            <div class="form-inputs">
                <input type="email"     placeholder="Email Address"     name="Email" required>
            </div>
            <div class="form-inputs">
                <input type="text"      placeholder="NID"               name="NID" required>
            </div>
            <div class="form-inputs">
                <label for="Date of birth" class="label_dob"      >Date of birth</label>
                <input type="date" id="datefield"  min='1899-01-01' max='2000-13-13' name="Dob" required>
                <script>
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth() + 1; //January is 0!
                    var yyyy = today.getFullYear();

                    if (dd < 10) {
                    dd = '0' + dd;
                    }

                    if (mm < 10) {
                    mm = '0' + mm;
                    } 
                        
                    today = yyyy + '-' + mm + '-' + dd;
                    document.getElementById("datefield").setAttribute("max", today);
                </script>
            </div>
            
            
            <button type="submit" class="btn-reg" name="reg_user">SIGN UP</button>

            <div class="foot-lnk">
                <a href="homepage.php">Already Member?</a>
            </div>  

        </div>
    </form>

    
    <footer class="text-center">
        <a class="text-dark" href="admin_login.php">Admin Panel</a>
    </footer>

</body>

</html>