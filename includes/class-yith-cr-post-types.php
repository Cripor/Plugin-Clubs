<?php
/*
 * This file belongs to the YITH PS Plugin Skeleton.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'YITH_PS_VERSION' ) ) {
	exit( 'Direct access forbidden.' );
}

if ( ! class_exists( 'YITH_CR_Post_Types' ) ) {

	class YITH_CR_Post_Types {

		/**
		 * Main Instance
		 *
		 * @var YITH_CR_Post_Types
		 * @since 1.0
		 * @access private
		 */

		private static $instance;

		/**
		 * Post type name
		 *
		 * @var YITH_CR_Post_Types
		 * @since 1.0
		 * @access public
		 */
		public static $post_type_clubs = 'clubs-cr';
		public static $post_type_players = 'players-cr';

		/**
		 * Main plugin Instance
		 *
		 * @return YITH_CR_Post_Types Main instance
		 * @author Carlos Rodríguez <carlos.rodriguez@yithemes.com>
		 */
		public static function get_instance() {
			return ! is_null( self::$instance ) ? self::$instance : self::$instance = new self();
		}

		/**
		 * YITH_PS_Post_Types constructor.
		 */
		private function __construct() {
			add_action( 'init', array( $this, 'setup_post_type' ) );
			add_action( 'init', array( $this, 'register_taxonomies' ) );
		}

		public function setup_post_type() {
			$post_types =  apply_filters(
				'yps_post_types',
				array(
			self::$post_type_clubs => array(
						'label'                 => __( 'Clubs', 'text_domain' ),
						'description'           => __( 'CPT for clubs', 'text_domain' ),
						'supports'              => array( 'title', 'editor', 'thumbnail', 'author'),
						'taxonomies'            => array( 'none' ),
						'capability_type'		=> array( 'club', 'clubs'),
						'public'                => true,
						'show_ui'               => true,
						'show_in_menu'          => true,
						'menu_icon'             => 'dashicons-groups',
						'rewrite'               => true,
					),
			self::$post_type_players => array(
						'label'                 => __( 'Jugadores', 'text_domain' ),
						'description'           => __( 'CPT for players', 'text_domain' ),
						'supports'              => array( 'title', 'editor', 'thumbnail', 'author'),
						'taxonomies'  			=> array( 'nacionalidad', 'genero', 'club' ),
						'capability_type'		=> array( 'player', 'players'),
						'public'                => true,
						'show_ui'               => true,
						'show_in_menu'          => true,
						'menu_icon'             => 'dashicons-smiley',
						'rewrite'               => true,
					),
				)
			);

			foreach ( $post_types as $post_type => $post_types_args ) {
					register_post_type( $post_type, $post_types_args );
			}
		}

		public function register_taxonomies(){
			$args = array(
				'label'		=> __( 'Nationality', 'players_taxonomies'),
				'labels'	=> [
					'separate_items_with_commas' => __('separe las personas con comas' , 'players_taxonomies')
				],
				'hierarchical' => false,
			);
			register_taxonomy( 'nacionalidad' , self::$post_type_players , $args);

			$args = array(
				'label'		=> __( 'Gender', 'players_taxonomies'),
				'labels'	=> [
					'separate_items_with_commas' => __('separe las personas con comas' , 'players_taxonomies')
				],
				'hierarchical' => false,
			);
			register_taxonomy( 'genero' , self::$post_type_players , $args);

			$args = array(
				'label'		=> __( 'Club', 'players_taxonomies'),
				'labels'	=> [
					'separate_items_with_commas' => __('separe las personas con comas' , 'players_taxonomies')
				],
				'hierarchical' => false,
			);
			register_taxonomy( 'club' , self::$post_type_players , $args);
		}
	};
}
