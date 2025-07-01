@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Libro</h1>

    <form method="POST" action="{{ route('libros.store') }}">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        
        <div class="mb-3">
            <label for="autor_id" class="form-label">Autor</label>
            <select class="form-control" id="autor_id" name="autor_id" required>
                @foreach($autores as $autor)
                    <option value="{{ $autor->AUTOR_ID }}">{{ $autor->NOMBRE }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->CATEGORIA_ID }}">{{ $categoria->NOMBRE }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" required>
        </div>
        
        <div class="mb-3">
            <label for="ejemplares" class="form-label">Ejemplares</label>
            <input type="number" class="form-control" id="ejemplares" name="ejemplares" min="1" value="1" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection