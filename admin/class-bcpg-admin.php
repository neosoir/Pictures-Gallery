<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       https://beziercode.com.co
 * @since      1.0.0
 *
 * @package    Beziercode_blank
 * @subpackage Beziercode_blank/admin
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
class BCPG_Admin {
    
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
	 * Objeto registrador de menús
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $build_menupage  Instancia del objeto BCPG_Build_Menupage
	 */
    private $build_menupage;
    
    /**
	 * Objeto wpdb
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $db @global $wpdb
	 */
    private $db;
    
    /**
	 * Objeto BCPG_CRUD_JSON
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $crud_json Instancia del objeto BCPG_CRUD_JSON
	 */
    private $crud_json;
    
    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->build_menupage = new BCPG_Build_Menupage();
        
        global $wpdb;
        $this->db = $wpdb;
        
    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
     * @access   public
     *
     * @param    string   $hook    Devuelve el texto del slug del menú con el texto toplevel_page
	 */
    public function enqueue_styles( $hook ) {
        
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
         * bcpg-admin.css
         * Archivo de hojas de estilos principales
         * de la administración
         */
		wp_enqueue_style( 'bcpg_wordpress_icons_css', BCPG_PLUGIN_DIR_URL . 'admin/css/bcpg-wordpress.css', array(), $this->version, 'all' );
        
        /**
         * Condicional para controlar la carga de los archivos
         * solamente en la página del plugin
         */
        if( $hook != 'toplevel_page_bcpg' ) {
            return;
        }
        
        /**
         * Framework Materializecss
         * http://materializecss.com/getting-started.html
         * Material Icons Google
         * https://material.io/icons/
         */
		wp_enqueue_style( 'bcpg_material_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $this->version, 'all' );
		wp_enqueue_style( 'bcpg_materialize_admin_css', BCPG_PLUGIN_DIR_URL . 'helpers/materialize/css/materialize.min.css', array(), '0.100.1', 'all' );
        
        /**
         * Sweet Alert
         * http://t4t5.github.io/sweetalert/
         */
		wp_enqueue_style( 'bcpg_sweet_alert_css', BCPG_PLUGIN_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.css', array(), $this->version, 'all' );
        
        /**
         * bcpg.min.css
         * Archivo de hojas de estilos principales
         * de la administración
         */
		wp_enqueue_style( 'jquery_bcpg_css', BCPG_PLUGIN_DIR_URL . 'helpers/jquery-bcpg/css/bcpg.min.css', array(), $this->version, 'all' );

        /**
         * bcpg-admin.css
         * Archivo de hojas de estilos principales
         * de la administración
         */
		wp_enqueue_style( $this->plugin_name, BCPG_PLUGIN_DIR_URL . 'admin/css/bcpg-admin.css', array(), $this->version, 'all' );
        
    }
    
    /**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    1.0.0
     * @access   public
     *
     * @param    string   $hook    Devuelve el texto del slug del menú con el texto toplevel_page
	 */
    public function enqueue_scripts( $hook ) {
        
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
         * Condicional para controlar la carga de los archivos
         * solamente en la página del plugin
         */
        if( $hook != 'toplevel_page_bcpg' ) {
            return;
        }
        
        wp_enqueue_media();
        
        /**
         * Framework Materializecss
         * http://materializecss.com/getting-started.html
         * Material Icons Google
         */
		wp_enqueue_script( 'bcpg_materialize_admin_js', BCPG_PLUGIN_DIR_URL . 'helpers/materialize/js/materialize.min.js', ['jquery'], '0.100.1', true );
        
        /**
         * Sweet Alert
         * http://t4t5.github.io/sweetalert/
         */
		wp_enqueue_script( 'bcpg_sweet_alert_js', BCPG_PLUGIN_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.min.js', ['jquery'], $this->version, true );
        
        /**
         * bcpg.min.js
         * Archivo Javascript principal
         * de la administración
         */
        wp_enqueue_script( 'jquery_bcpg_js', BCPG_PLUGIN_DIR_URL . 'helpers/jquery-bcpg/js/bcpg.min.js', ['jquery'], $this->version, true );

        /**
         * bcpg-admin.js
         * Archivo Javascript principal
         * de la administración
         */
        wp_enqueue_script( $this->plugin_name, BCPG_PLUGIN_DIR_URL . 'admin/js/bcpg-admin.js', ['jquery'], $this->version, true );
        
        /**
         * Lozalizando el archivo Javascript
         * principal del área de administración
         * para pasarle el objeto "bcpg" con los parámetros:
         * 
         * @param bcpg.url        Url del archivo admin-ajax.php
         * @param bcpg.seguridad  Nonce de seguridad para el envío seguro de datos
         */
        wp_localize_script(
            $this->plugin_name,
            'bcpg',
            [
                'url'       => admin_url( 'admin-ajax.php' ),
                'seguridad' => wp_create_nonce( 'bcpg_seg' )
            ]
        );
        
    }
    
    /**
	 * Registra los menús del plugin en el
     * área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function add_menu() {
        
        $this->build_menupage->add_menu_page(
            __( 'Portafolio Galería', 'bcpg-textdomain' ),
            __( 'Portafolio Galería', 'bcpg-textdomain' ),
            'manage_options',
            'bcpg',
            [ $this, 'controlador_display_menu' ],
            'dashicons-bcpg',
            22
        );
        
        $this->build_menupage->run();
        
    }
    
    /**
	 * Controla las visualizaciones del menú
     * en el área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function controlador_display_menu() {
        
        if(
            $_GET['page'] == 'bcpg' &&
            isset($_GET['action']) &&
            isset( $_GET['id'] )
        ) {
            if( $_GET['action'] == 'edit' ) {
                require_once BCPG_PLUGIN_DIR_PATH . 'admin/partials/bcpg-admin-display-edit.php';
            }
        } else {
            require_once BCPG_PLUGIN_DIR_PATH . 'admin/partials/bcpg-admin-display.php';
        }
        
        
    }
    
    /**
	 * Método que controla el envío
     * de datos con POST, desde el lado público
     * hacia el lado del servidor
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function ajax_crud_gallery() {
        
        check_ajax_referer( 'bcpg_seg', 'nonce' );
        
        if( current_user_can( 'manage_options' ) ) {
            
            extract( $_POST, EXTR_OVERWRITE );
            
            if( $tipo == 'add' ) {
                
                $columns = [
                    'nombre'    => $nombre,
                    'tipo'      => $type_val,
                    'data'      => '',
                ];
                
                $format = [
                    "%s",
                    "%s",
                    "%s"
                ];

                $result = $this->db->insert( BCPG_TABLE, $columns, $format );

                $json = json_encode( [
                    'result'        => $result,
                    'nombre'        => $nombre,
                    'insert_id'     => $this->db->insert_id
                ] );
                
            } 
            
            elseif( $tipo == 'delete' ) {
                
                $where = [
                    'id' => $idgal
                ];
                
                $where_format = [
                    "%s"
                ];
                
                $result = $this->db->delete( BCPG_TABLE, $where, $where_format );
                
                $json = json_encode( [
                    'result'        =>  $result,
                    'nombre'        =>  $nombre,
                    'insert_id'     =>  $this->db>-insert_id
                ] );
                
            }
            
            echo $json;
            wp_die();
            
        }
        
    }
    
    /**
	 * Método que controla el envío
     * de datos con POST, desde el lado público
     * hacia el lado del servidor
     * para guardar la información en
     * formato JSON
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function ajax_data() {
        
        check_ajax_referer( 'bcpg_seg', 'nonce' );
        
        if( current_user_can( 'manage_options' ) ) {
            
            extract( $_POST, EXTR_OVERWRITE );
            
            $data = stripslashes( $data );
            
            $columns = [
                'nombre'    => $nombregalbcpg,
                'tipo'      => $type,
                'data'      => $data
            ];

            $where = [
                "id" => $idgalbcpg
            ];

            $format = [
                "%s",
                "%s",
                "%s"
            ];

            $where_format = [
                "%d"
            ];

            $result_update = $this->db->update( BCPG_TABLE, $columns, $where, $format, $where_format );

            $json = json_encode( [
                'result'        => $result_update
            ] );
            
            echo $json;
            wp_die();
            
        }
        
    }
    
    /**
	 * Método que controla el envío
     * de datos con POST, desde el lado público
     * hacia el lado del servidor
     * para obtener la configuración
     * de que tipo de categoría mostrar
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function ajax_categorias() {
        
        check_ajax_referer( 'bcpg_seg', 'nonce' );
        
        if( current_user_can( 'manage_options' ) ) {
            
            extract( $_POST, EXTR_OVERWRITE );
            
            $args_query = [
                'cat'               => $cat_ID,
                'posts_per_page'    => $postPerPage,
                'order'             => $orden,
                'orderby'           => $orderby
            ];
            
            $query = new WP_Query( $args_query );
            $posts = [];
            $c = 0;
            
            if( $query->have_posts() ) {
                
                while( $query->have_posts() ) {
                    
                    $query->the_post();
                    
                    $posts[$c]['title']     = get_the_title();
                    $posts[$c]['content']   = get_the_content();
                    $posts[$c]['excerpt']   = get_the_excerpt();
                    
                    if( has_post_thumbnail() ) {
                        
                        $posts[$c]['imgtag'] = get_the_post_thumbnail(
                            get_the_ID(),
                            'medium',
                            [
                                'class' => 'bcpg-img-tag'
                            ]
                        );
                        
                        $posts[$c]['imgurl'] = get_the_post_thumbnail_url(
                            get_the_ID(),
                            'medium'
                        );
                        
                    } else {
                        $posts[$c]['imgtag'] = null;
                        $posts[$c]['imgurl'] = null;
                    }
                    
                    $posts[$c]['link'] = get_the_permalink();
                    $posts[$c]['time'] = get_the_time( 'F j Y' );
                    
                    $c++;
                    
                }
                
            }
            wp_reset_postdata();

            $json = json_encode( [
                'posts' => $posts
            ] );
            
            echo $json;
            wp_die();
            
        }
        
    }
    
}




















