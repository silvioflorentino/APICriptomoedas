<?php

namespace App\Http\Controllers;

use App\Models\Criptomoedas;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CriptomoedasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regBook = Criptomoedas::All();
        $contador = $regBook->count();

        return Response()->json($regBook);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validação dos dados recebidos
    $validator = Validator::make($request->all(), [
        'sigla' => 'required',
        'nome' => 'required',
        'valor' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Registros inválidos',
            'errors' => $validator->errors()
        ], 400); // Retorna HTTP 400 (Bad Request) se houver erro de validação
    }

    // Criando a criptomoeda no banco de dados
    $registros = Criptomoedas::create($request->all());

    if ($registros) {
        return response()->json([
            'success' => true,
            'message' => 'Criptomoeda cadastrada com sucesso!',
            'data' => $registros
        ], 201); 
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao cadastrar a criptomoeda'
        ], 500); // Retorna HTTP 500 (Internal Server Error) se o cadastro falhar
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Criptomoedas $id)
    {
        //
         $regBook = Criptomoedas::find($id);

        if($regBook){
            return 'Criptomoedas Localizados: '.$regBook.Response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return 'Criptomoedas não localizados. '.Response()->json([],Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validator = Validator::make($request->all(), [
        'sigla' => 'required',
        'nome' => 'required',
        'valor' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Registros inválidos',
            'errors' => $validator->errors()
        ], 400); // Retorna HTTP 400 se houver erro de validação
    }

    // Encontrando a criptomoeda no banco
    $regBookBanco = Criptomoedas::find($id);

    if (!$regBookBanco) {
        return response()->json([
            'success' => false,
            'message' => 'Criptomoeda não encontrado'
        ], 404); 
    }

    // Atualizando os dados
    $regBookBanco->nomeLivro = $request->nomeLivro;
    $regBookBanco->generoLivro = $request->generoLivro;
    $regBookBanco->anoLivro = $request->anoLivro;

    // Salvando as alterações
    if ($regBookBanco->save()) {
        return response()->json([
            'success' => true,
            'message' => 'Criptomoeda atualizado com sucesso!',
            'data' => $regBookBanco
        ], 200); // Retorna HTTP 200 se a atualização for bem-sucedida
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao atualizar a criptomoeda'
        ], 500); // Retorna HTTP 500 se houver erro ao salvar
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Encontrando a criptomoeda no banco
    $regBook = Criptomoedas::find($id);

    if (!$regBook) {
        return response()->json([
            'success' => false,
            'message' => 'cripotomoeda não encontrado'
        ], 404); // Retorna HTTP 404 se a criptomoeda não for encontrado
    }

    // Deletando a criptomoeda
    if ($regBook->delete()) {
        return response()->json([
            'success' => true,
            'message' => 'Criptomoeda deletado com sucesso'
        ], 200); // Retorna HTTP 200 se a exclusão for bem-sucedida
    }

    return response()->json([
        'success' => false,
        'message' => 'Erro ao deletar a criptomoeda'
    ], 500); // Retorna HTTP 500 se houver erro na exclusão
}
}
