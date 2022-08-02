<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://customer.singstravel.co.uk/
 * @since      1.0.0
 *
 * @package    Sings_Itinerary
 * @subpackage Sings_Itinerary/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sings_Itinerary
 * @subpackage Sings_Itinerary/admin
 * @author     Grzegorz Kubala <grzegorz.kubala@thetravelnetworkgroup.co.uk>
 */
class Sings_Itinerary_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sings_itinerary    The ID of this plugin.
	 */
	private $sings_itinerary;

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
	 * @param      string    $sings_itinerary       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sings_itinerary, $version ) {

		$this->sings_itinerary = $sings_itinerary;
		$this->version = $version;

        add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);
        add_action('admin_init', array( $this, 'registerAndBuildFields' ));
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
		 * defined in Sings_Itinerary_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sings_Itinerary_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->sings_itinerary, plugin_dir_url( __FILE__ ) . 'css/sings-itinerary-admin.css', array(), $this->version, 'all' );

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
		 * defined in Sings_Itinerary_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sings_Itinerary_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->sings_itinerary, plugin_dir_url( __FILE__ ) . 'js/sings-itinerary-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function addPluginAdminMenu() {
        add_menu_page(  'Sings Itinerary', 'Sings Itinerary', 'administrator', $this->sings_itinerary, array( $this, 'displayPluginAdminDashboard' ), 'dashicons-tagcloud', 26 );
    }

    public function displayPluginAdminDashboard() {
        // set this var to be used in the settings-display view
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
        if(isset($_GET['error_message'])){
            add_action('admin_notices', array($this,'pluginNameSettingsMessages'));
            do_action( 'admin_notices', $_GET['error_message'] );
        }
        require_once 'partials/'.$this->sings_itinerary.'-admin-display.php';
    }

    public function pluginNameSettingsMessages($error_message){
        switch ($error_message) {
            case '1':
                $message = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'my-text-domain' );
                $err_code = esc_attr( 'sings_itinerary_wpBranchID' );
                $setting_field = 'sings_itinerary_wpBranchID';
                break;
        }
        $type = 'error';
        add_settings_error(
            $setting_field,
            $err_code,
            $message,
            $type
        );
    }

    public function registerAndBuildFields() {
        /**
         * First, we add_settings_section. This is necessary since all future settings must belong to one.
         * Second, add_settings_field
         * Third, register_setting
         */
        add_settings_section(
        // ID used to identify this section and with which to register options
            'sings_itinerary_general_section',
            // Title to be displayed on the administration page
            '',
            // Callback used to render the description of the section
            array( $this, 'sings_itinerary_display_general_account' ),
            // Page on which to add this section of options
            'sings_itinerary_general_settings'
        );
        // Make sure all of below variables are unset first
        unset($widgetIDinput);
        // Set up variables' details below - whether they are text field, selects etc..
        $widgetIDinput = array (
            'type'      => 'input',
            'subtype'   => 'text',
            'id'    => 'sings_itinerary_wpBranchID',
            'name'      => 'sings_itinerary_wpBranchID',
            'required' => 'true',
            'get_options_list' => '',
            'value_type'=>'normal',
            'wp_data' => 'option',
        );
        // Add above variables to the 'setting' bit and then...
        add_settings_field(
            'sings_itinerary_wpBranchID',
            'Sings Widget ID',
            array( $this, 'sings_itinerary_render_settings_field' ),
            'sings_itinerary_general_settings',
            'sings_itinerary_general_section',
            $widgetIDinput
        );
        // Register the 'setting' bit within the page (which will display all of the above on the page)
        register_setting(
            'sings_itinerary_general_settings',
            'sings_itinerary_wpBranchID'
        );

    }

    public function sings_itinerary_render_settings_field($args) {
        /* EXAMPLE INPUT
                  'type'      => 'input',
                  'subtype'   => '',
                  'id'    => $this->sings_itinerary.'_example_setting',
                  'name'      => $this->sings_itinerary.'_example_setting',
                  'required' => 'required="required"',
                  'get_option_list' => "",
                    'value_type' = serialized OR normal,
        'wp_data'=>(option or post_meta),
        'post_id' =>
        */
        if($args['wp_data'] == 'option'){
            $wp_data_value = get_option($args['name']);
        } elseif($args['wp_data'] == 'post_meta'){
            $wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
        }

        switch ($args['type']) {

            case 'input':
                $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
                if($args['subtype'] != 'checkbox'){
                    $prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
                    $prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
                    $step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
                    $min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
                    $max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
                    if(isset($args['disabled'])){
                        // hide the actual input bc if it was just a disabled input the informaiton saved in the database would be wrong - bc it would pass empty values and wipe the actual information
                        echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
                    } else {
                        echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
                    }
                    /*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->sings_itinerary.'_cost2" name="'.$this->sings_itinerary.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->sings_itinerary.'_cost" step="any" name="'.$this->sings_itinerary.'_cost" value="' . esc_attr( $cost ) . '" />*/

                } else {
                    $checked = ($value) ? 'checked' : '';
                    echo '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
                }
                break;
            default:
                # code...
                break;
        }
    }

    public function sings_itinerary_display_general_account() {
        echo '<p>Please provide <i>Sings Widget ID</i> from Sings below. You can find it in your <i>Branch</i> setup</p>';
    }

}

function hstngr_register_widget() {
    register_widget( 'hstngr_widget' );
}
add_action( 'widgets_init', 'hstngr_register_widget' );
class hstngr_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            // widget ID
            'hstngr_widget',
            // widget name
            __('Sings Itinerary Widget', ' hstngr_widget_domain'),
            // widget description
            array( 'description' => __( 'This widget will allow easy access to Itinerary', 'hstngr_widget_domain' ), )
        );
    }
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', 'Check My Itinerary' );
        echo $args['before_widget'];
        //if title is present
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
        //output
        $output = "Please provide following details<br>
        <form action='' method='post' target='_blank'>
        <p><input type='text' name='bookingRef' placeholder='Booking Reference' required/></p>
        <p><input type='text' name='password' placeholder='Password' required/></p>
        <input type='submit' id='submitBranch' value='Submit'/>
        </form>";

        echo __( $output, 'hstngr_widget_domain' );
        echo $args['after_widget'];
    }
    /*public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) )
            $title = $instance[ 'title' ];
        else
            $title = __( 'Check my itinerary', 'hstngr_widget_domain' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }*/
}

add_action('template_redirect', 'getSingsItinerary');

function getSingsItinerary() {
    $baseURL = 'https://customer.singstravel.co.uk';
    $baseAPI = 'https://api.singstravel.co.uk';

    try {
        // Check if variables are empty first
        if (isset($_POST['bookingRef']) and isset($_POST['password'])) {
            $bookingRef = sanitize_text_field($_POST['bookingRef']);
            $password = sanitize_text_field($_POST['password']);

            $apiUrl = $baseAPI . '/authWpWidgetRequest?wpBranchID=' . get_option('sings_itinerary_wpBranchID') .
                '&bookingReference=' . $bookingRef . '&password=' . $password;

            $response = json_decode(file_get_contents($apiUrl));

            if ($response->status == "OK") {
                header('Location: ' . $baseURL . '/booking/' . $response->data->publicRequest . '/' . $response->data->publicKey, true, 303);
            } else {
                header('Location: ' . $baseURL, true, 303);
            }
            die();
        }
    } catch (Exception $e) {
        header('Location: ' . $baseURL, true, 303);
        die();
    }
}