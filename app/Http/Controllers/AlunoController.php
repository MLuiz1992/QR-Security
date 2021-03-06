<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sala;
use App\Aluno;
use App\Frequencia;
use App\User;
use Session;
use Carbon\Carbon;
use Image;
use File;

class AlunoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salas = Sala::all();
        $alunos = Aluno::all();
        return view('alunos.index', compact('salas', 'alunos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $salas = Sala::all();
        $users = User::all();
        return view('alunos.create', compact('salas', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aluno = new Aluno();
        $foto = $request->file('foto');
        $filename = time() . '.' . $foto->getClientOriginalExtension();
        Image::make($foto)->resize(150, 200)->save( public_path('/uploads/alunos/' . $filename) );
        $aluno->foto = $filename;

        $aluno->id = $request->id;
        $aluno->nome = $request->nome;
        $aluno->sala_id = $request->sala_id;
        $aluno->user_id = $request->user_id;

        $aluno->save();
        
        Session::flash('success', 'Aluno cadastrado com sucesso!');

        return redirect()->route('admin.dashboard');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aluno = Aluno::find($id);
        $pai = User::find($aluno->id);
        $frequencia = Frequencia::all()->where('aluno_id', $id)->count();
        return view('alunos.show', compact('pai', 'aluno', 'frequencia'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAdmin($id)
    {
        $aluno = Aluno::find($id);
        $pai = User::find($aluno->user_id);
        $frequencia = Frequencia::all()->where('aluno_id', $id)->count();
        return view('alunos.showadmin', compact('pai', 'aluno', 'frequencia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aluno = Aluno::find($id);
        $dias = Dia::all();
        $dias2 = array();
        foreach ($dias as $dia) {
            $dias2[$dia->id] = $dia->aula;
        }

        return view('alunos.edit')->withAluno($aluno)->withDias($dias2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
                 // Validate the data
        $aluno = Aluno::find($id);
                     
        $aluno->id = $request->id;
        $aluno->nome = $request->nome;
        $aluno->sala_id = $request->sala_id;
        $aluno->timestamps();

        $aluno->save();
        
        Session::flash('success', 'Aluno atualizado com sucesso!');

        return redirect()->route('alunos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aluno->delete();

        Session::flash('success', 'Aluno deletado com sucesso!');

        return redirect()->route('alunos.index');
    }


    public function chamadapagina(Request $request)
    {
        $dias = Dia::all();
        $dias2 = array();
        foreach ($dias as $dia) {
            $dias2[$dia->id] = $dia->aula;
        }
 
       return view ('alunos.chamada')->withDias($dias2);
    }

    public function chamada(Request $request)
    {
        $aluno = Aluno::find($request->aluno);
                     
        $aluno->dias()->attach($request->dias);
             
        // set flash data with success message
        Session::flash('success', 'O aluno ' .$aluno->nome. ' entrou com sucesso!');
        // redirect with flash data to posts.show
       return redirect()->route('alunos.chamadapagina');
    }
}
