<?php include('server.php')?>


<?php if(!empty($_SESSION['Username'])):?>

<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\user_home.css">
    


</head>

<body>
    <form action="user_profile.php" method="POST">
        <header>
            <img src="image\logo.png" class="logo">
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
            
            <div class="form-inputs">
                <input type="text"      placeholder="Full Name"          name="Full_name" required>
            </div>
            <div class="form-inputs">
                <input type="text"      placeholder="Mobile No."               name="Mobile_no" required>
            </div>
            <div class="form-inputs">
                <input type="text"     placeholder="Address"     name="Address" required>
            </div>
            
            
            
            <button type="submit" class="btn-reg" name="update_user">Update</button>
 

        </div>

    </form>
</body>


<?php endif; ?>