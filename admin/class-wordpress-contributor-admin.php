<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/cnaveenkumar
 * @since      1.0.0
 *
 * @package    Wordpress_Contributor
 * @subpackage Wordpress_Contributor/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Contributor
 * @subpackage Wordpress_Contributor/admin
 * @author     Naveenkumar C <cnaveen777@gmail.com>
 */
class Wordpress_Contributor_Admin {

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

		add_action('add_meta_boxes', array($this, 'wordpress_contributor_details'), 10, 2);
		add_action( 'save_post', array( $this, 'wordpress_contributor_save'), 10, 2 );
	}

	/**
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-contributor-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-contributor-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function wordpress_contributor_details($post_type){
		$post_types= array('post');
		if( in_array( $post_type, $post_types)){
			add_meta_box(
				'wp_contributor_list',
				__( 'Choose Author', 'wordpress-contributor' ),
				array( $this, 'wordpress_contributor_display' ),
				$post_type,
				'advanced',
				'high'
			);
		}
		
	}

	public function wordpress_contributor_display($post){
		$blogusers = get_users();
		$authorList = unserialize(get_post_meta( $post->ID, 'wp_contributor_list', true ));
		wp_nonce_field( 'wc_add_meta_box','wc_add_meta_box_nonce');
		foreach( $blogusers as $user ){ ?>
			<input type="checkbox" 
			id="wp_<?php echo esc_html( $user->display_name  ); ?>"
			name="wp_contributor_list[]" value="<?php echo esc_html( $user->ID  ); ?>" 
			<?php if( in_array( $user->ID, $authorList ) ) { echo 'checked="checked"'; }?>>
			<label for="wp_<?php echo esc_html( $user->display_name  ); ?>"> <?php echo esc_html( $user->display_name  ); ?></label>
		<?php } 
	}
	/**
	 * Save Meta Data
	 */
	public function wordpress_contributor_save($post){
		$get_user_id = serialize( $_POST['wp_contributor_list'] );
		$nonce_verified = check_admin_referer( 'wc_add_meta_box', 'wc_add_meta_box_nonce' );
		if( isset ( $get_user_id ) && isset ( $nonce_verified ) ){
			update_post_meta( $post->ID, 'wp_contributor_list', $get_user_id );
		}
	}

}
