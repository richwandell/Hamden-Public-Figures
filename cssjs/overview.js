(function($){

    function main(){
        $("#organization-type").change(function(){
            window.location.href = window.location.href.replace(/\?.*/, "") + "?type=" + this.value;
        });
    }

    $(document).ready(function(){
        main();
    })
})(jQuery);