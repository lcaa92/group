<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imoveis;
use App\Fotos;
use Storage;

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
    	]);
   	
    	
    	$foto = Fotos::create([
    			'id_imovel'=>$imovel->id,
    			'imagem' => $imagem->getClientOriginalName(),
    			'principal' => '1'
    		]);
    	$destinationPath = 'imagens/imoveis/'.$imovel->id.'/'.$foto->id;
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
    		$foto = Fotos::where('id_imovel', '=', $imovel->id)->where('principal', '=', '1')->first();
			$imagem = $request->file('imagem');

			$filename = 'imagens/imoveis/'.$imovel->id.'/'.$foto->imagem;

			if (file_exists($filename)) {
			    unlink($filename);
			} 

    		$foto->fill([
    			'imagem'=>$imagem->getClientOriginalName()
    		]);
    		$foto->save();


			$destinationPath = 'imagens/imoveis/'.$imovel->id.'/'.$foto->id;
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
    	return redirect()->route('editar_imoveis', ['id'=>$imovel->id])->with('tipo','success')->with('msg','Foto atualizada com sucesso');
    }

    public function deletar($id){
    	$imovel = Imoveis::find($id);

    	$fotos = Fotos::where('id_imovel', '=', $imovel->id)->get();

		$dir = 'imagens/imoveis/'.$imovel->id;
    	foreach ($fotos as $foto) {
    		$dir_foto = $dir.'/'.$foto->id;
	    	$filename = $dir_foto.'/'.$foto->imagem;
	    	
			if (file_exists($filename)) {
			    unlink($filename);
			    rmdir($dir_foto);
			}
			$foto->delete();
    	}
    	rmdir($dir);
    	
    	$imovel->delete();
    	return redirect()->route('lista_imoveis')->with('tipo','success')->with('msg','Imóvel excluído com sucesso');
    }

    public function buscaPorCodigo(Request $request){
    	$imovel = Imoveis::where('id', '=', $request->id)->orWhere('codigo', '=', $request->id)->first();

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
		$url = "http://imob21.com.br/acc/imob21/publish/integracao.xml";

		$xml = simplexml_load_file($url)->Imoveis;

		foreach ($xml->Imovel as $imovel) {
			$imo = Imoveis::create([
				'codigo' => $imovel->CodigoImovel,
				'titulo' => $imovel->TipoImovel." ".$imovel->QtdDormitorios." quartos",
	    		'tipo' => $imovel->TipoImovel,
	    		'cep' => $imovel->CEP,
	    		'cidade' => $imovel->Cidade,
	    		'estado' => $imovel->UF,
	    		'bairro' => $imovel->Bairro,
	    		'numero' => $imovel->Numero,
	    		'complemento' => $imovel->Complemento,
	    		'preco' => $imovel->PrecoVenda,
	    		'area' => $imovel->AreaUtil,
	    		'qnt_dormitorios' => $imovel->QtdDormitorios,
	    		'qnt_suites' => $imovel->QtdSuites,
	    		'banheiros' => $imovel->QtdBanheiros,
	    		'salas' => $imovel->QtdSalas,
	    		'garagem' => $imovel->QtdVagas,
	    		'descricao' => $imovel->DescricaoLocalizacao,
			]);
			

			foreach ($imovel->Fotos->Foto as $foto) {
				$contents = file_get_contents($foto->URLArquivo);
 				$ext = str_replace('.','',strrchr($foto->URLArquivo, '.'));
				$name = $foto->NomeArquivo.'.'.$ext;

				$ft = Fotos::create([
					'imagem'=>$name,
					'principal'=>$foto->Principal,
					'id_imovel'=>$imo->id
				]);

				Storage::disk('imagens')->put('imoveis/'.$imo->id.'/'.$ft->id.'/'.$name, $contents);
			}
		}
		return redirect()->route('lista_imoveis')->with('tipo','success')->with('msg','XML importado com sucesso');
    }


    public function addFotos(Request $request){
    	$foto = new Fotos();
    	$imagens = $request->file('imagens');
    	$request->merge(['principal' => '0']);

    	foreach ($request->imagens as $key => $imagem) {
    		$request->merge(['imagem' => $imagem]);
    		print_r( $request->imagem);
    		$this->validate($request, $foto->rules);
    	}
    	
    	foreach ($request->imagens as $key => $imagem) {
    		$foto = Fotos::create([
    			'id_imovel'=>$request->id_imovel,
    			'principal'=>$request->principal,
    			'imagem'=>$imagem->getClientOriginalName(),
    		]);

    		$destinationPath = 'imagens/imoveis/'.$request->id_imovel.'/'.$foto->id;
        	$imagem->move($destinationPath,$imagem->getClientOriginalName());
    	}

    	return redirect()->route('editar_imoveis', ['id'=>$request->id_imovel])->with('tipo','success')->with('msg','Fotos adicionadas com sucesso');
    }

    public function excluirFotos($id){
    	$foto = Fotos::find($id);

    	$dir = 'imagens/imoveis/'.$foto->id_imovel.'/'.$foto->id;
    	$filename = $dir.'/'.$foto->imagem;
    	
			if (file_exists($filename)) {
			    unlink($filename);
			    rmdir($dir);
			    $foto->delete();
			}
    	return redirect()->route('editar_imoveis', ['id'=>$foto->id_imovel])->with('tipo','success')->with('msg','Foto excluída com sucesso');
    }

}