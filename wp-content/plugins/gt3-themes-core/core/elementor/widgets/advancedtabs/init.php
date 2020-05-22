<?php

namespace ElementorModal\Widgets;

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;

if(!defined('ABSPATH')) {
	exit;
}

if (!class_exists('ElementorModal\Widgets\GT3_Core_Elementor_Widget_AdvancedTabs')) {
	class GT3_Core_Elementor_Widget_AdvancedTabs extends \ElementorModal\Widgets\GT3_Core_Widget_Base {

		public function get_name(){
			return 'gt3-core-advanced-tabs';
		}

		public function get_title(){
			return esc_html__('Advanced Tabs', 'gt3_themes_core');
		}

		public function get_icon(){
			return 'eicon-library-download';
		}

		protected function construct() {
			$this->add_script_depends('jquery-ui-tabs');
			wp_enqueue_style('jquery-ui');

			$this->add_script_depends('jquery-ui-accordion');
		}

	}
}











