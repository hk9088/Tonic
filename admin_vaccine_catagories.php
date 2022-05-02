<?php include('server.php')?>
<?php if(!empty($_SESSION['admin_id'])):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\admin_home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="m-4">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <label>
                        Admin
                    </label>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="admin_homepage.php" class="nav-item nav-link ">Dashboard</a>
                        <a href="admin_vaccine_information.php" class="nav-item nav-link ">Vaccine Information</a>
                        <a href="admin_vaccine_catagories.php" class="nav-item nav-link active">Vaccine Catagories</a>                
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a href="logout.php" class="nav-item nav-link">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <form action="admin_vaccine_catagories.php" method="POST">
        <div class="form_grid">
            <div class="row">

                <div class="col">
                    <div class="form" id="approve">
                        <?php if(isset($_SESSION['info'])){ ?>
                            <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php }?>
                        <?php if(count($errors) > 0){?>
                            <div class="alert alert-danger text-center">
                                <?php
                                foreach($errors as $showerror){
                                    echo $showerror;
                                }
                                ?>
                            </div>
                            <?php } ?>
                        <?php unset($_SESSION['info']) ;?>
                        <label class = "entry">
                            Catagory Name:
                        </label>
                        <input type="text" name="vaccine_cat_add" >
                        <br>
                        <div class="form_button">
                            <button class="btn btn-success" name="add_cat_info" >ADD</button>
                        </div>
                        
                        
                    </div>


                </div>

                <div class="col">
                    <div class="form" id="approve">
                        <?php if(isset($_SESSION['info'])){ ?>
                            <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php }?>
                        <?php if(count($errors) > 0){?>
                            <div class="alert alert-danger text-center">
                                <?php
                                foreach($errors as $showerror){
                                    echo $showerror;
                                }
                                ?>
                            </div>
                            <?php } ?>
                        <?php unset($_SESSION['info']) ;?>
                        <div class = "select_box">
                            <label class = "label_info">Catagory ID  : </label>
                            <select name="select_cat_id_to_update" id="svcu1">
                                <option value=""></option>
                                <?php
                                    $list = mysqli_query($con,"SELECT *from vaccine_catagories");
                                    $options= '';
                                    while($row_list = mysqli_fetch_assoc($list)){
                                        $options .=  "<option value=\"". $row_list["catagory_id"] ."\">" . $row_list["catagory_id"]."</option>";
                                    }
                                    echo $options;
                                ?>
                            </select>
                        </div>
                        <label class = "entry">
                            Catagory Name:
                        </label>
                        <input type="text" name="vaccine_cat_update" >
                        <br>
                        
                        <div class="form_button">
                            <button class="btn btn-success" name="update_cat_info">UPDATE</button>
                        </div>
                        
                        
                    </div>


                </div>

            </div>
        </div>

        <div class="form" id="table">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Catagory ID</th>
                        <th>Catagory Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $list = mysqli_query($con,"SELECT * from vaccine_catagories");
                        while($row_list = mysqli_fetch_assoc($list)){
                            echo "<tr><td>".$row_list['catagory_id']."</td><td>".$row_list['catagory_name']."</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

    
    </form>
    
</body>
<?php endif; ?>
</html>