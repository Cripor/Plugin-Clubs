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

if ( ! class_exists( 'YITH_CR_Admin' ) ) {

	class YITH_CR_Admin {

		/**
		 * Main Instance
		 *
		 * @var YITH_CR_Admin
		 * @since 1.0
		 * @access private
		 */

		private static $instance;

		/**
		 * Main plugin Instance
		 *
		 * @return YITH_CR_Admin Main instance
		 * @author Carlos Rodríguez <carlos.rodriguez@yithemes.com>
		 */
		public static function get_instance() {
			return ! is_null( self::$instance ) ? self::$instance : self::$instance = new self();
		}

		/**
		 * YITH_PS_Admin constructor.
		 */
		private function __construct() {
			// add meta boxes 
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes_clubs' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes_players' ) );

			// saving meta data 
			add_action( 'save_post', array( $this, 'save_meta_box_clubs' ) );
			add_action( 'save_post', array( $this, 'save_meta_box_players' ) );

			// adding roles and caps
			add_action( 'init',  array( $this, 'add_users_roles' ) );
			add_action( 'init',  array( $this, 'add_new_cap' ) );
		}

		/**
		 * Setup the meta boxes for clubs and players
		 */
		public function add_meta_boxes_clubs() {
			add_meta_box(
				'yith-ps-additional-information',
				__( 'Additional information', 'yith-clubs-cristian' ),
				array( $this, 'view_meta_boxes_clubs' ),
				YITH_CR_Post_Types::$post_type_clubs
			);
		}

		public function add_meta_boxes_players() {
			add_meta_box(
				'yith-ps-additional-information',
				__( 'Additional information', 'yith-clubs-cristian' ),
				array( $this, 'view_meta_boxes_players' ),
				YITH_CR_Post_Types::$post_type_players
			);
		}

		/**
		 * Wiev meta boxes
		 *
		 * @param $post
		 */
		// view for clubs 
		public function view_meta_boxes_clubs( $post ) {
			yith_ps_get_view(
				'/metaboxes/cr-clubs-info-metabox.php',
				array( 'post' => $post )
			);
		}
		// view for players 
		public function view_meta_boxes_players( $post ) {
			yith_ps_get_view(
				'/metaboxes/cr-players-info-metabox.php',
				array( 'post' => $post )
			);
		}

		/**
		 * Save meta box values for clubs and players
		 *
		 * @param $post_id
		 */
		// save meta data for clubs
		public function save_meta_box_clubs( $post_id ) {

			if ( get_post_type( $post_id ) !== YITH_CR_Post_Types::$post_type_clubs ) {
				return;
			}

			if ( isset( $_POST['_yith_cr_year'] ) ) {
				update_post_meta( $post_id, '_yith_cr_year', $_POST['_yith_cr_year'] );
			}

			if ( isset( $_POST['_yith_cr_stadium'] ) ) {
				update_post_meta( $post_id, '_yith_cr_stadium', $_POST['_yith_cr_stadium'] );
			}

		}

		// save meta data for players
		public function save_meta_box_players( $post_id ) {

			if ( get_post_type( $post_id ) !== YITH_CR_Post_Types::$post_type_players ) {
				return;
			}

			if ( isset( $_POST['_yith_cr_nationality'] ) ) {
				update_post_meta( $post_id, '_yith_cr_nationality', $_POST['_yith_cr_nationality'] );
			}

			if ( isset( $_POST['_yith_cr_number'] ) ) {
				update_post_meta( $post_id, '_yith_cr_number', $_POST['_yith_cr_number'] );
			}

		}

					// add roles

		public function add_users_roles() {

			add_role(
				'manager_de_clubs', //  System name of the role.
				__( 'Manager de clubs'  ), // Display name of the role.
				array(
					'read'  => true,
					'delete_posts'  => false,
					'delete_published_posts' => false,
					'edit_posts'   => false,
					'publish_posts' => false,
					'upload_files'  => false,
					'edit_pages'  => false,
					'edit_published_pages'  =>  false,
					'publish_pages'  => false,
					'delete_published_pages' => false, // This user will NOT be able to  delete published pages.
					'read_club'  => true,
					'read_clubs'  => true,
				)
			);
		}


		public function add_new_cap() {

			$role = get_role( 'administrator' );
			$role->add_cap( 'read_club' );
			$role->add_cap( 'read_clubs' );
			$role->add_cap( 'edit_club' );
			$role->add_cap( 'edit_clubs' );
			$role->add_cap( 'delete_club' );
			$role->add_cap( 'delete_clubs' );
			$role->add_cap( 'publish_club' );
			$role->add_cap( 'publish_clubs' );
			$role->add_cap( 'read_player' );
			$role->add_cap( 'read_players' );
			$role->add_cap( 'edit_player' );
			$role->add_cap( 'edit_players' );
			$role->add_cap( 'delete_player' );
			$role->add_cap( 'delete_players' );
			$role->add_cap( 'publish_player' );
			$role->add_cap( 'publish_players' );

			$manager_role = get_role('manager_de_clubs');
			$manager_role->add_cap('read_club');
			$manager_role->add_cap('edit_club');
			$manager_role->add_cap('delete_club');
			$manager_role->add_cap('publish_club');
			$manager_role->add_cap('read_player');
			$manager_role->add_cap('edit_player');
			$manager_role->add_cap('delete_player');
			$manager_role->add_cap('publish_player');
		}
	}
}