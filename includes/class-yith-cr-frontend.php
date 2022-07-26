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

if ( ! class_exists( 'YITH_CR_Frontend' ) ) {

	class YITH_CR_Frontend {

		/**
		 * Main Instance
		 *
		 * @var YITH_CR_Frontend
		 * @since 1.0
		 * @access private
		 */

		private static $instance;

		/**
		 * Main plugin Instance
		 *
		 * @return YITH_CR_Frontend Main instance
		 * @author Carlos Rodríguez <carlos.rodriguez@yithemes.com>
		 */
		public static function get_instance() {
			return ! is_null( self::$instance ) ? self::$instance : self::$instance = new self();
		}

		/**
		 * YITH_PS_Frotend constructor.
		 */
		private function __construct() {
			add_shortcode( 'get_players', 'yith_show_players' );
			add_shortcode( 'get_clubs', 'yith_club_description' );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts_styles' ) );
		}

		public function load_scripts_styles() {
			wp_enqueue_style( 'clubs-style', YITH_PS_DIR_ASSETS_CSS_URL . '/mystyle.css', array(), true,   );
		}
	}
}



function yith_club_description( $atts = '' ) {
/* Uso: 
Filter by club ej: [get_clubs clubs="barcelona"] ->use slug;
Filter by name ej: [get_clubs name="Johnathan Rivers"] ->use title(player name) */
//Additional info to show by shortcode: [get_clubs additional="what an awesome player"]

	$args1 = array(
		'post_type'   => 'clubs-cr', //nombre de mi Custom Post Type
		'numberposts' => 6,
		'post_id'	  => '',
	);

	$args = shortcode_atts(
		array(
			'clubs' => '',
			'name'  => '',
			'additional'=> '',
		),
		$atts
	);

	$my_posts = get_posts( $args1 );

	ob_start();

	echo '<div class="register"> <h4>Clubes registrados:</h4> </div>';

	if( ! empty( $my_posts ) && is_user_logged_in() && current_user_can( 'read_club' ) ){
		$output = '<div>';
		foreach ( $my_posts as $my_post ){
			$image = get_the_post_thumbnail($my_post->ID, 'thumbnail');
			$year = get_post_meta($my_post->ID, '_yith_cr_year', true);
			$stadium = get_post_meta($my_post->ID, '_yith_cr_stadium', true);
			echo '<div class="club-cards">' .  '<h2>' . $my_post->post_title . '</h2>' . $image . '<br>' . 'Year: ' . $year . '<br>' . 'Stadium: ' . $stadium  . '</div>';
		}
		$output = '</div>';
	} elseif ( is_user_logged_in() && (current_user_can( 'read_club' ) == false) ) {
		echo "El contenido está restringido para algunos usuarios, ponte en contacto con el administrador";
	} else {
		$login = wp_login_url();
		echo   "El contenido solo está disponible para usuarios logueados " . '<a href="' . $login . '">Click aquí para loguear' . '</a>';
	}


	echo '<div class="register"> <h4>Jugadores filtrados : </h4> </div>';

	if ($args['clubs'] && is_user_logged_in() && current_user_can( 'read_club' )) {
		$query = array(
			'post_type' => 'players-cr',
			'show_image' => 'yes',
			'tax_query' => array(
				array(
					'taxonomy' => 'club',
					'field' => 'slug',
					'terms' => $args ['clubs'],
				)
			)
		);
		$posts = get_posts($query);
		echo '<div>';
			foreach( $posts as $post ) {
					$title = get_the_title($post->ID);
					$image = get_the_post_thumbnail($post->ID, 'thumbnail');
					$nationality = get_post_meta($post->ID, '_yith_cr_nationality', true);
					$number = get_post_meta($post->ID, '_yith_cr_number', true);
					echo  '<div class="players">' . $title . $image . $post->post_content . '<br>' . 'Nacionality:' . '<br>'  . $nationality . '<br>' . 'Dorsal :' . '<br>' . $number . '<br>' . '<hr>' ;
					if ( ($args['additional']) ) {
						echo ($args['additional']);
					}
				}
		echo '</div>';
	}

	if ( $args['name'] && is_user_logged_in() && current_user_can( 'read_club' )) {
		$query2 = array(
			'post_type' => 'players-cr',
			'show_image'=> 'yes',
			'name'      =>  $args ['name'],
		);
	$posts2 = get_posts($query2);
	echo '<div>';
		foreach( $posts2 as $post ) {
				$title = get_the_title($post->ID);
				$image = get_the_post_thumbnail($post->ID, 'thumbnail');
				$nationality = get_post_meta($post->ID, '_yith_cr_nationality', true);
				$number = get_post_meta($post->ID, '_yith_cr_number', true);
				echo  '<div class="players">' . $title . $image . $post->post_content . '<br>' . 'Nacionality:' . '<br>'  . $nationality . '<br>' . 'Dorsal :' . '<br>' . $number . '<br>' . '<hr>' ;
				if ( ($args['additional']) ) {
					echo ($args['additional']);
				}
			}
	echo '</div>';
	}  elseif ( is_user_logged_in() && (current_user_can( 'read_club' ) == false) ) {
		echo "El contenido está restringido para algunos usuarios, ponte en contacto con el administrador";
	}  else{
		$login = wp_login_url();
		echo   "El contenido solo está disponible para usuarios logueados " . '<a href="' . $login . '">Click aquí para loguear' . '</a>';
	}

	return ob_get_clean();
}


