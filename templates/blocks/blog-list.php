<?php
/**
 * Blog List Display Template
 * ViceVersa-style layout: featured image, metadata sidebar, title + excerpt.
 *
 * @package oneguy
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

global $wp_query, $post;

$decoration = get_theme_mod( 'minimalio_settings_link_decoration' );
if ( $decoration === 'underline' ) {
	$class = ' underlined';
} elseif ( $decoration === 'line-through' ) {
	$class = ' line-through';
} else {
	$class = '';
}

// Dynamic title for archive pages
$dynamic_title = '';
$term = get_queried_object();
if ( isset( $term->display_name ) ) {
	$dynamic_title = 'Posts by ' . ucfirst( $term->display_name );
} elseif ( isset( $term->name ) ) {
	$dynamic_title = ucfirst( $term->name );
}

// Category filter
$filter_default = isset( $filter ) ? $filter : get_theme_mod( 'minimalio_settings_archive_template_filter_enable', 'yes' );
$categories     = isset( $categories ) ? $categories : get_categories( [ 'hide_empty' => true ] );
$all_label      = isset( $all_label ) ? $all_label : get_theme_mod( 'minimalio_settings_post_cart_button_label', 'All' );
$label          = $all_label ? $all_label : __( 'All', 'minimalio' );

$category_selected = isset( $_GET['category'] ) ? $_GET['category'] : 0;

// Clean URL for filter form
$clean_url = remove_query_arg( [ 'paged', 'page' ], get_pagenum_link( 1 ) );

// Query setup
$pagination_option = isset( $pagination_option ) ? $pagination_option : get_theme_mod( 'minimalio_settings_blog_pagination', 'pagination' );
$posts_page        = ( $pagination_option === 'pagination' ) ? get_option( 'posts_per_page' ) : '-1';
$current_page      = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

// Build query args
$check_cat    = isset( $category ) ? $category : 'all';
$check_tag    = isset( $tag ) ? $tag : 'all';
$check_author = isset( $author ) ? $author : 'all';
$check_date   = isset( $date_query ) ? $date_query : 'all';

if ( $check_tag !== 'all' ) {
	$args_search = [
		'tag_id'         => $check_tag,
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => $posts_page,
		'paged'          => $current_page,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];
} elseif ( $check_author !== 'all' ) {
	$args_search = [
		'author'         => $check_author,
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => $posts_page,
		'paged'          => $current_page,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];
} elseif ( $check_date !== 'all' ) {
	$args_search = [
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => $posts_page,
		'paged'          => $current_page,
		'date_query'     => $check_date,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];
} else {
	$args_search = [
		'cat'            => $check_cat,
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => $posts_page,
		'paged'          => $current_page,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];
}

// Handle category filter from GET parameter
if ( isset( $_GET['category'] ) && ! empty( $_GET['category'] ) ) {
	$args_search['tax_query'] = [
		[
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => [ $_GET['category'] ],
		],
	];
}

$original_query = $wp_query;
$wp_query       = new WP_Query( $args_search );
$search         = $wp_query;
?>

<div class="posts overflow-hidden w-full pb-12 lg:pb-16">

	<?php if ( $filter_default === 'yes' ) : ?>
		<div class="pt-0 pb-8 m-0 posts__container">
			<div class="flex items-center justify-between block m-0 posts__row">
				<form action="<?php echo esc_url( $clean_url ); ?>" class="justify-between block w-full posts__form" method="get">
					<div class="flex flex-wrap items-center justify-start posts__categories-wrapper gap-x-4 lg:gap-x-8 gap-y-4">
						<label role="button" tabindex="0" class="posts__tab<?php if ( $category_selected == '0' ) : ?> checked<?php endif; ?> inline-block bg-transparent h-fit rounded-none">
							<input type="radio" class="posts__radio<?php if ( empty( $_GET['category'] ) && empty( $_GET['keywords'] ) ) : ?> checked<?php endif; ?> absolute top-0 right-0 bottom-0 left-0 invisible" name="category" value="" onchange="this.form.submit();" data-search-element />
							<span class="posts__tab-label <?php echo esc_attr( $class ); ?> block"><?php echo esc_html( $label ); ?></span>
						</label>
						<?php if ( $categories ) :
							foreach ( $categories as $cat ) : ?>
								<label role="button" tabindex="0" class="posts__tab<?php if ( $category_selected === $cat->slug || $category_selected === '/' . $cat->slug . '/' ) : ?> checked<?php endif; ?> inline-block bg-transparent h-fit rounded-none">
									<input type="radio" class="absolute top-0 bottom-0 left-0 right-0 invisible posts__radio" name="category" value="<?php echo esc_attr( $cat->slug ); ?>" onchange="this.form.submit();" data-search-element />
									<span class="posts__tab-label <?php echo esc_attr( $class ); ?>"><?php echo esc_html( $cat->name ); ?></span>
								</label>
							<?php endforeach;
						endif; ?>
					</div>
				</form>
			</div>
		</div>
	<?php endif; ?>

	<div class="blog-post-type blog-list-view">
		<div class="posts__container">

			<?php if ( ! empty( $dynamic_title ) ) :
				$titleSize  = get_theme_mod( 'minimalio_settings_page_title_size', 'h2' );
				$titleAlign = get_theme_mod( 'minimalio_settings_page_title_align' );
			?>
				<h1 class="entry-title pb-8 mb-0 break-words <?php echo esc_attr( $titleSize ); ?> <?php echo esc_attr( $titleAlign ); ?>">
					<?php echo esc_html( $dynamic_title ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( $search->have_posts() ) : ?>

				<?php while ( $search->have_posts() ) : $search->the_post(); ?>
					<table class="blog-list__row" style="width: 100%; table-layout: fixed; border-collapse: collapse; border: none; margin-bottom: 0.5rem;">
						<tr>
							<?php if ( has_post_thumbnail() ) : ?>
							<td style="width: 170px; padding: 0.75rem 1rem 0.75rem 0; vertical-align: top; border: none;">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium', [ 'style' => 'width: 170px; height: 170px; object-fit: cover; display: block;' ] ); ?>
								</a>
							</td>
							<?php endif; ?>
							<td style="padding: 0.75rem 0; vertical-align: top; border: none;">
								<h2 class="blog-list__title" style="margin: 0 0 0.2rem 0; font-size: 21px; font-weight: 700; line-height: 1.35;">
									<a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;"><?php the_title(); ?></a>
								</h2>
								<div class="blog-list__date" style="margin-bottom: 0.4rem; opacity: 0.5;">
									<?php echo get_the_date(); ?>
								</div>
								<div class="blog-list__excerpt">
									<?php
									$excerpt_words = get_theme_mod( 'minimalio_settings_blog_excerpt_words', 40 );
									echo wp_trim_words( get_the_excerpt(), $excerpt_words, '...' );
									?>
								</div>
							</td>
						</tr>
					</table>
				<?php endwhile; ?>

			<?php else : ?>
				<p class="posts__no-label"><?php _e( 'No posts found.', 'minimalio' ); ?></p>
			<?php endif; ?>

			<div class="mt-8 posts__pagination pagination">
				<?php
				$pagination_args = [
					'mid_size'  => 2,
					'prev_text' => __( 'Previous Page', 'minimalio' ),
					'next_text' => __( 'Next Page', 'minimalio' ),
					'total'     => $wp_query->max_num_pages,
					'current'   => max( 1, $current_page ),
				];
				if ( isset( $_GET['category'] ) && ! empty( $_GET['category'] ) ) {
					$pagination_args['add_args'] = [ 'category' => $_GET['category'] ];
				}
				the_posts_pagination( $pagination_args );
				?>
			</div>

		</div>
	</div>

</div>

<?php
$wp_query = $original_query;
wp_reset_postdata();
?>
