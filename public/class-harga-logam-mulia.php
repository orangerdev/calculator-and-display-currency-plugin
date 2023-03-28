<?php

namespace Calculator_And_Display_Currency\Front;

/**
 * The public-specific functionality of the plugin.
 *
 * @link       https://ridwan-arifandi.com
 * @since      1.0.0
 *
 * @package    Calculator_And_Display_Currency
 * @subpackage Calculator_And_Display_Currency/Front
 */

/**
 * The public-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 * @package    Calculator_And_Display_Currency
 * @subpackage Calculator_And_Display_Currency/Front
 * @author     Orangerdev Team <orangerdigiart@gmail.com>
 */
class Harga_Logam_Mulia {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'harga_logam_mulia', [$this,'display_harga_logam_mulia'] );
		add_shortcode( 'kalkulator_logam_mulia', [$this,'display_kalkulator_logam_mulia'] );

	}

    /**
	 * Display harga logam mulai
	 * used by shortcode harga_logam_mulai
	 *
	 * @since 1.0.0
	 * @param array $atts
	 * @return html
	 */
	public function display_harga_logam_mulia( $atts )
	{

		$update_date = get_lastpostdate( 'blog', 'harga-logam-mulia' );
		if ( $update_date ) :
			$update_date = date('d F Y, H:i', strtotime($update_date));
		else:
			$update_date = date('d F Y, H:i');
		endif;

		$hlm_saat_ini = 0;
		$count_posts = wp_count_posts( 'harga-logam-mulia' );
		if ( isset( $count_posts->publish ) ) :
			$hlm_saat_ini = hlm_human_number( $count_posts->publish );
		endif;

		ob_start();
		include CALCULATOR_AND_DISPLAY_CURRENCY_PATH.'/public/partials/harga-logam-mulia.php';
		return ob_get_clean();

	}

	public function get_list_harga_logam_mulia_by_ajax() 
	{

		if ( isset( $_REQUEST['hlm-ajax'], $_REQUEST['nonce'] ) &&
			$_REQUEST['hlm-ajax'] === 'get_list_harga_logam_mulia' &&
			wp_verify_nonce( $_REQUEST['nonce'], 'get_list_harga_logam_mulia' ) ) :

			$_request = wp_parse_args( $_REQUEST, [
				'start' => 0,
				'length' => 10,
				'draw' => 1,
				'order' => [
					[
						'column' => 0,
						'dir' => 'asc',
					]
				],
				'filter' => ''
			] );

			$data = [];
			$recordsTotal = $recordsFiltered = 0;

			$args = [
				'post_type' => 'harga-logam-mulia',
				'offset' => $_request['start'],
				'posts_per_page' => $_request['length'],
				'update_post_term_cache' => false,
				'post_status' => 'publish'
			];

			$args['order'] = $_request['order'][0]['dir'];

			switch ( $_request['order'][0]['column'] ) :
				case 0:
					$args['orderby'] = 'date';
					break;

				case 1:
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = '_harga_platinum';
					break;

				case 2:
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = '_harga_palladium';
					break;

				case 3:
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = '_harga_rhadium';		
					break;
				
				default:
					$args['orderby'] = 'date';
					break;
			endswitch;

			parse_str( $_request['filter'], $filter );

			if ( isset( $filter['logam'] ) ) :
				if ( $filter['logam'] === 'platinum' ) :
					$args['meta_key'] = '_harga_platinum';
				elseif ( $filter['logam'] === 'palladium' ) :
					$args['meta_key'] = '_harga_palladium';
				elseif ( $filter['logam'] === 'rhadium' ) :
					$args['meta_key'] = '_harga_rhadium';
				endif;
			endif;
			
			$query = new \WP_Query( $args );
		
			$posts = $query->posts;
			$recordsTotal = $recordsFiltered = $query->found_posts;

			$currency = 'USD';
			if ( isset( $filter['harga_dalam'] ) ) :
			endif;

			foreach ( $posts as $key => $value ) :

				$harga_platinum = hlm_convert_value_usd_to( $value->_harga_platinum, $currency );
				$harga_palladium = hlm_convert_value_usd_to( $value->_harga_palladium, $currency ); 
				$harga_rhadium = hlm_convert_value_usd_to( $value->_harga_rhadium, $currency );

				$data[] = [
					'date' => date('d M Y',strtotime($value->post_date)),
					'platinum' => $harga_platinum,
					'palladium' => $harga_palladium,
					'rhadium' => $harga_rhadium,
				];

			endforeach;

			$response = [
				'draw' => $_request['draw'],
				'data' => $data,
				'recordsTotal' => $recordsTotal,
				'recordsFiltered' => $recordsFiltered
			];

			wp_send_json( $response );

		endif;

	}

	public function get_riwayat_harga_logam_mulia_by_ajax() 
	{

		if ( isset( $_REQUEST['hlm-ajax'], $_REQUEST['nonce'] ) &&
			$_REQUEST['hlm-ajax'] === 'get_riwayat_harga_logam_mulia' &&
			wp_verify_nonce( $_REQUEST['nonce'], 'get_riwayat_harga_logam_mulia' ) ) :

			$_request = wp_parse_args( $_REQUEST, [
				'filter' => ''
			] );

			$labels = [];
			$harga_palladium_arr = [];
			$harga_platinum_arr = [];
			$harga_rhadium_arr = [];

			$args = [
				'post_type' => 'harga-logam-mulia',
				'offset' => 0,
				'posts_per_page' => -1,
				'update_post_term_cache' => false,
				'post_status' => 'publish',
				'date_query' => [
					[
						'year' => date('Y'),
						'month' => 1,
						'day' => 1,
						'hour' => 0,
						'minute' => 0,
						'second' => 0,
						'compare'   => '>=',
					],
					[
						'year' => date('Y'),
						'month' => date('m'),
						'day' => date('j'),
						'hour' => date('G'),
						'minute' => date('i'),
						'second' => date('s'),
						'compare'   => '<=',
					],
				]
			];

			parse_str( $_request['filter'], $filter );

			if ( isset( $filter['logam'] ) ) :
				if ( $filter['logam'] === 'platinum' ) :
					$args['meta_key'] = '_harga_platinum';
				elseif ( $filter['logam'] === 'palladium' ) :
					$args['meta_key'] = '_harga_palladium';
				elseif ( $filter['logam'] === 'rhadium' ) :
					$args['meta_key'] = '_harga_rhadium';
				endif;
			endif;

			$currency = 'USD';
			if ( isset( $filter['harga_dalam'] ) ) :
			endif;

			$query = new \WP_Query( $args );
		
			$posts = $query->posts;

			$data = [];

			foreach ( $posts as $key => $value ) :

				$harga_platinum = $value->_harga_platinum;
				$harga_palladium = $value->_harga_palladium; 
				$harga_rhadium = $value->_harga_rhadium;

				$date = date('M',strtotime($value->post_date));

				if ( isset($data[$date]['platinum'] ) ) :
					$data[$date]['platinum'] += $harga_platinum;
				else:
					$data[$date]['platinum'] = $harga_platinum;
				endif;

				if ( isset( $data[$date]['palladium'] ) ) :
					$data[$date]['palladium'] += $harga_palladium;
				else:
					$data[$date]['palladium'] = $harga_palladium;
				endif;

				if ( isset( $data[$date]['rhadium'] ) ) :
					$data[$date]['rhadium'] += $harga_rhadium;
				else:
					$data[$date]['rhadium'] = $harga_rhadium;
				endif;

			endforeach;

			$labels = array_keys($data);

			foreach ( $data as $key => $value ) :
				$harga_platinum_arr[] = hlm_human_number($value['platinum']);
				$harga_palladium_arr[] = hlm_human_number($value['palladium']);
				$harga_rhadium_arr[] = hlm_human_number($value['rhadium']);
			endforeach;

			$datasets = [
				[
					'label' => 'Palladium',
					'data' => $harga_palladium_arr,
					'borderWidth' => 2
				],
				[
					'label' => 'Platinum',
					'data' => $harga_platinum_arr,
					'borderWidth' => 2
				],
				[
					'label' => 'Rhadium',
					'data' => $harga_rhadium_arr,
					'borderWidth' => 2
				]
			];

			$response = [
				'labels' => $labels,
				'datasets' => $datasets
			];

			wp_send_json( $response );

		endif;

	}

	/**
	 * Display kalkulator logam mulia
	 * used by shortcode kalkulator_logam_mulia
	 *
	 * @since 1.0.0
	 * @param array $atts
	 * @return html
	 */
	public function display_kalkulator_logam_mulia( $atts )
	{

		ob_start();
		include CALCULATOR_AND_DISPLAY_CURRENCY_PATH.'/public/partials/kalkulator-logam-mulia.php';
		return ob_get_clean();

	}

}