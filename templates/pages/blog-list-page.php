<?php
/**
 * Blog List Page Template
 * Loaded directly via template_include filter when blog display type is "list".
 *
 * @package oneguy
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$minimalio_container = get_theme_mod( 'minimalio_settings_container_type', 'container' );

?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $minimalio_container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php get_template_part( 'templates/global-templates/checker/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php
				minimalio_get_part( 'templates/blocks/blog-list',
					[
						'pagination_option' => get_theme_mod( 'minimalio_settings_blog_pagination', 'pagination' ),
						'all_label'         => get_theme_mod( 'minimalio_settings_blog_all', 'All' ),
						'categories'        => get_categories( [ 'hide_empty' => true ] ),
						'filter'            => get_theme_mod( 'minimalio_settings_archive_template_filter_enable', 'yes' ),
					]
				);
				?>

			</main><!-- #main -->

			<?php get_template_part( 'templates/global-templates/checker/right-sidebar-check' ); ?>

		</div> <!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php get_footer(); ?>
