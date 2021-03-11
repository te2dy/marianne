<?php
/**
 * Template Tags
 *
 * This file adds functions used in the theme.
 *
 * @package Marianne
 * @since Marianne 1.0
 */

if ( ! function_exists( 'marianne_logo' ) ) {
	/**
	 * The logo of the site.
	 *
	 * @return void
	 */
	function marianne_logo() {
		if ( has_custom_logo() ) {
			echo '<div class="site-logo">';
			the_custom_logo();
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'marianne_site_title' ) ) {
	/**
	 * The title of the site
	 *
	 * Puts the title in a h1 or a p tag depending on the context.
	 *
	 * @param string $class The class of the title.
	 *
	 * @return void
	 */
	function marianne_site_title( $class = 'site-title' ) {
		?>

		<?php if ( is_front_page() && ! is_paged() ) : ?>
			<h1 class="<?php echo esc_attr( $class ); ?>">
				<?php bloginfo( 'name' ); ?>
			</h1>
		<?php elseif ( is_front_page() || is_home() ) : ?>
			<h1 class="<?php echo esc_attr( $class ); ?>">
				<a href="<?php echo esc_url( home_url() ); ?>">
					<?php bloginfo( 'name' ); ?>
				</a>
			</h1>
		<?php else : ?>
			<p class="<?php echo esc_attr( $class ); ?>">
				<a href="<?php echo esc_url( home_url() ); ?>">
					<?php bloginfo( 'name' ); ?>
				</a>
			</p>
		<?php endif; ?>

		<?php
	}
}

if ( ! function_exists( 'marianne_site_description' ) ) {
	/**
	 * The description of the site.
	 *
	 * Puts the description in a h2 or a p tag depending on the context.
	 *
	 * @param string $class The class of the description.
	 *
	 * @return void
	 */
	function marianne_site_description( $class = 'site-description text-secondary' ) {
		?>

		<?php if ( is_front_page() || is_home() ) : ?>
			<h2 class="<?php echo esc_attr( $class ); ?>">
				<?php bloginfo( 'description' ); ?>
			</h2>
		<?php else : ?>
			<p class="<?php echo esc_attr( $class ); ?>">
				<?php bloginfo( 'description' ); ?>
			</p>
		<?php endif; ?>

		<?php
	}
}

if ( ! function_exists( 'marianne_menu_primary' ) ) {
	/**
	 * The primary menu of the site.
	 *
	 * @return void
	 */
	function marianne_menu_primary() {
		echo '<button id="menu-mobile-button" onclick="marianneExpandMobileMenu(this)">' . esc_html__( 'Menu', 'marianne' ) . '</button>';

		if ( has_nav_menu( 'primary' ) ) {
			echo '<nav id="menu-primary-container" role="navigation" aria-label="' . esc_attr__( 'Primary menu', 'marianne' ) . '">';

			wp_nav_menu(
				array(
					'container'            => '',
					'depth'                => 2,
					'item_spacing'         => 'discard',
					'menu_class'           => 'navigation-menu',
					'menu_id'              => 'menu-primary',
					'theme_location'       => 'primary',
				)
			);

			echo '</nav>';
		}
	}
}

if ( ! function_exists( 'marianne_the_date' ) ) {
	/**
	 * Displays the publish date of a post
	 *
	 * @param string $class If a class is set, the date will be displayed within a <div>.
	 *
	 * @return void
	 */
	function marianne_the_date( $class = 'post-date' ) {
		?>
			<time class="<?php echo esc_attr( $class ); ?>" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
		<?php
	}
}

if ( ! function_exists( 'marianne_loop_comments' ) ) {
	/**
	 * Link to comments
	 *
	 * @param string $container Wrap the link in a 'div' or 'footer' block… or nothing (default).
	 * @param string $class     The class added to the container.
	 *
	 * @return void
	 */
	function marianne_loop_comments( $container = '', $class = '' ) {
		$comments_number = get_comments_number();

		$allowed_containers = array( 'div', 'footer' );
		$container_open     = '';
		$container_close    = '';

		if ( $comments_number && 0 < $comments_number ) :
			?>

			<?php
			if ( $container && in_array( $container, $allowed_containers, true ) ) {
				$container_open = '<' . esc_attr( $container );
				if ( $class ) {
					$container_open .= ' class="' . esc_attr( $class ) . '"';
				}
				$container_open .= '>';

				$container_close = '</' . esc_attr( $container ) . '>';
			}
			?>

			<?php echo $container_open; ?>
				<a href="<?php echo esc_url( get_comments_link() ); ?>">
					<?php
					printf(
						/* translators: $d: Comment count number */
						esc_html( _nx( '%d comment', '%d comments', absint( $comments_number ), 'Link to comments', 'marianne' ) ),
						absint( $comments_number )
					);
					?>
				</a>
			<?php echo $container_close; ?>

			<?php
		endif;
	}
}

if ( ! function_exists( 'marianne_loop_navigation' ) ) {
	/**
	 * The pagination of the theme in the loop.
	 *
	 * @return void
	 */
	function marianne_loop_navigation() {
		$nav_prev = get_previous_posts_link();
		$nav_next = get_next_posts_link();

		$class = 'loop-pagination text-secondary';
		if ( ! $nav_prev ) {
			$class .= ' loop-pagination-right';
		}

		if ( $nav_prev || $nav_next ) {
			?>
				<div class="<?php echo esc_attr( $class ); ?>">
					<?php if ( $nav_prev ) { ?>
						<a href="<?php echo esc_url( get_previous_posts_page_link() ); ?>">
							<?php esc_html_e( '&lsaquo; Previous page', 'marianne' ); ?>
						</a>
					<?php } ?>

					<?php if ( $nav_next ) { ?>
						<a href="<?php echo esc_url( get_next_posts_page_link() ); ?>">
							<?php esc_html_e( 'Next page &rsaquo;', 'marianne' ); ?>
						</a>
					<?php } ?>

				</div>
			<?php
		}
	}
}

if ( ! function_exists( 'marianne_the_categories' ) ) {
	/**
	 * The list of categories of a post
	 *
	 * @param string $class Add a class to the list.
	 *
	 * @return void
	 */
	function marianne_the_categories( $class = '' ) {
		// If a class is set, create the attribute with its value.
		$class = 'list-inline ' . $class;

		$categories = get_the_category( get_the_ID() );

		if ( $categories ) {
			$cat_count = count( $categories );
			$i         = 0;
			?>
				<ul class="<?php echo esc_attr( $class ); ?>">
					<?php
					foreach ( $categories as $category ) {
						$i++;
						?>
							<li>
								<a href="<?php echo esc_url( get_category_link( $category->cat_ID ) ); ?>"><?php echo esc_html( $category->cat_name ); ?></a>

								<?php
								if ( $i !== $cat_count ) {
									' &middot;';
								}
								?>
							</li>
						<?php
					}
					?>
				</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'marianne_the_post_thumbnail' ) ) {
	/**
	 * The post thumbnail.
	 *
	 * @param string       $class The class of the figure.
	 * @param string|array $args  Options to activate.
	 *                            'link' adds a clickable permalink to the image.
	 *                            'caption' displays the caption below the image.
	 *
	 * @return void
	 */
	function marianne_the_post_thumbnail( $class = '', $args = '' ) {
		if ( has_post_thumbnail() ) :

			// If a class is set, create the attribute with its value.
			if ( esc_attr( $class ) ) {
				$class = ' class="' . esc_attr( $class ) . '"';
			}

			// Options available.
			$allowed_args = array( 'link', 'caption' );

			// Put the option(s) defined with $args in the array $options.
			$options = array();

			if ( ! is_array( $args ) ) {
				if ( in_array( $args, $allowed_args, true ) ) {
					$options[] = $args;
				}
			} else {
				foreach ( $args as $option ) {
					$options[] = $option;
				}
			}
			?>
				<figure<?php echo $class; ?>>
					<?php if ( in_array( 'link', $options, true ) ) : ?>
						<a href="<?php the_permalink(); ?>">
					<?php endif; ?>

					<?php the_post_thumbnail(); ?>

					<?php if ( in_array( 'link', $options, true ) ) : ?>
						</a>
					<?php endif; ?>

					<?php if ( in_array( 'caption', $options, true ) && wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
						<figcaption class="wp-caption-text text-secondary">
							<?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?>
						</figcaption>
					<?php endif; ?>
				</figure>
			<?php
		endif;
	}
}
