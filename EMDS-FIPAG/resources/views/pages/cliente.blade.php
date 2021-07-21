@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div>
        {!! Form::open(['action' => 'ClienteController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'col s12']) !!}
        {{ csrf_field() }}
        <div class="card hoverable">
          <div class="card-content">
            <span class="card-title">Cliente</span>
            <div class="divider"></div>
            <div class="section">
                
                  
                <div class="input-field">
                    <i class="material-icons prefix">person</i>
                    {{ Form::text('name','',['class' => 'validate', 'id' => 'name']) }}
                    <label for="name">Nome </label>
                    @if ($errors->has('name'))
                      <span class="red-text"><strong>{{ $errors->first('name') }}</strong></span>
                    @endif
                  </div>
                  <br>
                
                  <div class="input-field">
                    <i class="material-icons prefix">mail</i>
                    {{ Form::text('email','',['class' => 'validate', 'id' => 'email']) }}
                    <label for="email">Email </label>
                    @if ($errors->has('email'))
                      <span class="red-text"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                  </div>
                  <br>
                
                  <div class="input-field">
                    <i class="material-icons prefix">phone</i>
                    {{ Form::text('phone','',['class' => 'validate', 'id' => 'phone']) }}
                    <label for="phone">Numero de telefone </label>
                    @if ($errors->has('phone'))
                      <span class="red-text"><strong>{{ $errors->first('phone') }}</strong></span>
                    @endif
                  </div>
                  <br>
                   
                
                  <div class="input-field">
                    <i class="material-icons prefix">message</i>
                    <br>
                    

                    {{ Form::textarea('description','',['name'=>'description','class' => 'ckeditor form-control', 'id' => 'description']) }}
                    @if ($errors->has('description'))
                      <span class="red-text"><strong>{{ $errors->first('description') }}</strong></span>
                    @endif
                  </div>
                  
                
                    <br>
                    <div class="input-field">
                      <i class="material-icons prefix">class</i>
                      {{ Form::select('category_id[]',$categories,null,['name' => 'category' ,'id' => 'category','value' =>'category_id[].id']),'category_id[0]' }}
      
                      <label for="category">Categoria do Documento</label>
                      @if ($errors->has('category'))
                        <span class="red-text"><strong>{{ $errors->first('category') }}</strong></span>
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
                          {{ Form::submit('Submeter',['class' => 'btn-large waves-effect waves-light']) }}
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