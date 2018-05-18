jQuery("body").on("contextmenu",function(e){
    return false;
});

jQuery('body').bind('cut copy paste', function(e) {
   e.preventDefault();
});
