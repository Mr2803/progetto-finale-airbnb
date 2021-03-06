@extends("layouts.base")

@section("content")
<style>

  /* addrress' autocomplete rules */
  .my_style_drop {
    top: 0;
  }
</style>

<div class="container-fluid" id="update-aptm-container">
  <h3 class="text-center">
    Ciao {{ Auth::user() -> name }}! Modifica il tuo appartamento.
  </h3>
  <div class="row">
    <div class="col-lg-6">
      <form id="update-aptm-form" action="{{ route("apartment.update", $apartment -> id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("POST")
        <div class="d-flex flex-column">

          {{-- title --}}
          <label for="title">Titolo</label>
          <input type="text" id="title" name="title" value="{{ $apartment -> title }}" class="@error("title") is-invalid @enderror" required maxlength="255">
          @error("title")
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          {{-- /title --}}

          {{-- description --}}
          <label for="description">Descrizione</label>
          <input type="text" id="description" name="description" value="{{ $apartment -> description }}" class="@error("description") is-invalid @enderror" required maxlength="255">
          @error("description")
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          {{-- /description --}}
          
          {{-- address --}}
          <label for="update-address">Indirizzo dell"appartamento</label>
          <input type="text" id="update-address" name="address" value="{{ $apartment -> address }}" class="@error("address") is-invalid @enderror" required maxlength="255">
          <div id="addressesList"></div>
          @error("address")
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          {{-- /address --}}
          
          <div class="inputs-number-container">
            
            {{-- square feet --}}
            <div>
              <label for="square_feet">Metri quadri</label>
              <input type="number" id="square_feet" name="square_feet" value="{{ $apartment -> square_feet }}" class="@error("square_feet") is-invalid @enderror" required min="1" max="1000">
            </div>
            {{-- /square feet --}}

            {{-- rooms --}}
            <div>
              <label for="rooms">Stanze</label>
              <input type="number" id="rooms" name="rooms" value="{{ $apartment -> rooms }}" class="@error("rooms") is-invalid @enderror" required min="1" max="10">
            </div> 
            {{-- /rooms --}}

            {{-- beds --}}
            <div>
              <label for="beds">Letti</label>
              <input type="number" id="beds" name="beds" value="{{ $apartment -> beds }}" class="@error("beds") is-invalid @enderror" required min="1" max="10">
            </div>
            {{-- /beds --}}
            
            {{-- bathrooms --}}
            <div>
              <label for="bathrooms">Bagni</label>
              <input type="number" id="bathrooms" name="bathrooms" value="{{ $apartment -> bathrooms }}" class="@error("bathrooms") is-invalid @enderror" required min="1" max="10">
            </div>
            {{-- /bathrooms --}}

          </div>
          @error("square_feet")
            <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          @error("rooms")
            <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          @error("beds")
            <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          @error("bathrooms")
            <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror

          {{-- main image --}}
          <label id="main-img-label" for="main-img-input">Immagine principale</label>
          @if ($apartment -> poster_img === "https://source.unsplash.com/random/1920x1280/?apartment")
            <div id="main-img" style="width:180px; height:180px; background-image: url('https://source.unsplash.com/random/1920x1280/?apartment'); background-size: cover; background-position:center;">
            </div>
          @elseif($apartment -> poster_img !== null)
            <div id="main-img" style="width:180px; height:180px; background:url('/images/AptImg/{{$apartment -> id}}/{{$apartment -> poster_img}}'); background-size:cover; background-position:center;">
            </div>
          @else
            <div id="main-img" style="width:180px; height:180px; background:url('/images/noUpload.png'); background-size:cover; background-position:center;">
            </div>
          @endif
          <input type="file" id="main-img-input" name="poster_img" class="@error("poster_img") is-invalid @enderror">
          @error("poster_img")
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          {{-- /main image --}}
          
          {{-- secondary images --}}
          <label>Altre immagini</label>
          <div id="images-row">
            @for ($i = 0; $i < 2; $i++)
              <div id="img-{{ $i }}-box">
                @if ($apartment -> images[$i] -> path === "noUpload")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/noUpload.png'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path === "/images/ShowApt/img1.jpg")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/ShowApt/img1.jpg'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path === "/images/ShowApt/img2.jpg")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/ShowApt/img2.jpg'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path === "/images/ShowApt/img3.jpg")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/ShowApt/img3.jpg'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path === "/images/ShowApt/img4.jpg")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/ShowApt/img4.jpg'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path !== null)
                  <div id="secondary-img" style="width:180px; height:180px; background:url('/images/AptImg/{{$apartment -> id}}/others/{{$apartment -> images[$i] -> path}}'); background-size:cover; background-position:center;">
                  </div>
                @else
                  <div id="secondary-img" style="width:180px; height:180px; background:url('/images/noUpload.png'); background-size:cover; background-position:center;">
                  </div>
                @endif
                <input type="file" class="image-{{$i}}-input-file" name="image{{$i}}" class="@error("image{{$i}}") is-invalid @enderror">
              </div>
            @endfor
          </div>
          <div id="images-row">
            @for ($i = 2; $i < 4; $i++)
              <div id="img-{{ $i }}-box">
                @if ($apartment -> images[$i] -> path === "noUpload")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/noUpload.png'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path === "/images/ShowApt/img1.jpg")
                <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/ShowApt/img1.jpg'); background-size: cover; background-position:center;">
                </div>
                @elseif ($apartment -> images[$i] -> path === "/images/ShowApt/img2.jpg")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/ShowApt/img2.jpg'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path === "/images/ShowApt/img3.jpg")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/ShowApt/img3.jpg'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path === "/images/ShowApt/img4.jpg")
                  <div id="secondary-img" style="width:180px; height:180px; background-image: url('/images/ShowApt/img4.jpg'); background-size: cover; background-position:center;">
                  </div>
                @elseif ($apartment -> images[$i] -> path !== null)
                  <div id="secondary-img" style="width:180px; height:180px; background:url('/images/AptImg/{{$apartment -> id}}/others/{{$apartment -> images[$i] -> path}}'); background-size:cover; background-position:center;">
                  </div>
                @else
                  <div id="secondary-img" style="width:180px; height:180px; background:url('/images/noUpload.png'); background-size:cover; background-position:center;">
                  </div>
                @endif
                <input type="file" class="image-{{$i}}-input-file" name="image{{$i}}" class="@error("image{{$i}}") is-invalid @enderror">
              </div>
            @endfor
          </div>
          @error("image1")
            <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror          
          {{-- /secondary images --}}

          {{-- services --}}
          <label>Quali servizi metti a disposizione?</label>
          <div id="services-container">
            @foreach ($services as $service)
            <div>
              <input type="checkbox" id="{{ $service -> type }}" name="services[]" value="{{ $service -> id }}" @if ($apartment -> services() -> find($service -> id)) checked  @endif class="@error("services") is-invalid @enderror">
              <label for="{{ $service -> type }}">{{ $service -> type }}</label>
            </div>
            @endforeach
          </div>
          @error("services")
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          {{-- /services --}}

          <button id="update-aptm-btn">Modifica Appartamento</button>
        </div>
      </form>
    </div>
    <div class="col-lg-6 myBgCreateUpd d-md-none d-lg-block">
    </div>
  </div>
</div>

<script>
  // seleziona button
  // al click
  //
</script>
@endsection
