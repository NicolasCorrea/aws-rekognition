<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


        {{-- <link rel="stylesheet" href="{{asset("css/app.css")}}"> --}}
        {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> --}}
        {{-- <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet"> --}}
        {{-- <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet"> --}}
        <title>Laravel</title>
    </head>
    <body>
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div id="photo1" style="position:relative">
                                <img src="" alt=""  id="img1" width="100%" style="position:relative">
                            </div>
                        </div>
                        <div class="col">
                            <div id="photo2" style="position:relative">
                                <img src="" alt="" id="img2" width="100%" style="position:relative">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <form id="imagenes" enctype="multipart/form-data">
                            <div class="row">
                                <input type="hidden" name="data1" id="data1">
                                <input type="hidden" name="data2" id="data2">
                                {{-- <div class="col form-group">
                                    <label for="file1">Archivo 1</label>
                                    <input type="file" name="file1" class="form-control-file" onchange="tipo(this, 1)" id="file1">
                                </div>
                                <div class="col form-group">
                                    <label for="file2">Archivo 2</label>
                                    <input type="file" class="form-control-file" name="file2" onchange="tipo(this, 2)" id="file2">
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary" type="button" onclick="enviar()">Subir</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <video id="video"></video>
                        <button id="startbutton">Take photo</button>
                        <canvas id="canvas" style="display: none"></canvas>
                    </div>
                </div>
            </div>

        </div>




    <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <script>
        function readURL(input, tipo) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                $('#img'+tipo).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function tipo(el, nombre) {
            readURL(el, nombre);
            $("#id1").remove()
            $("#id2").remove()
        };
        function enviar(){
            var formData = new FormData(document.getElementById("imagenes"))
            $.ajax({
                type: "POST",
                url: "/FaceComparation",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done((aws) => {
                if (aws.coincidencias.length==0) {
                    alert("No se encontraron coincidencias")
                } else {
                $("#photo1").append(`
                    <div id="id1" style='
                        width: ${(aws.original.BoundingBox.Width*100).toFixed(2)}%;
                        height: ${(aws.original.BoundingBox.Height*100).toFixed(2)}%;
                        position: absolute;
                        top: ${(aws.original.BoundingBox.Top*100).toFixed(2)}%;
                        left: ${(aws.original.BoundingBox.Left*100).toFixed(2)}%;
                        border: 5px dashed orange;'>
                    </div>`)

                    $("#photo2").append(`<div id="id2" style='
                        width: ${(aws.coincidencias[0].Face.BoundingBox.Width*100).toFixed(2)}%;
                        height: ${(aws.coincidencias[0].Face.BoundingBox.Height*100).toFixed(2)}%;
                        position: absolute;
                        top: ${(aws.coincidencias[0].Face.BoundingBox.Top*100).toFixed(2)}%;
                        left: ${(aws.coincidencias[0].Face.BoundingBox.Left*100).toFixed(2)}%;
                        border: 5px dashed orange;'></div>`)
                }
             });
        }

        (function() {
            var firstPhoto = false;
            var streaming = false,
                video        = document.querySelector('#video'),
                canvas       = document.querySelector('#canvas'),
                photo1       = document.querySelector('#img1'),
                photo2       = document.querySelector('#img2'),
                data1        = document.querySelector('#data1'),
                data2        = document.querySelector('#data2'),
                startbutton  = document.querySelector('#startbutton'),
                width = 320,
                height = 0;

            navigator.getMedia = ( navigator.getUserMedia ||
                                navigator.webkitGetUserMedia ||
                                navigator.mozGetUserMedia ||
                                navigator.msGetUserMedia);

            navigator.getMedia(
            {
                video: true,
                audio: false
            },
            function(stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    // var vendorURL = window.webkitURL;
                    video.srcObject = stream;
                }
                video.play();
            },
            function(err) {
                console.log("An error occured! " + err);
            }
            );

            video.addEventListener('canplay', function(ev){
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
            }, false);

            function takepicture() {
                $("#id1").remove()
                $("#id2").remove()
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(video, 0, 0, width, height);
                var data = canvas.toDataURL('image/png');
                if(!firstPhoto){
                    photo1.setAttribute('src', data);
                    data1.value =  data;
                }else{
                    photo2.setAttribute('src', data);
                    data2.value =  data;
                }
                firstPhoto = !firstPhoto
            }

            startbutton.addEventListener('click', function(ev){
                takepicture();
            ev.preventDefault();
            }, false);

            })();
    </script>

    </body>
</html>
