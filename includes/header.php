<?php
         function sessionstart($lifetime,$path,$domain,$secure,$httponly){
            session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
            session_start();
        }
        
        sessionstart(0,'/','localhost',true,true);
?>

<?php 
        // if ($_POST){
        //         if($_SESSION['token'] != $_POST['token']){
        //             die('Invalid token!');
        //         }
        //      }
        
        $_SESSION['token'] = md5(uniqid(mt_rand(),true));

?>


<?php include "admin/functions.php" ?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>DevBlog - A Blog Made For All Blogers</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog Template">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="favicon.ico"> 
    <link rel="stylesheet" href="css/post.css">
    <!-- FontAwesome JS-->
	<script defer src="assets/fontawesome/js/all.min.js"></script>
    
    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="assets/css/theme-6.css">
    <link rel="stylesheet" href="assets/css/navigation.css">

    <script src="assets/plugins/popper.min.js"></script> 
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script> 

</head> 

<body>
