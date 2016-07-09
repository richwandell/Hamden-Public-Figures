(function($){

    function init() {
        $("#add-to-org-row button").click(function(e){
            $(this).hide();
            $("#add-to-org-row .hidden").removeClass("hidden");
            $("#save_new_org").val(1);
        });
    }

    $(document).ready(function(){
        init();
    });
})(jQuery);