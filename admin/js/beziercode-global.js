( function ( global, jQuery, nucleo ) {
    
    nucleo( global, jQuery );

})( typeof window !== 'undefined' ? window : this, jQuery, function ( window, $ ) {
    
    /**
     * Constructor autoejecutable
     */
    var Beziercode = (function () {

        var core = {

            /* Limpiador de enlaces para las imagenes */
            limpiarEnlace       :   function ( url ) {
                
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
                
            },
            /* Validando que los campos no estén vacíos */
            validarCamposVacios :   function ( selector ) {
                
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
                
            },
            validarEmail        :   function ( email ) {
        
                var er  = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;        
                
                return er.test( email );
                
            },
            quitarInvalid       :   function ( selector ) {
        
                var $inputs = $( selector );
                
                $.each( $inputs, function(k,v){
                    
                    var $input = $(v);
                    
                    if( $input.hasClass( 'invalid' ) ) {
                        $input.removeClass( 'invalid' );
                    } else if( $input.hasClass( 'active' ) ) {
                        $input.removeClass( 'active' );
                    }
                    
                });
                
            },
                // Add img to edid page
            templateItems   :   function ( arrItems ) {
        
                var template    = '',
                    col         = parseInt( $('#columnas').val() ),
                    classCol    = '';

                    switch (col) {
                        case 2:
                            classCol = 'm6'
                            break;
                            
                        case 3:
                            classCol = 'm4'
                            break;

                        case 4:
                            classCol = 'm3'
                            break;
                
                        default:
                            break;
                    }

                for ( var i in arrItems ) {
                    
                    var url =  arrItems[i].url ,
                        id  = arrItems[i].id;

                    template += `
                        <li class="col ${ classCol } bcpg-item" data-f="" data-id="${id}">

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

        }

        return core;
        
    })();

    window.Beziercode = window.$bc = Beziercode;

});