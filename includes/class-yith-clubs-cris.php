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

if ( ! class_exists( 'YITH_CR_Plugin_Clubs' ) ) {
	class YITH_CR_Plugin_Clubs {

        /**
		 * Main Instance
		 *
		 * @var YITH_CR_Plugin_Clubs
		 * @since 1.0
		 * @access private
		 */

		private static $instance;
        /**
		 * Main Admin Instance
		 *
		 * @var YITH_CR_Plugin_Clubs_Admin
		 * @since 1.0
		 */
		public $admin = null;
		/**
		 * Main Frontpage Instance
		 *
		 * @var YITH_CR_Plugin_Clubs_Frontend
		 * @since 1.0
		 */
        public $frontend = null;
        
        /**
         * Main plugin Instance
         *
         * @return YITH_CR_Plugin_Clubs Main instance
         * @author Carlos Rodríguez <carlos.rodriguez@yithemes.com>
         */
		public static function get_instance() {
			return ! is_null( self::$instance ) ? self::$instance : self::$instance = new self();

			// ternary operator --> https://www.codementor.io/@sayantinideb/ternary-operator-in-php-how-to-use-the-php-ternary-operator-x0ubd3po6 
        }
        

		private function __construct() {


            $require = apply_filters('yith_ps_require_class',
				 array(
					'common'   => array(
						'includes/class-yith-cr-post-types.php',
						'includes/functions.php',
						//'includes/class-yith-ps-ajax.php',
						//'includes/class-yith-ps-compatibility.php',
						//'includes/class-yith-ps-other-class.php',
					),
					'admin' => array(
						'includes/class-yith-cr-admin.php',
					),
					'frontend' => array(
						'includes/class-yith-cr-frontend.php',
					),
				)
			);

			$this->_require($require);

			$this->init_classes();

			/* 
				Here set any other hooks ( actions or filters you'll use on this class)
			*/
			
			// Finally call the init function
			$this->init();

		
		}
	
		/**
		 * Add the main classes file
		 *
		 * Include the admin and frontend classes
		 *
		 * @param $main_classes array The require classes file path
		 *
		 * @author Carlos Rodríguez <carlos.rodriguez@yithemes.com>
		 * @since  1.0
		 *
		 * @return void
		 * @access protected
		 */
		protected function _require($main_classes)
		{
			foreach ($main_classes as $section => $classes) {
				foreach ($classes as $class) {
					if ('common' == $section || ('frontend' == $section && !is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) || ('admin' == $section && is_admin()) && file_exists(YITH_PS_DIR_PATH . $class)) {
						require_once(YITH_PS_DIR_PATH . $class);
					}
				}
			}
		}

		/**
		 * Init common class if they are necessary
		 * @author Carlos Rodríguez <carlos.rodriguez@yithemes.com>
		 * @since  1.0
		 **/
		public function init_classes(){
			//$this->function = YITH_PS_Other_Class::get_instance();
			//$this->ajax = YITH_PS_Ajax::get_instance();
			//$this->compatibility = YITH_PS_Compatibility::get_instance();
			YITH_CR_Post_Types::get_instance();
		}

		/**
         * Function init()
         *
         * Instance the admin or frontend classes
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yithemes.com>
         * @since  1.0
         * @return void
         * @access protected
         */
        public function init()
        {
            if (is_admin()) {
                $this->admin =  YITH_CR_Admin::get_instance();
            }

            if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
                $this->frontend = YITH_CR_Frontend::get_instance();
            }
        }

	}	
}
/**
 * Get the YITH_CR_Plugin_Clubs instance
 *
 * @return YITH_CR_Plugin_Clubs
 */
if ( ! function_exists( 'yith_cr_plugin_clubs' ) ) {
	function yith_cr_plugin_clubs() {
		return YITH_CR_Plugin_Clubs::get_instance();
	}
}