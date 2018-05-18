var Navbar = Navbar || {};
(function( $ ) {
    Navbar = {
        bootstrap : function(){   
            this.menuHandle();
            this.addCurrentPageClass();
        },
        menuHandle: function(){            
            $('#navbar-menu-toggle').click(function(){
                $('#bf-navbar-menu').addClass('open');
                $('body').addClass('navbar-menu-open');
            });
            $('#navbar-menu-close').click(function(){
                $('#bf-navbar-menu').removeClass('open');
                $('body').removeClass('navbar-menu-open');                
            });
        },
        addCurrentPageClass: function(){
            let href = window.location.origin + window.location.pathname;            
            // strip slash at the end
            if ( href.charAt(href.length - 1) == '/' ){
                href = href.substr(0,href.length - 1);
            }
            $('.bf-navbar-link').each(function(index, ele){
                let navbar_link = $(this).attr('href');
                if(href.lastIndexOf(navbar_link) != -1){
                    $(this).addClass('current-link');
                }
            });
        }     
    }   
})(jQuery);

export default Navbar;
    