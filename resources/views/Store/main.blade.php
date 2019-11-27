{{-- Pagina principale --}}

@extends('layouts.app')

@section('content')

                <div class="w3-content w3-section" style="max-width:100%">

                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
                        </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src={{ asset('images/FFXII.jpg') }} alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src={{ asset('images/porto.jpg') }} alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src={{ asset('images/desert_city.jpg') }} alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src={{ asset('images/Agrobah.jpg') }} alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src={{ asset('images/desert_city_2.jpg') }} alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src={{ asset('images/forte.jpg') }} alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src={{ asset('images/fantasy_city.jpg') }} alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    </div>

                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                </div>

            </div>




            <br>
            <div class="card-deck">
            @foreach($slidercontent as $slider)
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <h3 class="subtitle">{{ $slider['title'] }}</h3>
                            <div class="card-deck">
                                @foreach ($slider['products'] as $product)
                                    @include('Store.common.prodtile', ['product' => $product])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

    @endsection




@section("page-javascript")
<script>
$("document").ready(function () {
    console.log("JQuery funzia :D");
    $(".add-to-cart").bind("click", function(event) { //non funzia se si imposta con onclick nell'HTML
        event.preventDefault(); //evita che la pagina cambi

        var product = $(this).attr("data-prod");
        //console.log($(this).parent().attr('action'));

        addToCart("{{ action('CartController@store') }}", product);
    });

    //$(".add-to-cart").bind("mouseenter", function(event) {console.log("ciaone :)");}); //TEST
});
</script>
<script>
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
        }
        myIndex++;
        if (myIndex > x.length) {myIndex = 1}
        x[myIndex-1].style.display = "block";
        setTimeout(carousel, 3000); // Change image every 2 seconds
    }
</script>
<script>

</script>
@endsection
