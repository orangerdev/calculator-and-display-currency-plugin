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

		add_shortcode( 'riwayat_harga_logam_mulia', [$this,'display_riwayat_harga_logam_mulia'] );
		add_shortcode( 'kalkulator_harga_logam_mulia', [$this,'display_kalkulator_harga_logam_mulia'] );

	}

    /**
	 * Display riwayat harga logam mulai
	 * used by shortcode harga_logam_mulai
	 *
	 * @since 1.0.0
	 * @param array $atts
	 * @return html
	 */
	public function display_riwayat_harga_logam_mulia( $atts )
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
		include CALCULATOR_AND_DISPLAY_CURRENCY_PATH.'/public/partials/riwayat-harga-logam-mulia.php';
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
			if ( isset( $filter['harga_dalam'] ) && !empty( $filter['harga_dalam'] ) ) :
				$currency = $filter['harga_dalam'];
			endif;
			$rate = hlm_get_currency_rate( 'USD', $currency );

			$currencies = hlm_get_currencies();
			if ( isset( $currencies[$currency]['position'], $currencies[$currency]['symbol'] ) ) :
				$currency_pos = $currencies[$currency]['position'];
				$currency_symbol = $currencies[$currency]['symbol'];
			else:
				$currency_pos = 'left';
				$currency_symbol = '$';
			endif;

			foreach ( $posts as $key => $value ) :

				$harga_platinum = floatval( $value->_harga_platinum ) * $rate;
				$harga_palladium = floatval( $value->_harga_palladium ) * $rate; 
				$harga_rhadium = floatval( $value->_harga_rhadium ) * $rate;

				$harga_platinum = hlm_formatted_currency( $harga_platinum, $currency_pos, $currency_symbol );
				$harga_palladium = hlm_formatted_currency( $harga_palladium, $currency_pos, $currency_symbol ); 
				$harga_rhadium = hlm_formatted_currency( $harga_rhadium, $currency_pos, $currency_symbol );

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
				'harga_dalam' => '',
				'logam' => '',
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
					]
					// [
					// 	'year' => date('Y'),
					// 	'month' => date('m'),
					// 	'day' => date('j'),
					// 	'hour' => date('G'),
					// 	'minute' => date('i'),
					// 	'second' => date('s'),
					// 	'compare'   => '<=',
					// ],
				]
			];

			if ( $_request['logam'] === 'platinum' ) :
				$args['meta_key'] = '_harga_platinum';
			elseif ( $_request['logam'] === 'palladium' ) :
				$args['meta_key'] = '_harga_palladium';
			elseif ( $_request['logam'] === 'rhadium' ) :
				$args['meta_key'] = '_harga_rhadium';
			endif;

			$currency = 'USD';
			if ( !empty( $_request['harga_dalam'] ) ) :
				$currency = $_request['harga_dalam'];
			endif;
			$rate = hlm_get_currency_rate( 'USD', $currency );

			$args['order'] = 'asc';
			$args['orderby'] = 'date';

			$query = new \WP_Query( $args );
		
			$posts = $query->posts;

			$labels = [];
			$datasets = [];

			if ( empty( $_request['logam'] ) ) :

				$data = [];

				foreach ( $posts as $key => $value ) :

					$date = date('M',strtotime($value->post_date));

					$harga_platinum = floatval($value->_harga_platinum) * $rate;
					// if ( isset($data[$date]['platinum'] ) ) :
					// 	$data[$date]['platinum'] = $harga_platinum;
					// else:
						$data[$date]['platinum'] = $harga_platinum;
					// endif;

					$harga_palladium = floatval($value->_harga_palladium) * $rate; 
					// if ( isset( $data[$date]['palladium'] ) ) :
					// 	$data[$date]['palladium'] = $harga_palladium;
					// else:
						$data[$date]['palladium'] = $harga_palladium;
					// endif;

					$harga_rhadium = floatval($value->_harga_rhadium) * $rate;
					// if ( isset( $data[$date]['rhadium'] ) ) :
					// 	$data[$date]['rhadium'] = $harga_rhadium;
					// else:
						$data[$date]['rhadium'] = $harga_rhadium;
					// endif;

				endforeach;

				$labels = array_keys($data);

				foreach ( $data as $key => $value ) :
					$harga_platinum_arr[] = $value['platinum'];
					$harga_palladium_arr[] = $value['palladium'];
					$harga_rhadium_arr[] = $value['rhadium'];
				endforeach;

			elseif ( $_request['logam'] === 'platinum' ) :

				$data = [];

				foreach ( $posts as $key => $value ) :

					$date = date('M',strtotime($value->post_date));

					$harga_platinum = floatval($value->_harga_platinum) * $rate;
					// if ( isset($data[$date]['platinum'] ) ) :
					// 	$data[$date]['platinum'] = $harga_platinum;
					// else:
						$data[$date]['platinum'] = $harga_platinum;
					// endif;

				endforeach;

				$labels = array_keys($data);

				foreach ( $data as $key => $value ) :
					$harga_platinum_arr[] = $value['platinum'];
				endforeach;

			elseif ( $_request['logam'] === 'palladium' ) :

				$data = [];

				foreach ( $posts as $key => $value ) :

					$date = date('M',strtotime($value->post_date));

					$harga_palladium = floatval($value->_harga_palladium) * $rate;
					// if ( isset( $data[$date]['palladium'] ) ) :
					// 	$data[$date]['palladium'] = $harga_palladium;
					// else:
						$data[$date]['palladium'] = $harga_palladium;
					// endif;

				endforeach;

				$labels = array_keys($data);

				foreach ( $data as $key => $value ) :
					$harga_palladium_arr[] = $value['palladium'];
				endforeach;

			elseif ( $_request['logam'] === 'rhadium' ) :

				$data = [];

				foreach ( $posts as $key => $value ) :

					$date = date('M',strtotime($value->post_date));

					$harga_rhadium = floatval($value->_harga_rhadium) * $rate;
					// if ( isset( $data[$date]['rhadium'] ) ) :
					// 	$data[$date]['rhadium'] = $harga_rhadium;
					// else:
						$data[$date]['rhadium'] = $harga_rhadium;
					// endif;

				endforeach;

				$labels = array_keys($data);

				foreach ( $data as $key => $value ) :
					$harga_rhadium_arr[] = $value['rhadium'];
				endforeach;

			endif;


			if ( $harga_palladium_arr ) :
				$datasets[] = [
					'label' => 'Palladium',
					'data' => $harga_palladium_arr,
					'borderWidth' => 2,
					'borderColor' => '#0F6EB7',
					'backgroundColor' => '#0F6EB7',
				];
			endif;

			if ( $harga_platinum_arr ) :
				$datasets[] = [
					'label' => 'Platinum',
					'data' => $harga_platinum_arr,
					'borderWidth' => 2,
					'borderColor' => '#B36EC3',
					'backgroundColor' => '#B36EC3',
				];
			endif;

			if ( $harga_rhadium_arr ) :
				$datasets[] = [
					'label' => 'Rhadium',
					'data' => $harga_rhadium_arr,
					'borderWidth' => 2,
					'borderColor' => '#FE7FB0',
					'backgroundColor' => '#FE7FB0',
				];
			endif;

			$response = [
				'labels' => $labels,
				'datasets' => $datasets
			];

			wp_send_json( $response );

		endif;

	}

	/**
	 * Display kalkulator harga logam mulia
	 * used by shortcode kalkulator_harga_logam_mulia
	 *
	 * @since 1.0.0
	 * @param array $atts
	 * @return html
	 */
	public function display_kalkulator_harga_logam_mulia( $atts )
	{

		ob_start();
		include CALCULATOR_AND_DISPLAY_CURRENCY_PATH.'/public/partials/kalkulator-harga-logam-mulia.php';
		return ob_get_clean();

	}

	public function count_kalkulator_harga_logam_mulia_by_ajax() 
	{

		if ( isset( $_REQUEST['hlm-ajax'], $_REQUEST['nonce'] ) &&
			$_REQUEST['hlm-ajax'] === 'count_kalkulator_harga_logam_mulia' &&
			wp_verify_nonce( $_REQUEST['nonce'], 'count_kalkulator_harga_logam_mulia' ) ) :

			$_request = wp_parse_args( $_REQUEST, [
				'title' => '',
				'weight' => 0,
				'pt' => 0,
				'pd' => 0,
				'ph' => 0,
				'mata_uang' => ''
			] );

			$harga_usd = '_';
			$harga_konversi = '_';

			$args = [
				'post_type' => 'harga-logam-mulia',
				'offset' => 0,
				'posts_per_page' => 1,
				'no_found_rows' => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'post_status' => 'publish',
				'order' => 'desc',
				'orderby' => 'date'
			];

			$hlms = get_posts( $args );
			if ( isset( $hlms[0] ) && !empty( $hlms[0] ) ) :
				
				$hlm = $hlms[0];
				$PT = floatval( $_request['pt'] );
				$PD = floatval( $_request['pd'] );
				$RH = floatval( $_request['ph'] );
				$Weight = floatval( $_request['weight'] );

				$currency = 'USD';
				if ( !empty( $_request['mata_uang'] ) ) :
					$currency = $_request['mata_uang'];
				endif;
				$rate = hlm_get_currency_rate( 'USD', $currency );

				$Harga_Dollar = $rate;
	
				$Harga_PT = floatval( $hlm->_harga_platinum );
				$Harga_PD = floatval( $hlm->_harga_palladium );
				$Harga_RH = floatval( $hlm->_harga_rhadium );
	
				$harga_konversi = ( ( ( $PT * $Harga_PT ) + ( $PD * $Harga_PD ) + ( $RH * $Harga_RH ) ) * ( $Harga_Dollar * 0.9 * $Weight ) ) - ( $Weight * 10 * $Harga_Dollar );
		
				$currencies = hlm_get_currencies();
				if ( isset( $currencies[$currency]['position'], $currencies[$currency]['symbol'] ) ) :
					$currency_pos = $currencies[$currency]['position'];
					$currency_symbol = $currencies[$currency]['symbol'];
				else:
					$currency_pos = 'left';
					$currency_symbol = '$';
				endif;

				$rate_usd = hlm_get_currency_rate( $currency, 'USD' );
				$harga_usd = $harga_konversi * $rate_usd;
				$harga_usd = hlm_formatted_currency( $harga_usd, 'left', '$' );

				$harga_konversi = hlm_formatted_currency( $harga_konversi, $currency_pos, $currency_symbol );
	
			endif;

			$response = [
				'harga_usd' => $harga_usd,
				'harga_konversi' => $harga_konversi,
			];

			wp_send_json( $response );

		endif;

	}

}