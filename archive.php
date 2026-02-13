<?php
/**
 * The archive template file (child theme override).
 * Adds support for "List" blog display type.
 *
 * @package oneguy
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

if ( get_theme_mod( 'minimalio_settings_container_type' ) ) {
	$minimalio_container = get_theme_mod( 'minimalio_settings_container_type' );
} else {
	$minimalio_container = 'container';
}

$minimalio_card      = get_theme_mod( 'minimalio_settings_blog_post_card' );
$minimalio_post_card = minimalio_post_postcard( $minimalio_card );
$blog_display_type   = get_theme_mod( 'minimalio_settings_blog_type', 'grid' );

if ( get_theme_mod( 'minimalio_settings_blog_pagination' ) ) {
	$minimalio_display = get_theme_mod( 'minimalio_settings_blog_pagination' );
} else {
	$minimalio_display = 'no';
}

// For category, tag, author, and date archives, always show all posts
if ( is_category() || is_tag() || is_author() || is_date() ) {
	$minimalio_nr_post = '-1';
} elseif ( $minimalio_display === 'no' ) {
	$minimalio_nr_post = '-1';
} else {
	$minimalio_nr_post = get_theme_mod( 'minimalio_settings_blog_posts_per_page' );
	if ( ! $minimalio_nr_post ) {
		$minimalio_nr_post = get_option( 'posts_per_page', 10 );
	}
}

if ( is_tag() ) {
	$minimalio_tag            = get_queried_object();
	$minimalio_tag_id         = $minimalio_tag->term_id;
	$minimalio_taxonomy       = 'tag';
	$minimalio_taxonomy_value = $minimalio_tag_id;
} elseif ( is_author() ) {
	$minimalio_author         = get_queried_object();
	$minimalio_author_id      = $minimalio_author->ID;
	$minimalio_taxonomy       = 'author';
	$minimalio_taxonomy_value = $minimalio_author_id;
} elseif ( is_date() ) {
	$minimalio_year     = get_query_var( 'year' );
	$minimalio_monthnum = get_query_var( 'monthnum' );
} else {
	$minimalio_category       = get_queried_object();
	$minimalio_category_id    = $minimalio_category->term_id;
	$minimalio_taxonomy       = 'category';
	$minimalio_taxonomy_value = $minimalio_category_id;
}
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $minimalio_container ); ?>" id="content" tabindex="-1">

		<div class="row">
			<!-- Do the left sidebar check -->
			<?php get_template_part( 'templates/global-templates/checker/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php if ( have_posts() ) : ?>

					<?php if ( $blog_display_type === 'list' ) :

						$list_args = [
							'pagination_option' => $minimalio_display,
							'all_label'         => get_theme_mod( 'minimalio_settings_blog_all' ),
							'categories'        => get_categories( [ 'hide_empty' => true ] ),
							'filter'            => 'no',
						];

						if ( is_tag() ) {
							$list_args['tag'] = $minimalio_tag_id;
						} elseif ( is_author() ) {
							$list_args['author'] = $minimalio_author_id;
						} elseif ( is_date() ) {
							$list_args['date_query'] = [
								[
									'year'     => $minimalio_year,
									'monthnum' => $minimalio_monthnum,
								],
							];
						} elseif ( is_category() ) {
							$list_args['category'] = $minimalio_category_id;
						}

						minimalio_get_part( 'templates/blocks/blog-list', $list_args );

					elseif ( is_category() || is_tag() || is_author() ) :

						minimalio_get_part( 'templates/blocks/posts/posts',
							[
								'nr_post'           => '-1',
								'nr_columns'        => get_theme_mod( 'minimalio_settings_blog_columns', 4 ),
								'pagination_option' => 'no',
								'all_label'         => get_theme_mod( 'minimalio_settings_blog_all' ),
								'post_type'         => 'post',
								'post_card'         => $minimalio_post_card,
								'author_type'       => 'author-first',
								'categories'        => get_categories( [ 'hide_empty' => true ] ),
								$minimalio_taxonomy => $minimalio_taxonomy_value,
								'enable_masonry'    => get_theme_mod( 'minimalio_settings_blog_type' ),
								'filter'            => 'no',
							]
						);

					elseif ( is_date() ) :
						minimalio_get_part( 'templates/blocks/posts/posts',
							[
								'nr_post'           => '-1',
								'nr_columns'        => get_theme_mod( 'minimalio_settings_blog_columns', 4 ),
								'pagination_option' => 'no',
								'all_label'         => get_theme_mod( 'minimalio_settings_blog_all' ),
								'post_type'         => 'post',
								'post_card'         => $minimalio_post_card,
								'author_type'       => 'author-first',
								'categories'        => get_categories( [ 'hide_empty' => true ] ),
								'date_query'        => [
									[
										'year'     => $minimalio_year,
										'monthnum' => $minimalio_monthnum,
									],
								],
								'enable_masonry'    => get_theme_mod( 'minimalio_settings_blog_type' ),
								'filter'            => 'no',
							]
						);

					else :

						minimalio_get_part( 'templates/blocks/posts-ajax/posts-ajax',
							[
								'nr_post'           => get_theme_mod( 'minimalio_settings_blog_posts_per_page' ),
								'nr_columns'        => get_theme_mod( 'minimalio_settings_blog_columns' ),
								'pagination_option' => get_theme_mod( 'minimalio_settings_blog_pagination' ),
								'all_label'         => get_theme_mod( 'minimalio_settings_blog_all' ),
								'post_type'         => 'post',
								'post_card'         => $minimalio_card,
								'author_type'       => 'author-first',
								'categories'        => get_categories( [ 'hide_empty' => true ] ),
								'enable_masonry'    => get_theme_mod( 'minimalio_settings_blog_type' ),
								'filter'            => get_theme_mod( 'minimalio_settings_archive_template_filter_enable' ),
								$minimalio_taxonomy => $minimalio_taxonomy_value,
							]
						);
					endif;
					?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php // minimalio_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'templates/global-templates/checker/right-sidebar-check' ); ?>

		</div> <!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php get_footer(); ?>
