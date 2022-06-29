if( typeof jQuery == 'undefined' ) {
    throw new Error( 'BC Portfolio Galería requiere de la librería jQuery' );
}

(function( $ ) {
    
    'use strict';
    console.log(gilbert);
    /* Declarando Objeto y constructor */
    var BC_PortfolioGaleria = function( element, options, callback ) {
        this.$element = null;
        this.options  = null;
        
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








