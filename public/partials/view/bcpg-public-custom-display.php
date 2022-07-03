<?php

$output = '
    <div class="bcpg-row mb0">
         <div class="col s12">
             <ul class="bcpg-ul">
                 <li data-filter="*" class="activo">' . __('Todo', 'bcpg-textdomain') . '</li>';

                     $output .= $this->helpers->add_btn_filters( $items );

$output .= '
            </ul>
         </div>
     </div>';

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

$output .= '
    <div id="content_gallery" class="bcpg-row">
        <ul class="bcpg-container">';

foreach( $items as $item ){
                                                 
 $media     = $item['media'];
 $title     = ( $item['title'] != '' ) ? "<div class='title-item'><h5>{$item['title']}</h5></div>" : '' ;
 $filters   = $this->normalize->init( $item['filters'] );

 $output .= "
    <li class='col $column bcpg-item' data-f='$filters'>
        <div class='bcpg-box'>
           $title
            <div class='bcpg-masc'>
                <i class='material-icons bcpg_img'>zoom_in</i>
            </div>
            <img src='$media' alt='{$item['title']}'>
        </div>
    </li>";

}

$output .= '
        </ul>
    </div>';























