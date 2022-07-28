<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>

<?php
    if (isset($_POST["registerbtn"])){
        $username= htmlspecialchars(trim($_POST['username']), ENT_QUOTES);
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES);
        $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES);
        

        if(isset($_POST["profile_image"])){

        $profile_image = htmlspecialchars($_POST['profile_image'], ENT_QUOTES);
        }else{
            $profile_image='';
        }

        // Validation
        $error = [
            'username' => '',
            'email' => '',
            'password' => ''
        ];

        if ($username == ''){
            $error['username'] = 'Username cannot be empty';
        }

        if (strlen($username) <4){
            $error['username'] = 'Username needs to be longer';
        }

        if (username_exists($username)){
            $error['username'] = 'Username alredy exists, pick another username';
        }

        if ($email == ''){
            $error['email'] = 'Email cannot be empty';
        }

        if (email_exists($email)){
            $error['email'] = 'Email alredy exists, <a href="login.php">Please login</a>';

        }

        if ($password == ''){
            $error['password'] = 'Password cannot be empty';
        }

        if (strlen($password) <6){
            $error['password'] = 'Password needs to be longer';
        }


        foreach ($error as $key => $value){
            if (empty($value)){
                unset($error[$key]);
            }
        }


        if (empty($error)){
            register_user($username, $email, $password,$profile_image);
            login_user($username, $password);
            header("Location: index.php");
        }

    }


?>

<div class="main-wrapper">
<section class="cta-section theme-bg-light py-5 mb-3">
<div class="container text-center single-col-max-width">
            <h2 class="heading">DevBlog - A Blog Made For All Blogers</h2>
			<div class="intro">Welcome to my blog. Have a great & valuable time.</div>

            <div class="row mt-5">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-group">
                        <h2 class="heading">Register</h2>
                        <br />
                        <form action="register.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                            <div class="form-group">
                                <label>Username:</label>
                                <input type="text" name="username" class="form-control" >
                                <p style="color:red;"><?php echo isset($error['username']) ? $error['username']:'' ?></p>
                            </div>
                            <br />
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="text" name="email" class="form-control" >
                                <p style="color:red;"><?php echo isset($error['email']) ? $error['email']:'' ?></p>

                            </div>
                            <br />
                            <div class="form-group">
                                <label>Password:</label>
                                <input type="password" name="password" class="form-control" >
                                <p style="color:red;"><?php echo isset($error['password']) ? $error['password']:'' ?></p>

                            </div>
                            <br />

                            <input name='profile_image' type="file" id="files" style="display:none;"/>
					        <label for="files" class="btn btn-primary">Select Image File to Upload: <i class="fas fa-upload"></i></label>

                            <br />
                            <br />
                            <input type="submit" name="registerbtn" class="btn btn-primary" value="Register">

                        </form>           
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>


<?php include "includes/footer.php" ?>