<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Orinwebsolutions
 * @since      1.0.0
 *
 * @package    Wp_Pages_Tags
 * @subpackage Wp_Pages_Tags/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Pages_Tags
 * @subpackage Wp_Pages_Tags/admin
 * @author     Amila Priyankara <amilapriyankara16@gmail.com>
 */
class Wp_Pages_Tags_Admin
{

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
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Pages_Tags_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Pages_Tags_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-pages-tags-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Pages_Tags_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Pages_Tags_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-pages-tags-admin.js', array('jquery'), $this->version, false);
	}

	public function wp_tags_register_shortcodes()
	{
		add_shortcode('wp-pages-tags', array($this, 'wp_pages_tags_generator'));
	}

	public function wp_pages_tags_generator($atts, $content = null)
	{
		global $post;
		$a = shortcode_atts(array(
			'class' => 'tag-container',
			'max-item' => '10',
			'title' => 'Tags',
			'desc' => 'Add you tags',
		), $atts);

		$data_title = str_replace(' ', '_', $a['title']);

		// $post_meta = get_post_meta($post->ID, $data_title);
		$post_meta = get_post_meta($post->ID, $data_title, true);

		$tagsform = '<div id="wp-post-tags-id" class="' . esc_attr($a['class']) . '" data-max="' . esc_attr($a['max-item']) . '">';
		$tagsform .= '<h3 class="wp-page-tags-title">' . esc_html($a['title']) . '</h3>';
		$tagsform .= '<p class="wp-page-tags-des">' . esc_html($a['desc']) . '</p>';
		if ($content) {
			$tagsform .= $content;
		}
		$tagsform .= '<textarea data-title="' . esc_html($data_title) . '" name="tags" class="tags-area">' . esc_textarea($post_meta) . '</textarea>';
		$tagsform .= '<input type="hidden" name="page_id" value="' . $post->ID . '"/>';
		$tagsform .= '<input type="hidden" name="wppt_secret_key" value="' . wp_create_nonce("wppt_secret_nonce") . '"/>';
		$tagsform .= '</div>';

		return $tagsform;
	}
}
