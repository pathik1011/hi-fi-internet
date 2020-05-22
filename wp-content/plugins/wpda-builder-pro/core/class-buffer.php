<?php

namespace WPDaddy\Builder;
defined('ABSPATH') OR exit;

use DOMDocument;
use DOMXPath;
use Elementor\Plugin as Elementor_Plugin;

class Buffer {
	private static $instance = null;

	/** @return self */
	public static function instance(){
		if(is_null(static::$instance)) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct(){
		if($this->is_work()) {
			ob_start(array( $this, 'ob_finish' ));
			add_action('wp', array( $this, 'wp_head' ), 50);
			add_filter('cache_enabler_before_store', array( $this, 'ob_finish' ));
		}
	}

	private function is_work(){
		static $answer = null;
		if(!is_null($answer)) {
			return $answer;
		}

		if(is_admin() || defined('WPDA_PANEL_ENABLED')) {
			return ($answer = false);
		}

		$answer = true;

		return $answer;
	}

	public function wp_head(){
		$header    = false;
		$footer    = false;
		$_header   = false;
		$_footer   = false;
		$elementor = Elementor_Plugin::instance();

		$settings = Settings::instance()->get_settings();

		if(!$this->is_work()) {
			return;
		}
		if(is_singular()) {
			$_header = get_post_meta(get_the_ID(), '_wpda-builder-header', true);
			if(!empty($_header)) {
				$header = $elementor->frontend->get_builder_content_for_display($_header);
			} else {
				$_header = false;
			}

			$_footer = get_post_meta(get_the_ID(), '_wpda-builder-footer', true);
			if(!empty($_footer)) {
				$footer = $elementor->frontend->get_builder_content_for_display($_footer);
			} else {
				$_footer = false;
			}
		}

		if(false === $header) {
			$headers            = new \WP_Query(
				array(
					'post_type'      => 'elementor_library',
					'posts_per_page' => '-1',
					'meta_query'     => array_merge(
						array(
							'relation' => 'AND',
						),
						array(
							array(
								'key'   => '_elementor_template_type',
								'value' => 'wpda-header',
							),
							array(
								'key'   => '_wpda-builder-active',
								'value' => true,
							)
						)
					),
					'fields'         => 'ids',
					'no_found_rows'  => true
				)
			);
			$default_conditions = array(
				array(
					'type'  => 'include',
					'key'   => 'none',
					'value' => [],
				)
			);
			if($headers->have_posts()) {
				$all_headers  = array();
				$is_condition = false;
				foreach($headers->posts as $_header_id) {
					$conditions = get_post_meta($_header_id, '_wpda-builder-conditions', true);
					try {
						$conditions = json_decode($conditions, true);
						if(json_last_error() || !is_array($conditions)) {
							$conditions = $default_conditions;
						}
					} catch(\Exception $ex) {
						$conditions = $default_conditions;
					}

					foreach($conditions as $condition) {
						$condition = $condition['key'];

						if($condition === 'all') {
							$all_headers[] = $_header_id;
							break;
						}
						$is_condition = ($condition !== 'none');
						if($is_condition) {
							$is_condition = (
								($condition === 'all') || (function_exists($condition)
								                           && !!call_user_func($condition)));
							if($is_condition) {
								$_header = $_header_id;
								$header  = $elementor->frontend->get_builder_content_for_display($_header);
								break;
							}
						}
					}
					if(false !== $header) {
						break;
					}
				}
				if(false === $header && count($all_headers)) {
					foreach($all_headers as $header_id) {
						$header = $elementor->frontend->get_builder_content_for_display($header_id);

						$_header = $header_id;
						if(!empty($header)) {
							break;
						}
					}
				}
			}
		}

		if(false === $footer) {
			$footers            = new \WP_Query(
				array(
					'post_type'      => 'elementor_library',
					'posts_per_page' => '-1',
					'meta_query'     => array_merge(
						array(
							'relation' => 'AND',
						),
						array(
							array(
								'key'   => '_elementor_template_type',
								'value' => 'wpda-footer',
							),
							array(
								'key'   => '_wpda-builder-active',
								'value' => true,
							)
						)
					),
					'fields'         => 'ids',
					'no_found_rows'  => true
				)
			);
			$default_conditions = array(
				array(
					'type'  => 'include',
					'key'   => 'none',
					'value' => [],
				)
			);
			if($footers->have_posts()) {
				$all_footers  = array();
				$is_condition = false;
				foreach($footers->posts as $_footer_id) {
					$conditions = get_post_meta($_footer_id, '_wpda-builder-conditions', true);
					try {
						$conditions = json_decode($conditions, true);
						if(json_last_error() || !is_array($conditions)) {
							$conditions = $default_conditions;
						}
					} catch(\Exception $ex) {
						$conditions = $default_conditions;
					}

					foreach($conditions as $condition) {
						$condition = $condition['key'];

						if($condition === 'all') {
							$all_footers[] = $_footer_id;
							break;
						}
						$is_condition = ($condition !== 'none');
						if($is_condition) {
							$is_condition = (
								($condition === 'all') || (function_exists($condition)
								                           && !!call_user_func($condition)));
							if($is_condition) {
								$_footer = $_footer_id;
								$footer  = $elementor->frontend->get_builder_content_for_display($_footer);
								break;
							}
						}
					}
					if(false !== $footer) {
						break;
					}
				}
				if(false === $footer && count($all_footers)) {
					foreach($all_footers as $footer_id) {
						$footer = $elementor->frontend->get_builder_content_for_display($footer_id);

						$_footer = $footer_id;
						if(!empty($footer)) {
							break;
						}
					}
				}
			}
		}

		if(!empty($_header) || !empty($_footer)) {
			$elementor->frontend->enqueue_styles();
			$elementor->frontend->enqueue_scripts();
		}

		wp_cache_delete('render_header', 'wpda_builder');
		wp_cache_set('render_header', $header, 'wpda_builder', 30);
		wp_cache_delete('render_footer', 'wpda_builder');
		wp_cache_set('render_footer', $footer, 'wpda_builder', 30);
	}

	public function ob_finish($buffer){

		if(!$this->is_work()) {
			return false;
		}
		$settings = Settings::instance()->get_settings();
		if(empty($settings['header_area']) && empty($settings['footer_area'])/*|| !$settings['current_header']*/) {
			return false;
		}

		$document = new \WPDaddy\Dom\HTMLDocument($buffer);
		$oldNode  = $document->querySelector($settings['header_area']);

		if(null !== $oldNode) {
			$content = wp_cache_get('render_header', 'wpda_builder');
			wp_cache_delete('render_header', 'wpda_builder');
			if(false !== $content) {
				$replacement = $document->createDocumentFragment();
				$replacement->appendHTML($content);
				$oldNode->replaceWith($replacement);
			}
		}

		$oldNode = $document->querySelector($settings['footer_area']);
		if(null !== $oldNode) {
			$content = wp_cache_get('render_footer', 'wpda_builder');
			wp_cache_delete('render_footer', 'wpda_builder');
			if(false !== $content) {
				$replacement = $document->createDocumentFragment();
				$replacement->appendHTML($content);
				$oldNode->replaceWith($replacement);
			}
		}

		return $document;
	}

}
