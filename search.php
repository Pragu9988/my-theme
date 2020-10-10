<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package My_Theme
 */

get_header();
	if ( $_GET['search_text'] && !empty($_GET['search_text'])) {
		$text = $_GET['search_text'];
	}

	if ( $_GET['type'] && !empty($_GET['type'])) {
		$text = $_GET['type'];
	}
?>
<div class="container">
<?php
	$args = [
		'post_type' => $type,
		'posts_per_page' => -1,
		's' => $text,
		'exact' => true
	];
	$the_query = new WP_Query($args);
	while($the_query-> have_posts() ) : $the_query -> the_post();
?>
	<div class="post clearfix">
		<h5><?php the_title(); ?></h5>
		<strong>
			<?php 
			if ( get_post_type() == 'post' ) {
				echo 'Post';
			}
			if ( get_post_type() == 'movies' ) {
				echo 'movies';
			}
			if ( get_post_type() == 'books' ) {
				echo 'books';
			}
			?>
		</strong>
	</div>
		<?php endwhile; wp_reset_query(); ?>
</div>


	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'my-theme' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
