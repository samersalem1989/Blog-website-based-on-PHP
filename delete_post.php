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

    // Post to delete
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


    // Delete the post
    if (isset($_POST['deletebtn'])){

        $stmt = mysqli_prepare($connection, "DELETE FROM posts WHERE post_id= ?");
        mysqli_stmt_bind_param($stmt,'d',$post_id);
        $delete_post = mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($connection, "DELETE FROM comments WHERE comment_post_id= ?");
        mysqli_stmt_bind_param($stmt,'d',$post_id);
        $delete_comments = mysqli_stmt_execute($stmt);
        
        if($delete_post && $delete_comments ){
            header('location:index.php?delete=success');   
        }else {
              echo "Error deleting record: " . mysqli_error($conn);
            }
        
        mysqli_stmt_close($stmt);
    }
    ?>

<section class="blog-list px-3 py-5 p-md-5 ">

	<div class="container single-col-max-width  ">

    <div class="item mb-5 ">
		<div class="row g-3 g-xl-0 ">
            <h2 class="mb-5 mt-5 d-flex justify-content-center" style="color:red"><b><u>Are You Sure You Want To Delete Your Post?</u></b></h2>
            <div class="col">
                <h1 class="d-flex justify-content-center"><?php echo $post_title ?></h1>
                <hr />
                <div class="d-flex justify-content-center">
                <img class="col-2 col-xl-3" src="images/<?php echo $post_image; ?>" alt="blog image"/>
                </div>
                <hr />

               
              </div>

                <form method="post" class="d-flex justify-content-center">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                    <button type="button" class="btn btn-primary mt-3" onclick="location.href='index.php'">Cancel</button>
                    <button type="submit" name="deletebtn" class="btn btn-danger mt-3">Delete</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php" ?>