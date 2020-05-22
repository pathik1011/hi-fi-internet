<?php

namespace WPDaddy\Builder;

final class Assets {
	private static $instance  = null;
	private static $dist_url  = '';
	private static $dist_path = '';
	private static $js_url    = '';
	private static $js_path   = '';
	private static $css_url   = '';
	private static $css_path  = '';

	/** @return \WPDaddy\Builder\Assets */
	public static function instance(){
		if(is_null(static::$instance)) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct(){
		self::$dist_url = plugin_dir_url(WPDA_PRO_HEADER_BUILDER__FILE).'dist/';
		self::$js_url   = self::$dist_url.'js/';
		self::$css_url  = self::$dist_url.'css/';

		self::$dist_path = plugin_dir_path(WPDA_PRO_HEADER_BUILDER__FILE).'dist/';
		self::$js_path   = self::$dist_path.'js/';
		self::$css_path  = self::$dist_path.'css/';
	}

	public static function enqueue_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all'){
		if(!file_exists(self::$css_path.$src)) {
			trigger_error('Css file <b>'.$src.'</b> not found.', E_USER_WARNING);

			return;
		}
		wp_enqueue_style(
			$handle,
			self::$css_url.$src,
			$deps,
			filemtime(self::$css_path.$src),
			$media
		);
	}

	public static function enqueue_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = true){
		if(!file_exists(self::$js_path.$src)) {
			trigger_error('JS file <b>'.$src.'</b> not found.', E_USER_WARNING);

			return;
		}
		wp_enqueue_script(
			$handle,
			self::$js_url.$src,
			$deps,
			filemtime(self::$js_path.$src),
			$in_footer
		);
	}

	public static function get_dist_url() {
		return self::$dist_url;
	}
}
