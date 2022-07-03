<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       https://beziercode.com.co
 * @since      1.0.0
 *
 * @package    plugin_name
 * @subpackage plugin_name/admin
 */

/**
 * Define el nombre del plugin, la versión y dos métodos para
 * Encolar la hoja de estilos específica de administración y JavaScript.
 * 
 * @since      1.0.0
 * @package    BCPortfolioGallery
 * @subpackage BCPortfolioGallery/admin
 * @author     Gilbert Rodríguez <email@example.com>
 * 
 * @property string $plugin_name
 * @property string $version
 */
class BCPG_Public {
    
    /**
	 * El identificador único de éste plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name  El nombre o identificador único de éste plugin
	 */
    private $plugin_name;
    
    /**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version  La versión actual del plugin
	 */
    private $version;
    
    /**
	 * Objeto wpdb
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $db @global $wpdb
	 */
    private $db;
    
        /**
	 * Objeto BCPG_Normalize
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $normalize Instancia del objeto BCPG_Normalize
	 */
    private $normalize;
    
    /**
	 * Objeto BCPG_Helpers
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $helpers Instancia del objeto BCPG_Helpers
	 */
    private $helpers;

    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->helpers = new BCPG_Helpers;
        $this->normalize = new BCPG_Normalize;
        
        global $wpdb;
        $this->db = $wpdb;
        
    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_styles() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BCPG_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BCPG_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */

        /**
         * Framework Materializecss
         * http://materializecss.com/getting-started.html
         * Material Icons Google
         * https://material.io/icons/
         */
		wp_enqueue_style( 'bcpg_material_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $this->version, 'all' );

        /**
         * bcpg.min.css
         * Archivo de hojas de estilos principales
         * de la administración
         */
		wp_enqueue_style( 'jquery_bcpg_css', BCPG_PLUGIN_DIR_URL . 'helpers/jquery-bcpg/css/bcpg.min.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, BCPG_PLUGIN_DIR_URL . 'public/css/bcpg-public.css', array(), $this->version, 'all' );
        
    }
    
    /**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_scripts() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BCPG_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BCPG_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */

        /**
         * bcpg.min.js
         * Archivo Javascript principal
         * de la administración
         */
        wp_enqueue_script( 'jquery_bcpg_js', BCPG_PLUGIN_DIR_URL . 'helpers/jquery-bcpg/js/bcpg.min.js', ['jquery'], $this->version, true );

        wp_enqueue_script( $this->plugin_name, BCPG_PLUGIN_DIR_URL . 'public/js/bcpg-public.js', array( 'jquery' ), $this->version, true );
        
    }
    
    public function shortcode_id( $atts, $content = '' ) {
        
        $args = shortcode_atts([
            'id'    => ''
        ], $atts);
        
        extract( $args, EXTR_OVERWRITE );
        
        if( $id != '' ) {

            require_once BCPG_PLUGIN_DIR_PATH . 'public/partials/bcpg-public-display.php';
            
            return $output;
            
        }
        
    }
    
}









