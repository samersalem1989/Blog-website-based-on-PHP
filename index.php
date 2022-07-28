<?php include "includes/db.php"; ?>

<?php include "includes/header.php"; ?>


    <?php include "includes/navigation.php"; ?>
    
    <div class="main-wrapper">

    <?php include "includes/sidebar.php"; ?>
    <?php if (isset($_SESSION['username'])){ ?>
                <button type="button" class="btn btn-primary mb-5" onclick="location.href='add_post.php'">Add New Post <i class="fas fa-plus fa-sm"></i></button>
    <?php }?>
	    
        <section class="blog-list px-3 py-5 p-md-5">
		    <div class="container single-col-max-width">
            
            <?php 
            if(isset($_GET['status'])){
            echo '<h6 class="mb-5 text-success">Your post has been added successfully!</h6>';
            }
            if(isset($_GET['delete'])){
                echo '<h6 class="mb-5 text-danger">Your post has been deleted!</h6>';
                }
            ?>
            <?php 
                    $query='SELECT * FROM posts ORDER BY post_id DESC';
                    $select_all_posts_query=mysqli_query($connection,$query);
                    while($row=mysqli_fetch_array($select_all_posts_query)){
                        $post_title=$row['post_title'];
                        $post_author=$row['post_author'];
                        $post_date=$row['post_date'];
                        $post_content=$row['post_content'];
                        $post_id=$row['post_id'];
                        $post_img=$row['post_image']; 
                        $post_author_image = $row['post_author_image'];  

                $comments_query= "SELECT * FROM comments Where comment_post_id = {$post_id}";
                $select_all_comments_query=mysqli_query($connection,$comments_query);
                $number_of_Comments = mysqli_num_rows($select_all_comments_query);
                                
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
                            <div class="meta mb-1"><span class="date">Published on <?php echo $post_date ?></span><span><?php echo "<img class='rounded-circle' style='width:24px; height:24px;' src='./assets/images/$post_author_image' alt='image'"?></span><span class="time text-success"> by <?php echo '<b>'. ucfirst($post_author) .'</b>' ?></span> <span class="comment"><a class="text-link" href="post.php?id=<?= $post_id;?>"> <?php echo $number_of_Comments?> comments</a></span></div>
                            <div class="intro" style="display: -webkit-box;-webkit-line-clamp: 4;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;"><?php echo $post_content ?></div>
                            <a class="text-link" href="post.php?id=<?= $post_id;?>">Read more &rarr;</a>
                    </br>
            <?php if (isset($_SESSION['username']) && $_SESSION['username'] == $post_author){?>
                <button type="button" class="btn btn-primary mt-3" onclick="location.href='edit_post.php?id=<?= $post_id;?>'">Edit</button>
                <button type="button" class="btn btn-danger mt-3" onclick="location.href='delete_post.php?id=<?= $post_id;?>'">Delete</button>      
            <?php 
              }
              ?>
					    </div><!--//col-->
				    </div><!--//row-->
			    </div><!--//item-->
                <?php
                    }    
                ?>
				
		    </div>
            
	    </section>

        </div>

   <?php include "includes/footer.php" ?>