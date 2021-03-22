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
	 * @param string $class The class of the title.
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
	 *
	 * @return void
	 */
	function marianne_logo( $class = 'site-logo' ) {
		if ( has_custom_logo() ) {
			?>
				<div class="<?php echo esc_attr( $class ); ?>">
					<?php the_custom_logo(); ?>
				</div>
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
	 * Adds class attribute.
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

if ( ! function_exists( 'marianne_get_twitter_username_to_url' ) ) {
	/**
	 * Converts a Twitter username into a Twitter URL.
	 *
	 * @param string $username
	 *
	 * @return string $url The Twitter URL associated to the username.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_get_twitter_username_to_url( $username = '' ) {
		$username = marianne_sanitize_twitter( $username );
		$url      = '';

		if ( $username ) {
			if ( '@' === substr( $username, 0, 1 ) ) {
				$username = substr( $username, 1 );
			}

			$url = 'https://twitter.com/' . $username;
		}

		return $url;
	}
}

if ( ! function_exists( 'marianne_svg_social_path' ) ) {
	/**
	 * SVG path for social icons.
	 *
	 * @param string $name The id of the icon.
	 *
	 * @return string $path The path of the icon.
	 */
	function marianne_svg_social_path( $name = '' ) {
		switch ( $name ) {
			case 'twitter':
				$path = '<path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>';
				break;

			case 'facebook':
				$path = '<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>';
				break;

			case 'instagram':
				$path = '<path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>';
				break;

			case 'linkedin':
				$path = '<path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>';
				break;

			case 'email':
				$path = '<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>';
				break;
		}

		return $path;
	}
}

if ( ! function_exists( 'marianne_esc_svg' ) ) {
	/**
	 * Escapes path for SVG image.
	 *
	 * Returns allowed SVG path attributes only and remove others.
	 *
	 * @link https://www.w3.org/TR/SVG2/shapes.html
	 *
	 * @param string $path Path to escape.
	 *
	 * @return string $shapes Escaped path.
	 */
	function marianne_esc_svg( $path = '' ) {
		$allowed_path = array(
			'path'  => array(
				'd'    => true,
				'fill' => true,
			),
		);

		$path = wp_kses( $path, $allowed_path );

		return $path;
	}
}

if ( ! function_exists( 'marianne_svg' ) ) {
	/**
	 * Converts a Twitter username into a Twitter URL.
	 *
	 * @param string $username
	 *
	 * @return string $url The Twitter URL associated to the username.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_svg( $path = '', $class = 'bi', $size = array( 20, 20 ), $viewbox = '0 0 16 16' ) {
		?>
			<svg xmlns="http://www.w3.org/2000/svg" width="<?php echo esc_attr( absint( $size[0] ) ); ?>" height="<?php echo esc_attr( absint( $size[1] ) ); ?>" class="<?php echo esc_attr( $class ); ?>" viewBox="<?php echo esc_attr( $viewbox ); ?>">
			  <?php
			  echo marianne_esc_svg( $path );
			  ?>
			</svg>
		<?php
	}
}

if ( ! function_exists( 'marianne_social_link' ) ) {
	/**
	 * Displays social links as icons.
	 *
	 * @param string $location The location of the icons (header or footer).
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_social_link( $location = 'footer' ) {
		if ( 'footer' === $location ) {
			$container_class = 'site-footer-block';
		} else {
			$container_class = 'site-social';
		}

		$social_links = array();

		$social_links['twitter'] = marianne_get_twitter_username_to_url( marianne_get_theme_mod( 'marianne_social_twitter' ) );
		$social_links['facebook'] = marianne_get_theme_mod( 'marianne_social_facebook' );
		$social_links['instagram'] = marianne_get_theme_mod( 'marianne_social_instagram' );
		$social_links['linkedin'] = marianne_get_theme_mod( 'marianne_social_linkedin' );

		if ( ! empty( $social_links ) ) :
			?>
				<div id="social-container" class="<?php echo esc_attr( $container_class ); ?>">
					<ul class="social-list list-inline">
						<?php
						foreach( $social_links as $site => $link ) {
							if ( $link ) {
								?>
									<li>
										<a href="<?php echo esc_url( $link ); ?>">
											<div class="social-icon-container">
												<?php marianne_svg( marianne_svg_social_path( $site ), 'bi bi-' . $site ); ?>
											</div>
										</a>
									</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
			<?php
		endif;
	}
}
