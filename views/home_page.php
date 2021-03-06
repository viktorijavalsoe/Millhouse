<?php
 
 session_start();

 include "../includes/head.php";
 require_once "../includes/database_connection.php";
 require_once "../classes/PostMethods.php";
 include "../includes/force_login.php";

 
// First have to create a new instance post to access functions in Class
$post_methods = new PostMethods($pdo);
// Using $post_methods to actually set of the functions we want and storing them
// in variables
$all_posts = $post_methods->list_all_posts();

// Deleting first array element using array_shift 
$removed = array_shift($all_posts);

// Get the latest post 
$latest_post = $post_methods->list_latest_post();

?>

<body id="home_page">

	<header>
		<?php
    include "../includes/nav-bar.php";
		include "../includes/carousel.php";
		?>
	</header>

	<main>
		<section class="container-fluid general_wrapper">
			<div class="text_wrapper">

			  <div class="row justify-content-center">
					<?php
					// If there are no posts in the table, show a error message
					if (!$latest_post) : ?> 
						<h2 class="subheading">Hm, it seems like there are no blog posts to show..</h2>
					<?php else: ?>
						<div class="col-11 col-md-10 text_header">	
							<h2 class="subheading">Latest Posts</h2>
							<div class="underline"></div>
						</div>
				<!-- Row-->	
				</div>

				<div class="row justify-content-center latest_post_content">
					<div class="col-11 col-md-6 order-md-12 latest_post_image_wrapper">
				  	<img class="img-fluid latest_post_image" src="<?= $latest_post->get_image();?>">	
					</div>

					<div class="col-11 col-md-4 order-md-1 latest_post_text">
						<!--latest post title from Post.php-->
						<h1 class="title_inverse latest_blogpost_title"><?= $latest_post->get_title();?></h1>
						<!--latest post summary or text from Post.php-->
						<p class="body1_inverse latest_post_content">
							<?php 
							// Print only the summary of the latest post content
							$text = $latest_post->get_description();
							preg_match('/^([^.!?]*[\.!?]+){0,2}/', strip_tags($text), $abstract);
							echo $abstract[0]."...";
							?>
						</p>
						<!-- If "read more" btn is clicked we send a $_GET variable with the id so we know which post to show on next page  -->
						<div class="read_more_button">
							<a href="single_post_page.php?id=<?= $latest_post->get_id();?>" class="btn pink_primory_btn">READ MORE</a>
          	</div>
					<!--Col-->	
					</div>
				<!-- Row -->
				</div>

				<div class="row justify-content-center"> 
					<div class="col-11 col-md-10 blog_section">	
						<h2 class="subheading">Blog</h2>		
					</div>

					<div class="col-11 col-md-10 text_header">
						<div class="underline"></div>
					</div>
				<!-- Row -->	
				</div>

	 			<!-- Here we loop through and show every individual post in database. And use the getter info from the class Post.php so we can loop out the correct data where we want it -->
				<div class="row justify-content-center text-center blog_post_container">

					<?php foreach ($all_posts as $post): ?>
					  <!-- Mobile blog display -->
						<div class="d-block col-10 col-md- blog_post">
							<div class="blog_image">
								<img class="img-fluid" src="<?= $post->get_image();?>">
							</div>

							<div>
								<h1 class="title blog_header"><?= $post->get_title();?></h2>	
								<a href="single_post_page.php?id=<?= $post->get_id();?>" class="btn primory_btn_inverse">READ MORE</a>
								<hr>
							</div>
						
						</div>
          	<!--Col-->

					<?php endforeach; ?>
			
				</div>	

			<!-- text wrapper div -->	
			</div>
		<!--Latest Post-->	
		</section>			

	</main>

	<?php 
	endif; //(!$latest_post)
	require "../includes/footer.php";
	?>

</body>

</html>
