<?php

/**
  * Proporcionar una vista de área de administración para el plugin
  *
  * Este archivo se utiliza para marcar los aspectos de administración del plugin.
  *
  * @link https://beziercode.com.co
  * @since desde 1.0.0
  *
  * @package Beziercode_blank
  * @subpackage Beziercode_blank/admin/parcials
  */

/* Este archivo debe consistir principalmente en HTML con un poco de PHP. */

$sql = "SELECT id, nombre FROM " . BCPG_TABLE;
$result = $this->db->get_results( $sql );

?>

<!-- Modal Structure -->
<div id="addbcpg" class="modal">
    <div class="modal-content">
        
        <!-- Precargador -->
        
        <div class="precargador">
            
            <div class="preloader-wrapper big active">
              <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>
            </div>
            
            
        </div>
        
        <form method="post" class="col s12">
            <div class="row">
               
                <div class="input-field col s4">
                    <input id="nombre-bcpg" type="text" class="validate">
                    <label for="nombre-bcpg">Nombre de la Galeria</label>
                </div>
                <div class="input-field col s6">
                  <select name="type" id="type">
                    <option value="" disabled selected>Seleccionar tipo</option>
                    <option value="custom">Perzonalizada</option>
                    <option value="category">Categoría</option>
                  </select>
                </div>
           
            </div>
            
            <div class="row">
                <div class="col s4">
                    <button id="crear-bcpg" class="btn waves-effect waves-light" type="button" name="action">
                        Crear <i class="material-icons right">add</i>
                    </button>
                </div>
            </div>
            
        </form>
        
    </div>
</div>

<div class="had-container">

  <div class="row">
    <div class="col s12">
      <div class="logo-bcpg">
        <img src="<?= BCPG_PLUGIN_DIR_URL ?>admin/img/core-50.svg" alt="">
        <span class="border-v v-31"></span>
        <span><?= esc_html_e('Portafolio Galeria', 'bcpg_textdomain') ?></span>
      </div>
    </div>
  </div>

  <div class="col s12">
    <div class="divider"></div>
  </div>

  <!-- Button to add galery -->
  <div class="section">
    <div class="row">
      <div class="col s4">
        <button ty class="addbcpg btn-bcpg bcpg-bg-azul">Nuevo <i class="material-icons">insert_photo</i></button>
      </div>
    </div>
  </div>

  <!-- Table of shortcodes -->
  <div class="row">
    <div class="col s12">
      <div class="bcpg-table">
        <table class="responsive-table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Tipo</th>
              <th>shortcode</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Fotos</td>
              <td>Custom</td>
              <td>
                <input type="text" class="bcpg-input-shortcode" value='[bcpg id=\"1"]'>
              </td>
              <td>
                <span>
                  <i class="tiny material-icons">mode_edit</i>
                </span>
                <span>
                  <i class="tiny material-icons">close</i>
                </span>
              </td>
            </tr>
            <tr>
              <td>Fotos</td>
              <td>Custom</td>
              <td>
                <input type="text" class="bcpg-input-shortcode" value='[bcpg id=\"1"]'>
              </td>
              <td>
                <span>
                  <i class="tiny material-icons">mode_edit</i>
                </span>
                <span>
                  <i class="tiny material-icons">close</i>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>







