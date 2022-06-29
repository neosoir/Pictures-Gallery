<?php

/**
 * Se activa en la desactivación del plugin
 *
 * @link       https://beziercode.com.co
 * @since      1.0.0
 *
 * @package    BCPortfolioGallery
 * @subpackage BCPortfolioGallery/includes
 */

/**
 * Ésta clase define todo lo necesario durante la desactivación del plugin
 *
 * @since      1.0.0
 * @package    BCPortfolioGallery
 * @subpackage BCPortfolioGallery/includes
 * @author     Gilbert Rodríguez <email@example.com>
 */

class BCPG_Deactivator {

	/**
	 * Método estático
	 *
	 * Método que se ejecuta al desactivar el plugin
	 *
	 * @since 1.0.0
     * @access public static
	 */
	public static function deactivate() {
        
        flush_rewrite_rules();
        
	}

}