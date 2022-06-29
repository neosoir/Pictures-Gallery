(function( $ ) {
	'use strict';

	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */
    
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
    
    $('.modal').modal();
    $('select').material_select();
    
    /* Modal con formulario para crear tabla */
    $('.addbcpg').on( 'click', function(e){
        e.preventDefault();
        $('#addbcpg').modal('open');
    });
    
    /**
     * Evento click para guardar
     * el registro en la base de datos
     * utilizando AJAX
     */
    $('#crear-tabla').on( 'click', function(e){
        e.preventDefault();
        
        var $nombre = $('#nombre-tabla'),
            nv =  $nombre.val();
        
        if( nv != '' ) {
            
            $precargador.css( 'display', 'flex' );
            
            // Envío de AJAX
            
            $.ajax({
                url         : bcpg.url,
                type        : 'POST',
                dataType    : 'json',
                data : {
                    action  : 'bcpg_crud_table',
                    nonce   : bcpg.seguridad,
                    nombre  : nv,
                    tipo    : 'add'
                }, success  : function( data ) {
                    
                    if( data.result ) {
                        
                        urledit += data.insert_id;
                        
                        setTimeout(function(){
                            location.href = urledit;
                        }, 1300 );
                        
                    }
                    
                }, error: function( d,x,v ) {
                    
                    console.log(d);
                    console.log(x);
                    console.log(v);
                    
                }
            });
            
        } else {
            
            $precargador.css( 'display', 'none' );
            
            if( ! $nombre.hasClass('invalid') ) {
                $nombre.addClass('invalid');
            }
            
        }
        
    });
    
    

})( jQuery );















