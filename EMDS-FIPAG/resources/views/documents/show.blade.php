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

  .styled-table {
    border-collapse: collapse;
    margin: 0px 0px 0px 0px;
    font-size: 0.9em;
    font-family: sans-serif;
    width: 1200px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
    background-color: #058ce6;
    color: #ffffff;
    text-align: left;
    height: 100px;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    border-bottom: thin solid #dddddd;
    height: 150px;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #058ce6;
}

.styled-table tbody tr.active-row {
    font-weight: bold;
    color: #058ce6;
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
          <a href="/history/{{ $doc->id }}" class="btn-circle brown  waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Ver Historico"><i class="material-icons">history</i></a>
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
        <a href="#" data-target="devModal" class="btn-circle purple waves-effect waves-light  tooltipped" data-position="top" data-delay="50" data-tooltip="Devolver ao atendimento" >
          <i class="material-icons">share</i>
        </a>
        {!! Form::close() !!}
        @endcan
       
          @endhasanyrole()

          @else
          @hasrole('User') 
          <!-- SHARE to user using link -->
          @can('shared')
          <a  href="#" class="btn-circle yellow waves-effect waves-light  tooltipped"  data-form="documents-{{ $doc->id }}"
          data-target="loginModal" data-position="top" data-delay="50" data-tooltip="Pegar o Documento" >
            <i class="material-icons">check</i>
          </a>
          @endcan
            @endhasrole()
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
      
          
          <div class="card-stacked">
            <div class="card-content">
              @if($doc->isExpire == 2)
                <h5 class="red-text">
                  <i class="material-icons">error_outline</i> Este documento expirou!
                </h5>
                <p class="red-text">Considera recuperar ou apagar o documento.</p>
              @endif
              
            </div>



            <table class="styled-table">
              <thead>
                  <tr>
                      <th><i class="material-icons">account_circle</i><h6>Usuário em posse</h6></th>
                      <th><i class="material-icons">description</i><h6>Descricao</h6></th>
                      <th><i class="material-icons">account_circle</i><h6>Cliente</h6></th>
                      <th><i class="material-icons">class</i><h6>Categoria</h6></th>
                      <th><i class="material-icons">date_range</i><h6>Data de expiracao</h6></th>
                      <th><i class="material-icons">date_range</i><h6>Data de Upload</h6></th>
                      @if ($doc->file != null)
                      <th><i class="material-icons">folder</i><h6>Tamanho</h6></th>
                      <th><i class="material-icons">aspect_ratio</i><h6>Tipo</h6></th>
                      <th><i class="material-icons">date_range</i><h6>Ultima Modificacao</h6></th>
                      @endif
                  </tr>
              </thead>
              <tbody>
                  <tr>
                    @if ($user != null)
                  <td>{{ $user->name }}</td>
                  @else
                  <td>Nenhum usuario em posse...</td>
                    @endif
                      <td>{{ $doc->description }}</td>
                      <td>{{ $doc->cliente_name }}</td>
                      <td>{{ $cat->name }}</td>
                      @if ($doc->expires_at != null)
                      <td>{{$doc->expires_at->toDayDateTimeString() }}</td>
                      @else
                      <td>Nao expira...</td>
                      @endif
                      <td>{{ $doc->created_at->toDayDateTimeString()}}</td>

                      @if ($doc->file != null)
                         <td>{{ $doc->filesize }}</td>
                         <td>{{ $doc->mimetype }}</td>
                         <td>{{ \Carbon\Carbon::createFromTimeStamp(Storage::lastModified($doc->file))->formatLocalized('%d %B %Y, %H:%M') }}</td>
                      @endif
                  </tr>
                  
              </tbody>
          </table>

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
                    <i class="material-icons prefix">message</i>
                   
                    <textarea class="validate" id="description" name="description" placeholder="Mensagem"></textarea>
                    
                    @if ($errors->has('description'))
                      <span class="red-text"><strong>{{ $errors->first('description') }}</strong></span>
                    @endif
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
                                <input type="checkbox" id="{{ $dept->id }}dept" name="depart" value="{{ $dept->id }}" class="sub_chk" data-id="{{$dept->id}}dept">
                                <label for="{{ $dept->id }}dept"></label>
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
                    <div class="input-field">
                      <i class="material-icons prefix">message</i>
                     
                      <textarea class="validate" id="description" name="description" placeholder="Mensagem"></textarea>
                      
                      @if ($errors->has('description'))
                        <span class="red-text"><strong>{{ $errors->first('description') }}</strong></span>
                      @endif
                    </div>

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

<!-- Take pop up modal -->
<div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" >Adicionar mensagem ao documento</h5>
              
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('document.take',$doc->id) }}">
                {{ csrf_field() }}

                <div class="input-field">
                  <i class="material-icons prefix">message</i>
                 
                  <textarea class="validate" id="description" name="description" placeholder="Mensagem"></textarea>
                  
                  @if ($errors->has('description'))
                    <span class="red-text"><strong>{{ $errors->first('description') }}</strong></span>
                  @endif
                </div>
                <div class="input-field">
                  <input type="submit" class= 'btn waves-effect waves-light' value="Enviar">
                </div>

              </form>
          </div>
      </div>
  </div>
</div>




<!-- Devolver pop up modal -->
<div class="modal" id="devModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" >Adicionar mensagem ao documento</h5>
              
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('document.devolver',$doc->id) }}">
                {{ csrf_field() }}

                <div class="input-field">
                  <i class="material-icons prefix">message</i>
                 
                  <textarea class="validate" id="description" name="description" placeholder="Mensagem"></textarea>
                  
                  @if ($errors->has('description'))
                    <span class="red-text"><strong>{{ $errors->first('description') }}</strong></span>
                  @endif
                </div>
                <div class="input-field">
                  <input type="submit" class= 'btn waves-effect waves-light' value="Enviar">
                </div>

              </form>
          </div>
      </div>
  </div>
</div>

@endsection





