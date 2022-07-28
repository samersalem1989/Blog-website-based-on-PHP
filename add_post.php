<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>


<?php
    if(!isset($_SESSION['username'])){
        header("Location:index.php");
    }

    // Add New Post
    if (isset($_POST["create_post"])){
        
        $post_title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES);
        $post_author = $_SESSION['username'];
        $post_tags = htmlspecialchars(trim($_POST['post_tags']), ENT_QUOTES);
        $post_content = htmlspecialchars(trim($_POST['post_content']), ENT_QUOTES);
        $post_date = date('d-m-y');


        if(!empty($_SESSION['image'])){
            $post_author_image = $_SESSION['image'];
        } else {
            $post_author_image = htmlspecialchars('default.jpg', ENT_QUOTES);;
        }

    // Validation
        $error = [
            'title' => '',
            'author' => '',
            'post_tags' => '',
            'post_content' => ''
        ];

        if ($post_title == ''){
            $error['title'] = 'Title cannot be empty';
        }

        if (strlen($post_title) <2){
            $error['title'] = 'Title needs to be longer';
        }


        if ($post_tags == ''){
            $error['post_tags'] = 'Please add tags to your post';
        }

        if (strlen($post_tags) <4){
            $error['post_tags'] = 'Post Tags needs to be longer';
        }

        if ($post_content == ''){
            $error['post_content'] = 'Post Content cannot be empty';
        }

        if (strlen($post_content) <20){
            $error['post_content'] = 'Post Content needs to be longer';
        }


        foreach ($error as $key => $value){
            if (empty($value)){
                unset($error[$key]);
            }
        }


        if (empty($error)){

            if(!empty($_FILES["image"]["name"])){
                $targetDir = "images/";     
                $post_image = htmlspecialchars(basename($_FILES["image"]["name"]), ENT_QUOTES);
                // $post_image = basename($_FILES["image"]["name"]);
                $targetFilePath = $targetDir . $post_image;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);    
                $allowTypes = array('jpg','png','jpeg','gif','pdf');
                if(in_array($fileType, $allowTypes)){
                    // Upload file to server
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
                        add_post($post_title, $post_author,$post_image,$post_tags,$post_content,$post_date,$post_author_image);
                       
                        // header("Location: index.php");
                        header('location:index.php?status=success');
                        }
            }
            }else{
                $error['image'] = 'Told Ya ! You have to Add an image!';
            }
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
                    <h2 class="heading">Add New Post</h2>
                    <br />


                    <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                            <div class="form-group">
                                <label>Post title</label>
                                <input type="text" class="form-control" name="title" />
                                <p><?php echo isset($error['title']) ? $error['title']:'' ?></p>
                            </div>

                            <div class="form-group">
                                <label>Post Tags</label>
                                <input type="text" class="form-control" name="post_tags" />
                                <p><?php echo isset($error['post_tags']) ? $error['post_tags']:'' ?></p>
                            </div>

                            <div class="form-group">
                                <label>Post Content</label>
                                <textarea class="form-control" name="post_content" rows="10" cols="25"></textarea>
                                <p><?php echo isset($error['post_content']) ? $error['post_content']:'' ?></p>

                            </div>

                            <div class="form-group mt-3 mb-3">
                                <label>Post Image</label>
                                <input type="file" name="image">
                            </div>
                            <p class="mt-4" style="color:red;"><?php echo isset($error['image']) ? $error['image']:'Do not foget to add image to your post!' ?></p>


                            <div class="form-group mt-5">
                                <input type="submit" class="btn btn-primary" name="create_post" value="Add Post" />
                            </div>

                    </form>

                    </div>                       
                  </div>     
                </div>    
              </div>
            </section>
    </div>


<?php include "includes/footer.php" ?>