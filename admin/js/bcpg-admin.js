(function( $ ) {
	'use strict';

	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */

    // Start the jquery plugin
    $('.bcpg-container').bcpg();
    
    var $precargador    = $('.precargador'),
        urledit         = "?page=bcpg&action=edit&id=",
        idTable        = $('#idTable').val(),
        marco;
    
    /**
     * Helpers 
     */
    
    /* Limpiador de enlaces para las imagenes */
    function limpiarEnlace( url ) {
        
        var local = /localhost/;
        
        if( local.test( url ) ) {
            
            var url_pathname    = location.pathname,
                indexPos        = url_pathname.indexOf( 'wp-admin' ),
                url_pos         = url_pathname.substr( 0, indexPos ),
                url_delete      = location.protocol + "//" + location.host + url_pos;
            
            return url_pos + url.replace( url_delete, '' );
            
        } else {
            
            var url_real = location.protocol + '//' + location.hostname;
            return url.replace( url_real, '' );
            
        }
        
    }
    
    /* Validando que los campos no estén vacíos */
    function validarCamposVacios( selector ) {
        
        var $inputs = $( selector ),
            result  = false;
        
        $.each( $inputs, function(k,v){
            
            var $input      = $(v),
                inputVal    = $input.val();
            
            if( inputVal == '' && $input.attr('type') != 'file' ) {
                
                if( ! $input.hasClass( 'invalid' ) ) {
                    
                    $input.addClass( 'invalid' );
                    
                }
                
                result = true;
                
            }
            
        });
        
        if( result ) {
            return true;
        } else {
            return false;
        }
        
    }
    
    function validarEmail( email ) {
        
        var er  = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;        
        
        return er.test( email );
        
    }
    
    function quitarInvalid( selector ) {
        
        var $inputs = $( selector );
        
        $.each( $inputs, function(k,v){
            
            var $input = $(v);
            
            if( $input.hasClass( 'invalid' ) ) {
                $input.removeClass( 'invalid' );
            } else if( $input.hasClass( 'active' ) ) {
                $input.removeClass( 'active' );
            }
            
        });
        
    }

    function templateItems( arrItems ) {
        
        var template = '';

        for ( var i in arrItems ) {
            
            var url =  arrItems[i].url ,
                id  = arrItems[i].id;

            template += `
                <li class="col bcpg-item" data-f="" data-id="${id}">

                    <div class="bcpg-box">
                        <div class="edit-item">
                            <i class="material-icons">edit</i>
                        </div>
                        <div class="remove-item">
                            <i class="material-icons">close</i>
                        </div>
                        <div class="bcpg-masc">
                            <i class="material-icons bcpg_img">zoom_in</i>
                        </div>
                        <img src="${url}" alt="">
                    </div>

                </li>`;
            
        }

        return template;

    }
    
    $('.modal').modal();
    $('select').material_select();
    
    /* Modal con formulario para crear tabla */
    $('.addbcpg').on( 'click', function(e){
        e.preventDefault();
        $('#addbcpg').modal('open');
    });

    var $type               = $('#type'),
        type_val            = null,
        $select             = $('.select-dropdown'),
        $selectionCustom    = $('#custom'),
        $selectionCategory  = $('#category'),
        $setCategory        = $('#setCategory');

    /**
     * Analizando el tipo de galeria
     * para mostrar y ocultar ajusters y selecciones.
     */
     
    if ( $type.val() =='custom' ) {
        $selectionCustom.css('display', 'block');
        $selectionCategory.css('display', 'none');
        $setCategory.css('display', 'none');
    }
    else if ( $type.val() =='category' ) {
        $selectionCustom.css('display', 'none');
        $selectionCategory.css('display', 'block');
        $setCategory.css('display', 'block');
    }

    $type.on('change',  function() {

        type_val = $(this).val();

        if ( $select.hasClass('invalid') ) {
            $select.removeClass('invalid');
            $select.addClass('valid'); 
        }
        if ( type_val =='custom' ) {
            $selectionCustom.css('display', 'block');
            $selectionCategory.css('display', 'none');
            $setCategory.css('display', 'none');
        }
        else if ( type_val =='category' ) {
            $selectionCustom.css('display', 'none');
            $selectionCategory.css('display', 'block');
            $setCategory.css('display', 'block');
        }

    });

    
    /**
     * Evento click para guardar
     * el registro en la base de datos
     * utilizando AJAX
     */
    $('#crear-bcpg').on( 'click', function(e){
        e.preventDefault();
        
        var $nombre = $('#nombre-bcpg'),
            nv =  $nombre.val();

        $precargador.css( 'display', 'flex' );
        
        if( nv == '' ) {
            
            $precargador.css( 'display', 'none' );

            if ( ! $nombre.hasClass('invalid') ) {
                $nombre.addClass('invalid');
            }

        }
        else if ( ( type_val == null ) || ( type_val == '' ) ) {

            $precargador.css( 'display', 'none' );

            if ( ! $select.hasClass('invalid') ) {
                $select.addClass('invalid');
                $select.removeClass('valid');   
            }

        }
        else {
            // Envío de AJAX
        
            $.ajax({
                url         : bcpg.url,
                type        : 'POST',
                dataType    : 'json',
                data : {
                    action      : 'bcpg_crud_gallery',
                    nonce       : bcpg.seguridad,
                    nombre      : nv,
                    type_val    : type_val,
                    tipo        : 'add'
                }, 
                success      : function( data ) {
                    
                    if( data.result ) {
                        
                        urledit += data.insert_id;
                        
                        setTimeout(function(){
                            location.href = urledit;
                        }, 1300 );
                        
                    }
                    
                }, 
                error: function( d,x,v ) {
                    
                    console.log(d);
                    console.log(x);
                    console.log(v);
                    
                }
            });

        }
        
    });

    /**
     * Edit forder.
     */
    $(document).on('click', '[idbcpgedit]', function() {
        var id = $(this).attr('idbcpgedit');
        location.href = urledit + id;
    });

    /**
     * Delete item
     */
     $(document).on('click', '[idbcpgremove]', function(){

        var id      = $(this).attr('idbcpgremove'),
            $tr     = $('tr[data-bcpg="'+id+'"]'),
            nombre  = $tr.find( $('td:nth-child(1)') ).text();

        swal({
            title               : "¿Estás seguro que quieres eliminar la galería '" + nombre + "'?",
            text                : "No podrás deshacer esto!",
            type                : "warning",
            showCancelButton    : true,
            confirmButtonColor  : "#DD6B55",
            confirmButtonText   : "Si, borrarlo",
            closeOnConfirm      : false,
            showLoaderOnConfirm : true,
            html                : true
        }, function(isConfirm){

            if( isConfirm ) {

                $.ajax({
                    url         : bcpg.url,
                    type        : 'POST',
                    dataType    : 'json',
                    data : {
                        action      : 'bcpg_crud_gallery',
                        nonce       : bcpg.seguridad,
                        tipo        : 'delete',
                        idgal       : id
                    }, success : function( data ) {

                        if( data.result ) {

                            setTimeout(function(){

                                swal({
                                    title       : "Borrado",
                                    text        : "La galería " + nombre + " ha sido eliminado",
                                    type        : "success",
                                    timer       : 1500
                                });
                                $tr.css({
                                    "background" : "red",
                                    "color"      : "white"
                                }).fadeOut(600)
                                setTimeout(function(){
                                    $tr.remove();
                                }, 1000);

                            }, 1500);

                        } else {

                            swal({
                                title   : 'Error',
                                text    : 'Hubo un error al eliminar la galería, por favor intenta más tarde',
                                type    : 'error',
                                timer   : 2000
                            });

                        }

                    }, error: function( d,x,v ) {

                        console.log(d);
                        console.log(x);
                        console.log(v);

                    }
                });

            } else {



            }

        });

    });

    var $addItems = $('#addItems'),
        marco;

    $addItems.on('click', function() {
        console.log('hola')
        if (marco) {
            marco.open();
            return;
        }

        marco = wp.media({
            title   : 'Seleccionar esta imagen',
            button  : {
                text : 'Usar esta imagen'
            },
            multiple : true,
            library  : {
                type  : 'image'
            }
        });

        marco.on('select', function () {

            var adjuntos = marco.state().get('selection').map(function (adj) {
                return adj.toJSON();
            });

            var output = templateItems( adjuntos );
            $('.bcpg-container').append( output )

        });

    });

})( jQuery );















