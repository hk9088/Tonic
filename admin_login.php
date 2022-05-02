<?php include('server.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\admin_home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body >
    <div class="top_buttons">
        <a href="homepage.php"><button type="button" class="btn btn-secondary">User Homepage</button></a>
        <a href="hospital_login.php"><button type="button" class="btn btn-secondary">Hospital Login Page</button></a>
    </div>
    <div class="form">
        <?php if(count($errors) > 0){?>
            <div class="alert alert-danger text-center">
                <?php
                foreach($errors as $showerror){
                    echo $showerror;
                }
                ?>
            </div>
        <?php } ?>
        <label class="label">
            <h1>Admin</h1>
        </label>
        <form action="admin_login.php" method="POST">
            <div class="form-inputs">
                <input type="text"          placeholder="Username"  name="admin_username" required>
            </div>
            <div class="form-inputs">
                <input type="password"      placeholder="Password"  name="admin_password" required>
            </div>

            <button type="submit" class="btn btn-success" name="login_admin">LOGIN</button>

        </form>
    </div>
</body>
</html>