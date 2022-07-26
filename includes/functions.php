<?php
/*
 * This file belongs to the YITH PS Plugin Skeleton.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

// HERE SET FUNCTIONS TO USE ON YOUR PROJECT LIKE Template functions

/**
 * Include templates
 *
 * @param $file_name name of the file you want to include.
 * @param array $args (array) (optional) Arguments to retrieve.
 */
if ( ! function_exists( 'yith_cr_get_template' ) ) {
	function yith_ps_get_template( $file_name, $args = array() ) {
		extract( $args );
		$full_path = YITH_PS_DIR_TEMPLATES_PATH . $file_name;
		if ( file_exists( $full_path ) ) {
			include $full_path;
		}
	}
}

/**
 * Include views
 *
 * @param $file_name name of the file you want to include.
 * @param array $args (array) (optional) Arguments to retrieve.
 */
if ( ! function_exists( 'yith_cr_get_view' ) ) {
	function yith_ps_get_view( $file_name, $args = array() ) {
		extract( $args );
		$full_path = YITH_PS_DIR_VIEWS_PATH . $file_name;
		if ( file_exists( $full_path ) ) {
			include $full_path;
		}
	}
}
