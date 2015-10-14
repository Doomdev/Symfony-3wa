$(document).ready(function(){
    $("#productdetail").on("click",".delete",function(event){
        event.preventDefault();
        if(confirm("Etes-vous ?")){
            var adelete = $(this);
            var urlDelete = adelete.attr("href");
            $.ajax({
                type: "GET",
                url: urlDelete
            })
            .done(function(){

                adelete.closest("tr").fadeOut();
            });
        }
    })

})