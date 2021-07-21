@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
      <div class="col m8 offset-m2 s12">
        {!! Form::open(['action' => ['DocumentsController@destroy', $doc_id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data', 'class' => 'col s12']) !!}
        {{ csrf_field() }}
        <div class="card hoverable">
          <div class="card-content">
            <span class="card-title">Enviar Resposta ao cliente</span>
            <div class="divider"></div>
            <div class="section">
                
                 
                   
                
                  <div class="input-field">
                    <i class="material-icons prefix">message</i>
                    {{ Form::text('description','',['class' => 'validate', 'id' => 'description']) }}
                    <label for="description">Mensagem </label>
                    @if ($errors->has('description'))
                      <span class="red-text"><strong>{{ $errors->first('description') }}</strong></span>
                    @endif
                  </div>
                  
                
                    
                    <br>
                    <div class="file-field input-field">
                      <div class="btn white">
                        <span class="black-text">Escolhe o ficheiro</span>
                        {{ Form::file('file') }}
                        @if ($errors->has('file'))
                          <span class="red-text"><strong>{{ $errors->first('file') }}</strong></span>
                        @endif
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                      </div>
                    </div>

                    <div class="input-field">
                        <p class="center">
                          {{ Form::submit('Enviar',['class' => 'btn-large waves-effect waves-light']) }}
                        </p>
                      </div>
            </div>
          </div>
         
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

@endsection