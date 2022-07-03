<?php

$id = $_GET['id'];
$sql = $this->db->prepare("SELECT * FROM " . BCPG_TABLE . " WHERE id = %d", $id );
$resultado = $this->db->get_results( $sql );

$data       = json_decode( $resultado[0]->data, true );
$items      = $data['items'];
$settings   = $data['settings'];

?>

<!-- Estructura Modal para la edición de items -->
<div id="bpcg-item-edit" class="modal">

    <div class="modal-content">
        
        <div class="modal-header">
            <div class="row mb0">
                <div class="col s8">
                    <h5><?= _e('Editar item', 'bcpg-textdomain') ?></h5>
                </div>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <input id="edit-item-id" type="hidden" value="">
        
        <!-- Sección imagen -->
        <h6 class="title-modal">Media:</h6>
        
        <div class="content-item">
            
            <div class="row mb0">
                <div class="col m4">
                    <p><?= _e('Imagen', 'bcpg-textdomain') ?>:</p>                    
                </div>
                <div class="col m4">
                    <button type="button" id="change-img-item" class="btn-bcpg bcpg-bg-azul">
                        Cambiar imagen <i class="material-icons">cached</i>
                    </button>
                    <br>
                    <br>
                    <img id="edit-item-img" src="" alt="">
                </div>
            </div>
            
        </div>
        
        <!-- Sección campos de datos -->
        <h6 class="title-modal">Datos:</h6>
        
        <div class="content-item">
            
            <!-- Campo título -->
            <div class="row mb0">
               
               <div class="col m4">
                   <h6><?= _e('Título', 'bcpg-textdomain') ?>:</h6>
               </div>
               <div class="bcpg-input col m7">
                   <input id="edit-item-title" type="text" placeholder="Título">
               </div>
               
            </div>
            
            <!-- Campo filtros -->
            <div class="row mb0">
               
               <div class="col m4">
                   <h6><?= _e('Filtros', 'bcpg-textdomain') ?>:</h6>
               </div>
               <div class="bcpg-input col m7">
                   <input id="edit-item-filters" type="text" placeholder="Ej: diseño,operación">
               </div>
               
            </div>
            
        </div>
        
        <div class="row mb0">
            <div class="col s12 right-align">
               <br>
                <button type="button" id="update-item" class="modal-action modal-close btn waves-effect waves-light">Actualizar</button>
            </div>
        </div>
        
    </div>
</div>

