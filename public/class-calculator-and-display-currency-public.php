<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ridwan-arifandi.com
 * @since      1.0.0
 *
 * @package    Calculator_And_Display_Currency
 * @subpackage Calculator_And_Display_Currency/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Calculator_And_Display_Currency
 * @subpackage Calculator_And_Display_Currency/public
 * @author     Orangerdev Team <orangerdigiart@gmail.com>
 */
class Calculator_And_Display_Currency_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Calculator_And_Display_Currency_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Calculator_And_Display_Currency_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 
		wp_enqueue_style( 'jquery.dataTables', '//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css', array(), '1.13.4', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/calculator-and-display-currency-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Calculator_And_Display_Currency_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Calculator_And_Display_Currency_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 
		wp_enqueue_script( 'jquery.dataTables', '//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js', array( 'jquery' ), '1.13.4', true );
		wp_enqueue_script( 'chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/calculator-and-display-currency-public.js', array( 'jquery', 'chart-js' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'hlm_vars', [
			'get_list_harga_logam_mulia' => [
				'ajax_url' => add_query_arg( [
					'hlm-ajax' => 'get_list_harga_logam_mulia',
					'nonce' => wp_create_nonce( 'get_list_harga_logam_mulia' )
				], site_url() )
			],
			'get_riwayat_harga_logam_mulia' => [
				'ajax_url' => add_query_arg( [
					'hlm-ajax' => 'get_riwayat_harga_logam_mulia',
					'nonce' => wp_create_nonce( 'get_riwayat_harga_logam_mulia' )
				], site_url() )
			],
		] );
	}

}
