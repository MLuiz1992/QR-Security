@extends('main')

@section('title', '| Trabalho Matheus e Maxwell')

@section('content')
    
        <div class="col-md-6">
         <h3>Entrada de Alunos</h3>
        <hr>
        <canvas></canvas>
        <hr>
        <select id="camera"></select>
        
        </div>
        <div class="col-md-6">
                {!! Form::model(['route' => ['alunos.chamada'], 'method' => 'POST', 'id' => 'chamada']) !!}
	            	<div class="col-md-8">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="put">

                        <input type="hidden" id="aluno" name="aluno" onchange="submitar()" value="">

			            {{ Form::label('Dias', 'Dia de Hoje:', ['class' => 'form-spacing-top']) }}
			            {{ Form::select('dias', $dias, null, ['class' => 'form-control']) }}
			 
        	{!! Form::close() !!}
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    {!! Html::script('js/webcodecamjs.js') !!}
    {!! Html::script('js/qrcodelib.js') !!}
    {!! Html::script('js/main.js') !!}
    {!! Html::script('js/filereader.js') !!}
    {!! Html::script('js/select2.min.js') !!}

         <script type="text/javascript">
        	var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
            var arg = {
                resultFunction: function(result) {
                    var rm = result.code;
                    var objetoDados = document.getElementById("aluno");
			        objetoDados.value = rm;
                }
            };
            var decoder = new WebCodeCamJS("canvas").buildSelectMenu(document.getElementById('camera'), 'environment|back').init(arg).play();
            document.querySelector('select').addEventListener('change', function(){
            	decoder.stop().play();
            });
        </script>
        	
        <script type="text/javascript">
		$('.select2-multi').select2();
        </script>

        
@endsection