<!-- Estructure of edit page -->
<div class="had-container">
      
        <div class="row">

            <div class="col s12">
                <div class="logo-bcpg">
                    <img src="<?= BCPG_PLUGIN_DIR_URL ?>admin/img/core-50.svg" alt="">
                    <span class="border-v v-31"></span>
                    <span><?= esc_html_e('Portafolio Galería', 'bcpg_textdomain') ?></span>
                </div>
            </div>
            
            <div class="col s12">
                <div class="divider"></div>
            </div>
            
        </div>
      
      <div class="row">
          
        <form method="post" id="bcpg-edit-formu">
            
            <div class="row">
            
                <!-- Nombre y Tipo de galería  -->
                <input id="idgalbcpg" type="hidden" value="<?= $id ?>">
            
                <div class="bcpg-input col m4">
                    <input id="nombregalbcpg" type="text" class="" value="<?= $resultado[0]->nombre ?>">
                </div>

                <div class="col m4">
                
                    <select id="type">
                        <option value="" disabled selected>Selecciona el tipo</option>
                        <option value="custom"   <?= selected( $resultado[0]->tipo, 'custom' ) ?>>Personalizada</option>
                        <option value="category" <?= selected( $resultado[0]->tipo, 'category' ) ?>>Categoría</option>
                    </select>

                </div>
                
                <div class="col s12">
                    <div class="divider"></div>
                </div>
                
                <div class="col s12">

                    <div class="row">
                        
                        <!-- Zona de edición de los items -->
                        <div class="col m8">
                            
                            <!-- Sección personalizada -->
                            <section id="custom">
                                
                                <!-- Botones de filtrado -->
                                <div class="row mb0">
                                    <div class="col s12">
                                        <ul class="bcpg-ul">
                                            <li data-filter="*" class="activo"><?= _e('Todo', 'bcpg-textdomain'); ?></li>
                                            <?php if( $resultado[0]->data != '' ) echo $this->helpers->add_btn_filters( $items ); ?>
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- Botón agregar items -->
                                <div class="row">
                                    <div class="col s12">
                                        <button type="button" id="addItems" class="btn-bcpg bcpg-bg-azul">
                                            <?= _e('Agregar items', 'bcpg-textdomain') ?> 
                                            <i class="material-icons">add</i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Contenido de los items -->
                                <div id="content_gallery" class="row">
                                    
                                    <ul class="bcpg-container">

                                        <?php
                                            
                                        if( $resultado[0]->data != '' ) {

                                            $output        = '';
                                            $val_columns   = $settings['columns'];
                                            
                                            switch( $val_columns ) {
                                                case 2:
                                                    $column = 'm6';
                                                    break;
                                                case 3:
                                                    $column = 'm4';
                                                    break;
                                                case 4:
                                                    $column = 'm3';
                                                    break;
                                                
                                            }
                                            
                                            foreach( $items as $item ){
                                                
                                                $media     = $item['media'];
                                                $title     = $item['title'];
                                                $filters   = $item['filters'];
                                                $filters2  = $this->normalize->init( $item['filters'] );
                                                $id        = $item['id'];
                                                
                                                if( $title != '' ) {
                                                    $title_output = "
                                                        <div class='title-item'>
                                                            <h5>$title</h5>
                                                        </div>
                                                    ";
                                                } 
                                                
                                                else {
                                                    $title_output = '';
                                                }
                                                
                                                $output .= "
                                                    <li class='col $column bcpg-item' 
                                                        data-f='$filters2' 
                                                        data-id='$id' 
                                                        data-src='$media' 
                                                        data-value='media=$media;title=$title;filters=$filters;id=$id'
                                                    >
                                                    
                                                        <div class='bcpg-box'>
                                                            <div class='edit-item'>
                                                                <i class='material-icons'>edit</i>
                                                            </div>
                                                            $title_output
                                                            <div class='remove-item'>
                                                                <i class='material-icons'>close</i>
                                                            </div>
                                                            <div class='bcpg-masc'>
                                                                <i class='material-icons bcpg_img'>zoom_in</i>
                                                            </div>
                                                            <img src='$media' alt='$title'>
                                                        </div>

                                                    </li>
                                                ";
                                                
                                            }
                                            
                                            echo $output;
                                            
                                        }
                                            
                                        ?>
                                    </ul>
                                
                                <!-- End contenido de los items -->
                                </div>
                            
                            <!-- End sección personalizada -->
                            </section>
                            
                            <!-- Sección categría -->
                            <section id="category">
                            
                                <div class="loaderengine">
                                    <img src="<?= BCPG_PLUGIN_DIR_URL . '/admin/img/loader.gif' ?>" alt="">
                                </div>
                                 
                                <div class="row">

                                    <div class="categoryTemplate">
                                        <!-- Here come the categories (use js to display) -->
                                    </div>

                                </div>
                            
                            <!-- End ección categría -->
                            </section>         

                        <!-- End zona de edición de los items --> 
                        </div>
                        
                        <!-- Zona de ajustes -->
                        <div class="col m4">
                            
                            <div class="" style="border-left:1px solid #DDDDDD">
                                
                                <div class="row">
                                    
                                    <div class="col s12">
                                        <h5><?= _e( 'Ajustes', 'bcpg-textdomain' ) ?></h5>
                                        <div class="divider"></div>
                                    </div>
                                    
                                </div>
                                
                                <?php 
                                // correct value in colums
                                $resultado[0]->data != '' ? $selected = '' : $selected = 'selected';
                                if( ! isset($val_columns) ) $val_columns = '';
                                ?>
                                
                                <!-- Columnas -->
                                <div class="row">
                                    <div class="col s12">
                                        <label for="columnas">Columnas</label>
                                        <select id="columnas">
                                            <option value="" disabled>Seleciona las columnas</option>
                                            <option value="2" <?= selected( $val_columns, 2 ) ?>>2</option>
                                            <option value="3" <?= $selected; selected( $val_columns, 3 ) ?>>3</option>
                                            <option value="4" <?= selected( $val_columns, 4 ) ?>>4</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Ajuste de la categoría -->
                                <div id="setCategory">

                                    <div class="row">
                                        
                                        <!-- Categoría -->
                                        <div class="col s12">
                                        
                                            <label for="categorias">Categorías</label>
                                            <select id="categorias">
                                                <option value="" selected disabled>Seleciona la categoría</option>
                                                <?php
                                                                                            
                                                $categories = get_categories( [
                                                    'orderby'       => 'name',
                                                    'taxonomy'      => 'category'
                                                ] );

                                                foreach( $categories as $category )
                                                    echo "<option value='{$category->cat_ID}'" . selected( $settings['category'], $category->cat_ID ) . " > ". ucfirst( $category->name ) ." </option>";

                                                ?>
                                                   
                                            </select>
                                                
                                        </div>
                                            
                                        <!-- Límite -->
                                        <div class="col s12">
                                            
                                            <div class="bcpg-input col s12">
                                                <label for="limite"></label>
                                                <input type="text" id="limite" value="<?= isset( $postPerPage ) && $postPerPage != '' ? $postPerPage : '-1'; ?>" disabled>
                                            </div>
                                            
                                        </div>
                                        
                                        <!-- Orden -->
                                        <div class="col s12">
                                        
                                            <label for="orden">Orden</label>
                                            <select id="orden" disabled>
                                                <option value="" disabled>Selecciona orden</option>
                                                <option value="desc" <?= $selected; selected( $order, 'desc' ) ?>>Descendente</option>
                                                <option value="asc" <?= selected( $order, 'asc' ) ?>>Ascendente</option>
                                            </select>
                                            
                                        </div>
                                            
                                        <!-- Ordenar Por -->
                                        <div class="col s12">
                                        
                                            <label for="orderby">Ordenar por</label>
                                            <select id="orderby" disabled>
                                                <option value="" disabled>Selecciona el orden por</option>
                                                <option value="date"    <?= $selected; selected( $orderby, 'date' ) ?>>Fecha</option>
                                                <option value="author"  <?= selected( $orderby, 'author' ) ?>>Autor</option>
                                                <option value="title"   <?= selected( $orderby, 'title' ) ?>>Título</option>
                                                <option value="name"    <?= selected( $orderby, 'name' ) ?>>Nombre (slug)</option>
                                                <option value="rand"    <?= selected( $orderby, 'rand' ) ?>>Aleatorio</option>
                                            </select>
                                            
                                        </div>
                                            
                                    </div>                                 
                                    
                                </div>
                                
                            </div>

                        <!-- End zona de ajustes --> 
                        </div>

                    <!-- End div class="row"--> 
                    </div>

                <!-- End div class="col s12"--> 
                </div>

            <!-- End div class="row" -->
            </div>
                
        </form>
          
    </div>
    
    <button type="button" id="guardar-items" class="btn-bcpg bcpg-bg-verde">
        <?= _e( 'Guardar', 'bcpg-textdomain' ) ?> 
        <i class="material-icons">save</i> 
    </button>
    <a href="?page=bcpg" id="cancelar" class="btn-bcpg bcpg-bg-azulC">
        <?= _e( 'Cancelar', 'bcpg-textdomain' ) ?> <i class="material-icons">close</i> 
    </a>
    
</div>



