<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/Orinwebsolutions
 * @since      1.0.0
 *
 * @package    Wp_Pages_Tags
 * @subpackage Wp_Pages_Tags/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Pages_Tags
 * @subpackage Wp_Pages_Tags/public
 * @author     Amila Priyankara <amilapriyankara16@gmail.com>
 */
class Wp_Pages_Tags_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-pages-tags-public.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . '_tagfy_css', 'https://unpkg.com/@yaireo/tagify/dist/tagify.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name . '_tagify', 'https://unpkg.com/@yaireo/tagify/dist/jQuery.tagify.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-pages-tags-public.js', array($this->plugin_name . '_tagify'), $this->version, false);
		wp_localize_script($this->plugin_name, 'wppt_script', array('ajaxurl' => admin_url('admin-ajax.php')));
	}

	public function wppt_store_ajax_data()
	{

		if (!wp_verify_nonce($_POST['nonce'], "wppt_secret_nonce")) {
			exit("No naughty business please");
		}
		$tagsArray = json_decode(stripslashes($_POST['data']));
		$tagsString = '';
		foreach ($tagsArray as $tag) {
			$tagsString .= $tag->value . ',';
		}
		$tagsString = rtrim($tagsString, ',');

		$result = update_post_meta($_POST['pageid'], $_POST['meta_title'], sanitize_text_field($tagsString));
		$metatitle = get_post_meta($_POST['pageid'], 'meta_titles', true);
		$metatitleArray = explode(",", $metatitle);
		if (!in_array($_POST['meta_title'], $metatitleArray) && $metatitle != $_POST['meta_title'] . ',') {
			$metatitle = ($metatitle . $_POST['meta_title'] . ',');
		}
		update_post_meta($_POST['pageid'], 'meta_titles', sanitize_text_field($metatitle));
		if ($result) {
			wp_send_json('Successful updated', 200);
		} else {
			wp_send_json_error('There is a error on updating data, please try again later', 400);
		}
	}
}
