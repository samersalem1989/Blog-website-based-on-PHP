<?php ob_start(); ?>

<?php
	// Logout
    if (isset($_POST["logoutbtn"])){
        unset($_SESSION["username"]);
		unset($_SESSION['image']);
        header("Location:login.php");     
    }
?>
<?php
	if(isset($_POST["uploadimg"])){
	// Upload profile image
		htmlspecialchars( basename($_FILES["profile_image"]["name"]), ENT_QUOTES);
		$profile_image = htmlspecialchars($_POST['profile_image'], ENT_QUOTES);
		$username = $_SESSION["username"];

		$targetDir = "assets/images/";
		$profile_image = htmlspecialchars( basename($_FILES["profile_image"]["name"]), ENT_QUOTES);
        $targetFilePath = $targetDir . $profile_image;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    
		$allowTypes = array('jpg','png','jpeg','gif','pdf');
		if(in_array($fileType, $allowTypes)){
			if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)){
				$stmt = mysqli_prepare($connection, "UPDATE users SET user_image = ? WHERE username = ?");
				mysqli_stmt_bind_param($stmt,'ss',$profile_image,$username);
				mysqli_stmt_execute($stmt);
				$_SESSION['image']= $profile_image;

				$stmt_post_image = mysqli_prepare($connection, "UPDATE posts SET post_author_image = ? WHERE post_author = ?");
				mysqli_stmt_bind_param($stmt_post_image,'ss',$profile_image,$username);
				mysqli_stmt_execute($stmt_post_image);
		
				header("Location: index.php");
		
				if (!$stmt){
					die("Query Failed" . mysqli_error($connection));
				}
		
				mysqli_stmt_close($stmt);
		
		}
	}}
?>

<header class="header text-center">
		<?php
		 if (isset($_SESSION['username'])){ 
		//  Display username
		$username = ucfirst($_SESSION['username']);
		echo "<h1 class='blog-name pt-lg-4 mb-0'><a class='no-text-decoration' href='index.php'>$username's Blog</a></h1>";
		 }else {
		echo "<h1 class='blog-name pt-lg-4 mb-0'><a class='no-text-decoration' href='index.php'>Samer's Blog</a></h1>";
		 } 
		 ?>        

	    <nav class="navbar navbar-expand-lg navbar-dark" >
           
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div id="navigation" class="collapse navbar-collapse flex-column" >
				<div class="profile-section pt-3 pt-lg-0">
					<?php 
					//Display profile image
					if (isset($_SESSION['image'])){
					$userimage = $_SESSION['image'];
					 echo "<img id='myimg' class='mb-3 rounded-circle mx-auto' src='assets/images/$userimage' alt='image' >";
					}
					
					if (isset($_SESSION['username'])){
					if (empty($_SESSION['image'])){ 
					?>			
					<img id='myimg' class='mb-3 rounded-circle mx-auto' src='assets/images/default.jpg' alt='image' >					
					<?php
					}}

					if (!isset($_SESSION['username'])){
					if (!isset($_SESSION['image'])){
						echo "<img id='myimg' class='mb-3 rounded-circle mx-auto' src='assets/images/profilee.jpg' alt='image' >";
					}}
					if (isset($_SESSION['username'])){
					?>
					<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
					<input name='profile_image' type="file" id="files" style="display:none;"/>
					<label for="files">Select image <i class="fas fa-upload"></i></label>
					<label><input type="submit" name="uploadimg" class="btn btn-primary" value="upload"></label>				
					</form>
					<?php }?>
					<hr>
					<?php if (!isset($_SESSION['username'])){ ?>
					<div class="bio mb-3">Hi, my name is Samer Salem. I'm a fullstack developer. I hope you like my php project.<br></div><!--//bio-->
					<?php }else{
						//  Display username
						$username = strtoupper($_SESSION["username"]);
						echo "<div class='bio mb-3'>Hi $username.I hope you like my php project. <br></div>";
						} ?>

					 <ul class="social-list list-inline py-3 mx-auto">
					 <li class="list-inline-item"><i class="far fa-smile-wink fa-lg"></i></li>
					 <li class="list-inline-item"><i class="far fa-laugh-squint fa-lg"></i></li>
					 <li class="list-inline-item"><i class="far fa-laugh-beam fa-lg"></i></li>
					 <li class="list-inline-item"><i class="far fa-grin-tongue-squint fa-lg"></i></li>
			        </ul>

			        <hr> 
				</div><!--//profile-section-->
				
				<ul class="navbar-nav flex-column text-start">
					<li class="nav-item">
						<a class="<?php echo (basename($_SERVER['PHP_SELF']) == "index.php" ? "nav-link active" : "nav-link")?>" href="index.php"><i class="fas fa-home fa-fw me-2"></i>Blog Home</a>
					</li>
					<li class="nav-item">
					    <a class="<?php echo (basename($_SERVER['PHP_SELF']) == "blog-post.php" ? "nav-link active" : "nav-link")?>" href="blog-post.php"><i class="fas fa-bookmark fa-fw me-2"></i>My Posts</a>
					</li>
					<?php if (!isset($_SESSION['username'])){ ?> 
					<li class="nav-item">
					    <a class="<?php echo (basename($_SERVER['PHP_SELF']) == "about.php" ? "nav-link active" : "nav-link")?>" href="about.php"><i class="fas fa-user fa-fw me-2"></i>About Me</a>
					</li>
					<?php }?>
				</ul>
				
                <?php if (!isset($_SESSION['username'])){ ?>                      
                    <div class="my-2 my-md-3">
				    <a class="btn btn-primary" href="register.php">Register</a>
                    <a class="btn btn-primary" href="login.php">Login</a>
				</div>
                   <?php }?>

				
                <?php if (isset($_SESSION['username'])){ ?>                      
                    <form method="post">
					<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                    <input type="submit" name="logoutbtn" class="btn btn-primary mt-3" value="Logout">
                    </form> 
                   <?php }?>
			</div>
		</nav>
    </header>
