<?php include('server.php')?>


<?php if(!empty($_SESSION['Username'])):?>
<head>
    <title>Tonic</title>
    <link rel="stylesheet" href="css\user_home.css">
    


</head>

<body>
    <form action="user_homepage.php" method="POST">
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
        <div class="form">
            <div class = "select_box">
                <label>Search By Catagory  :</label>
                <select name="select_vac_cat" id="s_v_c1" >
                    <option value=""></option>
                <?php
                    $list = mysqli_query($con,"SELECT * from 	vaccine_catagories ");
                    $options= '';
                    while($row_list = mysqli_fetch_assoc($list)){
                            $options .=  "<option value=\"". $row_list["catagory_id"] ."\">" . $row_list["catagory_name"]."</option>";
                    }
                    echo $options;
                        
                ?>
                </select>
                <button type ='submit' class='btn-vac-reg' name ='user_search_by_cat_dashboard'>Search</button>
            </div>
            
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Vaccine Name</th>
                        <th>Category</th>
                        <th>Vaccination Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        
            $username = $_SESSION['Username'];
            if($_SESSION['search_cat']!==""){
                $search_cat_id = $_SESSION['search_cat'];
                $sql_1 = "SELECT * From vaccine where catagory_id = '$search_cat_id'";
            }
            else{
                $sql_1 = "SELECT * From vaccine";
            }
                
            
            $result_1 = mysqli_query($con,$sql_1);

            $sql_2 = "SELECT * From users where username = '$username'   limit 1  ";
            $result_2 = mysqli_query($con,$sql_2);
            $fetch_user_data = mysqli_fetch_assoc($result_2);
            
            if(mysqli_num_rows($result_1)){
                while($row = mysqli_fetch_assoc($result_1)){
                    
                    $user_id = $fetch_user_data['user_id'];
                    $vaccine_id = $row['vaccine_id'];

                    $fetch_vaccine_staus = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From vaccine_request Where user_id = '$user_id' AND vaccine_id = '$vaccine_id'"));
                    
                    
                    $c_id = $row['catagory_id'];
                    $fetch_catagory = mysqli_fetch_assoc(mysqli_query($con,"SELECT * From vaccine_catagories Where catagory_id = '$c_id'"));
                    
                    $check_query = mysqli_query($con,"SELECT * From vaccine_request Where user_id = '$user_id' AND catagory_id = '$c_id' ");
                    if(mysqli_fetch_assoc($check_query)){
                        continue;
                    }

                    if($fetch_vaccine_staus){
                        echo "<tr><td>".$row['vaccine_name']."</td><td>".$fetch_catagory ['catagory_name']."</td><td>".$fetch_vaccine_staus['request_status']."</td></tr>";
                    }
                    else{
                        echo "<tr>
                                <td>".$row['vaccine_name']."</td><td>".$fetch_catagory ['catagory_name']."</td>

                                <td> <button type='submit' class='btn-vac-reg' name='vac_reg' value = '$vaccine_id'>Register</button></td>
                            </tr>";

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