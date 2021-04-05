<?php
/**
 * Template Tags
 *
 * This file adds functions used in the theme's templates.
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
		$class .= ' site-title-weight-' . marianne_get_theme_mod( 'marianne_header_title_weight' );
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
		$class .= ' site-desc-style-' . marianne_get_theme_mod( 'marianne_header_desc_style' );
		$class .= ' site-desc-weight-' . marianne_get_theme_mod( 'marianne_header_desc_weight' );
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
	 *
	 * @since Marianne 1.3
	 */
	function marianne_menu_primary() {
		if ( has_nav_menu( 'primary' ) ) {
			?>
				<nav id="menu-primary-container" class="button" role="navigation" aria-label="<?php echo esc_attr__( 'Primary Menu', 'marianne' ); ?>">
					<button id="menu-mobile-button" onclick="marianneAriaExpand(this)"><?php esc_html_e( 'Menu', 'marianne' ); ?></button>

					<?php
					$items_wrap  = '<ul id="%1$s" class="%2$s">';
					$items_wrap .= '%3$s';

					if ( ! is_search() && true === marianne_get_theme_mod( 'marianne_header_menu_search' ) ) {
						$items_wrap .= '<li id="menu-item-search" class="menu-item">';
						$items_wrap .= '<button id="header-search-button" class="button-inline button-expand" aria-haspopup="true" aria-expanded="false">';

						if ( ! marianne_get_theme_mod( 'marianne_header_menu_search_text' ) ) {
							$items_wrap .= esc_html_x( 'Search', 'The search button in the header.', 'marianne' );
						} else {
							$items_wrap .= esc_html( marianne_get_theme_mod( 'marianne_header_menu_search_text' ) );
						}

						$items_wrap .= '<span class="screen-reader-text">';
						$items_wrap .= esc_html__( 'Open the search form', 'marianne' );
						$items_wrap .= '</span>';
						$items_wrap .= '</button>';
						$items_wrap .= '</li>';
					}

					$items_wrap .= '</ul>';

					wp_nav_menu(
						array(
							'container'      => '',
							'depth'          => 2,
							'item_spacing'   => 'discard',
							'items_wrap'     => $items_wrap,
							'menu_class'     => 'navigation-menu',
							'menu_id'        => 'menu-primary',
							'theme_location' => 'primary',
						)
					);
					?>
				</nav>
			<?php
		} elseif ( ! is_search() && true === marianne_get_theme_mod( 'marianne_header_menu_search' ) ) {
			?>
				<div id="menu-primary-container" aria-label="<?php echo esc_attr__( 'Open the search form', 'marianne' ); ?>">
					<button id="header-search-button" class="button-inline button-expand" aria-haspopup="true" aria-expanded="false">
						<?php echo esc_html_x( 'Search', 'The search button in the header.', 'marianne' ); ?>

						<span class="screen-reader-text">
							<?php esc_html_e( 'Open the search form', 'marianne' ); ?>
						</span>
					</button>
				</div>
			<?php
		}
		?>

		<?php if ( true === marianne_get_theme_mod( 'marianne_header_menu_search' ) ) : ?>
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				$marianne_search_id = 'header-search-with-menu';
			} else {
				$marianne_search_id = 'header-search-without-menu';
			}
			?>

			<div id="<?php echo esc_attr( $marianne_search_id ); ?>" class="header-search-box">
				<?php
				get_search_form(
					array(
						'aria_label' => esc_html__( 'Search the site', 'marianne' ),
					)
				);
				?>
			</div>
		<?php endif; ?>

		<?php
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
	 * @param string $class     The class of the container.
	 *                          To set multiple classes,
	 *                          separate them with a space.
	 *                          Example: $class = "class-1 class-2".
	 *
	 * @return void
	 */
	function marianne_loop_comments( $class = '' ) {
		$comments_number = get_comments_number();

		// Displays the comment link it there is at least one comment.
		if ( $comments_number && 0 < absint( $comments_number ) ) :
			?>
				<footer<?php marianne_add_class( $class ); ?>>
					<a href="<?php echo esc_url( get_comments_link() ); ?>">
						<?php
						printf(
							/* translators: %d: Comment count number. */
							esc_html( _n( '%d comment', '%d comments', absint( $comments_number ), 'marianne' ) ),
							esc_html( $comments_number )
						);
						?>
					</a>
				<footer>
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
						<a href="<?php echo esc_url( get_previous_posts_page_link() ); ?>" rel="prev">
							<?php esc_html_e( '&lsaquo; Previous page', 'marianne' ); ?>
						</a>
					<?php } ?>

					<?php if ( $nav_next ) { ?>
						<a href="<?php echo esc_url( get_next_posts_page_link() ); ?>" rel="next">
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
			?>
				<figure<?php marianne_add_class( $class ); ?>>
					<?php if ( ! in_array( 'link', $args, true ) ) : ?>
						<?php the_post_thumbnail( 'marianne-thumbnails' ); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( get_the_permalink() ); ?>">
							<?php the_post_thumbnail( 'marianne-thumbnails' ); ?>
						</a>
					<?php endif; ?>

					<?php if ( in_array( 'caption', $args, true ) && wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
						<figcaption class="wp-caption-text text-secondary">
							<?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?>
						</figcaption>
					<?php endif; ?>
				</figure>
			<?php
		}
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

		$social_links = array();

		$social_links['twitter']   = marianne_get_theme_mod( 'marianne_social_twitter' ) ? marianne_get_theme_mod( 'marianne_social_twitter' ) : '';
		$social_links['facebook']  = marianne_get_theme_mod( 'marianne_social_facebook' ) ? marianne_get_theme_mod( 'marianne_social_facebook' ) : '';
		$social_links['instagram'] = marianne_get_theme_mod( 'marianne_social_instagram' ) ? marianne_get_theme_mod( 'marianne_social_instagram' ) : '';
		$social_links['youtube']   = marianne_get_theme_mod( 'marianne_social_youtube' ) ? marianne_get_theme_mod( 'marianne_social_youtube' ) : '';
		$social_links['linkedin']  = marianne_get_theme_mod( 'marianne_social_linkedin' ) ? marianne_get_theme_mod( 'marianne_social_linkedin' ) : '';
		$social_links['github']    = marianne_get_theme_mod( 'marianne_social_github' ) ? marianne_get_theme_mod( 'marianne_social_github' ) : '';
		$social_links['gitlab']    = marianne_get_theme_mod( 'marianne_social_gitlab' ) ? marianne_get_theme_mod( 'marianne_social_gitlab' ) : '';
		$social_links['twitch']    = marianne_get_theme_mod( 'marianne_social_twitch' ) ? marianne_get_theme_mod( 'marianne_social_twitch' ) : '';
		$social_links['email']     = marianne_get_theme_mod( 'marianne_social_email' ) ? marianne_get_theme_mod( 'marianne_social_email' ) : '';
		$social_links['phone']     = marianne_get_theme_mod( 'marianne_social_phone' ) ? marianne_get_theme_mod( 'marianne_social_phone' ) : '';
		$social_links['link']      = marianne_get_theme_mod( 'marianne_social_link' ) ? marianne_get_theme_mod( 'marianne_social_link' ) : '';
		$social_links['rss']       = marianne_get_theme_mod( 'marianne_social_rss' ) ? marianne_get_theme_mod( 'marianne_social_rss' ) : '';

		if ( ! empty( $social_links ) ) :
			?>
				<div<?php marianne_add_class( $container_class ); ?>>
					<ul class="social-links list-inline">
						<?php
						foreach ( $social_links as $site => $link ) {
							$svg_icons  = marianne_svg_feather_icons( $site );
							$svg_name   = $svg_icons['name'];
							$svg_shapes = $svg_icons['shapes'];

							if ( $link ) {
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
							}

							if ( $link ) {
								if ( false === marianne_get_theme_mod( 'marianne_social_target_blank' ) ) {
									$target = '_self';
								} else {
									$target = '_blank';
								}

								?>
									<li>
										<?php
										if ( 'phone' !== $link && 'link' !== $site && 'rss' !== $site ) {
											$link_aria_label = sprintf(
												/* translators: %s. The name of the social site. */
												_x( 'Link to %s', 'Label for links to social sites.', 'marianne' ),
												ucfirst( $site )
											);

											$svg_args = array(
												'class'      => 'feather feather-' . $site,
												'aria-label' => sprintf(
													/* translators: %s. The name of the social site. */
													_x( '%s icon', 'Alternative text for social icon images', 'marianne' ),
													ucfirst( $site )
												),
												'size'       => array( 16, 16 ),
											);
										} elseif ( 'phone' === $site ) {
											$link_aria_label = __( 'Link to the phone number', 'marianne' );

											$svg_args = array(
												'class'      => 'feather feather-' . $site,
												'aria-label' => __( 'Phone icon', 'marianne' ),
												'size'       => array( 16, 16 ),
											);
										} elseif ( 'link' === $site ) {
											$link_aria_label = __( 'Link to a custom URL', 'marianne' );

											$svg_args = array(
												'class'      => 'feather feather-' . $site,
												'aria-label' => __( 'Link icon', 'marianne' ),
												'size'       => array( 16, 16 ),
											);
										} elseif ( 'rss' === $site ) {
											$link_aria_label = __( 'Link to the RSS feed', 'marianne' );

											$svg_args = array(
												'class'      => 'feather feather-' . $site,
												'aria-label' => __( 'RSS icon', 'marianne' ),
												'size'       => array( 16, 16 ),
											);
										}
										?>

										<a href="<?php echo esc_attr( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" aria-label="<?php echo esc_attr( $link_aria_label ); ?>">
											<div class="social-icon-container">
												<?php marianne_svg( $svg_shapes, $svg_args ); ?>
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

if ( ! function_exists( 'marianne_print_info' ) ) {
	/**
	 * Displays print information on posts and pages on print only.
	 *
	 * @param string $class The class of the title.
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_print_info( $class = 'text-secondary' ) {
		$today_date = date_i18n( get_option( 'date_format' ) );
		$today_time = date_i18n( get_option( 'time_format' ) );
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
				$site_short_url  = wp_get_shortlink();
				$site_scheme     = wp_parse_url( $site_short_url, PHP_URL_SCHEME ) . '://';
				$site_scheme_len = strlen( $site_scheme );

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

if ( ! function_exists( 'marianne_post_links' ) ) {
	/**
	 * Displays links to the previous and next posts if they exist.
	 *
	 * @param string $class The class of the title.
	 *                      To set multiple classes,
	 *                      separate them with a space.
	 *                      Example: $class = "class-1 class-2".
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_post_links( $class = 'entry-links post-links text-secondary' ) {
		$marianne_newer_post = get_next_post_link();
		$marianne_older_post = get_previous_post_link();

		if ( $marianne_newer_post || $marianne_older_post ) {
			?>
				<div<?php marianne_add_class( $class ); ?>>
					<nav class="post-navigation">
						<?php
						if ( $marianne_newer_post && $marianne_older_post ) {
							$nav_links_class = 'nav-links';
						} else {
							$nav_links_class = 'nav-links-one';
						}
						?>
						<div<?php marianne_add_class( $nav_links_class ); ?>>
							<?php if ( $marianne_older_post ) : ?>
								<div class="nav-link-previous">
									<div>
										<strong><?php echo esc_html_x( 'Previous', 'Link to the previous post.', 'marianne' ); ?></strong>
									</div>

									<div>
										<?php previous_post_link( '%link', '‹ %title' ); ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $marianne_newer_post ) : ?>
								<div class="nav-link-next">
									<div>
										<strong><?php echo esc_html_x( 'Next', 'Link to the next post.', 'marianne' ); ?></strong>
									</div>

									<div>
										<?php next_post_link( '%link', '%title ›' ); ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</nav>
				</div>
			<?php
		}
	}
}
