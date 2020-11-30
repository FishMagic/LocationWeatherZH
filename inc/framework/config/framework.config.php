<?php if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings = array(
	'menu_title'      => __( 'Location Weather ZH', 'location-weather' ),
	'menu_type'       => 'menu', // menu, submenu, options, theme, etc.
	'menu_slug'       => 'lw_settings',
	'ajax_save'       => true,
	'show_reset_all'  => false,
	'framework_title' => __( 'Location Weather ZH', 'location-weather' ),
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[] = array(
	'name'   => 'advanced_settings',
	'title'  => __( '高级设置', 'location-weather' ),
	// 'icon'   => 'fa fa-cogs',

	// begin: fields.
	'fields' => array(
		array(
			'id'      => 'lw_api_key',
			'type'    => 'text',
			'title'   => __( 'API Key', 'location-weather' ),
			'desc'    => __( '添加你的OpenWeatherMap API key. <a href="http://openweathermap.org/appid" target="_blank">获取你的key</a>', 'location-weather' ),
		),

	), // end: fields.
);

// ------------------------------
// Custom CSS                   -
// ------------------------------
$options[] = array(
	'name'   => 'custom_css_section',
	'title'  => __( '自定义CSS', 'location-weather' ),
	// 'icon'   => 'fa fa-css3',
	'fields' => array(

		array(
			'id'    => 'lw_custom_css',
			'type'  => 'textarea',
			'title' => __( '自定义CSS', 'location-weather' ),
			'desc'  => __( '输入你的自定义css.', 'location-weather' ),
		),
	),
);


SP_LW_Framework::instance( $settings, $options );
