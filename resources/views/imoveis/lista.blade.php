@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista de imóveis
                    <div class="pull-right">
                        <a href="{{ route('cadastro_imoveis') }}">Cadastrar novo imóvel</a>
                    </div>
                </div>

                <div class="panel-body">

                    @if (session('tipo') == 'success')
                        <div class="alert alert-success fade in alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Feito!</strong> {{ session('msg') }}
                        </div>
                    @endif

                    @if (count($imoveis) == 0)
                        Nenhum imóvel cadastrado ainda
                    @else

                        <div class="table-responsive">
                            <table id="table_lista_imoveis" class="table display">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Cidade</th>
                                        <th>Estado</th>
                                        <th>Preço</th>
                                        <th>Descrição</th>
                                        <th></th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach ($imoveis as $imovel)
                                        <tr>
                                            <td>{{ $imovel->id }}</td>
                                            <td>{{ $imovel->titulo }}</td>
                                            <td>{{ $imovel->tipo }}</td>
                                            <td>{{ $imovel->cidade }}</td>
                                            <td>{{ $imovel->estado }}</td>
                                            <td>R${{ $imovel->exibePreco($imovel->preco) }}</td>
                                            <td>{{ $imovel->descricao }}</td>
                                            <td><a href="{{ route('visualizar_imoveis', ['id'=>$imovel->id]) }}">Visualizar</a> | <a href="{{ route('editar_imoveis', ['id'=>$imovel->id]) }}">Editar</a> | <a onclick="return ConfirmDelete()" href="{{ route('deletar_imoveis', ['id'=>$imovel->id]) }}">Excluir</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>   
                            </table>                            
                        </div>                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
                $('#table_lista_imoveis').DataTable({
                    "language": {
                        "lengthMenu": "Exibir _MENU_ registros por página",
                        "zeroRecords": "Nothing found - sorry",
                        "info": "Exibindo página _PAGE_ de _PAGES_",
                        "infoEmpty": "No records available",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "search": "Filtrar:",
                        "paginate": {
                            "first":      "Primeira",
                            "last":       "Ultima",
                            "next":       "Proxima",
                            "previous":   "Anterior"
                        },
                    }
                });
            } );
</script>
<script type="text/javascript">
    // For demo to fit into DataTables site builder...
    $('#table_lista_imoveis')
        .removeClass( 'display' )
        .addClass('table table-striped table-bordered');
</script>
<script>
  function ConfirmDelete()
  {
  var x = confirm("Você tem certeza que deseja excluir esse imóvel?");
  if (x)
    return true;
  else
    return false;
  }
</script>
@endsection