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
			'name'                  => _x( 'Harga Logam Mulia', 'Post Type General Name', 'calculator-and-display-currency' ),
			'singular_name'         => _x( 'Harga Logam Mulia', 'Post Type Singular Name', 'calculator-and-display-currency' ),
			'menu_name'             => __( 'Harga Logam Mulia', 'calculator-and-display-currency' ),
			'name_admin_bar'        => __( 'Harga Logam Mulia', 'calculator-and-display-currency' ),
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
			'label'                 => __( 'Harga Logam Mulia', 'calculator-and-display-currency' ),
			'description'           => __( 'Harga Logam Mulia', 'calculator-and-display-currency' ),
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

        Container::make( 'post_meta', 'Harga Logam Mulia' )
            ->where( 'post_type', '=', 'harga-logam-mulia' )
            ->add_fields( array(
				Field::make( 'text', 'harga_platinum', __( 'Harga Platinum ($)' ) )
					->set_attribute( 'type', 'number' ),
				Field::make( 'text', 'harga_palladium', __( 'Harga Palladium ($)' ) )
					->set_attribute( 'type', 'number' ),
				Field::make( 'text', 'harga_rhadium', __( 'Harga Rhadium ($)' ) )
					->set_attribute( 'type', 'number' ),
            ));

    }

	public function setup_custom_columns( $columns ) {

		if ( isset( $columns['title'] ) ) :
			unset($columns['title']);
		endif;

		$columns['platinum'] = __('Harga Platinum ($)', 'calculator-and-display-currency');
		$columns['palladium'] = __('Harga Palladium ($)', 'calculator-and-display-currency');
		$columns['rhadium'] = __('Harga Rhadium ($)', 'calculator-and-display-currency');

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