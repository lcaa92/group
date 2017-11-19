<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imoveis;

class ImoveisController extends Controller
{

    public function lista(){
    	$imoveis = Imoveis::all();
    	return view('imoveis.lista', ['imoveis'=>$imoveis]);
    }

    public function cadastro(){
    	return view('imoveis.cadastro-edita');
    }

    public function gravar(Request $request){
    	$imovel = new Imoveis();
    	$imagem = $request->file('imagem');
    	
    	$request->merge(['imagem' => $imagem->getClientOriginalName()]);
    	$this->validate($request, $imovel->rules);
    	
    	$imovel = Imoveis::create([
    		'titulo' => $request->titulo,
    		'tipo' => $request->tipo,
    		'cep' => $request->cep,
    		'cidade' => $request->cidade,
    		'estado' => $request->estado,
    		'bairro' => $request->bairro,
    		'numero' => $request->numero,
    		'complemento' => $request->complemento,
    		'preco' => $request->preco,
    		'area' => $request->area,
    		'qnt_dormitorios' => $request->qnt_dormitorios,
    		'qnt_suites' => $request->qnt_suites,
    		'banheiros' => $request->banheiros,
    		'salas' => $request->salas,
    		'garagem' => $request->garagem,
    		'descricao' => $request->descricao,
    		'imagem'=>$request->imagem->getClientOriginalName()
    	]);

    	$destinationPath = 'imagens/imoveis/'.$imovel->id;
        $imagem->move($destinationPath,$imagem->getClientOriginalName());

    	return redirect()->route('lista_imoveis')->with('tipo','success')->with('msg','Imóvel cadastrado com sucesso');
    }

    public function editar($id){
    	$imovel = Imoveis::find($id);
    	return view('imoveis.cadastro-edita', ['imovel'=>$imovel]);
    }

    public function salvar(Request $request){
    	$imovel = Imoveis::find($request->id);

    	$this->validate($request, $imovel->rules);

    	if ($request->imagem){
			$imagem = $request->file('imagem');

			$filename = 'imagens/imoveis/'.$imovel->id.'/'.$imovel->imagem;

			if (file_exists($filename)) {
			    unlink($filename);
			} 

    		$imovel->fill([
    			'imagem'=>$imagem->getClientOriginalName()
    		]);
    		$imovel->save();


			$destinationPath = 'imagens/imoveis/'.$imovel->id;
        	$imagem->move($destinationPath,$imagem->getClientOriginalName());
    	}

    	$imovel->fill([
    		'titulo' => $request->titulo,
    		'tipo' => $request->tipo,
    		'cep' => $request->cep,
    		'cidade' => $request->cidade,
    		'estado' => $request->estado,
    		'bairro' => $request->bairro,
    		'numero' => $request->numero,
    		'complemento' => $request->complemento,
    		'preco' => $request->preco,
    		'area' => $request->area,
    		'qnt_dormitorios' => $request->qnt_dormitorios,
    		'qnt_suites' => $request->qnt_suites,
    		'banheiros' => $request->banheiros,
    		'salas' => $request->salas,
    		'garagem' => $request->garagem,
    		'descricao' => $request->descricao
    	]);
    	$imovel->save();
    	return redirect()->route('lista_imoveis')->with('tipo','success')->with('msg','Imóvel atualizado com sucesso');
    }

    public function deletar($id){
    	$imovel = Imoveis::find($id);
    	$imovel->delete();
    	return redirect()->route('lista_imoveis')->with('tipo','success')->with('msg','Imóvel excluído com sucesso');
    }

    public function buscaPorCodigo(Request $request){
    	$imovel = Imoveis::find($request->id);

    	if (!$imovel){
    		$imovel = null;
    	}
    	
    	return view('imoveis.visualizar', ['imovel'=>$imovel]);
    }

    public function visualizar($id){
    	$imovel = Imoveis::find($id);

    	if (!$imovel){
    		$imovel = null;
    	}
    	
    	return view('imoveis.visualizar', ['imovel'=>$imovel]);
    }
}