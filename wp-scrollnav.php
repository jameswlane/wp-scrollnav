<?php
/**
 * WordPress Widget Boilerplate
 *
 * The WordPress Widget Boilerplate is an organized, maintainable boilerplate for building widgets using WordPress best practices.
 *
 * @package   Widget_Name
 * @author    James W. Lane <james.w.lane@mac.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 James W. Lane
 *
 * @wordpress-plugin
 * Plugin Name:       wp-scrollnav
 * Plugin URI:        @TODO
 * Description:       Sidebar scrollnav
 * Version:           1.0.0
 * Author:            James W. Lane
 * Author URI:        http://jameswlane.com
 * Text Domain:       widget-name
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /lang
 * GitHub Plugin URI: https://github.com/jameswlane/wp-scrollnav
 */

// TODO: change 'Widget_Name' to the name of your plugin
class Widget_Name extends WP_Widget {

    /**
     * @TODO - Rename "widget-name" to the name your your widget
     *
     * Unique identifier for your widget.
     *
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'widget-name';

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		// TODO: update description
		parent::__construct(
			$this->get_widget_slug(),
			__( 'Widget Name', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'Short description of the widget goes here.', $this->get_widget_slug() )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

	} // end constructor


    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		
		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset ( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset ( $cache[ $args['widget_id'] ] ) )
			return print $cache[ $args['widget_id'] ];
		
		// go on with your widget logic, put everything into a string and …


		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		// TODO: Here is where you manipulate your widget's values based on their input fields
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;


		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	} // end widget
	
	
	public function flush_widget_cache() 
	{
    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		// TODO: Here is where you update your widget's old values with the new, incoming values

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		// TODO: Define default values for your variables
		$instance = wp_parse_args(
			(array) $instance
		);

		// TODO: Store the values of the widget in their own variable

		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {

		// TODO be sure to change 'widget-name' to the name of *your* plugin
		load_plugin_textdomain( $this->get_widget_slug(), false, plugin_dir_path( __FILE__ ) . 'lang/' );

	} // end widget_textdomain

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here
	} // end deactivate

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

        if ( 'local' == WP_ENV ) {
            wp_enqueue_style( $this->get_widget_slug().'-admin-styles', plugins_url( 'assets/dev/admin.css', __FILE__ ) );
        } else {
            wp_enqueue_style( $this->get_widget_slug().'-admin-styles', plugins_url( 'assets/dist/admin.min.css', __FILE__ ) );
        }

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

        if ( 'local' == WP_ENV ) {
            wp_enqueue_script( $this->get_widget_slug().'-admin-script', plugins_url( 'assets/dev/admin.js', __FILE__ ), array('jquery') );
        } else {
            wp_enqueue_script( $this->get_widget_slug().'-admin-script', plugins_url( 'assets/dist/admin.min.js', __FILE__ ), array('jquery') );
        }

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

        if ( 'local' == WP_ENV ) {
            wp_enqueue_style( $this->get_widget_slug().'-widget-styles', plugins_url( 'assets/dev/style.css', __FILE__ ) );
        } else {
            wp_enqueue_style( $this->get_widget_slug().'-widget-styles', plugins_url( 'assets/dist/style.min.css', __FILE__ ) );
        }

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

        if ( 'local' == WP_ENV ) {
            wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'assets/dev/header.js', __FILE__ ), array('jquery') );
            wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'assets/dev/footer.js', __FILE__ ), array('jquery') );
        } else {
            wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'assets/dist/header.min.js', __FILE__ ), array('jquery') );
            wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'assets/dist/footer.min.js', __FILE__ ), array('jquery') );
        }

	} // end register_widget_scripts

} // end class

// TODO: Remember to change 'Widget_Name' to match the class name definition
add_action( 'widgets_init', create_function( '', 'register_widget("Widget_Name");' ) );

/**
 * Magellan Scroll Nav Functions
 * Example: <?php magellan_scroll_nav(); ?>
 */

/**
 * Navigating the DOM using php to get the text between html tags
 * @link http://php.net/manual/en/book.dom.php
 */
function getTextBetweenTags() {
    $tag = get_post_meta( get_the_ID(), 'magellan_tag', true );
    if ( empty( $tag ) ) {
        $tag = 'h2';
    }
    $html = get_the_content();
    $dom = new domDocument;
    $dom->loadHTML($html);
    $dom->preserveWhiteSpace = false;
    $content = $dom->getElementsByTagname($tag);
    $items = array();
    foreach ($content as $item) {
        $items[] = $item->nodeValue;
    }
    return $items;
}

/**
 * Converts stings into slugs
 */
function create_slug( $string ) {
    $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return $slug;
}

/**
 * Checks the post to see if Magellan overrides have been set
 */
function magellan_settings() {
    $settings_output = '';
    $settings = '';
    $threshold = get_post_meta( get_the_ID(), 'magellan_threshold', true );
    if ( ! empty( $threshold ) ) {
        $settings_output .= 'threshold:' . $threshold . ';';
    }
    $destination_threshold = get_post_meta( get_the_ID(), 'magellan_destination_threshold', true );
    if ( ! empty( $destination_threshold ) ) {
        $settings_output .= 'destination_threshold:' . $destination_threshold . ';';
    }
    $fixed_top = get_post_meta( get_the_ID(), 'magellan_fixed_top', true );
    if ( ! empty( $fixed_top ) ) {
        $settings_output .= 'fixed_top:' . $fixed_top . ';';
    }
    if ( ! empty( $settings_output ) ) {
        $settings = 'data-options="' . $settings_output . '"';
    }
    return $settings;
}

/**
 * Returns a title for the widget
 */
function magellan_title(){
    $title = get_post_meta( get_the_ID(), 'magellan_title', true );
    if ( empty( $title ) ) {
        $title = the_title( '', '', FALSE );
    }
    return $title;
}

/**
 * This does the following
 * - Generates the <dd> items in the magellan toc
 * - Filters the content and adds the correct markup
 * - Adds a smoothScroll to the footer output
 */
function magellan_scroll_nav(){
    $items = getTextBetweenTags();
    $settings = magellan_settings();
    $output = '';
    foreach( $items as $item ) {
        $output .= '<dd data-magellan-arrival="' . create_slug( $item ) . '"><a href="#' . create_slug( $item ) . '">' . $item . '</a></dd>';
    }
    add_filter('the_content', 'my_formatter', 99);
    echo $output;
}

/**
 * This filters throught the content and adds the content and adds the
 * the correct markup to make Magellan work
 */
function my_formatter( $content ) {
    $new_content = '';
    $tag = get_post_meta( get_the_ID(), 'magellan_tag', true );
    if ( empty( $tag ) ) {
        $tag = 'h2';
    }
    $pattern_full = '{(<' . $tag . '>.*?</' . $tag . '>)}is';
    $pattern_contents = '{<' . $tag . '>(.*?)</' . $tag . '>}is';
    $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    foreach ($pieces as $piece) {
        if (preg_match($pattern_contents, $piece, $matches)) {
            $test = $matches[1];
            $new_content .= '<a name="'.create_slug($test).'"></a>'.PHP_EOL.'<'.$tag.' data-magellan-destination="'.create_slug($test).'">'.$test.'</'.$tag.'>'.PHP_EOL;
        } else {
            $new_content .= wptexturize(wpautop($piece));
        }
    }
    return $new_content;
}

/**
 * This adds a place where you can hook in and attach a content below the toc
 * inside the magellan widget
 * Example below
 */
function magellan_after_toc() {
    $output = apply_filters('magellan_after_toc', '');
    if ( ! empty( $output ) ) {
        echo $output;
    }
}

/**
 * This adds a place where you can hook in and attach a widget above Magellan
 * Example below
 */
function magellan_before_toc_widget() {
    $output = apply_filters('magellan_before_toc_widget', '');
    if ( ! empty( $output ) ) {
        echo $output;
    }
}

/**
 * This adds a place where you can hook in and attach a widget below Magellan
 * Example below
 */
function magellan_after_toc_widget() {
    $output = apply_filters('magellan_after_toc_widget', '');
    if ( ! empty( $output ) ) {
        echo $output;
    }
}


/* Example of how to add a widget
function test_before_widget( $output ) {
  $output = file_get_contents( CHILD_DIR . '/template/part-monitize-widget.php' );
  return $output;
};
add_filter('magellan_after_toc', 'test_before_widget', 10, 1);
*/