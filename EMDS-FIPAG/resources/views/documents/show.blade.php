@extends('layouts.app')

@section('content')
<style media="screen">
  .btn-icons {
    display: flex;
    justify-content: center;
  }
  .btn-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    color: #fff;
    padding-left: 16px;
    padding-top: 16px;
    margin: auto 5px;
  }
  .btn-circle i:hover {
    color: #000;
    transition: 0.5s all;
  }
</style>
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">info</i>Informacao do Documento</h3>
        <div class="btn-icons">
          {!! Form::open() !!}
          <a href="/documents/{{ $doc->id }}/edit" class="btn-circle teal waves-effect waves-light tooltipped" data-position="left" data-delay="50" data-tooltip="Edit this"><i class="material-icons">mode_edit</i></a>
          <a href="/documents/open/{{ $doc->id }}" class="btn-circle blue darken-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Open this"><i class="material-icons">open_with</i></a>
          {!! Form::close() !!}
          <!-- SHARE using link -->
          {!! Form::open(['action' => ['ShareController@update', $doc->id], 'method' => 'PATCH', 'id' => 'form-share-documents-' . $doc->id]) !!}
          @can('shared')
          <a href="#" class="btn-circle purple waves-effect waves-light data-share tooltipped" data-position="top" data-delay="50" data-tooltip="Share this" data-form="documents-{{ $doc->id }}"><i class="material-icons">share</i></a>
          @endcan
          {!! Form::close() !!}
          <!-- DELETE using link -->
          {!! Form::open(['action' => ['DocumentsController@destroy', $doc->id],
          'method' => 'DELETE', 'id' => 'form-delete-documents-' . $doc->id]) !!}
          @can('delete')
          <a href="#" class="btn-circle red waves-effect waves-light data-delete tooltipped" data-position="right" data-delay="50" data-tooltip="Delete this" data-form="documents-{{ $doc->id }}"><i class="material-icons">delete</i></a>
          @endcan
          {!! Form::close() !!}
        </div>
      </div>
      <div class="col s12 m11">
        <div class="card horizontal hoverable">
          <div class="card-image hide-on-med-and-down">
            <img src="/storage/images/sideytu1.jpg" height="650px">
          </div>
          <div class="card-stacked">
            <div class="card-content">
              @if($doc->isExpire == 2)
                <h5 class="red-text">
                  <i class="material-icons">error_outline</i> Este documento expirou!
                </h5>
                <p class="red-text">Considera recuperar ou apagar o documento.</p>
              @endif
              <ul class="collapsible" data-collapsible="accordion">
                <li>
                  <div class="collapsible-header active"><i class="material-icons">folder</i>Nome do documento</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->name }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">description</i>Descricao</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->description }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">account_circle</i>Dono</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->user['name'] }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">group</i>Departmento</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->user->department['dptName'] }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">class</i>Categoria</div>
                  <div class="collapsible-body">
                    <span class="teal-text">
                      <ul>
                        @foreach($doc->categories()->get() as $cate)
                        <li>{{ $cate->name }}</li>
                        @endforeach
                      </ul>
                    </span>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">date_range</i>Data de expiracao</div>
                  <div class="collapsible-body">
                    <span class="teal-text">
                      @if($doc->isExpire)
                        {{ $doc->expires_at }}
                      @else
                        Nenhum data de expiracao
                      @endif
                    </span>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">date_range</i>Data de expiracao</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->created_at->toDayDateTimeString() }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">date_range</i>Data de upload</div>
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->updated_at->toDayDateTimeString() }}</span></div>
                </li>
                <li>
                  <div class="collapsible-header"><i class="material-icons">info_outline</i>MetaData</div>
                  <div class="collapsible-body">
                    <span class="teal-text">
                      <ul>
                        <li>Tamanho : {{ $doc->filesize }} </li>
                        <li>Tipo : {{ $doc->mimetype }}</li>
                        <li>Ultima modificacao : {{ \Carbon\Carbon::createFromTimeStamp(Storage::lastModified($doc->file))->formatLocalized('%d %B %Y, %H:%M') }}</li>
                      </ul>
                    </span>
                  </div>
                </li>
              </ul>
            </div>
            <div class="card-action">
              <a href="/documents" class="teal-text">Voltar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


<!-- medium modal -->
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="mediumBody">
            <div>
                <!-- the result to be displayed apply here -->
            </div>
        </div>
    </div>
</div>
</div>


