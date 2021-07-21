@extends('layouts.app')

@section('content')
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">folder</i> Meus Documentos
        
        </h3>
        <div class="divider"></div>
      </div>
      <div class="card">
        <div class="card-content">
          <table class="bordered centered highlight responsive-table" id="myDataTable">
            <thead>
              <tr>
                  <th>Categoria</th>
                  <th>Tipo</th>
                  <th>Tamanho</th>
                  <th>Data do upload</th>
                  <th>Data de expiracao</th>
                  <th>Accoes</th>
              </tr>
            </thead>
            <tbody>
              @if(count($docs) > 0)
                @foreach($docs as $doc)
                <tr>
                  @foreach( $cat as $ct)
                      @if ($ct->id === $doc->category_id)
                      <td>{{ $ct->name  }}</td>
                      @endif
                      @endforeach
                  <td>{{ $doc->mimetype }}</td>
                  <td>{{ $doc->filesize }}</td>
                  <td>{{ $doc->created_at->toDayDateTimeString() }}</td>
                  <td>
                    @if($doc->isExpire)
                      {{ $doc->expires_at }}
                    @else
                      Nao Expira
                    @endif
                  </td>
                  <td>
                    @can('read')
                    {!! Form::open() !!}                    
                    <a href="documents/{{ $doc->id }}" class="tooltipped" data-position="left" data-delay="50" data-tooltip="View Details"><i class="material-icons">visibility</i></a>
                    {!! Form::close() !!}
                    {!! Form::open() !!}
                    <a href="documents/open/{{ $doc->id }}" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Open"><i class="material-icons">open_with</i></a>
                    {!! Form::close() !!}
                    @endcan
                    {!! Form::open() !!}
                    @can('download')
                    <a href="documents/download/{{ $doc->id }}" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Download"><i class="material-icons">file_download</i></a>
                    @endcan
                    {!! Form::close() !!}
                    {!! Form::open() !!}
                    @can('shared')
                    <a href="#" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Share"><i class="material-icons">share</i></a>
                    @endcan
                    {!! Form::close() !!}
                    {!! Form::open() !!}
                    @can('edit')
                    <a href="documents/{{ $doc->id }}/edit" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Edit"><i class="material-icons">mode_edit</i></a>
                    @endcan
                    {!! Form::close() !!}
                    <!-- DELETE using link -->
                    {!! Form::open(['action' => ['DocumentsController@destroy', $doc->id],
                    'method' => 'DELETE',
                    'id' => 'form-delete-documents-' . $doc->id]) !!}
                    @can('delete')
                    <a href="" class="data-delete tooltipped" data-position="left" data-delay="50" data-tooltip="Delete" data-form="documents-{{ $doc->id }}"><i class="material-icons">delete</i></a>
                    @endcan
                    {!! Form::close() !!}
                  </td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6"><h5 class="teal-text">Nenhum documento encontrado</h5></td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
