<?php

namespace App\Http\Controllers;

use App\Frequencia;
use App\Saida;
use App\Aluno;
use Auth;
use App\User;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\Out;

class SaidaControllerApi extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $saida = Saida::all();
    }

    
    public function store(Request $request)
    {
        $teste = Frequencia::all()
                 ->where('aluno_id', $request->aluno_id)
                 ->where('saida_id', null)
                 ->first();


        $aluno = Aluno::find($request->aluno_id);
        $find = User::find($aluno->user_id);

        if($teste != null)
        {
            $aluno = Aluno::find($request->aluno_id);
            $frequencia = Frequencia::find($teste->id);
            $saida = new Saida();

            $saida->aluno_id = $request->aluno_id;
            $saida->created_at = $request->created_at;
            $saida->save();

            $frequencia->saida()->associate($saida);
            $frequencia->save();

            $find->notify(new Out($saida));        

            //$frequencia->saida = $saida->id;
            //$frequencia->save();

            return "O Aluno ". $aluno->nome . " saiu com sucesso!";
        }else{
            $aluno = Aluno::find($request->aluno_id);
            return "O Aluno ". $aluno->nome . " já saiu!";
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Frequencia  $frequencia
     * @return \Illuminate\Http\Response
     */
    public function show(Frequencia $frequencia, $id)
    {
        $events = [];
        $events2 = [];
        $aluno = Aluno::find($id); 
        $frequencias = Frequencia::all()->where('aluno_id', $aluno->id);
        $saidas = Saida::all()->where('aluno_id', $aluno->id);
        foreach ($frequencias as $frequencia) { 
           $crudFieldValue = $frequencia->getOriginal('created_at'); 

           if (! $crudFieldValue) {
               continue;
           }

           $eventLabel     = $frequencia->nome; 
           $prefix         = $aluno->nome; 
           $suffix         = 'Entrou na escola'; 
           $dataFieldValue = trim($prefix . " " . $eventLabel . " " . $suffix); 
           $events[]       = [ 
                'title' => $dataFieldValue, 
                'start' => $crudFieldValue, 
                'url'   => route('frequencia.edit', $frequencia->id)
           ]; 
        } 

        foreach ($saidas as $saida) { 
           $crudFieldValue = $saida->getOriginal('created_at'); 

           if (! $crudFieldValue) {
               continue;
           }

           $eventLabel     = $saida->nome; 
           $prefix         = $aluno->nome; 
           $suffix         = 'Saiu da escola'; 
           $dataFieldValue = trim($prefix . " " . $eventLabel . " " . $suffix); 
           $events2[]       = [ 
                'title' => $dataFieldValue, 
                'start' => $crudFieldValue, 
                'url'   => route('saida.edit', $saida->id)
           ]; 
        } 



        return view('frequencia.show', compact('events', 'aluno', 'events2'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Frequencia  $frequencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Frequencia $frequencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Frequencia  $frequencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Frequencia $frequencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Frequencia  $frequencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Saida $saida, Request $request)
    {
        $saida = Saida::find($request->aluno_id);
        $saida->delete();
        return $saida;
    }

    public function calendario(Frequencia $frequencia)
    {
        $events = [];
        $events2 = [];
        $aluno = Aluno::all()->where('user_id', Auth::id())->first();
        $frequencias = Frequencia::all()->where('aluno_id', $aluno->id);
        $saidas = Saida::all()->where('aluno_id', $aluno->id);
        foreach ($frequencias as $frequencia) { 
           $crudFieldValue = $frequencia->getOriginal('created_at'); 

           if (! $crudFieldValue) {
               continue;
           }

           $eventLabel     = $frequencia->nome; 
           $prefix         = $aluno->nome; 
           $suffix         = 'Entrou na escola'; 
           $dataFieldValue = trim($prefix . " " . $eventLabel . " " . $suffix); 
           $events[]       = [ 
                'title' => $dataFieldValue, 
                'start' => $crudFieldValue, 
                'url'   => route('frequencia.edit', $frequencia->id)
           ]; 
        } 

        foreach ($saidas as $saida) { 
           $crudFieldValue = $saida->getOriginal('created_at'); 

           if (! $crudFieldValue) {
               continue;
           }

           $eventLabel     = $saida->nome; 
           $prefix         = $aluno->nome; 
           $suffix         = 'Saiu da escola'; 
           $dataFieldValue = trim($prefix . " " . $eventLabel . " " . $suffix); 
           $events2[]       = [ 
                'title' => $dataFieldValue, 
                'start' => $crudFieldValue, 
                'url'   => route('saida.edit', $saida->id)
           ]; 
        } 



        return view('frequencia.show', compact('events', 'aluno', 'events2'));

    }

    
}
