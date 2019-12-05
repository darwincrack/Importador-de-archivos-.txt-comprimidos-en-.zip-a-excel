<!DOCTYPE html>
<html>

<head>
    <title>importador de archivos de .zip a .xlsx</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

    <script src="https://kit.fontawesome.com/397712a024.js" crossorigin="anonymous"></script>

    <style>
        .dropzone {
            min-height: 150px;
            border: 2px solid rgba(0, 0, 0, 0.3);
            background: #e1faff;
            padding: 20px 20px;
            border-style: dashed;
            text-align: center;
        }
        
        .list-archivos ul {
            columns: 3;
            -webkit-columns: 3;
            -moz-columns: 3;
        }
        
        ul li {
            list-style-type: none;
        }
        
        #process {
            padding-left: 4%;
            padding-right: 4%;
        }
        
        #wrap-descarga {
            padding: 35px;
        }
        
        .form-horizontal .control-label {
            text-align: left;
        }
        
        .downloader__btn.active,
        .uploader__btn.active {
            background-color: #2196F3;
        }
        
        .downloader,
        .downloader__btn {
            margin-bottom: 0;
        }
        
        .downloader__btn,
        .uploader__btn {
            display: -ms-inline-flexbox;
            display: inline-flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            min-height: 56px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            background: #e5322d;
            padding: 9px 56px;
            font-weight: 600;
            font-size: 18px;
            line-height: 32px;
            vertical-align: middle;
            color: #fff;
            text-decoration: none;
            margin-bottom: 12px;
            -webkit-transition: all .1s linear;
            -o-transition: all .1s linear;
            transition: all .1s linear;
            border-radius: 8px;
            -webkit-box-shadow: 0 3px 6px 0 rgba(0, 0, 0, .14);
            box-shadow: 0 3px 6px 0 rgba(0, 0, 0, .14);
            -ms-flex-order: 1;
            order: 1;
            max-width: 60vw;
        }
        
        .downloader__btn.active:hover,
        .uploader__btn.active:hover {
            background-color: #161616;
        }
        
        .downloader__btn,
        .downloader__btn:hover {
            text-decoration: none;
            color: white;
        }
        
        .wrap-link {
            margin-left: 31px;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">

                                <h4>Subir archivo (.zip)</h4>

                                <div class="alert alert-danger print-error-file-msg" style="display:none"></div>
                                <div class="panel-body">

                                    {!! Form::open([ 'route' => [ 'dropzone.store' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}

                                    <div class="dz-message" data-dz-message>
                                        <i class="fas fa-cloud-upload-alt fa-7x"></i>
                                        <br>
                                        <span>Elija el archivo o arrastre aqui </span>
                                        <br>
                                        <span>Limite de Tamaño 10 MB</span>

                                    </div>

                                    {!! Form::close() !!}

                                </div>

                                <p class="text-center" style="display: none">
                                    <button id="submit" class="btn btn-primary " style="display: none"><span class="glyphicon glyphicon-plus"></span> Procesar</button>

                                </p>

                            </div>

                            <div class="form-group" id="process" style="display:none; clear: both;">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <span id="porcentaje">0</span>
                                        <span id="process_data" style="display:none; ">0</span> <span id="total_data" style="display:none; ">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 wrap-contribuyente" id="wrap-contribuyente" style="display: none;     clear: both;">
                                <div>
                                    <span>Importador / Exportador:</span>
                                    <span id="text-contribuyente"></span>
                                </div>

                            </div>

                            <div class="col-md-12 wrap-archivos" id="wrap-archivos" style="display: none;     clear: both;">
                                <div class="text-archivos">
                                    <h4>Estructura de los archivos .ASC</h4>
                                </div>
                                <div class="list-archivos" id="list-archivos">
                                </div>
                            </div>

                            <div class="col-md-12 wrap-descarga" id="wrap-descarga" style="display: none;     clear: both;">

                                <h4>Complete para descargar Excel (.xlsx)</h4>

                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>

                                <form class="form-horizontal" id="form-descarga" method="post" action="{{ URL::asset('formstore') }}">
                                    {!! csrf_field() !!}

                                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                                        <label class="col-lg-12 control-label">Nombre</label>

                                        <div class="col-lg-12">
                                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}"> @if ($errors->has('nombre'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span> @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-lg-12 control-label">email</label>

                                        <div class="col-lg-12">
                                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}"> @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span> @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-5">
                                            <button class="btn btn-block btn-primary" id="btn-descarga" type="submit" title="Enviar datos">Enviar</button>

                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="col-md-12 wrap-link text-center" id="wrap-link" style="display: none;     clear: both;">

                                <a class="downloader__btn active" id="pickfiles" href="descarga">
                                    <svg aria-hidden="true" width="26" height="24" data-icon="download" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z" class=""></path>
                                    </svg>
                                    Descargar archivo </a>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            Dropzone.options.imageUpload = {

               // autoProcessQueue: false,
                parallelUploads: 1,
                paramName: "files",
                addRemoveLinks: true,
                dictRemoveFile: "Eliminar",
                maxFiles: 1,
                maxFilesize: 10, // Tamaño máximo en MB
                acceptedFiles: ".zip",

                accept: function(file, done) {
                    console.log(file.name.endsWith);
                    if (file.name.endsWith(".zip")) {
                        done();
                        return;
                    } else {
                        done("Error! archivos de este tipo no son aceptados");
                    }
                },

                init: function() {

                    var submitButton = document.querySelector("#submit")
                    myDropzone = this; // closure

                    this.on("maxfilesexceeded", function(file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });

                    submitButton.addEventListener("click", function() {
                        myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                    });

                    // You might want to show the submit button only when 
                    // files are dropped here:
                    this.on("addedfile", function() {
                        // Show submit button here and/or inform user to click it.

                        resetForm();
                        $("#submit").show();
                        $("#wrap-archivos").hide();
                       

                    });

                    this.on("queuecomplete", function(file) {
                        
                    });

                    this.on("removedfile", function(file) {
                     
                        resetForm();
                    });

                },
                success: function(file, response) {

                    if (!$.isEmptyObject(response.error)) {

                        $(".print-error-file-msg").html(response.error);
                        $(".print-error-file-msg").show();

                        return;

                    }

                    $(".dz-success-mark").css("opacity", "1");
                    $(".dz-error-mark").css("display", "none");
                    $(".dz-remove").css("display", "none");
                    $("#submit").hide();
                    $("#list-archivos").empty();
                    $("#list-archivos").html(response["html"]);

                    $("#text-contribuyente").empty();
                    $("#text-contribuyente").html(response["nombreContribuyente"]);

                    $('#total_data').text(response["total_files"]);
                    importar();
                    resetForm();

                    clear_timer = setInterval(procesando, 500);
                },

                error: function(file, response) {
                    $(".dz-error-mark svg").css("background", "red");
                     $(".dz-error-mark ").css("opacity", "1");
                    $(".dz-success-mark").css("display", "none");
                    $(".print-error-file-msg").html("No puede subir archivos de este tipo, solo .zip");
                        $(".print-error-file-msg").show();
                }

            };

            function importar() {
                $('#process').css('display', 'block');

                $.ajax({

                    url: 'importar',
                    data: {
                        '_token': $('input[name=_token]').val(),

                    },

                    type: 'POST',

                    success: function(data) {},

                    error: function(xhr, status) {
                        alert("Disculpe, existió un problema, mientras se procesaba el archivo");
                    },

                });

            }

            function procesando() {
                $.ajax({
                    url: "procesando",
                    data: {
                        '_token': $('input[name=_token]').val(),

                    },

                    type: 'POST',
                    success: function(data) {

                        var total_data = $('#total_data').text();
                        var width = Math.round((data / total_data) * 100);
                        $('#process_data').text(data);
                        $('#porcentaje').text(width + "%");
                        $('.progress-bar').css('width', width + '%');
                        $('#wrap-contribuyente').css('display', 'block');
                        if (width >= 100) {
                            clearInterval(clear_timer);
                            $('#process').css('display', 'none');
                            $('#wrap-contribuyente').css('display', 'none');

                            $("#wrap-archivos").show();
                            $("#wrap-descarga").show();

                            
                        }
                    }
                })
            }

            $('#form-descarga').on('submit', function(event) {
                event.preventDefault();

                var form = $('#form-descarga');

                $.ajax({
                    url: "formstore",
                    method: "POST",
                    data: form.serialize(),

                    beforeSend: function() {

                        $('#btn-descarga').attr('disabled', 'disabled');
                        $('#btn-descarga').val('Enviando...');
                    },
                    success: function(data) {

                        if ($.isEmptyObject(data.error)) {

                            resetForm();

                            $("#wrap-descarga").hide();
                            $("#wrap-link").show();

                        } else {
                            printErrorMsg(data.error);

                            $('#btn-descarga').attr('disabled', false);
                            $('#btn-descarga').val('Enviar');
                        }
                    }
                })

            });

            function printErrorMsg(msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }

            function printErrorFileMsg(msg) {

                $(".print-error-msg").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }

            function resetForm() {

                $("#nombre").val('');
                $("#email").val('');
                $("#wrap-link").css('display', 'none');
                $("#wrap-descarga").css('display', 'none');
                $(".print-error-msg").css('display', 'none');
                $(".print-error-file-msg").css('display', 'none');
                $('#btn-descarga').attr('disabled', false);
                $('#btn-descarga').val('Enviar');
                $('#porcentaje').text('');
                $('.progress-bar').css('width', '0');
                $("#submit").hide();

            }

        });
    </script>

</body>

</html>