@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h2>{{ $title }}</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ $action }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="mb-3">
                    <label for="value" class="form-label">Precio:</label>
                    <input type="number" step="0.01" name="value" class="form-control" placeholder="Ingrese el precio" required>
                </div>
                <div class="mb-3">
                    <label for="iva" class="form-label">IVA (%):</label>
                    <input type="number" step="0.01" name="iva" class="form-control" value="19" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success w-100">Calcular</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection