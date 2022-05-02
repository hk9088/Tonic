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
                        <a href="admin_homepage.php" class="nav-item nav-link active">Dashboard</a>
                        <a href="admin_vaccine_information.php" class="nav-item nav-link ">Vaccine Information</a>  
                        <a href="admin_vaccine_catagories.php" class="nav-item nav-link ">Vaccine Catagories</a>                
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a href="logout.php" class="nav-item nav-link">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <form action="admin_homepage.php" method="POST">
        <div class="form_grid">
            <div class="row">
                <div class="col" >
                    <button class="not_verfied" name="admin_btn_notverified">
                        Not Verified
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from hospitals where  h_status = 'notverified'");
                            echo mysqli_num_rows($result);
                        ?>
                    </button>
                </div>
                
                <div class="col">
                    <button class="verified" name="admin_btn_verified">
                        Verified
                        <br>
                        <?php
                            $result = mysqli_query($con,"SELECT *from hospitals where  h_status = 'verified'");
                            echo mysqli_num_rows($result);
                        ?>            
                    </button>
                </div>
            </div>

        </div>
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
                <label class = "label_info">Select Hospital to Approve  : </label>
                <select name="select_hospital_to_approve" id="sha1">
                    <option value=""></option>
                    <?php
                        $list = mysqli_query($con,"SELECT *from hospitals where h_status = 'notverified'");
                        $options= '';
                        while($row_list = mysqli_fetch_assoc($list)){
                            $options .=  "<option value=\"". $row_list["hospital_id"] ."\">" . $row_list["hospital_name"]."</option>";
                        }
                        echo $options;
                    ?>
                </select>
            </div>
            
            <div class="form_button">
                <button type='submit' name='submit_hos_approve' class="btn btn-success">Approve</button>
            </div>
            
        </div>
        <div class="form" id="table">
            <div class = "form_button">
                <div class="entry">
                    <label>Search by name : </label>
                    <input type="text"  name="search-hospital-name">
                    <button class="btn btn-success" name="search_hospital_name">SEARCH</button>
                    <button class="btn btn-success" name="show_all_hospitals">SHOW ALL</button>
                </div>
            </div>
            
            <?php $status = $_SESSION['search_status']; ?>
            <?php if($status == 'verified'):?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Hospital ID</th>
                            <th>Hospital Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>License Number</th>
                            <th>Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($_SESSION['search_name'] == ''){
                                $list = mysqli_query($con,"SELECT *from hospitals where  h_status = 'verified'");
                                while($row_list = mysqli_fetch_assoc($list)){
                                    echo "<tr><td>".$row_list['hospital_id']."</td><td>".$row_list['hospital_name']."</td><td>".$row_list['h_email']."</td><td>".$row_list['h_contact']."</td><td>".$row_list['h_license_number']."</td><td>".$row_list['h_address']."</td><td>".$row_list['h_status']."</td></tr>";
                                }
                            }
                            else{
                                $search_name = strtolower($_SESSION['search_name'].trim(" "));
                                $list = mysqli_query($con,"SELECT *from hospitals where  h_status = 'verified'");

                                while($row_list = mysqli_fetch_assoc($list)){
                                    $temp = strtolower($row_list['hospital_name'].trim(" "));
                                    if ($search_name == $temp)
                                    {
                                        echo "<tr><td>".$row_list['hospital_id']."</td><td>".$row_list['hospital_name']."</td><td>".$row_list['h_email']."</td><td>".$row_list['h_contact']."</td><td>".$row_list['h_license_number']."</td><td>".$row_list['h_address']."</td><td>".$row_list['h_status']."</td></tr>";

                                    }

                                }

                            }
                            
                        ?>
                    </tbody>
                </table>
            <?php else:?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Hospital ID</th>
                            <th>Hospital Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>License Number</th>
                            <th>Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($_SESSION['search_name'] == ''){
                                $list = mysqli_query($con,"SELECT *from hospitals where h_status = 'notverified'");
                                while($row_list = mysqli_fetch_assoc($list)){
                                    echo "<tr><td>".$row_list['hospital_id']."</td><td>".$row_list['hospital_name']."</td><td>".$row_list['h_email']."</td><td>".$row_list['h_contact']."</td><td>".$row_list['h_license_number']."</td><td>".$row_list['h_address']."</td><td>".$row_list['h_status']."</td></tr>";
                                }
                            }
                            else{
                                $search_name = strtolower($_SESSION['search_name'].trim(" "));
                                $list = mysqli_query($con,"SELECT *from hospitals where  h_status = 'verified'");

                                while($row_list = mysqli_fetch_assoc($list)){
                                    $temp = strtolower($row_list['hospital_name'].trim(" "));
                                    if ($search_name == $temp)
                                    {
                                        echo "<tr><td>".$row_list['hospital_id']."</td><td>".$row_list['hospital_name']."</td><td>".$row_list['h_email']."</td><td>".$row_list['h_contact']."</td><td>".$row_list['h_license_number']."</td><td>".$row_list['h_address']."</td><td>".$row_list['h_status']."</td></tr>";

                                    }

                                }

                            }
                            
                        ?>
                    </tbody>
                </table>

            <?php endif; ?>
        </div>


    </form>
</body>
<?php endif; ?>
</html>