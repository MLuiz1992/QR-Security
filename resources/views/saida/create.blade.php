@extends('admin')

@section('title', '| Saída de Alunos')

@section('content')
    
        <div class="col-md-6">
         <h1 class="page-header">Saída de Alunos</h1>
        <canvas></canvas>
        <hr>
        <select class="form-control" id="camera"></select>
        
        </div>
        <div class="col-md-6">

                        <input type="hidden" id="aluno" name="aluno_id" value="">
                        <input type="hidden" id="created_at" name="created_at" value="">
                        <input type="hidden" id="foto" name="foto" value="">

                <h1 class="page-header">Alunos: <button class="btn btn-primary pull-right" id="clear">Limpar</button></h1>
                <div id="bookmarksResults">
                </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    {!! Html::script('js/webcodecamjs.js') !!}
    {!! Html::script('js/qrcodelib.js') !!}
    {!! Html::script('js/main.js') !!}
    {!! Html::script('js/main2.js') !!}
    {!! Html::script('js/filereader.js') !!}
    {!! Html::script('js/select2.min.js') !!}
    {!! Html::script('js/DecoderWorker.js') !!}

         <script type="text/javascript">
        	var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
            var arg = {
                resultFunction: function(result) {
                    var rm = result.code;
                    
                    var objetoDados = document.getElementById('aluno');
			        objetoDados.value = rm;

                    saveBookmark();
                    submitS();

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