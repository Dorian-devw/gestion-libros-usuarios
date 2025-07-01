@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h1>Listado de Libros</h1>
        @if(session('usuario')['rol'] === 'BIBLIOTECARIO')
            <a href="{{ route('libros.create') }}" class="btn btn-primary">Nuevo Libro</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoría</th>
                <th>ISBN</th>
                <th>Ejemplares</th>
            </tr>
        </thead>
        <tbody>
            @foreach($libros as $libro)
                <tr>
                    <td>{{ $libro['TITULO'] }}</td>
                    <td>{{ $libro['AUTOR'] }}</td>
                    <td>{{ $libro['CATEGORIA'] }}</td>
                    <td>{{ $libro['ISBN'] }}</td>
                    <td>{{ $libro['EJEMPLARES'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection