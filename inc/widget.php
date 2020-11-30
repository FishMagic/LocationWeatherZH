<?php
// Weather Widget.
function sp_location_weather_widget() {
	register_widget( 'sp_location_weather_widget_content' );
}

add_action( 'widgets_init', 'sp_location_weather_widget' );

/**
 * Class sp_location_weather_widget_content
 */
class sp_location_weather_widget_content extends WP_Widget {

	function __construct() {
		parent::__construct(
			'sp_location_weather_widget_content', __( 'Location Weather ZH', 'location-weather' ),
			array(
				'description' => __( '这是一个可以显示天气的小部件', 'location-weather' ),
			)
		);
	}

	/*
	-------------------------------------------------------
	 *				Front-end display of widget
	 *-------------------------------------------------------*/

	function widget( $args, $instance ) {
		extract( $args );
		$title                    = apply_filters( 'widget_title', $instance['title'] );
		$location_weather_id      = $instance['location_weather_id'];
		$location_weather_city    = $instance['location_weather_city'];
		$location_weather_country = $instance['location_weather_country'];

		echo $before_widget;

		$weather_api = ( ! empty( sp_get_option( 'lw_api_key' ) ) ? sp_get_option( 'lw_api_key' ) : 'e1e48c6dd68c90e8fd4db063ed6b7ab4' );

		$output = '';
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$output .= '<div class="sp-location-weather-widget">';
		$output .= '<div id="location-weather-widget-' . $location_weather_id . '" class="sp-hide">
			<div class="sp-location-weather-image"><img class="weather-image" src="" alt="Weather Icon"/></div>
			<span class="weather-type"></span>
			<span class="weather-temp"></span>
			<span class="weather-date"></span>
			<span class="weather-region"></span>
		</div>';
		$output .= '</div><!--/#widget-->';

		$output .= "<script>
		/*
		 * Location weather
		 */
		jQuery(document).ready(function() {
			loadWeatherWidget$location_weather_id('$location_weather_city','$location_weather_country'); //@params location, woeid
		});

		function loadWeatherWidget$location_weather_id(location, woeid) {
			if (woeid != '' ) {
				var country = ',' + woeid;
			} else{
				var country = '';
			}
			jQuery('#location-weather-widget-$location_weather_id .weather-temp').locationWeather({
				key: '$weather_api',
				city: location+''+country,
				units: 'c',
				iconTarget: '#location-weather-widget-$location_weather_id .weather-image',
				descriptionTarget: '#location-weather-widget-$location_weather_id .weather-type',
				placeTarget: '#location-weather-widget-$location_weather_id .weather-region',
				weatherDate: '#location-weather-widget-$location_weather_id .weather-date',
				customIcons: '" . SP_LOCATION_WEATHER_URL . "assets/images/weather/',
				success: function(data) {
					// show weather
					jQuery('#location-weather-widget-$location_weather_id').show();
				},
				error: function(data) {
					jQuery('#location-weather-widget-$location_weather_id').remove();
				}
			});
		}</script>";

		echo $output;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance                             = $old_instance;
		$instance['title']                    = strip_tags( $new_instance['title'] );
		$instance['location_weather_id']      = strip_tags( $new_instance['location_weather_id'] );
		$instance['location_weather_city']    = strip_tags( $new_instance['location_weather_city'] );
		$instance['location_weather_country'] = strip_tags( $new_instance['location_weather_country'] );

		return $instance;
	}


	function form( $instance ) {
		$defaults = array(
			'title'                    => '',
			'location_weather_id'      => 1,
			'location_weather_city'    => 'beijing',
			'location_weather_country' => 'cn',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( '标题', 'location-weather' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				   value="<?php echo $instance['title']; ?>" class="widefat"/>
		</p>
		<p>
			<label
					for="<?php echo esc_attr( $this->get_field_id( 'location_weather_id' ) ); ?>"><?php _e( 'ID', 'location-weather' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'location_weather_id' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'location_weather_id' ) ); ?>"
				   value="<?php echo $instance['location_weather_id']; ?>" style="width:100%;"/>
		</p>
		<p>
			<label
					for="<?php echo esc_attr( $this->get_field_id( 'location_weather_city' ) ); ?>"><?php _e( '城市', 'location-weather' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'location_weather_city' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'location_weather_city' ) ); ?>"
				   value="<?php echo esc_attr( $instance['location_weather_city'] ); ?>" style="width:100%;"/>
		</p>
		<p>
			<label
					for="<?php echo esc_attr( $this->get_field_id( 'location_weather_country' ) ); ?>"><?php _e( '国家', 'location-weather' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'location_weather_country' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'location_weather_country' ) ); ?>"
				   value="<?php echo esc_attr( $instance['location_weather_country'] ); ?>" style="width:100%;"/>
		</p>
		<p>以下功能仅在 <a href="https://shapedplugin.com/plugin/location-weather-pro/">专业版</a> 可用/p>
		<p>
			<label disabled for=""><?php _e( '单位', 'location-weather' ); ?></label>
			<select id="" name="">
				<option value="fahrenheit">华氏度</option>
				<option value="celsius">摄氏度</option>
			</select>
		</p>
		<p>
			<label disabled for=""><?php _e( '自动定位', 'location-weather' ); ?></label>
			<select disabled id="" name="">
				<option value="yes">开</option>
				<option value="no">关</option>
			</select>
		</p>
		<p>
			<label disabled for=""><?php _e( '日期', 'location-weather' ); ?></label>
			<select disabled id="" name="">
				<option value="show">显示</option>
				<option value="hide">隐藏</option>
			</select>
		</p>
		<p>
			<label disabled for=""><?php _e( '湿度', 'location-weather' ); ?></label>
			<select disabled id="" name="">
				<option value="show">显示</option>
				<option value="hide">隐藏</option>
			</select>
		</p>
		<p>
			<label disabled for=""><?php _e( '风速', 'location-weather' ); ?></label>
			<select disabled id="" name="">
				<option value="show">显示</option>
				<option value="hide">隐藏</option>
			</select>
		</p>

		<?php
	}
}
