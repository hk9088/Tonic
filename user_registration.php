<?php include('server.php')?>

<?php if(!empty($_SESSION['Username'])):?>
    <?php if(!empty($_SESSION['reg_vac_id'])):?>
    
<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\user_home.css">
    


</head>

<body>
    <form action="user_registration.php" method="POST">
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

        <div class="form" id="registration">
            <div class="labels" >
                <label class="label_info">Selected Catagory:</label>
                <label class="label_data">
                    <?php   
                        $vac_id = $_SESSION['reg_vac_id'];
                        $fetch_catagory_id = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From vaccine WHERE vaccine_id = '$vac_id'"));
                        $cat_id = $fetch_catagory_id['catagory_id'];
                        $fetched_catagory_name= mysqli_fetch_assoc(mysqli_query($con,"SELECT * From vaccine_catagories WHERE catagory_id = '$cat_id'"));
                        $cat_name = $fetched_catagory_name['catagory_name'];
                        echo $cat_name;
                    ?>

                </label>
            </div>

            <div class="labels">
                <label class="label_info">Selected Vaccine:</label>
                <label class="label_data">
                    <?php   
                        $vac_id = $_SESSION['reg_vac_id'];
                        $fetch_vac_info = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From vaccine WHERE vaccine_id = '$vac_id'"));
                        $vac_name = $fetch_vac_info['vaccine_name'];
                        echo $vac_name;
                    ?>

                </label>
            </div>

            <div class = "select_box">
            <label class = "label_info">Hospitals Available  :</label>
                <select name="select_hospital" id="sb1">
                    <?php
                        $list = mysqli_query($con,"SELECT * from inventory where vaccine_id = '$vac_id' ORDER BY available_quantity DESC");
                        while($row_list = mysqli_fetch_assoc($list)){
                            if((int)$row_list['available_quantity']>0){
                            $h_id = $row_list['hospital_id'];
                            $status = "verified";
                            $result = mysqli_query($con,"SELECT * from hospitals where hospital_id = '$h_id' and h_status = '$status'");
                            $options= '';
                            while($list_of_hospital = mysqli_fetch_assoc($result)){
                                $options .=  "<option value=\"". $list_of_hospital["hospital_id"] ."\">" . $list_of_hospital["hospital_name"]."</option>";
                            }
                            echo $options;
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="btn-confirm_button">
                <button type ="submit" name = submit_vac_req class="btn-vac-reg">Confirm</button>

            </div>



            
        </div>

        <div class="form" >
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Hospital Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $vac_id = $_SESSION['reg_vac_id'];
                        $list = mysqli_query($con,"SELECT * from inventory where vaccine_id = '$vac_id' ORDER BY available_quantity DESC");
                        while($row_list = mysqli_fetch_assoc($list)){
                            if((int)$row_list['available_quantity']>0){
                            $h_id = $row_list['hospital_id'];
                            $result = mysqli_query($con,"SELECT * from hospitals where hospital_id = '$h_id' and h_status = '$status'");
                            $options= '';
                            while($list_of_hospital = mysqli_fetch_assoc($result)){
                                echo "<tr><td>".$list_of_hospital['hospital_name']."</td><td>".$list_of_hospital['h_contact']."</td><td>".$list_of_hospital['h_email']."</td><td>".$list_of_hospital ['h_address']."</td></tr>";
                            }
                            
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
    </form>
    
</body>

    <?php endif; ?>
<?php endif; ?>