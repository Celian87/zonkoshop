$(document).ready(function(){
    //Inserisce il token CSRF nell'header di tutte le chiamate AJAX
    //così si fa senza passarlo nel campo data
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Per le schede degli ordini e altro
    $('div.collapsable .card-header').on('click', function () {

        $(this).parent().children('.card-body')
        .slideToggle(250)
        ;

        $(this).find('i.fas').toggleClass('d-none');
    });
});


/* Aggiunta elemento al carrello */
function addToCart(route, product_id) {
    var request = {
        //_token: document.getElementsByName("_token")[0].value, //CSRF
        product_id: product_id,
        quantity: 1
    };
    console.log(request);

    $.ajax({
        method: 'POST', //mettere direttamente tipo di rotta
        dataType: "json",
        url: route,
        data: request,
        success: function(response){
            console.log(response); //stampa quello che ha restituito il controller
            //Disattiva il pulsante
            $('#comprato_'+product_id).show();
			$('#disponibile_'+product_id).hide();
        },
        error: function(request, error) {
            console.log("AJAX error "+request.status+": "+request.statusText);
            //console.log(request); console.log(error);
        }
    });
}

/* Rimozione elemento dal carrello */
function removeFromCart(route) {
    $.ajax({
        method: 'DELETE',
        dataType: "json",
        url: route,
        data: {
            //non servono dati, l'ID è nell'URL
            //_token: document.getElementsByName("_token")[0].value, //CSRF
        },
        success: function(response){
            console.log(response); //stampa quello che ha restituito il controller
            return true;
        },
        error: function(request, error) {
            console.log("AJAX error "+request.status+": "+request.statusText);
            //console.log(request); console.log(error);
            return false;
        }
    });
}