function yith_show_players($atts = '') {
	//Filter by club ej: [get_players clubs="barcelona"] ->use slug
	//or just [get_players] to show every player
	$args = shortcode_atts(
		array(
			'clubs' => '',
		),
		$atts
	);
	ob_start();
	if ($args['clubs'] && is_user_logged_in() && current_user_can( 'read_club' )) {
		$query = array(
			'post_type' => 'players-cr',
			'show_image' => 'yes',
			'tax_query' => array(
				array(
					'taxonomy' => 'club',
					'field' => 'slug',
					'terms' => $args ['clubs'],
				)
			)
		);
		$posts = get_posts($query);
		echo '<div>';
			foreach( $posts as $post ) {
					$title = get_the_title($post->ID);
					$image = get_the_post_thumbnail($post->ID, 'thumbnail');
					$nationality = get_post_meta($post->ID, '_yith_cr_nationality', true);
					$number = get_post_meta($post->ID, '_yith_cr_number', true);
					echo  '<div class="players">' . $title . $image . $post->post_content . '<br>' . 'Nacionality:' . '<br>'  . $nationality . '<br>' . 'Dorsal :' . '<br>' . $number . '<br>' .'<hr>' ;
				}
		echo '</div>';
	} elseif ($args['clubs'] == '' && is_user_logged_in() && current_user_can( 'read_club' )) {
		$query = array(
			'post_type' => 'players-cr',
			'show_image' => 'yes',
		);
		$posts = get_posts($query);
		echo '<div>';
			foreach( $posts as $post ) {
					$title = get_the_title($post->ID);
					$image = get_the_post_thumbnail($post->ID, 'thumbnail');
					$nationality = get_post_meta($post->ID, '_yith_cr_nationality', true);
					$number = get_post_meta($post->ID, '_yith_cr_number', true);
					echo  '<div class="players">' . $title . $image . $post->post_content . '<br>' . 'Nacionality:' . '<br>'  . $nationality . '<br>' . 'Dorsal :' . '<br>' . $number . '<br>' .'<hr>' ;
				}
		echo '</div>';
	} elseif ( is_user_logged_in() && (current_user_can( 'read_club' ) == false) ) {
		$args = array(
			'post_type'   => 'players-cr',
			'numberposts' => 2,
		);
			$my_posts = get_posts( $args );
			if( ! empty( $my_posts ) ){
				foreach( $my_posts as $post ) {
					$title = get_the_title($post->ID);
					$image = get_the_post_thumbnail($post->ID, 'thumbnail');
					$nationality = get_post_meta($post->ID, '_yith_cr_nationality', true);
					$number = get_post_meta($post->ID, '_yith_cr_number', true);
					echo  '<div class="players">' . $title . $image . $post->post_content . '<br>' . 'Nacionality:' . '<br>'  . $nationality . '<br>' . 'Dorsal :' . '<br>' . $number . '<br>' .'<hr>' ;
				}
			}
		echo "<strong>El contenido está restringido para algunos usuarios, ponte en contacto con el administrador</strong>";
	} else {
		$login = wp_login_url();
		echo   "El contenido solo está disponible para usuarios logueados " . '<a href="' . $login . '">Click aquí para loguear' . '</a>';
	}

	return ob_get_clean();
}