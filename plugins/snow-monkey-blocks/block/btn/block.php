<?php
/**
 * @package snow-monkey-blocks
 * @author inc2734
 * @license GPL-2.0+
 */

use Inc2734\WP_Customizer_Framework\Customizer_Framework;

$cfs = Customizer_Framework::styles();

$accent_color = get_theme_mod( 'accent-color' );

$cfs->register(
	'.smb-btn',
	'background-color: ' . $accent_color
);

$cfs->register(
	[
		'.smb-btn:hover',
		'.smb-btn:active',
		'.smb-btn:focus',
	],
	'background-color: ' . $cfs->darken( $accent_color, 0.05 ),
	'@media (min-width: 64em)'
);
