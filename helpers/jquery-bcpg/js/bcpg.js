if( typeof jQuery == 'undefined' ) {
    throw new Error( 'BC Portfolio Galería requiere de la librería jQuery' );
}

(function( $ ) {
    
    'use strict';
    
    /* Declarando Objeto y constructor */
    var BC_PortfolioGaleria = function( element, options, callback ) {
        this.$element = null;
        this.options  = null;
        this.zoomfull = '<div id="bcpg-zoom">\
                              <div>\
                                  <img src="" alt="">\
                              </div>\
                          </div>';
        this.overdark = '<div class="bcpg-overdark"></div>';
        
        this.init( element, options, callback );
        
    }
    
    BC_PortfolioGaleria.Defatuls = {
        filter      : '.bcpg-ul li',
        item        : '.bcpg-item',
        animation   : 'scale',
        callback    : null
    }
    
    BC_PortfolioGaleria.prototype.init = function( element, options, callback ) {
        
        this.$element   = $(element);
        this.options    = this.getOptions(options);
        
        this.$element.children().addClass( this.options.item.replace( '.', '' ) );
        this.filtro(this.options);
        
        $('body').prepend(this.zoomfull + this.overdark);        
        this.zoom();
        
        if( typeof callback == 'function' ) {
            callback.call(this);
        }
        
        if( typeof this.options.callback == 'function' ) {
            this.options.callback.call(this);
        }
        
    }
    
    BC_PortfolioGaleria.prototype.getDefatuls = function() {
        return BC_PortfolioGaleria.Defatuls;
    }
    
    BC_PortfolioGaleria.prototype.getOptions = function(options) {
        return $.extend({}, this.getDefatuls(), options);
    }
    
    BC_PortfolioGaleria.prototype.filtro = function(options) {
        
        $(document).on('click', options.filter, function(){
            
            var $this   = $(this),
                filtro  = $this.attr('data-filter'),
                $item   = $( options.item );
            
            if( filtro == '*' ) {
                $this.addClass('activo')
                    .siblings().removeClass('activo');
                
                /* Validando animaciones */
                
                if( options.animation == 'scale' ) {
                    $item.show('slow')                    
                } else if( options.animation == 'desvaneciendo' ) {
                    // ...
                }
                
            } else {
                
                if( ! $this.hasClass('activo') ) {
                    $this.addClass('activo')
                            .siblings().removeClass('activo');
                }
                
                /* Validando animaciones */
                
                if( options.animation == 'scale' ) {                    
                    $item.hide('slow');
                    setTimeout(function(){
                        $( '[data-f*="' + filtro + '"]' ).show('slow');
                    }, 700);
                } else if( options.animation == 'desvaneciendo' ) {
                    // ...
                }
                
            }
            
        });
        
    }
    
    BC_PortfolioGaleria.prototype.zoom = function() {
        
        var $overdark   = $('.bcpg-overdark'),
            $zoom       = $('#bcpg-zoom'),
            $zoomImg    = $('#bcpg-zoom img'),
            $bcpg_img   = $('.bcpg_img');
        
        $overdark.on('click', function(){
            $(this).fadeOut();
            $zoom.fadeOut();
        });
        
        $(document).on('click', '.bcpg_img', function(){
            
            var $this   = $(this),
                src     = $this.parent().parent().find('img').attr('src');
            
            $zoomImg.attr('src', src);
            
            $zoom.fadeIn();
            $overdark.fadeIn();
            
        });
        
    }
    
    /* $(element).bcpg( {}, function(){
        // ...
    }) */
    var Plugin = function( options, callback ) {
        return this.each(function(){
            var option  = typeof options == 'object' && options,
                data    = new BC_PortfolioGaleria( this, option, callback );
        });
    }
    
    var old = $.fn.bcpg;
    $.fn.bcpg = Plugin;
    $.fn.bcpg.Constructor = BC_PortfolioGaleria;
    
    $.fn.bcpg.noConflict = function() {
        $.fn.bcpg = old;
    }
    
})( jQuery );








