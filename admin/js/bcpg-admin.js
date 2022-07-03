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

    /**
     * Select img of wordpress.
     */
    var $addItems = $('#addItems'),
        marco;

    $addItems.on('click', function() {
        
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

            var output = Beziercode.templateItems( adjuntos );
            $('.bcpg-container').append( output )

        });

        marco.open();

    });

    /**
     *  Change the img depending th columns.
     */ 
    $('#columnas').on('change', function (params) {
        
        var $this       = $(this),
            valor       = parseInt( $this.val() ),
            $items      = $('.bcpg-item'),
            $itemsCat   = $('.bcpg-carditem');

        if ( $items.length ) {

            var arrClass    = $items.attr('class').split(' '),
               er          = /m[346]/,
                r           = null,
                col         = null;

            for (var i in arrClass) {

                if( typeof arrClass[i] != 'function' ) {
                    r = arrClass[i].match( er );
                    if( r != null ) col = r['input'];
                }
            }

            if ( col !== null ) {

                if ( $items ) {
                    if ( $items.hasClass(col) ) {

                        $items.removeClass(col);

                        switch ( valor ) {

                            case 2:
                                $items.addClass('m6');
                                break;
                                
                            case 3:
                                $items.addClass('m4');
                                break;
    
                            case 4:
                                $items.addClass('m3');
                                break;
                    
                        }

                    }

                }
                
            }
            
        }

        if ( $itemsCat.length ) {

            var arrClass    = $itemsCat.attr('class').split(' '),
                er          = /m[346]/,
                r           = null,
                col         = null;

            for (var i in arrClass) {

                if( typeof arrClass[i] != 'function' ) {
                    r = arrClass[i].match( er );
                    if( r != null ) col = r['input'];
                }
            }

            if ( col !== null ) {

                if ( $itemsCat ) {

                    if ( $itemsCat.hasClass(col) ) {

                        $itemsCat.removeClass(col);

                        switch ( valor ) {
                            
                            case 2:
                                $itemsCat.addClass('m6');
                                break;
                                
                            case 3:
                                $itemsCat.addClass('m4');
                                break;
    
                            case 4:
                                $itemsCat.addClass('m3');
                                break;
                    
                        }

                    }

                }
                
            }
            
        }



    });

    /**
     * Edit img of edit page.
     */
    $(document).on('click','.edit-item', function () {
        
        $('#bpcg-item-edit').modal('open');

        var $li         = $(this).parents('li'),
            id          = $li.attr('data-id'),
            title       = $li.attr('data-title'),
            src         = $li.attr('data-src'),
            dataValue   = $li.attr('data-value'),
            filters     = dataValue.split(';');

        var er      = /filters/,
            r       = null,
            arf     = null;

        for (const i in filters) {

            if( typeof filters[i] != 'function' ) {
                r = filters[i].match(er);

                if ( r !== null ) {
                    arf = r['input'].split('=');
                }
            }
        }

        if ( arf !== null ) {
            $('#edit-item-filters').val(arf[1]);   
        }
        else {
            $('#edit-item-filters').val('');   
        }

        $('#edit-item-id').val(id);
        $('#edit-item-title').val(title);
        $('#edit-item-img').attr({
            'src'       : src,
            'data-id'   : id

        });

    });

    /**
     * Change the img of item.
     */
    var $changeImgItem = $('#change-img-item'),
        mediaSingle;

    $changeImgItem.on('click', function () {

        if ( mediaSingle ) {
            mediaSingle.open();
            return;
        }

        mediaSingle = wp.media({
            title   : 'Selecciona la imagen a cambiar',
            button  : {
                text    : 'Usar esta imagen'
            },
            multiple: false
        });

        mediaSingle.on('select', function() {
            var adjunto = mediaSingle.state().get('selection').first().toJSON(),
                url     = adjunto.url;

            $('#edit-item-img').attr( {
                'src'       : url,
                'data-id'   : adjunto.id
            });
        });

        mediaSingle.open();

    });

    /**
     * Update item.
     */
    $('#update-item').on('click', function() {

        var id          = $('#edit-item-id').val(),
            title       = $('#edit-item-title').val(),
            src         = $('#edit-item-img').attr('src'),
            filters     = $('#edit-item-filters').val();
            
        var $item = $('[data-id="'+ id +'"]');
        $item.find('img').attr( 'src', src );
        var idN     = $('#edit-item-img').attr('data-id');

        var valsUpdated = [
            'media='+src,
            'title='+title,
            'filters='+filters,
            'id='+idN
        ];

        $item.attr({
            'data-value'    :   valsUpdated.join(';'),
            'data-title'    :   title,
            'data-src'      :   src,
            'data-f'        :   Beziercode.normalize(filters),
            'data-id'       :   idN
        });

        var $titleItem = $item.find('.title-item h5');

        if ( $titleItem.length ) {

            if ( title !== '' ) {
                $titleItem.text(title);
            }
            else {
                $('.title-item').remove();
            }
            
        }

        else {
            if ( title !== '' ) {
                var output = Beziercode.addTitleItem(title);
                $item.find('.bcpg-masc').before(output);
            }
        }

        // Filtros.

        if ( $('.bcpg-container li').length ) {

            $('ul.bcpg-ul').find('li').remove();
            var filtersArr = Beziercode.analizadorFiltros('.bcpg-container li');
            $('ul.bcpg-ul').append( Beziercode.templateBtnFilter( filtersArr ) );

        }



    });

    $('.bcpg-container').sortable();

    /**
     * Save data in database by ajax in json format
     */
    $('#guardar-items').on('click', function() {

        var dataValueItems  = $('.bcpg-container').sortable( 'toArray', {attribute:'data-value'} ),
            objetoItem      = Beziercode.toObject( dataValueItems ),
            idgalbcpg       = $('#idgalbcpg').val(),
            nombregalbcpg   = $('#nombregalbcpg').val(),
            type            = $('#type').val(),
            columnas        = $('#columnas').val(),
            bcpgMaster      = {
                bcpg        : {
                    name    :   nombregalbcpg,
                },
            },
            conf            = {
                settings    : {
                    columns :   columnas
                }
            },
            data = $.extend( {}, bcpgMaster, objetoItem, conf );
        
        $.ajax({
            url         : bcpg.url,
            type        : 'POST',
            dataType    : 'json',
            data : {
                action          : 'bcpg_data',
                nonce           : bcpg.seguridad,
                idgalbcpg       : idgalbcpg,
                nombregalbcpg   : nombregalbcpg,
                type            : type,
                data            : JSON.stringify( data )
            }, 
            success      : function( data ) {
                
                if( data.result ) {
                    
                    swal({
                        title   :   'Guardar!',
                        text    :   'La informacion se ha guardado con exito',
                        type    :   'success',
                        tiner   :   15000
                    });
                    
                }
                
            }, 
            error: function( d,x,v ) {
                
                console.log(d);
                console.log(x);
                console.log(v);
                
            }
        });

    });

    /**
     * Remove items.
     */
    $(document).on('click', '.remove-item', function () {
        
        $(this).parents('li').remove();
        $('ul.bcpg-ul').find('li').remove();

        if ( $('.bcpg-container li').length ) {
            var filtersArr = Beziercode.analizadorFiltros( '.bcpg-container li')
        }
        else {
            var filtersArr = '';
        }

        $('ul.bcpg-ul').append( Beziercode.templateBtnFilter( filtersArr ) );

    })

    /**
     * Show more options setting in categories.
     */
    var $categorias         = $('#categorias'),
        $limite             = $('#limite'),
        $orden              = $('#orden'),
        $orderby            = $('#orderby'),
        $categoryTemplate   = $('.categoryTemplate'),
        $loaderengine       = $('.loaderengine');

    if ( ( $categorias.val() !== null ) && ( ! isNaN( $categorias.val() ) ) ) {

        $limite.prop('disabled', false);
        $orden.prop('disabled', false);
        $orderby.prop('disabled', false);
        $('select').material_select();

    }
    else {

        $limite.prop('disabled', true);
        $orden.prop('disabled', true);
        $orderby.prop('disabled', true);
        $('select').material_select();

    }

    $categorias.on('change', function () {

        var catValue        = $(this).val(),
            postPerPage     = $limite.val(),
            orden           = $orden.val(),
            orderby        = $orderby.val();
            

        if ( ( catValue !== null ) && ( ! isNaN( catValue ) ) ) {

            $limite.prop('disabled', false);
            $orden.prop('disabled', false);
            $orderby.prop('disabled', false);
            $('select').material_select();
    
        }
        else {
    
            $limite.prop('disabled', true);
            $orden.prop('disabled', true);
            $orderby.prop('disabled', true);
            $('select').material_select();
    
        }

        $('.categoryTemplate > *').remove();
        $loaderengine.css('display', 'block');

        $.ajax({
            url         : bcpg.url,
            type        : 'POST',
            dataType    : 'json',
            data : {
                action          : 'bcpg_categorias',
                nonce           : bcpg.seguridad,
                cat_ID          : catValue,
                postPerPage     : postPerPage,
                orden           : orden,
                orderby         : orderby
            }, 
            success      : function( data ) {
                
                //if( data.result ) {
                    
                    $loaderengine.css('display', 'none');
                    console.log( data.posts )
                    $categoryTemplate.append( Beziercode.templateCardCategory( data.posts ) )

                //}
                
            }, 
            error: function( d,x,v ) {
                
                console.log(d);
                console.log(x);
                console.log(v);
                
            }
            
        });

    });



})( jQuery );















