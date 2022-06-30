<?php

$id = $_GET['id'];
$sql = $this->db->prepare("SELECT * FROM " . BCPG_TABLE . " WHERE id = %d", $id );
$resultado = $this->db->get_results( $sql );

?>
<div class="had-container">

    <div class="row">
        <div class="col s12">
            <div class="logo-bcpg">
            <img src="<?= BCPG_PLUGIN_DIR_URL ?>admin/img/core-50.svg" alt="">
            <span class="border-v v-31"></span>
            <span><?= esc_html_e('Portafolio Galeria', 'bcpg_textdomain') ?></span>
            </div>
        </div>

        <div class="col s12">
            <div class="divider"></div>
        </div>
    </div>

    <div class="row">
        <form id="bcpg-edit-form">
            <!-- Nombre y tipo de galeria -->
            <div class="row">

                <input id="idgalbcpg" type="hidden" value="<?= $id ?>">

                <div class="input-input col s4">
                    <input id="nombregalbcpg" type="text" class="" value="<?= $resultado[0]->nombre ?>">
                </div>

                <div class="input-field col s4">
                  <select name="type" id="type">
                    <option value="" disabled selected>Seleccionar tipo</option>
                    <option value="custom" <?= selected( $resultado[0]->tipo, "custom" ) ?>>Perzonalizada</option>
                    <option value="category" <?= selected( $resultado[0]->tipo, "category"  ) ?>>Categoría</option>
                  </select>
                </div>

                <div class="col s12">
                    <div class="divider"></div>
                </div>

                <div class="col s12">
                    <div class="row">
                        <!-- Zona de edicion de los items -->
                        <div class="col m8">

                        </div>
                        <!-- Zona de ajustes-->
                        <div class="col m4">

                        </div>
                    </div>
                </div>
        

            </div>

        </form>
    </div>



</div>




