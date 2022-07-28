<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>
      <?php 
                if (isset($_GET['id'])){
                    $the_post_id = htmlspecialchars($_GET["id"], ENT_QUOTES);
                }

                $stmt = mysqli_prepare($connection, "SELECT * FROM posts WHERE post_id = ?");
                mysqli_stmt_bind_param($stmt,'d',$the_post_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                while ($row = mysqli_fetch_array($result)){
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
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
                ?>

    <div class="main-wrapper">
    <?php include "includes/sidebar.php" ?>

        <div class="row">
        <div class="container single-col-max-width px-3 py-5 p-md-5">
                <h1><?php echo $post_title ?></h1>
                <hr />
                <p>Posted on <?php echo $post_date ?></p>
                <img class="blog-img mb-3" src="images/<?php echo $post_image; ?>" alt="blog image"/>
                <p class="lead">by <?php echo '<b>'. ucfirst($post_author) .'</b>' ?></p>
                <hr/>

                <?php
                 $first_letter = $post_content[0];
                 $post_content = ltrim($post_content, $first_letter);
                 $wallpost=nl2br($post_content);
                 ?>
                <p class="lead" id="article">
                    <?php echo "<span class='fs-1 text-primary'><b>$first_letter</b></span>$wallpost "?>
                </p>
                <hr />


                <?php 

                    if (isset($_POST['create_comment'])){

                            $the_post_id = htmlspecialchars($_GET['id'], ENT_QUOTES);
                            $comment_content = htmlspecialchars($_POST['comment_content'], ENT_QUOTES);
                            $comment_author = $_SESSION['username'];

                      
                            $stmt = mysqli_prepare($connection, "INSERT INTO comments (comment_post_id, comment_author, comment_content, comment_date)
                            VALUES (?, ?, ?, ?)");
                            date_default_timezone_set("Israel");
                            $comment_date = date("Y/m/d h:i:sa");
                           mysqli_stmt_bind_param($stmt,'dsss',$the_post_id,$comment_author,$comment_content,$comment_date);
                           mysqli_stmt_execute($stmt);
                           header("Location: post.php?id=$the_post_id");
                       
                           if (!$stmt){
                               die("Query Failed" . mysqli_error($connection));
                           }
                       
                           mysqli_stmt_close($stmt);
                       
                    }

                ?>

                <?php if (isset($_SESSION['username'])){ ?>
                <div class="well">
                    <h4>Leave a Comment</h4>
                    <form action="" method="post">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                        <div class="form-group pb-3">
                            <textarea class="form-control" row="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>
                <?php }else{
                    echo '<h4 class="text-danger"> *** Please Login to leave a comment! ***</h4>';
                }
                ?>


                <hr>
                <h5 class="mb-3 bg-warning"><b>*Comments <i class="far fa-comment-dots"></i></b></h5>

                <?php 
                
                    $stmt = mysqli_prepare($connection, "SELECT * FROM comments WHERE comment_post_id = ? ORDER BY comment_id");
                    mysqli_stmt_bind_param($stmt,'d',$the_post_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($result)>0){
                    $comment_number=0;
                    while ($row = mysqli_fetch_array($result)){
                        $comment_author = $row['comment_author'];
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_number++;
                ?>


                <div class="media">
                    <h6 class="media-heading mt-2"><?php echo "$comment_number. $comment_content" ?></h6>
                    <?php                        
                        echo '<small><b>'. ucfirst($comment_author).'</b> '. $comment_date. '</small>';
                    ?>
                </div>



                <?php
                    }}
                    if (!$stmt){
                        die("Query Failed" . mysqli_error($connection));
                    }

                    mysqli_stmt_close($stmt);

                ?>
            </div>
        </div>
    </div>
    <?php include "includes/footer.php" ?>