@extends('layouts.app')

@section('content')
<div class="row">
  <div class="section">
    <div class="col m1 hide-on-med-and-down">
      @include('inc.sidebar')
    </div>
    <div class="col m11 s12">
      <div class="row">
        <h3 class="flow-text"><i class="material-icons">mode_edit</i> Edit User</h3>
        <div class="divider"></div>
      </div>
      <div class="row">
        <div class="col m8 s12">
          {!! Form::open(['action' => ['UsersController@update', $user->id], 'method' => 'PATCH', 'enctype' => 'multipart/form-data', 'class' => 'col s12']) !!}
            {{ csrf_field() }}
          <div class="card hoverable">
            <div class="card-content">
              <div class="row">
                <div class="input-field">
                  <i class="material-icons prefix">account_circle</i>
                  {{ Form::text('name',$user->name,['class' => 'validate', 'id' => 'name']) }}
                  <label for="name" class="blue-text">Nome/label>
                </div>
              </div>
              <div class="row">
                <div class="input-field">
                  <i class="material-icons prefix">email</i>
                  {{ Form::email('email',$user->email,['class' => 'validate', 'id' => 'email']) }}
                  <label for="email" class="blue-text">Email</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field">
                  <i class="material-icons prefix">group</i>
                  <select name="department_id" id="department_id">
                    @if(count($depts) > 0)
                      @if(Auth::user()->hasRole('Root'))
                        @foreach($depts as $dept)
                        <option value="{{ $dept->id }}" {{ $user->department['id'] == $dept->id ? 'selected' : '' }}>{{ $dept->dptName }}</option>
                        @endforeach
                      @elseif(Auth::user()->hasRole('Admin'))
                        <option value="{{ Auth::user()->department_id }}">{{ Auth::user()->department['dptName'] }}</option>
                      @endif
                    @endif
                  </select>
                  <label for="department_id" class="blue-text">Departmento</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field">
                  <i class="material-icons prefix">assignment_ind</i>
                  <select name="role" id="role">
                    <option value="" disabled selected>Assign Role</option>
                    @if(count($roles) > 0)
                      @foreach($roles as $role)
                      <option value="{{ $role->name }}" {{ $user->roles->pluck('name')->implode(' ') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                      @endforeach
                    @endif
                  </select>
                  <label for="role" class="blue-text">Current Role</label>
                </div>
              </div>
              <div class="row">
                <!-- Switch -->
                <div class="switch left">
                  <h5>Account</h5>
                  <label>
                    @if($user->status)
                      Desabilitar a conta
                      {{ Form::checkbox('status','',true) }}
                      <span class="lever"></span>
                      Habilitado
                    @else
                      Desabilitado
                      {{ Form::checkbox('status','') }}
                      <span class="lever"></span>
                      Habilitar
                    @endif
                  </label>
                </div>
                <div class="right">
                  <p><a href="#modal1" class="modal-trigger">Mudar Password ?</a></p>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="input-field">
                  {{ Form::submit('Save Changes', ['class' => 'btn waves-effect waves-light']) }}
                </div>
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
       
      </div>
    </div>
  </div>
</div>
<!-- Modal Structure -->
<div id="modal1" class="modal bottom-sheet">
  {!! Form::open(['action' => 'ProfileController@changePassword','method' => 'PATCH']) !!}
    {{ csrf_field() }}
  <div class="modal-content">
    <h4>Change Password</h4>
    <br>
    <div class="row">
        <div class="input-field col m4">
          <i class="material-icons prefix">vpn_key</i>
          {{ Form::password('current_password',['id' => 'current_password']) }}
          <label for="current_password">Current Password</label>
          @if ($errors->has('current_password'))
            <span class="red-text"><strong>{{ $errors->first('current_password') }}</strong></span>
          @endif
        </div>
        <div class="input-field col m4">
          <i class="material-icons prefix">vpn_key</i>
          {{ Form::password('new_password',['id' => 'new_password']) }}
          <label for="new_password">Novo Password</label>
          @if($errors->has('new_password'))
            <span class="red-text"><strong>{{ $errors->first('new_password') }}</strong></span>
          @endif
        </div>
        <div class="input-field col m4">
          <i class="material-icons prefix">vpn_key</i>
          {{ Form::password('new_password_confirmation',['id' => 'new_password_confirmation']) }}
          <label for="new_password_confirmation">Confirma Password</label>
          @if($errors->has('new_password_confirmation'))
            <span class="red-text"><strong>{{ $errors->first('new_password_confirmation') }}</strong></span>
          @endif
        </div>

    </div>
  </div>
  <div class="modal-footer">
    {{ Form::submit('Save Changes',['class' => 'modal-action modal-close waves-effect waves-green btn']) }}
  </div>
  {!! Form::close() !!}
</div>
@endsection
