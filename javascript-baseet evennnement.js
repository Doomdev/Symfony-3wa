Nous souhaitons que si l'utilisateur clique par erreur sur un bouton supprimer, cala envois '
une boite de dialogue qui permette de lui demander si il souhaite vraiment supprimer.

    $(document).ready(function(){
        console.log($("#productdetail"))
        $("#productdetail").on("click",".delete",function(event){
            if(!confirm("Etes-vous sur de vouloir supprimer ce produit ?")){
                ;
            }

        })
    })