<?php

namespace WPDaddy\Builder;
defined('ABSPATH') OR exit;

use Elementor\Plugin;
use WPDaddy\Builder\Library\Footer;
use WPDaddy\Builder\Library\Header;

class Init {
	use Trait_REST;
	private static $instance = null;

	/** @return self */
	public static function instance(){
		if(is_null(static::$instance)) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct(){
		Elementor::instance();
		Menu::instance();
		Settings::instance();
		Assets::instance();

		add_action('wp', array( __CLASS__, 'action_wp' ));

		add_filter(
			'elementor/document/urls/preview', function($url, $post){
			if(isset($_GET['template_post']) && !empty($_GET['template_post'])) {
				$url = add_query_arg(
					array(
						'template_post' => $_GET['template_post'],
					), $url
				);
			}

			return $url;
		}, 999, 2
		);

		add_action('elementor/documents/register', [ $this, 'register_default_types' ], 0);
		add_filter('single_template', array( Header::class, 'load_canvas_template' ));
		add_filter('single_template', array( Footer::class, 'load_canvas_template' ));

		add_action(
			'admin_enqueue_scripts', function(){
			Assets::enqueue_style('wpda-admin-style', 'admin.css');
		}
		);

		$this->init_trait_rest();
	}


	public function register_default_types(){
		if(isset($_REQUEST['elementor_library_type'])) {
			switch ($_REQUEST['elementor_library_type'] === Header::$name) {
				case Header::$name:
					add_action('manage_elementor_library_posts_custom_column', array( Header::class, 'manage_posts_custom_column' ), 10, 2);
					add_filter('manage_elementor_library_posts_columns', array( Header::class, 'manage_posts_columns' ));
				break;
				case Footer::$name:
					add_action('manage_elementor_library_posts_custom_column', array( Footer::class, 'manage_posts_custom_column' ), 10, 2);
					add_filter('manage_elementor_library_posts_columns', array( Footer::class, 'manage_posts_columns' ));
				break;
			}
		}

		Plugin::instance()->documents->register_document_type(Header::$name, Header::class);
		Plugin::instance()->documents->register_document_type(Footer::$name, Footer::class);
	}

	public static function action_wp(){
		// Frontend
		Frontend::instance();
		Buffer::instance();

	}
}


