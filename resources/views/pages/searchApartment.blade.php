@extends('layouts.base')
@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-12  mt-5 mb-5 col-md-8 offset-md-2">
      <form  action="{{route('apartment.adv.search')}}" id="searchByFiltersForm" class="range-field " method="post">
        @csrf
        @method("POST")
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Aggiungi filtri per la tua ricerca</h3>
          </div>
          <div class="d-flex flex-column p-3">
            <div class="text-center">
              <label for="rooms">Numero Stanze</label>
              <input type="number" id="rooms" name="rooms" min="1" max="4">
              <label for="beds">Numero Letti</label>
              <input type="number" id="beds" name="beds" min="1" max="4">
              <span class="text-center ml-5 m">Raggio di ricerca: <span class="ml-2" id="valOfRadius"></span> km</span>
              <input id="radius" name="radius" type="range" min="1" max="200" value="50" class="slider ml-2">
            </div>
            <div class="mt-3 text-center">
              <p>Seleziona i servizi che desideri:</p>
              <input type="checkbox" id="wifi" name="services[]" value="wifi">
              <label for="wifi">Wi-Fi</label>
              <input type="checkbox" id="posto auto" name="services[]" value="posto auto">
              <label for="posto auto">posto auto</label>
              <input type="checkbox" id="piscina" name="services[]" value="piscina">
              <label for="piscina">piscina</label>
              <input type="checkbox" id="sauna" name="services[]" value="sauna">
              <label for="sauna">sauna</label>
              <input type="checkbox" id="vista mare" name="services[]" value="vista mare">
              <label for="vista mare">vista mare</label>
              <input type="checkbox" id="reception" name="services[]" value="reception">
              <label for="reception">reception</label>
            </div>
            <button id="advSearchBtn" type="button" class="btn btn-primary">Filtra</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div id="found-apartments">
      {!! $html !!}
  </div>
</div>

<script>
  var slider = document.getElementById("radius");
  var output = document.getElementById("valOfRadius");
  output.innerHTML = slider.value;
    slider.oninput = function() {
  output.innerHTML = this.value;
  }

  function printApartments(url) {
    $("#found-apartments").empty();
    var servicesArray = [];
    $("input[name='services[]']:checked").each(function(){
      servicesArray.push($(this).val());
    });
    $.ajax({
      "url": url,
      "method": "POST",
      "data": {
        "rooms": $("input[name='rooms']").val(),
        "beds": $("input[name='beds']").val(),
        "radius": $("input[name='radius']").val(),
        "services": servicesArray
      },
      "headers": {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      "success": function (data) {
        console.log(data);
        $("#found-apartments").append(data);
      },
      "error": function (iqXHR, textStatus, errorThrown) {
        alert(
          "iqXHR.status: " + iqXHR.status + "\n" +
          "textStatus: " + textStatus + "\n" +
          "errorThrown: " + errorThrown
        );
      }
    });
  }

  $("#advSearchBtn").click(function(event) {
    printApartments("{{ route('apartment.adv.search') }}");
  });

</script>


@endsection
