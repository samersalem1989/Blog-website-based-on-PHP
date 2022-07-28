<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>


    <div class="main-wrapper">
    <?php include "includes/sidebar.php" ?>

            <section class="blog-list px-3 py-5 p-md-5">
            <div class="container single-col-max-width">

                <!-- Blog -->
                <?php 
                    
                    if (isset($_POST['submit'])){
                        $search = htmlspecialchars("%{$_POST['search']}%", ENT_QUOTES);
                        $stmt = mysqli_prepare($connection, "SELECT post_id,post_title,post_content,post_author,post_date,post_image FROM posts WHERE post_tags LIKE ? ");
                        mysqli_stmt_bind_param($stmt,'s',$search);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt,$post_id,$post_title,$post_author,$post_date,$post_content,$post_img);
                        $result = mysqli_stmt_get_result($stmt);

                
                        while ($row = mysqli_fetch_array($result)){
                                $post_id=$row['post_id'];
                                $post_title=$row['post_title'];
                                $post_author=$row['post_author'];
                                $post_date=$row['post_date'];
                                $post_content=$row['post_content'];
                                $post_img=$row['post_image'];
                                
                ?>
        

                <div class="item mb-5">
                    <div class="row g-3 g-xl-0">
                        <div class="col-2 col-xl-3">
                            <a class="text-link" href="post.php?id=<?= $post_id;?>">
                                <img class="img-fluid post-thumb " src="./images/<?php echo $post_img; ?>" alt="image">
                            </a>
                        </div>
                        <div class="col">
                            <h3 class="title mb-1"><a class="text-link" href="post.php?id=<?= $post_id;?>"><?php echo $post_title ?></a></h3>
                            <div class="meta mb-1"><span class="date">Published on <?php echo $post_date ?></span><span class="time"> by <?php echo $post_author ?></span><span class="comment"><a class="text-link" href="#"> 8 comments</a></span></div>
                            <div class="intro" style="display: -webkit-box;-webkit-line-clamp: 4;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;"><?php echo $post_content ?></div>
                            <a class="text-link" href="blog-post.html">Read more &rarr;</a>
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//item-->
                <?php
                        if (!$stmt){
                            die("Query Failed" . mysqli_error($connection));
                        }
                                      
                        }
                        mysqli_stmt_close($stmt);
                    }
                          
                   
                    
                    ?>  
            </div>

            </section>

        

    </div>

   <?php include "includes/footer.php" ?>

</body>
</html>