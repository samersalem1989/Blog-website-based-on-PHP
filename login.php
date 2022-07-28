<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>

<?php
    if (isset($_POST["loginbtn"])){
        
        $username= htmlspecialchars(trim($_POST['username']), ENT_QUOTES);
        $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES);

        // Validation
        $error = [
            'username' => '',
            'password' => ''
        ];

        if ($username == ''){
            $error['username'] = 'Please fill your username';
        }

        if (strlen($username) <4){
            $error['username'] = 'Username needs to be longer';
        }

        if ($password == ''){
            $error['password'] = 'Please fill your password';
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
            login_user($username, $password);
        }
    }


?>

<div class="main-wrapper">
<section class="cta-section theme-bg-light py-5 mb-5">
<div class="container text-center single-col-max-width">
                <h2 class="heading">DevBlog - A Blog Made For All Blogers</h2>
			    <div class="intro">Welcome to my blog. Have a great & valuable time.</div>
            <div class="row mt-5">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-group">
                    <h2 class="heading mt-5">Login</h2>
                        <br />
                        <form method="post">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                            <div class="form-group">
                                <label>Username:</label>
                                <input type="text" name="username" class="form-control" >
                                <p><?php echo isset($error['username']) ? $error['username']:'' ?></p>
                            </div>
                            <br />
                            <div class="form-group">
                                <label>Password:</label>
                                <input type="password" name="password" class="form-control" >
                                <p><?php echo isset($error['password']) ? $error['password']:'' ?></p>

                            </div>
                            <br />

                            <input type="submit" name="loginbtn" class="btn btn-primary mt-4" value="Login">
 
                        </form>           
                    </div>    
                
                </div>     
            </div>    
        </div>
    </section>


</div>


<?php include "includes/footer.php" ?>