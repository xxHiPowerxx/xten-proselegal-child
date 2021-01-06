<?php
/**
 * Site Header included if Legacy Header is not Selected in Site Header Options.
 *
 * @package xten
 */

$site_name                 = esc_attr( get_bloginfo() );
$mobile_nav_breakpoint     = $GLOBALS['mobile_nav_breakpoint'];
$root_dir                  = get_template_directory_uri();
$font                      = 'roboto';
$style                     =
	'@font-face {' .
		'font-family:' . $font . ';' .
		'src: url(' . $root_dir . '/assets/fonts/' . $font . '/' . $font . '.ttf);' .
	'}' .
	'@media (min-width:' . $mobile_nav_breakpoint . 'px ){' .
		'.xten-site-header .site-branding{' .
			'margin-right:6rem;' .
		'}' .
	'}';
wp_register_style( 'xten-site-header-inline-style', false );
wp_enqueue_style( 'xten-site-header-inline-style', '', 'xten-content-css' );
wp_add_inline_style( 'xten-site-header-inline-style', $style );
?>
<header id="masthead" class="site-header new-site-header fixed-header">
	<div class="navbar" id="mainNav">
		<div class="header-container container container-ext">
			<div class="site-branding">
				<?php	$home_url = esc_url( home_url( '/' ) ); ?>
				<a class="custom-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url" title="<?php echo esc_attr( $site_name ); ?>"><span class="hide-me">Home Link</span>
					<div class="ctnr-custom-logo <?php echo $GLOBALS['xten-using-child-logo'] ? 'child-logo' : ''; ?>">
						<?php echo $GLOBALS['xten-site-logo'] ?>
					</div>
				</a>
				<?php echo get_site_phone_number_func(true); ?>
			</div><!-- .site-branding -->

			<button class="btn btn-theme-style" id="show-sidebar-modal" data-toggle="modal" data-target="#sidebar-modal" type="button">
				<span class="btn-text">Get Started</span>
			</button>
			<nav id="nav-mega-menu" class="main-navigation desktop-navigation navbar-nav ml-auto" aria-label="<?php esc_attr_e( 'Main menu', 'xten' ); ?>">
				<?php
				$menu_name = 'primary';
				$locations = get_nav_menu_locations();

				if ( $locations && isset( $locations[ $menu_name ] ) && $locations[ $menu_name ] > 0 ) :
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'desktop-menu',
							'container'      => 'ul',
							'depth'          => 2,
							'walker'         => new XTen_Walker(),
						)
					);
				endif;
				?>
			</nav><!-- #site-navigation -->
			<?php

			// Get Customizer Setting for Search Icon.
			$main_nav_search = get_theme_mod( 'main_nav_search', true );
			if ( $main_nav_search ) :
				?>
				<button class="header-search-toggle" type="button" data-toggle="collapse" data-target="#header-search" aria-controls="header-search" aria-expanded="false" aria-label="Toggle search">
					<i class="fas fa-search"></i>
				</button>
			<?php	endif; ?>
			<button id="mobile-nav-open" class="mobile-toggler collapsed" type="button" data-toggle="collapse" aria-controls="mobile-sidebar" aria-expanded="false" aria-label="Toggle navigation" tabindex="0" data-target="#mobile-sidebar">
				<div class="mobile-toggler-icon">
					<i class="fas fa-bars"></i>
				</div>
			</button>
		</div><!-- /.header-container -->
	</div><!-- /#mainNav -->
	<?php	if ( $main_nav_search ) : ?>
		<div class="collapse header-search" id="header-search">
			<div class="header-search-wrapper">
				<div class="container">
					<div class="row">
						<div class=" col-sm-12 col-xl-8 offset-xl-2">
							<?php echo get_search_form(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php	endif; ?>
</header><!-- #masthead -->
