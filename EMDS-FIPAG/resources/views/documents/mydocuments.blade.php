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
                  <th>Cliente</th>
                  <th>Departmento</th>
                  <th>Data de upload</th>
                  <th>Accoes</th>
              </tr>
            </thead>
            <tbody>
              @if(count($docs) > 0)
                @foreach($docs as $doc)
                <tr>
                  @foreach ($cat as $c )
                  @if ($c->id == $doc->category_id)
                  <td>{{ $c->name}}</td> 
                  @endif
                  @endforeach
                  <td>{{ $doc->cliente_name }}</td>
                  @foreach ($dept as $dep)
                  @if ($dep->id == $doc->depart_id)
                  <td>{{ $dep->dptName }}</td> 
                  @endif
                  @endforeach
                  <td>{{ $doc->created_at->toDayDateTimeString() }}</td>
                  <td>
                    <p>
                      <a href="documents/{{ $doc->id }}" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Abrir"><i class="material-icons">open_with</i></a>
                    </p>
                    <br>
                    <p>
                      <a href="documents/download/{{ $doc->id }}" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Baixar"><i class="material-icons">file_download</i></a>
                    </p>
                  </td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6"><h5 class="teal-text">Nenhum documento foi partilhado</h5></td>
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
