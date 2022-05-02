<?php include('server.php')?>


<?php if(!empty($_SESSION['Username'])):?>

<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\user_home.css">
    


</head>

<body>
    <form action="user_otp_password.php" method="POST">
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
            <label class="label">
                <h3 class="text-center">Code Verification</h3>
            </label>
            <?php echo $_SESSION['info']; ?>
            <div class="form-inputs">
                <input type="number" name="otp" placeholder="Enter verification code" required>
            </div>
                <button type="submit" class="form-control-button" name="check_pass_otp">check</button>

        </div>

    </form>
</body>


<?php endif; ?>