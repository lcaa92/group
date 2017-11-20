@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Visualizar imóvel
                    <div class="pull-right">
                        <a href="{{ route('lista_imoveis') }}">Voltar para lista de imóveis</a>
                    </div>
                </div>

                <div class="panel-body">

                    @if (session('tipo') == 'success')
                        <div class="alert alert-success fade in alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Feito!</strong> {{ session('msg') }}
                        </div>
                    @endif

                    @if ($imovel == null)
                        <div class="alert alert-danger fade in alert-dismissable">
                            <strong>Desculpe!</strong> Nenhum imóvel foi encontrado.
                        </div>
                    @else
                    
                        <div class="row">
                            <div class="col-md-2">                            
                                <label>ID/Cod:</label> {{ $imovel->id  }} / {{ empty($imovel->codigo) ? 'N/A' : $imovel->codigo }}
                            </div>
                            <div class="col-md-4">                            
                                <label>Título:</label> {{ $imovel->titulo }}
                            </div>
                            <div class="col-md-3">                            
                                <label>Tipo:</label> {{ $imovel->tipo }}
                            </div>
                            <div class="col-md-3">                            
                                <label>CEP:</label> {{ $imovel->cep }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">                            
                                <label>Cidade:</label> {{ $imovel->cidade }}
                            </div>
                            <div class="col-md-2">                            
                                <label>Estado:</label> {{ $imovel->estado }}
                            </div>
                            <div class="col-md-3">                            
                                <label>Bairro:</label> {{ $imovel->bairro }}
                            </div>
                            <div class="col-md-2">                            
                                <label>Número:</label> {{ $imovel->numero }}
                            </div>
                            <div class="col-md-2">                            
                                <label>Complemento:</label> {{ $imovel->complemento }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">                            
                                <label>Preço:</label> R${{ $imovel->exibePreco($imovel->preco) }}
                            </div>
                            <div class="col-md-2">                            
                                <label>Área:</label> {{ $imovel->area }} m²
                            </div>
                            <div class="col-md-2">                            
                                <label>Quartos:</label> {{ $imovel->qnt_dormitorios }}
                            </div>
                            <div class="col-md-2">                            
                                <label>Suítes:</label> {{ $imovel->qnt_suites }}
                            </div>
                            <div class="col-md-2">                            
                                <label>Banheiros:</label> {{ $imovel->banheiros }}
                            </div>
                            <div class="col-md-2">                            
                                <label>Salas:</label> {{ $imovel->salas }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">                            
                                <label>Garagem:</label> {{ $imovel->garagem }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">                            
                                <label>Descrição:</label> {{ $imovel->descricao }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">                            
                                <label>Fotos</label>
                            </div>
                            @foreach ($imovel->fotos as $foto)
                            <div class="col-md-2 text-center">
                                <img style="width: 250px; height: 200px;" src="{{ asset('imagens/imoveis/'.$foto->id_imovel.'/'.$foto->id.'/'.$foto->imagem) }}" class="img-responsive img-square">    
                            </div>
                            
                            @endforeach
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection