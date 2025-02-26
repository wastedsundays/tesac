<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tesac-curl
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">


	<?php wp_head(); ?>
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NQGV0F22GF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NQGV0F22GF');
</script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'tesac-curl' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$tesac_curl_description = get_bloginfo( 'description', 'display' );
			if ( $tesac_curl_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $tesac_curl_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<svg id="broom1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 458.33 114.63"><path d="M-8.43,53.72H15.57c.67,0,1.21.54,1.21,1.21v5.25H-9.64v-5.25c0-.67.54-1.21,1.21-1.21Z" transform="translate(-53.37 60.52) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".69"/><rect x="45.38" y="5.16" width="26.42" height="103.57" transform="translate(1.64 115.54) rotate(-90)" fill="navy" stroke="navy" stroke-miterlimit="10" stroke-width=".69"/><rect x="140.43" y="13.68" width="26.42" height="86.54" transform="translate(96.7 210.59) rotate(-90)" fill="#fdd411" stroke="#fdd411" stroke-miterlimit="10" stroke-width=".69"/><rect x="268.28" y="-27.63" width="26.42" height="169.16" transform="translate(224.54 338.44) rotate(-90)" fill="navy" stroke="navy" stroke-miterlimit="10" stroke-width=".69"/><polygon points="391.78 48.24 391.72 65.09 366.07 70.14 366.07 43.78 391.78 48.24" stroke="#000" stroke-miterlimit="10" stroke-width=".53"/><rect x="394.83" y="47.78" width="13.06" height="18.33" transform="translate(344.41 458.31) rotate(-90)" fill="#708d93" stroke="#708d93" stroke-miterlimit="10" stroke-width=".8"/><path id="b" d="M411.21,52.33h2.05c4.97,0,9,4.03,9,9v1.4c0,.14-.11.25-.25.25h-19.83c-.14,0-.25-.11-.25-.25v-1.11c0-5.13,4.16-9.29,9.29-9.29Z" transform="translate(354.44 469.74) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="c" d="M377.6,50.58h94.2c5.49,0,9.95,4.46,9.95,9.95v3.52h-114.11v-3.52c0-5.49,4.46-9.95,9.95-9.95Z" transform="translate(367.39 482.02) rotate(-90)" fill="#45585e" stroke="#45585e" stroke-miterlimit="10" stroke-width=".52"/><path id="d" d="M386.64,50.58h103.07c3.05,0,5.52,2.47,5.52,5.52v7.96h-114.11v-7.96c0-3.05,2.47-5.52,5.52-5.52Z" transform="translate(495.49 -380.86) rotate(90)" stroke="#000" stroke-miterlimit="10" stroke-width=".52"/><path id="e" d="M398.71,50.37h105.54s.08.04.08.08v2.29c0,5.95-4.83,10.78-10.78,10.78h-84.08c-5.98,0-10.84-4.86-10.84-10.84v-2.25s.03-.06.06-.06Z" transform="translate(394.54 508.44) rotate(-90)" fill="#fdd411" stroke="#fdd411" stroke-miterlimit="10" stroke-width=".52"/><path id="f" d="M409.01,88.56h9.05c1.36,0,2.47,1.11,2.47,2.47v5.37h-14.07v-5.29c0-1.4,1.14-2.55,2.55-2.55Z" transform="translate(321.02 505.98) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="g" d="M409.01,18.97h9.05c1.36,0,2.47,1.11,2.47,2.47v5.37h-14.07v-5.29c0-1.4,1.14-2.55,2.55-2.55Z" transform="translate(390.6 436.39) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="h" d="M393.92,55.18h105.61v2.54c0,.59-.48,1.08-1.08,1.08h-103.21c-.73,0-1.32-.59-1.32-1.32v-2.3h0Z" transform="translate(389.74 503.71) rotate(-90)" fill="#bfa832" stroke="#bfa832" stroke-miterlimit="10" stroke-width=".52"/><ellipse cx="422.24" cy="87.42" rx="2.47" ry="21.69" fill="#65767a"/></svg>
				<svg id="broom2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 458.33 114.63"><path d="M-8.43,53.72H15.57c.67,0,1.21.54,1.21,1.21v5.25H-9.64v-5.25c0-.67.54-1.21,1.21-1.21Z" transform="translate(-53.37 60.52) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".69"/><rect x="45.38" y="5.16" width="26.42" height="103.57" transform="translate(1.64 115.54) rotate(-90)" fill="navy" stroke="navy" stroke-miterlimit="10" stroke-width=".69"/><rect x="140.43" y="13.68" width="26.42" height="86.54" transform="translate(96.7 210.59) rotate(-90)" fill="#fdd411" stroke="#fdd411" stroke-miterlimit="10" stroke-width=".69"/><rect x="268.28" y="-27.63" width="26.42" height="169.16" transform="translate(224.54 338.44) rotate(-90)" fill="navy" stroke="navy" stroke-miterlimit="10" stroke-width=".69"/><polygon points="391.78 48.24 391.72 65.09 366.07 70.14 366.07 43.78 391.78 48.24" stroke="#000" stroke-miterlimit="10" stroke-width=".53"/><rect x="394.83" y="47.78" width="13.06" height="18.33" transform="translate(344.41 458.31) rotate(-90)" fill="#708d93" stroke="#708d93" stroke-miterlimit="10" stroke-width=".8"/><path id="b" d="M411.21,52.33h2.05c4.97,0,9,4.03,9,9v1.4c0,.14-.11.25-.25.25h-19.83c-.14,0-.25-.11-.25-.25v-1.11c0-5.13,4.16-9.29,9.29-9.29Z" transform="translate(354.44 469.74) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="c" d="M377.6,50.58h94.2c5.49,0,9.95,4.46,9.95,9.95v3.52h-114.11v-3.52c0-5.49,4.46-9.95,9.95-9.95Z" transform="translate(367.39 482.02) rotate(-90)" fill="#45585e" stroke="#45585e" stroke-miterlimit="10" stroke-width=".52"/><path id="d" d="M386.64,50.58h103.07c3.05,0,5.52,2.47,5.52,5.52v7.96h-114.11v-7.96c0-3.05,2.47-5.52,5.52-5.52Z" transform="translate(495.49 -380.86) rotate(90)" stroke="#000" stroke-miterlimit="10" stroke-width=".52"/><path id="e" d="M398.71,50.37h105.54s.08.04.08.08v2.29c0,5.95-4.83,10.78-10.78,10.78h-84.08c-5.98,0-10.84-4.86-10.84-10.84v-2.25s.03-.06.06-.06Z" transform="translate(394.54 508.44) rotate(-90)" fill="#fdd411" stroke="#fdd411" stroke-miterlimit="10" stroke-width=".52"/><path id="f" d="M409.01,88.56h9.05c1.36,0,2.47,1.11,2.47,2.47v5.37h-14.07v-5.29c0-1.4,1.14-2.55,2.55-2.55Z" transform="translate(321.02 505.98) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="g" d="M409.01,18.97h9.05c1.36,0,2.47,1.11,2.47,2.47v5.37h-14.07v-5.29c0-1.4,1.14-2.55,2.55-2.55Z" transform="translate(390.6 436.39) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="h" d="M393.92,55.18h105.61v2.54c0,.59-.48,1.08-1.08,1.08h-103.21c-.73,0-1.32-.59-1.32-1.32v-2.3h0Z" transform="translate(389.74 503.71) rotate(-90)" fill="#bfa832" stroke="#bfa832" stroke-miterlimit="10" stroke-width=".52"/><ellipse cx="422.24" cy="87.42" rx="2.47" ry="21.69" fill="#65767a"/></svg>
				<svg id="broom3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 458.33 114.63"><path d="M-8.43,53.72H15.57c.67,0,1.21.54,1.21,1.21v5.25H-9.64v-5.25c0-.67.54-1.21,1.21-1.21Z" transform="translate(-53.37 60.52) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".69"/><rect x="45.38" y="5.16" width="26.42" height="103.57" transform="translate(1.64 115.54) rotate(-90)" fill="navy" stroke="navy" stroke-miterlimit="10" stroke-width=".69"/><rect x="140.43" y="13.68" width="26.42" height="86.54" transform="translate(96.7 210.59) rotate(-90)" fill="#fdd411" stroke="#fdd411" stroke-miterlimit="10" stroke-width=".69"/><rect x="268.28" y="-27.63" width="26.42" height="169.16" transform="translate(224.54 338.44) rotate(-90)" fill="navy" stroke="navy" stroke-miterlimit="10" stroke-width=".69"/><polygon points="391.78 48.24 391.72 65.09 366.07 70.14 366.07 43.78 391.78 48.24" stroke="#000" stroke-miterlimit="10" stroke-width=".53"/><rect x="394.83" y="47.78" width="13.06" height="18.33" transform="translate(344.41 458.31) rotate(-90)" fill="#708d93" stroke="#708d93" stroke-miterlimit="10" stroke-width=".8"/><path id="b" d="M411.21,52.33h2.05c4.97,0,9,4.03,9,9v1.4c0,.14-.11.25-.25.25h-19.83c-.14,0-.25-.11-.25-.25v-1.11c0-5.13,4.16-9.29,9.29-9.29Z" transform="translate(354.44 469.74) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="c" d="M377.6,50.58h94.2c5.49,0,9.95,4.46,9.95,9.95v3.52h-114.11v-3.52c0-5.49,4.46-9.95,9.95-9.95Z" transform="translate(367.39 482.02) rotate(-90)" fill="#45585e" stroke="#45585e" stroke-miterlimit="10" stroke-width=".52"/><path id="d" d="M386.64,50.58h103.07c3.05,0,5.52,2.47,5.52,5.52v7.96h-114.11v-7.96c0-3.05,2.47-5.52,5.52-5.52Z" transform="translate(495.49 -380.86) rotate(90)" stroke="#000" stroke-miterlimit="10" stroke-width=".52"/><path id="e" d="M398.71,50.37h105.54s.08.04.08.08v2.29c0,5.95-4.83,10.78-10.78,10.78h-84.08c-5.98,0-10.84-4.86-10.84-10.84v-2.25s.03-.06.06-.06Z" transform="translate(394.54 508.44) rotate(-90)" fill="#fdd411" stroke="#fdd411" stroke-miterlimit="10" stroke-width=".52"/><path id="f" d="M409.01,88.56h9.05c1.36,0,2.47,1.11,2.47,2.47v5.37h-14.07v-5.29c0-1.4,1.14-2.55,2.55-2.55Z" transform="translate(321.02 505.98) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="g" d="M409.01,18.97h9.05c1.36,0,2.47,1.11,2.47,2.47v5.37h-14.07v-5.29c0-1.4,1.14-2.55,2.55-2.55Z" transform="translate(390.6 436.39) rotate(-90)" stroke="#000" stroke-miterlimit="10" stroke-width=".47"/><path id="h" d="M393.92,55.18h105.61v2.54c0,.59-.48,1.08-1.08,1.08h-103.21c-.73,0-1.32-.59-1.32-1.32v-2.3h0Z" transform="translate(389.74 503.71) rotate(-90)" fill="#bfa832" stroke="#bfa832" stroke-miterlimit="10" stroke-width=".52"/><ellipse cx="422.24" cy="87.42" rx="2.47" ry="21.69" fill="#65767a"/></svg>

			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
