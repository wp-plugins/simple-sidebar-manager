<?php

/*

Plugin Name: Simple Sidebar Manager
Description: An easy solution to sidebar management
Version: 1.0
Author: vuzzu
Author URI: http://vuzzu.net/
Plugin URI: https://github.com/vuzzu/simple-sidebar-manager
License: GPL v.2.0

*/

class Vuzzu_Simple_Sidebar_Manager {


	function __construct() {

		require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . "get_simple_sidebar.php";

		add_action( 'init', array( $this, 'register_sidebars' ) );
		add_action( 'plugins_loaded',	 	array( &$this, 'translation' ) );

    if( is_admin() ) {

			add_action( 'admin_init', array( $this, 'admin_register_settings' ) );

      require_once trailingslashit( plugin_dir_path( __FILE__ ) . "vendor" ) . '/vuzzu/utilizer-ui-elements/init.php';
      require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . "admin_view.php";

			add_action( 'admin_menu', array( $this, 'admin_panel' ) );
			add_action( 'add_meta_boxes', array( $this, 'admin_metabox' ) );
			add_action( 'save_post', array( $this, 'admin_save_filter' ) );

    }

	}


	public function register_sidebars() {

		if ( function_exists('register_sidebar') ) {

			# Checking if any sidebar is created
			if( get_option( 'ssm_dyn_sidebars' ) ) :

				$_dyn_sidebars = get_option( 'ssm_dyn_sidebars' );

				if( is_array($_dyn_sidebars) && count($_dyn_sidebars) > 0 ) :

					$args = array(
						'name' => '',
						'id'   => '',
						'before_widget' => '<div class="widget %2$s">',
						'after_widget' => '</div>',
						'before_title' => '<h1>',
						'after_title' => '</h1>'
					);

					foreach ( $_dyn_sidebars as $sidebar_name ) :

						$args['name'] = $sidebar_name;
						$args['id']   = preg_replace("/[\s_]/", "-", strtolower($sidebar_name));
						register_sidebar($args);

					endforeach;

				endif;

			endif;

		}

	}


	public function translation() {
		load_plugin_textdomain( 'ssm_terms', false, trailingslashit( plugin_dir_path( __FILE__ ) . 'languages' ) );
		$locale = get_locale();
		$locale_file = trailingslashit( plugin_dir_path( __FILE__ ) . 'languages' ) . $locale . ".php";
		if ( is_readable( $locale_file ) ) {
				require_once( $locale_file );
		}
	}


	public function admin_register_settings() {
    register_setting( 'ssm-settings-group', 'simple_sidebar_manager_support_types' );
    register_setting( 'ssm-sidebars-group', 'ssm_default_sidebar_position' );
    register_setting( 'ssm-sidebars-group', 'ssm_default_sidebar' );
    register_setting( 'ssm-sidebars-group', 'ssm_dyn_sidebars' );
  }


	public function admin_panel() {

    // Sidebar Management page
    add_menu_page(
      __('Manage sidebars','ssm_terms'),
      __('Sidebars','ssm_terms'),
      'edit_theme_options',
      'ssm-sidebars',
      'vuzzu_ssm_admin_sidebar_management_view',
      'dashicons-align-right',
      81
    );

    // Sidebar Settings page
    add_options_page(
      __('Simple Sidebar Manager Settings','ssm_terms'),
      __('Simple Sidebar Manager','ssm_terms'),
      'manage_options',
      'ssm-settings',
      'vuzzu_ssm_admin_settings_view'
    );

  }


	public function admin_metabox() {

		$supported_post_types = get_option('simple_sidebar_manager_support_types',array('post','page'));

		if( is_array($supported_post_types) ) :
			foreach ( $supported_post_types as $post_type ) :
				add_meta_box('ssm-sidebars', __('Simple Sidebar Manager','ssm_terms'), 'vuzzu_ssm_metabox_view', $post_type, 'side');
			endforeach;
		endif;

	}


	public function admin_save_filter($post_id) {

		$supported_post_types = get_option('simple_sidebar_manager_support_types',array('post','page'));
		$sidebar_manager_options = array();

		# In case not supported skip
		if( isset($_POST['post_type']) && !in_array($_POST['post_type'], $supported_post_types) ) {
			return $post_id;
		}

		# Set sidebar position
		if( isset($_POST['ssm_sidebar_position']) )
		{
			if( !empty($_POST['ssm_sidebar_position']) ) {
				update_post_meta( $post_id, 'ssm_sidebar_position', esc_sql($_POST['ssm_sidebar_position']) );
			} else {
				delete_post_meta( $post_id, 'ssm_sidebar_position');
			}
		}

		# Set sidebar
		if( isset($_POST['ssm_sidebar']) )
		{
			if( !empty($_POST['ssm_sidebar']) ) {
				update_post_meta( $post_id, 'ssm_sidebar', esc_sql($_POST['ssm_sidebar']) );
			} else {
				delete_post_meta( $post_id, 'ssm_sidebar');
			}
		}

	}


}

new Vuzzu_Simple_Sidebar_Manager();
