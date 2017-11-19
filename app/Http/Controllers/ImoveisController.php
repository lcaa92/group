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

    public function importarXML(){
    	//se o caminho esteja hospedado noutro servidor
		$url = "http://imob21.com.br/acc/imob21/publish/integracao.xml";

		$data = file_get_contents($url);
		$xml = simplexml_load_file($url)->Imoveis;

		foreach ($xml->Imovel as $imovel) {
			echo "Titulo: ".$imovel->TipoImovel." ".$imovel->QtdDormitorios." quartos <br />";
			echo "Tipo: ".$imovel->TipoImovel."<br />";
			echo "CEP: ".$imovel->CEP."<br />";
			echo "Cidade: ".$imovel->Cidade."<br />";
			echo "Estado: ".$imovel->UF."<br />";
			echo "Bairro: ".$imovel->Bairro."<br />";
			echo "Número: ".$imovel->Numero."<br />";
			echo "Complemento: ".$imovel->Complemento."<br />";
			echo "Preco: ".$imovel->PrecoVenda."<br />";
			echo "Area: ".$imovel->AreaUtil."<br />";
			echo "Quartos: ".$imovel->QtdDormitorios."<br />";
			echo "Suites: ".$imovel->QtdSuites."<br />";
			echo "Banheiros: ".$imovel->QtdBanheiros."<br />";
			echo "Salas: ".$imovel->QtdSalas."<br />";
			echo "Descricao: ".$imovel->DescricaoLocalizacao."<br />";
			dd($imovel->Fotos);
			echo "<br /><br />";
		}
    }

    public function importarXML2(){
    	$url = "http://imob21.com.br/acc/imob21/publish/integracao.xml";

		// caso o caminho esteja hospedado no próprio servidor
		// coloque o ficheiro no caminho: 'public/assets/xml/file.xml'
		// $url = asset('assets/xml/file.xml');

		$data = file_get_contents($url);
		$xml = simplexml_load_file($url)->Imoveis;

		dd($xml);
    }
}