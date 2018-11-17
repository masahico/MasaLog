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
	'.smb-section__title::after',
	'background-color: ' . $accent_color
);

snow_monkey_entry_content_styles( [ '.smb-section__body' ] );
