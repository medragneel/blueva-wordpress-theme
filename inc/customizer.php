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

	/**
	 * Dedicated white/light logo for the footer.
	 *
	 * The main Site Identity logo (Appearance > Customize > Site Identity)
	 * is designed for the white header and often has little contrast on
	 * the footer's teal background. If the main logo is an image, the
	 * footer CSS forces it to a plain white silhouette as a sane default
	 * (see .blueva-footer-logo img in footer.css) — but a real white
	 * logo file uploaded here always takes priority and will look best.
	 */
	$wp_customize->add_setting(
		'blueva_footer_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'blueva_footer_logo',
			array(
				'label'       => __( 'Footer logo (white version)', 'blueva' ),
				'description' => __( 'Optional. Upload a white/light version of the BLUEVA logo for the teal footer. If left empty, the main Site Identity logo is shown auto-converted to white.', 'blueva' ),
				'section'     => 'blueva_footer_section',
			)
		)
	);

	/**
	 * PHASE 3 — Homepage content.
	 */
	$wp_customize->add_section(
		'blueva_homepage_section',
		array(
			'title'    => __( 'BLUEVA — Homepage Content', 'blueva' ),
			'priority' => 161,
		)
	);

	$wp_customize->add_setting(
		'blueva_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'blueva_hero_image',
			array(
				'label'       => __( 'Hero background image', 'blueva' ),
				'description' => __( 'Full-bleed image behind the "SUMMER COLLECTION" hero text.', 'blueva' ),
				'section'     => 'blueva_homepage_section',
			)
		)
	);

	$wp_customize->add_setting(
		'blueva_video_section_file',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize,
			'blueva_video_section_file',
			array(
				'label'       => __( 'Product video (MP4)', 'blueva' ),
				'description' => __( 'Used in the "Watch our best product in action" section.', 'blueva' ),
				'section'     => 'blueva_homepage_section',
			)
		)
	);

	$wp_customize->add_setting(
		'blueva_video_section_poster',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'blueva_video_section_poster',
			array(
				'label'       => __( 'Product video poster image', 'blueva' ),
				'description' => __( 'Shown before the video plays and as a fallback if no video file is set.', 'blueva' ),
				'section'     => 'blueva_homepage_section',
			)
		)
	);

	$wp_customize->add_setting(
		'blueva_marquee_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'blueva_marquee_text',
		array(
			'label'       => __( 'Scrolling marquee phrases', 'blueva' ),
			'description' => __( 'Comma-separated. Leave empty to use the default BLUEVA brand messaging.', 'blueva' ),
			'section'     => 'blueva_homepage_section',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'blueva_customize_register' );
