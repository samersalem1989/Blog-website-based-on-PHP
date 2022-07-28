<section class="cta-section theme-bg-light py-5">
		    <div class="container text-center single-col-max-width">
			    <h2 class="heading">DevBlog - A Blog Made For All Blogers</h2>
				<?php 
               if (isset($_SESSION['username'])){
				$login_name = strtoupper($_SESSION['username']);
				 echo'<div class="intro">Welcome<b>'.' '. $login_name.'</b> to my blog. Have a great & valuable time.</div>';
                 } else{
                     echo'<div class="intro">Welcome to my blog. Have a great & valuable time.</div>';
                 }
               ?>
			    <div class="single-form-max-width pt-3 mx-auto">
				    <form class="signup-form row g-2 g-lg-2 align-items-center" action="search.php" method="post">
						<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
	                    <div class="col-12 col-md-9">
	                        <label class="sr-only">Search:</label>
	                        <input type="text" name="search" class="form-control me-md-1" placeholder="Search">
	                    </div>
	                    <div class="col-12 col-md-2">
	                        <button type="submit" name="submit" class="btn btn-primary">Send</button>
	                    </div>
	                </form><!--//signup-form-->
			    </div><!--//single-form-max-width-->
		    </div><!--//container-->
	    </section>