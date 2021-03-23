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
				<div<?php marianne_add_class( $class ); ?>>
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
			<h1<?php marianne_add_class( $class ); ?>>
				<?php bloginfo( 'name' ); ?>
			</h1>
		<?php elseif ( is_front_page() || is_home() ) : ?>
			<h1<?php marianne_add_class( $class ); ?>>
				<a href="<?php echo esc_url( home_url() ); ?>">
					<?php bloginfo( 'name' ); ?>
				</a>
			</h1>
		<?php else : ?>
			<p<?php marianne_add_class( $class ); ?>>
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
			<h2<?php marianne_add_class( $class ); ?>>
				<?php bloginfo( 'description' ); ?>
			</h2>
		<?php else : ?>
			<p<?php marianne_add_class( $class ); ?>>
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
				<nav id="menu-primary-container" class="button" role="navigation" aria-label="<?php echo esc_attr__( 'Primary Menu', 'marianne' ); ?>">
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
			<time<?php marianne_add_class( $class ); ?> datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_date(); ?></time>
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
				<div<?php marianne_add_class( $class ); ?>>
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
				<ul<?php marianne_add_class( $class ); ?>>
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
				<figure<?php marianne_add_class( $class ); ?>>
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
	function marianne_add_class( $classes = '', $space_before = true ) {
		if ( true === $space_before ) {
			echo ' ';
		}
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

if ( ! function_exists( 'marianne_svg_feather_icons' ) ) {
	/**
	 * SVG path for social icons.
	 *
	 * @param string $name The id of the icon.
	 *
	 * @return string $path The path of the icon.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_svg_feather_icons( $name = '' ) {
		$svg_data = array(
			'name'    => '',
			'shapes'  => '',
			'viewbox' => '0 0 24 24',
		);

		switch ( $name ) {
			case 'email':
				$svg_data['name']   = __( 'Email', 'marianne' );
				$svg_data['shapes'] = '<circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>';
				break;

			case 'facebook':
				$svg_data['name']   = __( 'Facebook', 'marianne' );
				$svg_data['shapes'] = '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>';
				break;

			case 'github':
				$svg_data['name']   = __( 'GitHub', 'marianne' );
				$svg_data['shapes'] = '<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>';
				break;

			case 'gitlab':
				$svg_data['name']   = __( 'GitLab', 'marianne' );
				$svg_data['shapes'] = '<path d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 0 1-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 0 1 4.82 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0 1 18.6 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.51L23 13.45a.84.84 0 0 1-.35.94z"></path>';
				break;

			case 'instagram':
				$svg_data['name']   = __( 'Instagram', 'marianne' );
				$svg_data['shapes'] = '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>';
				break;

			case 'link':
				$svg_data['name']   = __( 'Link', 'marianne' );
				$svg_data['shapes'] = '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>';
				break;

			case 'linkedin':
				$svg_data['name']   = __( 'LinkedIn', 'marianne' );
				$svg_data['shapes'] = '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>';
				break;

			case 'phone':
				$svg_data['name']   = __( 'Phone', 'marianne' );
				$svg_data['shapes'] = '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line>';
				break;

			case 'rss':
				$svg_data['name']   = __( 'RSS', 'marianne' );
				$svg_data['shapes'] = '<path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>';
				break;

			case 'youtube':
				$svg_data['name']   = __( 'YouTube', 'marianne' );
				$svg_data['shapes'] = '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>';
				break;

			case 'twitch':
				$svg_data['name']   = __( 'Twitch', 'marianne' );
				$svg_data['shapes'] = '<path d="M21 2H3v16h5v4l4-4h5l4-4V2zm-10 9V7m5 4V7"></path>';
				break;

			case 'twitter':
				$svg_data['name']   = __( 'Twitter', 'marianne' );
				$svg_data['shapes'] = '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>';
				break;
		}

		return $svg_data;
	}
}

if ( ! function_exists( 'marianne_esc_svg' ) ) {
	/**
	 * Escapes shapes for SVG image.
	 *
	 * Returns allowed SVG path attributes only and remove others.
	 *
	 * @link https://www.w3.org/TR/SVG2/shapes.html
	 *
	 * @param string $path Path to escape.
	 *
	 * @return string $shapes Escaped path.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_esc_svg( $shapes = '' ) {
		$allowed_path = array(
			'circle'  => array(
				'cx' => true,
				'cy' => true,
				'r'  => true,
			),
			'line'    => array(
				'x1' => true,
				'y1' => true,
				'x2' => true,
				'y2' => true,
			),
			'path'    => array(
				'd'    => true,
				'fill' => true,
			),
			'polygon' => array(
				'points' => true,
			),
			'rect'    => array(
				'x'      => true,
				'y'      => true,
				'width'  => true,
				'height' => true,
				'rx'     => true,
				'ry'     => true,
			),
		);

		$shapes = wp_kses( $shapes, $allowed_path );

		return $shapes;
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
	function marianne_svg( $path = '', $class = 'feather', $size = array( 18, 18 ), $viewbox = '0 0 24 24' ) {
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
		$container_class = 'site-social';

		if ( 'footer' === $location ) {
			$container_class .= ' site-footer-block';
		}

		$container_class .= ' site-social-' . marianne_get_theme_mod( 'marianne_social_style' );

		$option_twitter   = marianne_get_theme_mod( 'marianne_social_twitter' );
		$option_facebook  = marianne_get_theme_mod( 'marianne_social_facebook' );
		$option_instagram = marianne_get_theme_mod( 'marianne_social_instagram' );
		$option_youtube   = marianne_get_theme_mod( 'marianne_social_youtube' );
		$option_twitch    = marianne_get_theme_mod( 'marianne_social_twitch' );
		$option_linkedin  = marianne_get_theme_mod( 'marianne_social_linkedin' );
		$option_github    = marianne_get_theme_mod( 'marianne_social_gibhub' );
		$option_gitlab    = marianne_get_theme_mod( 'marianne_social_gitlab' );
		$option_link      = marianne_get_theme_mod( 'marianne_social_link' );
		$option_phone     = marianne_get_theme_mod( 'marianne_social_phone' );
		$option_email     = marianne_get_theme_mod( 'marianne_social_email' );
		$option_rss       = marianne_get_theme_mod( 'marianne_social_rss' );


		if ( $option_twitter || $option_facebook || $option_instagram || $option_linkedin || $option_youtube || $option_email || $option_github || $option_gitlab || $option_link || $option_phone || $option_rss || $option_twitch ) {
			$no_links = false;
		} else {
			$no_links = true;
		}

		if ( false === $no_links ) :
			$social_links = array();

			if ( $option_twitter ) {
				$social_links['twitter'] = $option_twitter;
			}

			if ( $option_facebook ) {
				$social_links['facebook'] = $option_facebook;
			}

			if ( $option_instagram ) {
				$social_links['instagram'] = $option_instagram;
			}

			if ( $option_linkedin ) {
				$social_links['linkedin'] = $option_linkedin;
			}

			if ( $option_youtube ) {
				$social_links['youtube'] = $option_youtube;
			}

			if ( $option_github ) {
				$social_links['github'] = $option_github;
			}

			if ( $option_gitlab ) {
				$social_links['gitlab'] = $option_gitlab;
			}

			if ( $option_link ) {
				$social_links['link'] = $option_link;
			}

			if ( $option_phone ) {
				$social_links['phone'] = $option_phone;
			}

			if ( $option_rss ) {
				$social_links['rss'] = $option_rss;
			}

			if ( $option_twitch ) {
				$social_links['twitch'] = $option_twitch;
			}

			if ( ! empty( $social_links ) ) :
				?>
					<div class="<?php echo esc_attr( $container_class ); ?>">
						<ul class="social-links list-inline">
							<?php
							foreach( $social_links as $site => $link ) {
								$svg_name    = marianne_svg_feather_icons( $site )['name'];
								$svg_shapes  = marianne_svg_feather_icons( $site )['shapes'];

								switch ( $site ) {
									case 'twitter':
										$link = 'https://twitter.com/' . str_replace( '@', '', $link );
										break;

									case 'email':
										if ( $link ) {
											$link = 'mailto:' . $link;
										}
										break;

									case 'phone':
										if ( $link ) {
											$phone_type   = marianne_get_theme_mod( 'marianne_social_phone_type' );
											$phone_prefix = 'tel:';

											if ( 'sms' === $phone_type ) {
												$phone_prefix = 'sms:';
											} elseif ( 'whatsapp' === $phone_type ) {
												$phone_prefix = 'whatsapp:';
											}

											$link = $phone_prefix . $link;
										}
										break;

									case 'rss':
										if ( true === $link ) {
											$link = get_bloginfo( 'rss2_url' );
										} else {
											$link = '';
										}
										break;
								}

								if ( $link ) {
									?>
										<li>
											<a href="<?php echo esc_attr( $link ); ?>">
												<div class="social-icon-container">
													<?php marianne_svg( $svg_shapes, 'feather feather-' . $site ); ?>
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
		endif;
	}
}

if ( ! function_exists( 'marianne_print_info' ) ) {
	/**
	 * Displays print information on posts and pages on print only.
	 *
	 * @param string $class The class of the title.
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
	 */
	function marianne_print_info( $class = 'text-secondary' ) {
		$today_date = current_time( get_option( 'date_format' ) );
		$today_time = current_time( get_option( 'time_format' ) );
		?>
			<div id="print-info"<?php marianne_add_class( $class ); ?>>
				<p>
					<?php
					printf(
						/* translators: %1$s: The retrieve date. %1$s: The retrieve time. */
						esc_html_x( 'Retrieved %1$s at %2$s (website time).', 'Use only on print.', 'marianne' ),
						esc_html( $today_date ),
						esc_html( $today_time )
					);
					?>
				</p>

				<?php
				$site_short_url   = wp_get_shortlink();
				$site_scheme      = parse_url( $site_short_url, PHP_URL_SCHEME ) . '://';
				$site_scheme_len  = strlen( $site_scheme );

				$site_short_url = substr_replace( $site_short_url, '', 0, $site_scheme_len );

				if ( $site_short_url ) :
					?>
						<p>
							<?php
							printf(
								/* translators: %s: The short link of the post. */
								esc_html_x( 'Available at: %s', 'Use only on print.', 'marianne' ),
								esc_html( $site_short_url )
							);
							?>
						</p>
					<?php
				endif;
				?>
			</div>
		<?php
	}
}
