<?php

namespace Calculator_And_Display_Currency\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ridwan-arifandi.com
 * @since      1.0.0
 *
 * @package    Calculator_And_Display_Currency
 * @subpackage Calculator_And_Display_Currency/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Calculator_And_Display_Currency
 * @subpackage Calculator_And_Display_Currency/admin
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

	}

    public function setup_custom_post_type() {

		$labels = array(
			'name'                  => _x( 'Precious Metal Prices', 'Post Type General Name', 'calculator-and-display-currency' ),
			'singular_name'         => _x( 'Precious Metal Prices', 'Post Type Singular Name', 'calculator-and-display-currency' ),
			'menu_name'             => __( 'Precious Metal Prices', 'calculator-and-display-currency' ),
			'name_admin_bar'        => __( 'Precious Metal Prices', 'calculator-and-display-currency' ),
			'archives'              => __( 'Item Archives', 'calculator-and-display-currency' ),
			'attributes'            => __( 'Item Attributes', 'calculator-and-display-currency' ),
			'parent_item_colon'     => __( 'Parent Item:', 'calculator-and-display-currency' ),
			'all_items'             => __( 'All Items', 'calculator-and-display-currency' ),
			'add_new_item'          => __( 'Add New Item', 'calculator-and-display-currency' ),
			'add_new'               => __( 'Add New', 'calculator-and-display-currency' ),
			'new_item'              => __( 'New Item', 'calculator-and-display-currency' ),
			'edit_item'             => __( 'Edit Item', 'calculator-and-display-currency' ),
			'update_item'           => __( 'Update Item', 'calculator-and-display-currency' ),
			'view_item'             => __( 'View Item', 'calculator-and-display-currency' ),
			'view_items'            => __( 'View Items', 'calculator-and-display-currency' ),
			'search_items'          => __( 'Search Item', 'calculator-and-display-currency' ),
			'not_found'             => __( 'Not found', 'calculator-and-display-currency' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'calculator-and-display-currency' ),
			'featured_image'        => __( 'Featured Image', 'calculator-and-display-currency' ),
			'set_featured_image'    => __( 'Set featured image', 'calculator-and-display-currency' ),
			'remove_featured_image' => __( 'Remove featured image', 'calculator-and-display-currency' ),
			'use_featured_image'    => __( 'Use as featured image', 'calculator-and-display-currency' ),
			'insert_into_item'      => __( 'Insert into item', 'calculator-and-display-currency' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'calculator-and-display-currency' ),
			'items_list'            => __( 'Items list', 'calculator-and-display-currency' ),
			'items_list_navigation' => __( 'Items list navigation', 'calculator-and-display-currency' ),
			'filter_items_list'     => __( 'Filter items list', 'calculator-and-display-currency' ),
		);
		$args = array(
			'label'                 => __( 'Precious Metal Prices', 'calculator-and-display-currency' ),
			'description'           => __( 'Precious Metal Prices', 'calculator-and-display-currency' ),
			'labels'                => $labels,
			'supports'              => false,
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-money-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);

		register_post_type( 'harga-logam-mulia', $args );

    }

    public function setup_post_meta() {

        Container::make( 'post_meta', 'Precious Metal Prices' )
            ->where( 'post_type', '=', 'harga-logam-mulia' )
            ->add_fields( array(
				Field::make( 'text', 'harga_platinum', __( 'Platinum Price ($)' ) )
					->set_attribute( 'type', 'number' ),
				Field::make( 'text', 'harga_palladium', __( 'Palladium Price ($)' ) )
					->set_attribute( 'type', 'number' ),
				Field::make( 'text', 'harga_rhadium', __( 'Rhodium Price ($)' ) )
					->set_attribute( 'type', 'number' ),
            ));

    }

	public  function setup_plugin_options() {

		$hlm_usd_idr_rate = '';
		if ( isset( $_GET['page'] ) && $_GET['page'] === 'hlm-calculator-options' ) :
			$usd_idr_rate = hlm_get_currency_rate( 'USD', 'IDR' );
			$hlm_usd_idr_rate = '<h3>USD to IDR Rate</h3><p>$1 = '.hlm_formatted_currency( $usd_idr_rate, 'left', 'Rp' ).'</p><p>Data Source: https://finance.yahoo.com/quote/usdidr=X/, On GMT Date: '.current_time('Y-m-d H:i:s', true).'</p>';
		endif;

		$hlm_pre_data_calc = array (
			array (
				'title' => 'u55',
				'weight' => '0.65',
				'pt' => '1.85',
				'pd' => '',
				'ph' => '0.37',
			),
			array (
				'title' => 'na4',
				'weight' => '0.43',
				'pt' => '1.80',
				'pd' => '2.50',
				'ph' => '0.70',
			),
			array (
				'title' => 'na5',
				'weight' => '0.32',
				'pt' => '1.90',
				'pd' => '',
				'ph' => '0.42',
			),
			array (
				'title' => 't30',
				'weight' => '0.56',
				'pt' => '2.09',
				'pd' => '',
				'ph' => '0.46',
			),
			array (
				'title' => 'tj3',
				'weight' => '0.55',
				'pt' => '',
				'pd' => '3.00',
				'ph' => '0.19',
			),
			array (
				'title' => 'uf5',
				'weight' => '0.64',
				'pt' => '',
				'pd' => '3.49',
				'ph' => '0.20',
			),
			array (
				'title' => 't23',
				'weight' => '0.52',
				'pt' => '2.51',
				'pd' => '',
				'ph' => '0.72',
			),
			array (
				'title' => 'futura',
				'weight' => '0.56',
				'pt' => '',
				'pd' => '1.25',
				'ph' => '0.171',
			),
			array (
				'title' => 'long code',
				'weight' => '0.56',
				'pt' => '',
				'pd' => '0.54',
				'ph' => '0.262',
			),
			array (
				'title' => 'ss',
				'weight' => '0.56',
				'pt' => '',
				'pd' => '0.53',
				'ph' => '0.27',
			),
			array (
				'title' => 'v3 left',
				'weight' => '0.38',
				'pt' => '0.627',
				'pd' => '2.23',
				'ph' => '0.81',
			),
			array (
				'title' => 'v3 right',
				'weight' => '0.5',
				'pt' => '0.557',
				'pd' => '3.661',
				'ph' => '0.617',
			),
			array (
				'title' => 'nf4',
				'weight' => '0.43',
				'pt' => '',
				'pd' => '7.8',
				'ph' => '0.2',
			),
			array (
				'title' => 'nf5',
				'weight' => '0.38',
				'pt' => '',
				'pd' => '2.9',
				'ph' => '0.124',
			),
			array (
				'title' => 'jazz 2 sen',
				'weight' => '0.62',
				'pt' => '0.46',
				'pd' => '9',
				'ph' => '0.568',
			),
			array (
				'title' => 'jazz 1 sen',
				'weight' => '0.62',
				'pt' => '0.4',
				'pd' => '4.5',
				'ph' => '0.9',
			),
			array (
				'title' => 'bz210',
				'weight' => '0.22',
				'pt' => '',
				'pd' => '1.327',
				'ph' => '0.325',
			),
			array (
				'title' => 'bz220',
				'weight' => '0.22',
				'pt' => '',
				'pd' => '0.533',
				'ph' => '0.062',
			),
			array (
				'title' => 'bz130',
				'weight' => '0.26',
				'pt' => '',
				'pd' => '0.8',
				'ph' => '0',
			),
			array (
				'title' => 'rs bawa',
				'weight' => '0.32',
				'pt' => '',
				'pd' => '1.2',
				'ph' => '0.46',
			),
		);

		Container::make( 'theme_options', __( 'Calculator Options' ) )
			->set_page_file( 'hlm-calculator-options' )
			->set_page_parent( 'edit.php?post_type=harga-logam-mulia' )
			->add_fields( array(
				Field::make( 'separator', 'metal_price', __( 'Metal Price' ) ),
				Field::make( 'text', 'mp_pt', __( 'PT' ) )
					->set_width(33)
					->set_default_value(29),
				Field::make( 'text', 'mp_pd', __( 'PD' ) )
					->set_width(33)
					->set_default_value(46),
				Field::make( 'text', 'mp_rh', __( 'RH' ) )
					->set_width(33)
					->set_default_value(345),
				Field::make( 'html', 'hlm_usd_idr_rate', 'USD to IDR Rate' )
					->set_html( $hlm_usd_idr_rate ),
				Field::make( 'complex', 'hlm_pre_data_calc', 'Pre Data Calculator' )
					->set_layout( 'tabbed-vertical' )
					->add_fields( array(
						Field::make( 'text', 'title', __( 'Title' ) ),
						Field::make( 'text', 'weight', __( 'Weight' ) ),
						Field::make( 'text', 'pt', __( 'PT' ) ),
						Field::make( 'text', 'pd', __( 'PD' ) ),
						Field::make( 'text', 'ph', __( 'RH' ) ),
					) )
					->set_default_value($hlm_pre_data_calc)
					->set_header_template( '
						<% if (title) { %>
							<%- $_index+1 %>. <%- title %>
						<% } else { %>
							<%- $_index+1 %>.
						<% } %>
					' )
			) );
			
	}

	public function setup_custom_columns( $columns ) {

		if ( isset( $columns['title'] ) ) :
			unset($columns['title']);
		endif;

		$columns['platinum'] = __('Platinum Price ($)', 'calculator-and-display-currency');
		$columns['palladium'] = __('Palladium Price ($)', 'calculator-and-display-currency');
		$columns['rhadium'] = __('Rhodium Price ($)', 'calculator-and-display-currency');

		return $columns;

	}

	public function display_custom_columns( $column_key, $post_id ) {

		if ($column_key == 'platinum') :

			$value = get_post_meta($post_id, '_harga_platinum', true);
			echo $value;

		elseif ($column_key == 'palladium') :

			$value = get_post_meta($post_id, '_harga_palladium', true);
			echo $value;

		elseif ($column_key == 'rhadium') :

			$value = get_post_meta($post_id, '_harga_rhadium', true);
			echo $value;

		endif;

	}

}