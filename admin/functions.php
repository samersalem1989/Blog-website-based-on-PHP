<?php 

    function register_user($username, $email, $password,$profile_image){
        global $connection;

        $username = mysqli_real_escape_string($connection,$username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
        //////upload image
        $targetDir = "assets/images/";
        $profile_image = basename($_FILES["profile_image"]["name"]);
        $targetFilePath = $targetDir . $profile_image;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        if(!empty($_FILES["profile_image"]["name"])){
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)){
                    // Insert image file name into database
                    $stmt = mysqli_prepare($connection, "INSERT INTO users (username, user_email, user_password, user_image)
                    VALUES(?, ?, ?,? )");
                    mysqli_stmt_bind_param($stmt,'ssss',$username,$email,$password,$profile_image);
        }
      }else{
        echo "<script> alert('Image type is not supported!');</script>";
        echo '<a href="register.php" class="mb-5 mt-5 d-flex justify-content-center" style="font-size:30px;">Try again!</a>"';

        exit();
      }
    }else{
        $stmt = mysqli_prepare($connection, "INSERT INTO users (username, user_email, user_password) 
        VALUES(?, ?, ? )");
        mysqli_stmt_bind_param($stmt,'sss',$username,$email,$password);
    }
    mysqli_stmt_execute($stmt);

    if (!$stmt){
        die("Query Failed" . mysqli_error($connection));
    }

    mysqli_stmt_close($stmt);

    }


    function login_user($username, $password){
        global $connection;
        
        $username = mysqli_real_escape_string($connection,$username);
        $password = mysqli_real_escape_string($connection, $password);

        $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt,'s',$username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result)== 0){
            echo "<script> alert('You are not registered !');</script>";
            echo '<h1 class="d-flex justify-content-center text-danger mt-5">You are not registered !</h1>';
            echo '<a href="register.php" class="mb-5 mt-5 d-flex justify-content-center" style="font-size:30px;">Register here!</a>"';
            exit();
        }else{
        
        while ($row = mysqli_fetch_array($result)){
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_image = $row['user_image'];

            if (password_verify($password, $db_user_password)){
                session_regenerate_id();
                $_SESSION['username'] = $db_username;
                $_SESSION['user_id'] = $db_user_id;
            if(!empty($db_user_image)){
                $_SESSION['image'] = $db_user_image;
            }
                header("Location:index.php");
            } else {
                echo "<script> alert('Wrong password!');</script>";
            }
        }}


        if (!$stmt){
            die("Query Failed" . mysqli_error($connection));
        }

        mysqli_stmt_close($stmt);

    }



    function add_post($post_title, $post_author,$post_image,$post_tags,$post_content,$post_date,$post_author_image){
        global $connection;

        $post_title = mysqli_real_escape_string($connection,$post_title);
        $post_author = mysqli_real_escape_string($connection, $post_author);
        $post_tags = mysqli_real_escape_string($connection, $post_tags);
        $post_content = mysqli_real_escape_string($connection, $post_content);
        date_default_timezone_set("Israel");
        $post_date = date("Y/m/d h:i:sa");


        $stmt = mysqli_prepare($connection, "INSERT INTO posts(post_title, post_content, post_author, post_date, post_image, post_tags,post_author_image)
         VALUES(?,?, ?, ?, ?, ?,?)");
        mysqli_stmt_bind_param($stmt,'sssssss',$post_title,$post_content,$post_author,$post_date,$post_image,$post_tags,$post_author_image);
        mysqli_stmt_execute($stmt);
    
        if (!$stmt){
            die("Query Failed" . mysqli_error($connection));
        }
    
        mysqli_stmt_close($stmt);
        
    }

    
    function username_exists($username){
        global $connection;

        $stmt = mysqli_prepare($connection, "SELECT username from users WHERE username = ?");
        mysqli_stmt_bind_param($stmt,'s',$username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0){
            return true;
        } else {
            return false;
        }

        if (!$stmt){
            die("Query Failed" . mysqli_error($connection));
        }
    
        mysqli_stmt_close($stmt);

    }



    function email_exists($email){
        global $connection;
        $stmt = mysqli_prepare($connection, "SELECT user_email from users WHERE user_email = ?");
        mysqli_stmt_bind_param($stmt,'s',$email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0){
            return true;
        } else {
            return false;
        }

        if (!$stmt){
            die("Query Failed" . mysqli_error($connection));
        }
    
        mysqli_stmt_close($stmt);

    }

?>