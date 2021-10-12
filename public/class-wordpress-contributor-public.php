<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/cnaveenkumar
 * @since      1.0.0
 *
 * @package    Wordpress_Contributor
 * @subpackage Wordpress_Contributor/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wordpress_Contributor
 * @subpackage Wordpress_Contributor/public
 * @author     Naveenkumar C <cnaveen777@gmail.com>
 */
class Wordpress_Contributor_Public {

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

		add_filter( 'the_content', array( $this, 'display_wordpress_contributor' ), 1 );
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
		 * defined in Wordpress_Contributor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Contributor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-contributor-public.css', array(), $this->version, 'all' );

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
		 * defined in Wordpress_Contributor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Contributor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-contributor-public.js', array( 'jquery' ), $this->version, false );

	}

	public function display_wordpress_contributor( $content ){
		if ( is_single() && 'post' == get_post_type() ) {
			$get_assigned_users = unserialize( get_post_meta(get_the_ID(), 'wp_contributor_list', true));
			foreach ( $get_assigned_users as $userid){
				$userdetails = get_userdata( $userid );
				echo "<div class='user-info'>
						ID : {$userdetails->ID},
						Name : {$userdetails->user_login},
						Role : {$userdetails->roles}
				</div>";
			}
		}
	}

}
