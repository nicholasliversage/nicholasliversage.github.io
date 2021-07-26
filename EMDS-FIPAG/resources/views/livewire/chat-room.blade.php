@extends('layouts.app')
@section('content')
<div class="row">
    <div class="section">
<div class="col m1 hide-on-med-and-down">
    @include('inc.sidebar')
  </div>
@foreach ($message as $msg)
<div class="container"   style=" width:800px" >
    <div class="row">
@if ($msg->user_id == $user->id)

        <div class="card hoverable" style="background-color:lightgreen">
            <div class="card-content">
                
      <h4><i class="material-icons prefix">person</i><b>   {{ $user->name }}</b></h4>
      <p>{{ $msg->body }}</p>
      <p>Nota: {{ $msg->description }}</p>
  </div>
</div>
    
@else

        <div class="card hoverable">
            <div class="card-content">
                @foreach ($cliente as $cc)
                  @if ($cc->id == $msg->cliente_id)
                  <h4><i class="material-icons prefix">person</i><b>    O cliente {{ $cc->name }}</b></h4> 
                  <p>{{ $msg->body }}</p>
                  <p>Assunto: {{ $msg->description }}</p>
                  @endif
                @endforeach

                @foreach ($users as $us)
                @if ($us->id == $msg->user_id)
                <h4><i class="material-icons prefix">person</i><b>      O Usuario {{ $us->name }}</b></h4> 
                <p>{{ $msg->body }}</p>
                <p>Nota: {{ $msg->description }}</p>
                @endif
              @endforeach
      
  </div>
</div>
   
@endif

@endforeach

</div>
</div>
    
@endsection