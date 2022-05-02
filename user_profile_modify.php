<?php include('server.php')?>


<?php if(!empty($_SESSION['Username'])):?>

<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\user_home.css">
    


</head>

<body>
    <form action="user_profile_modify.php" method="POST">
        <header>
        <a href="user_homepage.php"><img src="image\logo.png" class="logo"></a>
            <nav>

                <ul class="nav_links">
                    <li><button type='submit' class='btn-nav' name='vac_status'>Dashboard</button></li>
                    <li><button type='submit' class='btn-nav' name='vac_info_user'>Vaccine Information</button></li>

                </ul>
            </nav>
            <div>
                <a href="user_profile_modify.php" title="Profile"><img src="image\user.png" class="profile_icon"></a>
                <a href="logout.php" title="Logout"><img src="image\logout.png" class="logout_icon"></a>
            </div>
        </header>
        <div class="form" id="profile">
        <label class="label"><h3>Profile</h3></label>
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
            <?php
                $username = $_SESSION['Username'];
                $sql = "SELECT * from users WHERE username = '$username' limit 1";
                $result = mysqli_query($con,$sql);
                $result = mysqli_fetch_assoc($result);
                $name =   $result['name'];
                $address = $result['address'];
                $mobile = $result['mobile'];


            ?>
            
            <div class="form-inputs">
                <input type="text"      value="<?php echo $name;?>"          name="Full_name">
            </div>
            <div class="form-inputs">
                <input type="text"      value="<?php echo $mobile;?>"               name="Mobile_no"  >
            </div>
            <div class="form-inputs">
                <input type="text"     value="<?php echo $address;?>"     name="Address"  >
            </div>
            
            
            
            <button type="submit" class="btn-reg" name="update_user">Update</button>
            <button type="submit" class="btn-reg" name="update_otp">Change Password</button>
 

        </div>

    </form>
</body>


<?php endif; ?>