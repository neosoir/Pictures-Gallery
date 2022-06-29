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
<div id="add_bcpg_table" class="modal">
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
                    <input id="nombre-tabla" type="text" class="validate">
                    <label for="nombre">Nombre de la tabla</label>
                </div>
           
            </div>
            
            <div class="row">
                <div class="col s4">
                    <button id="crear-tabla" class="btn waves-effect waves-light" type="button" name="action">
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
        <img src="<?= BCPG_PLUGIN_DIR_URL ?>admin/img/core.svg" alt="">
      </div>
    </div>
  </div>

  <div class="col s12">
    <div class="divider"></div>
  </div>

</div>







