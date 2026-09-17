
<?php
/**
 * Customizer additions.
 *
 * Keeps footer contact/social details editable from
 * Appearance > Customize instead of hardcoded in the template, per the
 * "avoid hardcoded data" rule — while still defaulting to the real BLUEVA
 * details from the brief so the footer is correct on a fresh install.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function blueva_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'blueva_footer_section',
		array(
			'title'    => __( 'BLUEVA — Footer Contact & Social', 'blueva' ),
			'priority' => 160,
		)
	);

	$fields = array(
		'blueva_phone'          => array(
			'default'           => '0784284722 / 044361306',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => __( 'Phone number(s)', 'blueva' ),
		),
		'blueva_email'          => array(
			'default'           => 'info@blueva.dz',
			'sanitize_callback' => 'sanitize_email',
			'label'             => __( 'Email address', 'blueva' ),
		),
		'blueva_facebook_url'   => array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => __( 'Facebook URL', 'blueva' ),
		),
		'blueva_instagram_url'  => array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => __( 'Instagram URL', 'blueva' ),
		),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => $field['sanitize_callback'],
			)
		);

		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'blueva_footer_section',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'blueva_customize_register' );
