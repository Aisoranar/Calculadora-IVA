@extends('layouts.app')

@section('title', 'Dashboard - Calculadora IVA')

@section('content')
<div class="container text-center py-4">
    <h1 class="mb-4">Calculadoras IVA</h1>
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <a href="{{ route('calculators.priceWithoutIVA') }}" class="btn btn-primary btn-lg w-100 shadow">Hallar Precio Sin IVA (+IVA)</a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('calculators.priceWithoutIVAWithTax') }}" class="btn btn-primary btn-lg w-100 shadow">Hallar Precio Sin IVA (IVA)</a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('calculators.priceWithIVA') }}" class="btn btn-primary btn-lg w-100 shadow">Hallar Precio Más IVA</a>
        </div>
    </div>

    <h2 class="mt-5">Historial de Cálculos</h2>
    <p class="text-danger">Nota: Los cálculos se eliminan automáticamente después de 30 minutos. ¡Regístrate para guardarlos permanentemente!</p>

    <div class="table-responsive mt-3">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Valor</th>
                    <th>IVA (%)</th>
                    <th>Resultado</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Tiempo Restante</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($calculations as $calc)
                @php
                    $expirationTime = $calc->created_at->addMinutes(30);
                @endphp
                <tr id="calc-{{ $calc->id }}" data-id="{{ $calc->id }}">
                    <td>{{ $calc->id }}</td>
                    <td>${{ number_format($calc->value, 2) }}</td>
                    <td>{{ $calc->iva }}%</td>
                    <td>
                        <span id="result-{{ $calc->id }}">{{ number_format($calc->result, 2) }}</span>
                        <button class="btn btn-secondary btn-sm copy-to-clipboard" data-clipboard-text="{{ number_format($calc->result, 2) }}">
                            <i class="fas fa-copy"></i> Copiar
                        </button>
                    </td>
                    <td>{{ ucfirst(str_replace('_', ' ', $calc->type)) }}</td>
                    <td>{{ $calc->created_at->format('d/m/Y H:i') }}</td>
                    <td class="time-left" data-expiration="{{ $expirationTime->toIso8601String() }}">
                        {{ $expirationTime->diffForHumans() }}
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-calculation" data-id="{{ $calc->id }}" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Confirmación de Copia -->
<div class="modal fade" id="copySuccessModal" tabindex="-1" aria-labelledby="copySuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copySuccessModalLabel">Texto Copiado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                El resultado se ha copiado correctamente al portapapeles.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este cálculo?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            const calcId = this.getAttribute('data-id');
            const rowSelector = `#calc-${calcId}`;

            // Deshabilitar el botón y mostrar un spinner
            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Eliminando...';

            fetch(`/calculations/${calcId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Eliminar la fila correspondiente
                        const row = document.querySelector(rowSelector);
                        if (row) row.remove();

                        // Ocultar el modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
                        if (modal) modal.hide();

                        // Mostrar mensaje si la tabla está vacía
                        if (!document.querySelector('tbody tr')) {
                            const tbody = document.querySelector('tbody');
                            tbody.innerHTML = '<tr><td colspan="8" class="text-center">No hay cálculos disponibles.</td></tr>';
                        }
                    } else {
                        alert(data.message || 'Hubo un error al eliminar el cálculo.');
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar el cálculo:', error);
                    alert('No se pudo eliminar el cálculo. Por favor, inténtalo más tarde.');
                })
                .finally(() => {
                    // Restaurar el botón a su estado original
                    confirmDeleteBtn.disabled = false;
                    confirmDeleteBtn.innerHTML = 'Eliminar';
                });
        });
    }
});

</script>
@endsection
