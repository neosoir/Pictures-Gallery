<?php

/**
 * Se activa en la activación del plugin
 *
 * @link       https://beziercode.com.co
 * @since      1.0.0
 *
 * @package    BCPortfolioGallery
 * @subpackage BCPortfolioGallery/includes
 */

/**
 * Ésta clase define todo lo necesario durante la activación del plugin
 *
 * @since      1.0.0
 * @package    BCPortfolioGallery
 * @subpackage BCPortfolioGallery/includes
 * @author     Gilbert Rodríguez <email@example.com>
 */
class BCPG_Activator {

	/**
	 * Método estático que se ejecuta al activar el plugin
	 *
	 * Creación de la tabla {$wpdb->prefix}beziercode_data
     * para guardar toda la información necesaria
	 *
	 * @since 1.0.0
     * @access public static
	 */
	public static function activate() {
        
        global $wpdb;
        
        /*$sql = "CREATE TABLE IF NOT EXISTS " . BCPG_TABLE . "(
            id int(11) NOT NULL AUTO_INCREMENT,
            nombre varchar(50) NOT NULL,
            data longtext NOT NULL,
            PRIMARY KEY (id)
        );";
        
        $wpdb->query( $sql );*/
        
	}

}





