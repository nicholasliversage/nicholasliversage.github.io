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
          <a href="/documents/{{ $doc->id }}/edit" class="btn-circle teal waves-effect waves-light tooltipped" data-position="left" data-delay="50" data-tooltip="Editar"><i class="material-icons">mode_edit</i></a>
          <a href="/documents/open/{{ $doc->id }}" class="btn-circle blue darken-3 waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Abrir"><i class="material-icons">open_with</i></a>
          {!! Form::close() !!}

          @hasanyrole('Root|Atendimento')
          <!-- SHARE to user using link -->
          @can('shared')
          <a href="#" data-target="modal1" class="btn-circle purple waves-effect waves-light data-share tooltipped" data-position="top" data-delay="50" data-tooltip="Designar a um funcionario" data-form="documents-{{ $doc->id }}">
            <i class="material-icons">share</i>
          </a>
          @endcan
          @endhasanyrole()
          
          
          @if ($doc->user_id != null)
              
          
          @hasanyrole('User') 
        <!-- SHARE to user using link -->
        
        @can('shared')
        {!! Form::open() !!}
        <a href="{{ route('document.devolver',$doc->id) }}"  class="btn-circle purple waves-effect waves-light  tooltipped" data-position="top" data-delay="50" data-tooltip="Devolver ao atendimento" >
          <i class="material-icons">share</i>
        </a>
        {!! Form::close() !!}
        @endcan
       
          @endhasanyrole()

          @else
          @hasanyrole('User') 
          <!-- SHARE to user using link -->
          
          @can('shared')
          {!! Form::open() !!}
          <a href="{{ route('document.take',$doc->id) }}"  class="btn-circle yellow waves-effect waves-light  tooltipped" data-position="top" data-delay="50" data-tooltip="Pegar o Documento" >
            <i class="material-icons">check</i>
          </a>
          {!! Form::close() !!}
          @endcan
         
            @endhasanyrole()
          @endif

          @hasanyrole('Root|Atendimento')
         <!-- SHARE to department using link -->
          @can('shared')
          <a href="#" data-target="modal2" class="btn-circle green waves-effect waves-light data-share tooltipped" data-position="top" data-delay="50" data-tooltip="Enviar a departmento" data-form="documents-{{ $doc->id }}">
            <i class="material-icons">share</i>
          </a>
          @endcan
          @endhasanyrole()
          <!-- DELETE using link -->
          {!! Form::open(['action' => ['DocumentsController@destroy', $doc->id],
          'method' => 'DELETE', 'id' => 'form-delete-documents-' . $doc->id]) !!}
          @can('delete')
          <a href="#" class="btn-circle red waves-effect waves-light data-delete tooltipped" data-position="right" data-delay="50" data-tooltip="Apagar" data-form="documents-{{ $doc->id }}"><i class="material-icons">delete</i></a>
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
                  <div class="collapsible-body"><span class="teal-text">{{ $doc->cliente_name }}</span></div>
                </li>
               
                <li>
                  <div class="collapsible-header"><i class="material-icons">class</i>Categoria</div>
                  <div class="collapsible-body">
                    <span class="teal-text">
                      <ul>
                        @foreach($doc->categories()->get() as $cate)
                        @if($cate->id === $doc->category_id)
                        <li>{{ $cate->name }}</li>
                        @endif
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
                @if ($doc->file != null)
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
                @endif
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


<!--users medium modal -->
<div id="modal1" class="modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
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
              <form action="{{ route('document.user',$doc->id) }}" method="POST">
                {{ csrf_field() }}
                <!-- the result to be displayed apply here -->
                <div class="card z-depth-2">
                  <div class="card-content">
                   
                    <table class="bordered centered highlight" id="myDataTable">
                      <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Role</th>
                            <th>Departmento</th>
                            <th>Accoes</th>
                        </tr>
                      </thead>
                      
                      <tbody>
                        @if(count($users) > 0)
                          @foreach($users as $user)
                            @if(!$user->hasRole('Root'))
                            <tr>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>
                              <td>{{ $user->department['dptName'] }}</td>
                              <td>
                                <!-- ASSIGN using link -->
                                <input type="checkbox" id="{{ $user->id }}" name="user" value="{{ $user->id }}" class="sub_chk" data-id="{{$user->id}}">
                                <label for="{{ $user->id }}"></label>
                              </td>
                            </tr>
                            @endif
                          @endforeach
                        @else
                          <tr>
                            <td colspan="4"><h5 class="teal-text">Nenhum user foi adicionado</h5></td>
                          </tr>
                        @endif
                      </tbody>
                    
                    </table>
                  </div>
                  <div class="input-field">
                    <input type="submit" class= 'btn waves-effect waves-light' value="Enviar">
                  </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!--departments medium modal -->
<div id="modal2" class="modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
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
              <form action="{{ route('document.department',$doc->id) }}" method="POST">
                {{ csrf_field() }}
                <!-- the result to be displayed apply here -->
                <div class="card z-depth-2">
                  <div class="card-content">
                   
                    <table class="bordered centered highlight" id="myDataTable">
                      <thead>
                        <tr>  
                            <th>Departmento</th>
                            <th>Accoes</th>
                        </tr>
                      </thead>
                      
                      <tbody>
                        @if(count($depart) > 0)
                          @foreach($depart as $dept)
                            
                            <tr>
                              
                              <td>{{ $dept->dptName }}</td>
                              <td>
                                <!-- ASSIGN using link -->
                                <input type="checkbox" id="{{ $dept->id }}" name="depart" value="{{ $dept->id }}" class="sub_chk" data-id="{{$dept->id}}">
                                <label for="{{ $dept->id }}"></label>
                              </td>
                            </tr>
                           
                          @endforeach
                        @else
                          <tr>
                            <td colspan="4"><h5 class="teal-text">Nenhum departamento foi adicionado</h5></td>
                          </tr>
                        @endif
                      </tbody>
                    
                    </table>
                  </div>
                  <div class="input-field">
                    <input type="submit" class= 'btn waves-effect waves-light' value="Enviar">
                  </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection





