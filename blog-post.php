<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>


<div class="main-wrapper">
<?php include "includes/sidebar.php" ?>

<!-- Add New Post Button -->
<?php if (isset($_SESSION['username'])){?>
<button type="button" class="btn btn-primary mb-5" onclick="location.href='add_post.php'">Add New Post <i class="fas fa-plus fa-sm"></i></button>
<?php }?>

	<section class="blog-list px-3 py-5 p-md-5">
		<div class="container single-col-max-width">
		<?php
            if(isset($_GET['status'])){
            echo '<h6 class="mb-5">Your post has been added successfully!</h6>';
            }
            if(isset($_GET['delete'])){
                echo '<h6 class="mb-5">Your post has been deleted!</h6>';
                }
            ?>
	
	<!-- Select User Posts -->
<?php if (isset($_SESSION['username'])){

		$author = $_SESSION['username'];
		$query="SELECT * FROM posts WHERE post_author = '{$author}'";
		$select_all_posts_query=mysqli_query($connection,$query);
		while($row=mysqli_fetch_array($select_all_posts_query)){
			$post_title=$row['post_title'];
			$post_author=$row['post_author'];
			$post_date=$row['post_date'];
			$post_content=$row['post_content'];
			$post_id=$row['post_id'];
			$post_img=$row['post_image'];   
			$post_author_image = $row['post_author_image'];  
			
		//Comments    
		$comments_query= "SELECT * FROM comments Where comment_post_id = {$post_id}";
		$select_all_comments_query=mysqli_query($connection,$comments_query);
		$number_of_Comments = mysqli_num_rows($select_all_comments_query);
		
	?>


		
		<div class="item mb-5">
				<div class="row g-3 g-xl-0">
					<div class="col-2 col-xl-3">
						<img class="img-fluid post-thumb " src="./images/<?php echo $post_img; ?>" alt="image">
					</div>
					<div class="col">
						<h3 class="title mb-1"><a class="text-link" href="post.php?id=<?= $post_id;?>"><?php echo $post_title ?></a></h3>
						<div class="meta mb-1"><span class="date">Published on <?php echo $post_date ?></span><span class="time"> by <?php echo $post_author ?></span><span><?php echo "<img class='rounded-circle' style='width:24px; height:24px' src='./assets/images/$post_author_image' alt='image'"?></span> <span class="comment"><a class="text-link" href="#"> <?php echo $number_of_Comments?> comments</a></span></div>
						<div class="intro" style="display: -webkit-box;-webkit-line-clamp: 4;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;"><?php echo $post_content ?></div>
						<a class="text-link" href="post.php?id=<?= $post_id;?>">Read more &rarr;</a>
				</br>
		
			<button type="button" class="btn btn-primary mt-3" onclick="location.href='edit_post.php?id=<?= $post_id;?>'">Edit</button>
			<button type="button" class="btn btn-danger mt-3" onclick="location.href='delete_post.php?id=<?= $post_id;?>'">Delete</button>      
	
					</div><!--//col-->
				</div><!--//row-->
			</div><!--//item-->
			<?php
				}    
			?>
		</div>
		
	</section>

</div>
<?php } else{?>
<!--Default  -->
<article class="blog-post px-3 py-5 p-md-5">
		    <div class="container single-col-max-width">
			    <header class="blog-post-header">
				    <h2 class="title mb-5">Why Every Developer Should Have A Blog</h2>
			    </header>
			    
			    <div class="blog-post-body">
				    <figure class="blog-banner">
				        <img class="img-fluid" src="assets/images/blog/blog-post-banner.jpg" alt="image">
				    </figure>
				    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. </p>
				    
				    <h3 class="mt-5 mb-3">Code Block Example</h3>
				    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. </p>
				    <pre>
					    <code>
							function $initHighlight(block, cls) {
							try {
								if (cls.search(/\bno\-highlight\b/) != -1)
								return process(block, true, 0x0F) +
										` class="${cls}"`;
							} catch (e) {
								/* handle exception */
							}
							for (var i = 0 / 2; i < classes.length; i++) {
								if (checkCondition(classes[i]) === undefined)
								console.log('undefined');
							}
							}

							export  $initHighlight;
					    </code>
				    </pre>
				    <h3 class="mt-5 mb-3">Typography</h3>
				    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
				    <h5 class="my-3">Bullet Points:</h5>
				    <ul class="mb-5">
					  <li class="mb-2">Lorem ipsum dolor sit amet consectetuer.</li>
					  <li class="mb-2">Aenean commodo ligula eget dolor.</li>
					  <li class="mb-2">Aenean massa cum sociis natoque penatibus.</li>
					</ul>
					<ol class="mb-5">
					  <li class="mb-2">Lorem ipsum dolor sit amet consectetuer.</li>
					  <li class="mb-2">Aenean commodo ligula eget dolor.</li>
					  <li class="mb-2">Aenean massa cum sociis natoque penatibus.</li>
					</ol>
					<h5 class="my-3">Quote Example:</h5>
					<blockquote class="blockquote m-lg-5 py-3   ps-4 px-lg-5">
						<p class="mb-2">You might not think that programmers are artists, but programming is an extremely creative profession. It's logic-based creativity.</p>
						<footer class="blockquote-footer mt-0">John Romero</footer>
					</blockquote>
					
					<h5 class="my-3">Table Example:</h5>
					<table class="table table-striped my-5">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">First</th>
								<th scope="col">Last</th>
								<th scope="col">Handle</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Mark</td>
								<td>Otto</td>
								<td>@mdo</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>Larry</td>
								<td>the Bird</td>
								<td>@twitter</td>
							</tr>
						</tbody>
					</table>
					
					<h5 class="mb-3">Embed A Tweet:</h5>
					
					<blockquote class="twitter-tweet" data-lang="en"><p lang="en" dir="ltr">1969:<br>-what&#39;re you doing with that 2KB of RAM?<br>-sending people to the moon<br><br>2017:<br>-what&#39;re you doing with that 1.5GB of RAM?<br>-running Slack</p>&mdash; I Am Devloper (@iamdevloper) <a href="https://twitter.com/iamdevloper/status/926458505355235328?ref_src=twsrc%5Etfw">November 3, 2017</a></blockquote>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>


				    
				    <h3 class="mt-5 mb-3">Video Example</h3>
				    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. </p>

				    <div class="ratio ratio-16x9">
					   <iframe width="560" height="315" src="https://www.youtube.com/embed/1nxSE0R27Gg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>					
					</div>
				   
			    </div>				
		    </div><!--//container-->
	    </article>
                
		<section class="promo-section theme-bg-light py-5 text-center">
		    <div class="container">
			    <h2 class="title">Promo Section Heading</h2>
			    <p>You can use this section to promote your side projects etc. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. </p>
                <figure class="promo-figure">
			        <img class="img-fluid" src="assets/images/promo-banner.jpg" alt="image">
			    </figure>
		    </div><!--//container-->
	    </section><!--//promo-section-->
                            
<?php }?>
		</div>
	</div>
<?php include "includes/footer.php" ?>
