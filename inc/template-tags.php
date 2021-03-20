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
			if ( true === display_header_text() ) {
				$container = 'div';
			} else {
				if ( is_front_page() && ! is_paged() ) {
					$container = 'h1';
				} elseif ( is_front_page() || is_home() ) {
					$container = 'h1';
				} else {
					$container = 'div';
				}
			}
			?>
				<<?php echo esc_html( $container ); ?> class="site-logo">
					<?php the_custom_logo(); ?>
				</<?php echo esc_html( $container ); ?>>
			<?php
		}
	}
}

if ( ! function_exists( 'marianne_site_title' ) ) {
	/**
	 * The title of the site.
	 *
	 * Puts the title in a h1 or a p tag depending on the context.
	 *
	 * @param string $class The class of the title.
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
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
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
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

if ( ! function_exists( 'marianne_header_image' ) ) {
	/**
	 * The header image of the site.
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_header_image() {
		if ( has_header_image() ) {
			$header_img_src  = get_header_image();
			$header_img_id   = attachment_url_to_postid( get_header_image() );
			$header_img_data = wp_get_attachment_metadata( $header_img_id );

			$header_img_width  = absint( $header_img_data['width'] );
			$header_img_height = absint( $header_img_data['height'] );

			$header_img_responsive_attr = '';

			if ( $header_img_width && $header_img_height ) {
				$header_img_size_array = array( $header_img_width, $header_img_height );

				$header_img_srcset_value = wp_calculate_image_srcset( $header_img_size_array, $header_img_src, $header_img_data );

				$header_img_sizes_value = wp_calculate_image_sizes( $header_img_size_array, $header_img_src, $header_img_data );

				if ( $header_img_srcset_value && $header_img_sizes_value ) {
					$header_img_responsive_attr = 'srcset="' . esc_attr( $header_img_srcset_value ) . '" sizes="' . esc_attr( $header_img_sizes_value ) . '"';
				}
			}

			if ( true === display_header_text() || has_custom_logo() ) {
				$container = 'div';

				$header_img_alt = get_post_meta( $header_img_id, '_wp_attachment_image_alt', true );
			} else {
				if ( is_front_page() && ! is_paged() ) {
					$container = 'h1';
				} elseif ( is_front_page() || is_home() ) {
					$container = 'h1';
				} else {
					$container = 'div';
				}

				$header_img_alt = get_bloginfo( 'name' );
			}
			?>
				<<?php echo esc_html( $container ); ?> class="site-header-image-container">
					<img class="site-header-image" src="<?php header_image(); ?>" alt="<?php echo esc_attr( $header_img_alt ); ?>" aria-label="<?php esc_attr_e( 'Header Image', 'marianne' ); ?>" loading="lazy" <?php echo $header_img_responsive_attr; ?>>
				</<?php echo esc_html( $container ); ?>>
			<?php
		}
	}
}

if ( ! function_exists( 'marianne_menu_primary' ) ) {
	/**
	 * The primary menu of the site.
	 *
	 * @return void
	 */
	function marianne_menu_primary() {
		if ( has_nav_menu( 'primary' ) ) {
			?>
				<nav id="menu-primary-container" role="navigation" aria-label="<?php echo esc_attr__( 'Primary Menu', 'marianne' ); ?>">
					<button id="menu-mobile-button" onclick="marianneExpandMobileMenu(this)"><?php esc_html_e( 'Menu', 'marianne' ); ?></button>

					<?php
					wp_nav_menu(
						array(
							'container'      => '',
							'depth'          => 2,
							'item_spacing'   => 'discard',
							'menu_class'     => 'navigation-menu',
							'menu_id'        => 'menu-primary',
							'theme_location' => 'primary',
						)
					);
					?>
				</nav>
			<?php
		}
	}
}

if ( ! function_exists( 'marianne_the_date' ) ) {
	/**
	 *
	 * The date on which the post was published.
	 *
	 * @param string $class The class of the date.
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
	 *
	 * @return void
	 */
	function marianne_the_date( $class = 'entry-date' ) {
		?>
			<time class="<?php echo esc_attr( $class ); ?>" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_date(); ?></time>
		<?php
	}
}

if ( ! function_exists( 'marianne_loop_comments' ) ) {
	/**
	 * The link to comments.
	 *
	 * @param string $container Wrap the link in a 'div' or 'footer' block.
	 *                          This parameter can be empty.
	 * @param string $class     The class of the container.
	 *                          To set multiple classes,
	 *                          separate them with a space.
	 *                          Example: $class = "class-1 class-2".
	 *
	 * @return void
	 */
	function marianne_loop_comments( $container = '', $class = '' ) {
		$comments_number = get_comments_number();

		// Displays the comment link it there is at least one comment.
		if ( $comments_number && 0 < $comments_number ) :
			// 'div' and 'footer' are the only arguments that can be defined through $container.
			$allowed_containers = array( 'div', 'footer' );
			$container_open     = '';
			$container_close    = '';

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
						/* translators: %d: Comment count number. */
						esc_html( _n( '%d comment', '%d comments', absint( $comments_number ), 'marianne' ) ),
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
	 * The list of categories of a post.
	 *
	 * @param string $class The class of the list of categories.
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
	 *
	 * @return void
	 */
	function marianne_the_categories( $class = '' ) {
		$class = 'list-inline ' . $class;

		$categories = get_the_category( get_the_ID() );

		if ( $categories ) {
			$cat_count = count( $categories );
			$i         = 0;
			?>
				<ul class="<?php echo esc_attr( $class ); ?>">
					<?php foreach ( $categories as $category ) : ?>
						<li>
							<a href="<?php echo esc_url( get_category_link( $category->cat_ID ) ); ?>"><?php echo esc_html( $category->cat_name ); ?></a>

							<?php
							$i++;

							if ( $i !== $cat_count ) {
								' &middot;';
							}
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'marianne_the_post_thumbnail' ) ) {
	/**
	 * The post thumbnail.
	 *
	 * @param string $class The class of the list of categories.
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
	 * @param array  $args  Options to activate:
	 *                          - 'link' adds a clickable permalink to the image.
	 *                          - 'caption' displays the caption below the image.
	 *
	 * @return void
	 */
	function marianne_the_post_thumbnail( $class = '', $args = array() ) {
		if ( has_post_thumbnail() ) {

			// If a class is set, create the attribute with its value.
			if ( $class ) {
				$class = ' class="' . esc_attr( $class ) . '"';
			}

			// Options available.
			$allowed_options = array( 'link', 'caption' );

			$before = '';
			$after  = '';
			if ( in_array( 'link', $allowed_options, true ) ) {
				$before = '<a href="' . esc_url( get_the_permalink() ) . '">';
				$after  = '</a>';
			}

			// Put the option(s) defined with $args in the array $options.
			$options = array();
			?>
				<figure<?php echo $class; ?>>
					<?php
					echo $before;

					the_post_thumbnail( 'marianne-thumbnails' );

					echo $after;
					?>

					<?php if ( in_array( 'caption', $allowed_options, true ) && wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
						<figcaption class="wp-caption-text text-secondary">
							<?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?>
						</figcaption>
					<?php endif; ?>
				</figure>
			<?php
		}
	}
}

if ( ! function_exists( 'marianne_add_class' ) ) {
	/**
	 * Add class attribute.
	 *
	 * @param string $classes Classes to add.
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_add_class( $classes = '' ) {
		echo 'class="' . esc_attr( $classes ) . '"';
	}
}
