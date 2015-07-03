( function( $ ) {
    // Masonry get position after content(images) loaded
    $(window).load(function(){
        $('.mansory').masonry({
          // options
          itemSelector: '.grid6'
        });
    });
    
} )( jQuery );