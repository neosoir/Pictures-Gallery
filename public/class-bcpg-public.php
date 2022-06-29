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
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        
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
        wp_enqueue_script( $this->plugin_name, BCPG_PLUGIN_DIR_URL . 'public/js/bcpg-public.js', array( 'jquery' ), $this->version, true );
        
    }
    
    public function shortcode_id( $atts, $content = '' ) {
        
        $args = shortcode_atts([
            'id'    => ''
        ], $atts);
        
        extract( $args, EXTR_OVERWRITE );
        
        if( $id != '' ) {
            
            $sql = $this->db->prepare("SELECT nombre, data FROM " . BCPG_TABLE . " WHERE id = %d", $id );
            $resultado = $this->db->get_results( $sql );
            
            if( $resultado[0]->data != '' ) {
                
                $data   = json_decode( $resultado[0]->data, true );
                $nombre = $resultado[0]->nombre;
                
                $output = "";
                
            } else {
                
                $output = "<h5>[No hay información con el ID #$id]";
                
            }
            
            return $output;
            
        }
        
    }
    
}









