@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar novo imóvel</div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ isset($imovel) ? route('salvar_imoveis') : route('gravar_imoveis') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Título</label>
                                <input id="titulo" type="text" class="form-control" name="titulo" value="{{ isset($imovel) ? old('titulo', $imovel->titulo) : old('titulo') }}" required autofocus>
                                @if ($errors->has('titulo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('titulo') }}</strong>
                                    </span>
                                @endif
                            </div>    

                            <div class="col-md-6">
                                <label>Selecione um tipo de imóvel</label>
                                <select name="tipo" class="form-control" required>
                                    <option value="">Selecione um tipo de imóvel</option>
                                    <option value="APARTAMENTO" {{ isset($imovel) ? $imovel->tipo == 'APARTAMENTO' ? 'selected' : '' : old('tipo') == 'APARTAMENTO' ? 'selected' : '' }}>APARTAMENTO</option>
                                    <option value="CASA" {{ isset($imovel) ? $imovel->tipo == 'CASA' ? 'selected' : '' : old('tipo') == 'CASAA' ? 'selected' : '' }}>CASA</option>
                                </select>

                                @if ($errors->has('tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                                @endif
                            </div> 
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label>CEP</label>
                                <input id="cep" type="text" class="form-control" onkeypress="mascara(this,valida_cep)"  onblur="buscaCep()" name="cep" value="{{ isset($imovel) ? old('cep', $imovel->cep) : old('cep') }}">

                                @if ($errors->has('cep'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cep') }}</strong>
                                    </span>
                                @endif
                            </div>   

                            <div class="col-md-2">
                                <label>Cidade</label>
                                <input id="cidade" type="text" class="form-control" name="cidade" value="{{ isset($imovel) ? old('cidade', $imovel->cidade) : old('cidade') }}" readonly>

                                @if ($errors->has('cidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cidade') }}</strong>
                                    </span>
                                @endif
                            </div> 

                            <div class="col-md-2">
                                <label>Estado</label>
                                <input id="estado" type="text" class="form-control" name="estado" value="{{ isset($imovel) ? old('estado', $imovel->estado) : old('estado') }}" readonly>

                                @if ($errors->has('estado'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <label>Bairro</label>
                                <input id="bairro" type="text" class="form-control" name="bairro" value="{{ isset($imovel) ? old('bairro', $imovel->bairro) : old('bairro') }}">

                                @if ($errors->has('bairro'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bairro') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <label>Número</label>
                                <input id="numero" type="text" class="form-control" name="numero" value="{{ isset($imovel) ? old('numero', $imovel->numero) : old('numero') }}">

                                @if ($errors->has('numero'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numero') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <label>Complemento</label>
                                <input id="complemento" type="text" class="form-control" name="complemento" value="{{ isset($imovel) ? old('complemento', $imovel->complemento) : old('complemento') }}">

                                @if ($errors->has('complemento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('complemento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label>Preço</label>
                                <input id="preco" type="text" class="form-control" name="preco" onkeypress="mascara(this,moeda)"  value="{{ isset($imovel) ? old('preco', $imovel->preco) : old('preco') }}">

                                @if ($errors->has('preco'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('preco') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <label>Área <small>m²</small></label>
                                <input id="area" type="number" min="0" class="form-control" name="area" value="{{ isset($imovel) ? old('area', $imovel->area) : old('area') }}">

                                @if ($errors->has('area'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-1">
                                <label>Dormitórios</label>
                                <input id="qnt_dormitorios" type="number" min="0" class="form-control" name="qnt_dormitorios" value="{{ isset($imovel) ? old('qnt_dormitorios', $imovel->qnt_dormitorios) : old('qnt_dormitorios') }}">

                                @if ($errors->has('qnt_dormitorios'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qnt_dormitorios') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-1">
                                <label>Suítes</label>
                                <input id="qnt_suites" type="number" min="0" class="form-control" name="qnt_suites" value="{{ isset($imovel) ? old('qnt_suites', $imovel->qnt_suites) : old('qnt_suites') }}">

                                @if ($errors->has('qnt_suites'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qnt_suites') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-1">
                                <label>Banheiros</label>
                                <input id="banheiros" type="number" min="0" class="form-control" name="banheiros" value="{{ isset($imovel) ? old('banheiros', $imovel->banheiros) : old('banheiros') }}">

                                @if ($errors->has('banheiros'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banheiros') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-1">
                                <label>Salas</label>
                                <input id="salas" type="number" min="0" class="form-control" name="salas" value="{{ isset($imovel) ? old('salas', $imovel->salas) : old('salas') }}">

                                @if ($errors->has('salas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('salas') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-1">
                                <label>Garagem</label>
                                <input id="garagem" type="number" min="0" class="form-control" name="garagem" value="{{ isset($imovel) ? old('garagem', $imovel->garagem) : old('garagem') }}">

                                @if ($errors->has('garagem'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('garagem') }}</strong>
                                    </span>
                                @endif
                            </div>

                           <div class="col-md-3">
                                <label>Imagem </label>
                                <input id="imagem" type="file" class="form-control" name="imagem" value="{{ old('imagem') }}" {{ isset($imovel) ? '' : 'required' }}>
                                @if (isset($imovel))
                                <small>Deixe em branco para não alterar</small>
                                @endif

                                @if ($errors->has('imagem'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('imagem') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Descrição</label>
                                <textarea rows="5" id="descricao" class="form-control" name="descricao">{{ isset($imovel) ? old('descricao', $imovel->descricao) : old('descricao') }}</textarea>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                 @if (isset($imovel))
                                    <input type="hidden" name="id" value="{{ $imovel->id }}">
                                @endif
                                <button type="submit" class="form-control btn btn-primary">
                                    Cadastrar
                                </button>
                            </div>    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function leech(v){
    v=v.replace(/o/gi,"0")
    v=v.replace(/i/gi,"1")
    v=v.replace(/z/gi,"2")
    v=v.replace(/e/gi,"3")
    v=v.replace(/a/gi,"4")
    v=v.replace(/s/gi,"5")
    v=v.replace(/t/gi,"7")
    return v
}

function valida_cep(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
   // v=v.replace(/^(\d{2})(\d)/,"$1.$2") //Esse é tão fácil que não merece explicações
    v=v.replace(/(\d{3})(\d{1,3})$/,"$1-$2")
    
    return v
}

function moeda(v){ 
    v=v.replace(/\D/g,"") // permite digitar apenas numero 
    v=v.replace(/(\d{1})(\d{14})$/,"$1.$2") // coloca ponto antes dos ultimos digitos 
    v=v.replace(/(\d{1})(\d{11})$/,"$1.$2") // coloca ponto antes dos ultimos 13 digitos 
    v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") // coloca ponto antes dos ultimos 10 digitos 
    v=v.replace(/(\d{1})(\d{5})$/,"$1.$2") // coloca ponto antes dos ultimos 7 digitos 
    v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2") // coloca virgula antes dos ultimos 4 digitos 
    return v;
}

function buscaCep(){
    var cep = $('#cep').val();

    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
            if (!data.error) {
                $('#cidade').val(data.localidade)
                $('#estado').val(data.uf)
                $('#bairro').val(data.bairro)
                console.log(data);
            }
            else {
                alert('Endereço não encontrado!');
            }
        }).fail(function (error) {
            console.log(error);
        });
}    
</script>

@endsection
