<?php ob_start(); ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php" ?>

<?php
    if(!isset($_SESSION['username'])){
        header("Location:index.php");
    }
?>

<?php 
    if (isset($_GET['id'])){
        $post_id = htmlspecialchars($_GET['id'], ENT_QUOTES);   
    }

    // Edit the post
    $stmt = mysqli_prepare($connection, "SELECT * FROM posts WHERE post_id = ?");
    mysqli_stmt_bind_param($stmt,'d',$post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($result)){
        $post_id = $row['post_id'];
        $post_author = $_SESSION['username'];
        $post_title = $row['post_title'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_author_image = $row['post_author_image'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];
    }
    if (!$stmt){
        die("Query Failed" . mysqli_error($connection));
    }

    mysqli_stmt_close($stmt);


    // Update the post
    if (isset($_POST['update_post'])){

        if(!empty($_FILES["image"]["name"])){
        $targetDir = "images/";
        $post_image = htmlspecialchars(basename($_FILES["image"]["name"]), ENT_QUOTES);
        // $post_image = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $post_image;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);    
        $allowTypes = array('jpg','png','jpeg','gif','pdf');

        if(in_array($fileType, $allowTypes)){
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);       
        }
        }else{
            $post_image = $post_image;
        }

        
        $post_title_new = htmlspecialchars($_POST['post_title'], ENT_QUOTES);
        $post_author = $_SESSION['username'];
        $post_tags = htmlspecialchars($_POST['post_tags'], ENT_QUOTES); 
        $post_content = htmlspecialchars($_POST['post_content'], ENT_QUOTES); 

        $stmt = mysqli_prepare($connection, "UPDATE posts SET post_title = ?,
        post_author = ? ,post_tags = ?,post_content = ?,
        post_image = ? WHERE post_id = ? ");

        mysqli_stmt_bind_param($stmt,'sssssd',$post_title_new,$post_author,$post_tags,$post_content,$post_image,$post_id);
        mysqli_stmt_execute($stmt);


        header("Location: index.php");

        if (!$stmt){
            die("Query Failed" . mysqli_error($connection));
        }

        mysqli_stmt_close($stmt);


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
            <h2 class="heading">Edit Post</h2>
         <br />

            <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                <div class="form-group">
                    <label>Post title</label>
                    <input type="text" class="form-control" name="post_title" value="<?php echo $post_title ?>"  />
                </div>


                <div class="form-group">
                    <label>Post Tags</label>
                    <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags ?>"/>
                </div>

                <div class="form-group">
                    <label>Post Content</label>
                    <textarea class="form-control" name="post_content" rows="10" cols="25" style="height:100%"><?php  echo $post_content ?></textarea>
                </div>

                <div class="form-group">
                    <img width="100" class="mt-3" src="./images/<?php echo $post_image; ?>" alt=""></br></br>
                    <input type="file" name="image"/>
                </div>


                <div class="form-group mt-5">
                <button type="button" class="btn btn-danger mt-3" onclick="location.href='index.php'">Cancel</button>
                    <input type="submit" class="btn btn-primary mt-3" name="update_post" value="Update Post" />
                </div>

            </form>

        </div>    
                
     </div>     
    </div>    
</div>
</section>

</div>


<?php include "includes/footer.php" ?>