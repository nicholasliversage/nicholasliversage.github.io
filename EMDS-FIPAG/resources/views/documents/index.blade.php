@extends('layouts.app')

@section('content')
<style>
  .card-content2 {
    padding: 10px 7px;
  }
  /* --- for right click menu --- */
  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }
  .task i {
    color: rgb(35, 97, 231);
    font-size: 35px;
  }
  /* context-menu */
  .context-menu {
    padding: 0 5px;
    margin: 0;
    background: #f7f7f7;
    font-size: 15px;
    display: none;
    position: absolute;
    z-index: 10;
    box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.3);
  }
  .context-menu--active {
    display: block;
  }
  .context-menu_items {
    margin: 0;
  }
  .context-menu_item {
    border-bottom: 1px solid #ddd;
    padding: 12px 30px;
  }
  .context-menu_item:last-child {
    border-bottom: none;
  }
  .context-menu_item:hover {
    background: #fff;
  }
  .context-menu_item i {
    margin: 0;
    padding: 0;
  }
  .context-menu_item p {
    display: inline;
    margin-left: 10px;
  }
  .unshow {
    display: none;
  }
</style>
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">folder</i> Documentos
          @hasrole('Atendimento')
        @can('upload')
          <a href="/documents/create" class="btn waves-effect waves-light right tooltipped" data-position="left" data-delay="50" data-tooltip="Upload New Document"><i class="material-icons">file_upload</i></a>
        @endcan
        @endhasrole
        </h3>
        <div class="divider"></div>
      </div>
      <div class="card z-depth-2">
        <div class="card-content">
          <!-- Switch -->
          <div class="switch" style="margin-bottom: 2em;">
            <label>
              Grid View
              <input type="checkbox">
              <span class="lever"></span>
              Table View
            </label>
          </div>
          <!-- FOLDER View -->
          <div id="folderView">
            <div class="row">
              <form action="/sort" method="post" id="sort-form">
                {{ csrf_field() }}
                <div class="input-field col m2 s12">
                  <select name="filetype" id="sort">
                    <option value="" disabled selected>Choose</option>
                    <option value="image/jpeg" @if($filetype === 'image/jpeg') selected @endif>Imagens</option>
                    <option value="video/mp4" @if($filetype === 'video/mp4') selected @endif>Videos</option>
                    <option value="audio/mpeg" @if($filetype === 'audio/mpeg') selected @endif>Audio</option>
                    <option value="application/vnd.openxmlformats-officedocument.wordprocessingml.document">Documentos Word</option>
                    <option value="">Outros</option>
                  </select>
                  <label>Ordem dos Documentos</label>
                </div>
              </form>
              <form action="/search" method="post" id="search-form">
                {{ csrf_field() }}
                <div class="input-field col m4 s12 right">
                  <i class="material-icons prefix">search</i>
                  <input type="text" name="search" id="search" placeholder="Pesquisar...">
                  <label for="search"></label>
                </div>
              </form>
            </div>
            <br>
            <div class="row">
              @if(count($docs) > 0)
                @foreach($docs as $doc)
                <div class="col m2 s6" id="tr_{{$doc->id}}">
                  <div class="card hoverable indigo lighten-5 task" data-id="{{ $doc->id }}">
                    <label for="chk_{{$doc->id}}"></label>
                    <a href="/documents/{{ $doc->id }}">
                      <div class="card-content2 center">
                        @if(strpos($doc->mimetype, "image") !== false)
                        <i class="material-icons">image</i>
                        @elseif(strpos($doc->mimetype, "video") !== false)
                        <i class="material-icons">ondemand_video</i>
                        @elseif(strpos($doc->mimetype, "audio") !== false)
                        <i class="material-icons">music_video</i>
                        @elseif(strpos($doc->mimetype,"text") !== false)
                        <i class="material-icons">description</i>
                        @elseif(strpos($doc->mimetype,"application/pdf") !== false)
                        <i class="material-icons">picture_as_pdf</i>
                        @elseif(strpos($doc->mimetype, "application/vnd.openxmlformats-officedocument") !== false)
                        <i class="material-icons">library_books</i>
                        @else
                        <i class="material-icons">folder_open</i>
                        @endif
                        <h5>{{ $doc->cliente_name }}</h5>
                        @foreach( $category as $cate)
                        @if ($cate->id === $doc->category_id)
                        <h6>{{ $cate->name  }}<h6>
                       @endif
                       @endforeach
                        <p>{{ $doc->filesize }}</p>
                      </div>
                    </a>
                  </div>
                </div>
                @endforeach
              @else
                <h5 class="teal-text">Nenhum Documento encontrado no sistema</h5>
              @endif
            </div>
          </div>
          <!-- TABLE View -->
          <div id="tableView" class="unshow">
            <div class="row">
              <table class="bordered centered highlight responsive-table" id="myDataTable">
                <thead>
                  <tr>
                      <th></th>
                      <th>Nome do Ficheiro</th>
                      <th>Dono</th>
                      <th>Departmento</th>
                      <th>Data de upload</th>
                      <th>Data de expiracao</th>
                      <th>Accoes</th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($docs) > 0)
                    @foreach($docs as $doc)
                    <tr id="tr_{{$doc->id}}">
                      <td>
                        <label for="chk_{{ $doc->id }}"></label>
                      </td>
                      @foreach( $category as $cate)
                      @if ($cate->id === $doc->category_id)
                      <td>{{ $cate->name  }}</td>
                      @endif
                      @endforeach
                    
                      
                      <td>{{ $doc->created_at->toDayDateTimeString() }}</td>
                      <td>
                        @if($doc->isExpire)
                          {{ $doc->expires_at }}
                        @else
                          Nao expira
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
                        <!-- SHARE using link -->
                        @can('shared')
                        <a href="#" data-target="modal1" class="btn-circle purple waves-effect waves-light data-share tooltipped" data-position="top" data-delay="50" data-tooltip="Designar a um funcionario" >
                          <i class="material-icons">share</i>
                        </a>                       
                         @endcan
                        {!! Form::open() !!}
                        @can('edit')
                        <a href="documents/{{ $doc->id }}/edit" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Edit"><i class="material-icons">mode_edit</i></a>
                        @endcan
                        {!! Form::close() !!}
                        <!-- DELETE using link -->
                        {!! Form::open(['action' => ['DocumentsController@destroy', $doc->id],
                        'method' => 'DELETE', 'id' => 'form-delete-documents-' . $doc->id]) !!}
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
  </div>
</div>

@endsection

