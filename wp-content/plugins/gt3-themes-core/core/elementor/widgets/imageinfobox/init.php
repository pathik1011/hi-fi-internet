<?php

namespace ElementorModal\Widgets;

use Elementor\Widget_Base;

if(!defined('ABSPATH')) {
	exit;
}

if (!class_exists('ElementorModal\Widgets\GT3_Core_Elementor_Widget_ImageInfoBox')) {
	class GT3_Core_Elementor_Widget_ImageInfoBox extends \ElementorModal\Widgets\GT3_Core_Widget_Base {

		public function get_name(){
			return 'gt3-core-imageinfobox';
		}

		public function get_title(){
			return esc_html__('ImageInfoBox', 'gt3_themes_core');
		}

		public function get_icon(){
			return 'eicon-image-box';
		}

	}
}











