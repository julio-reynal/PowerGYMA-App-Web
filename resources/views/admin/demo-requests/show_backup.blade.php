@extends('layouts.admin')

@section('title', 'Detalle Solicitud Demo #' . $demoRequest->id)

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Solicitud Demo #{{ $demoRequest->id }}</h1>
            <p class="text-muted">{{ $demoRequest->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.demo-requests.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#estadoModal">
                <i class="fas fa-edit"></i> Cambiar Estado
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <!-- Información Personal -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> Información Personal
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Nombre:</td>
                                    <td>{{ $demoRequest->nombre }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email:</td>
                                    <td>
                                        <a href="mailto:{{ $demoRequest->email }}">{{ $demoRequest->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Teléfono Celular:</td>
                                    <td>
                                        @if($demoRequest->telefono_celular)
                                            <a href="tel:{{ $demoRequest->telefono_celular }}">{{ $demoRequest->telefono_celular }}</a>
                                        @else
                                            <span class="text-muted">No especificado</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Teléfono Fijo:</td>
                                    <td>
                                        @if($demoRequest->telefono)
                                            <a href="tel:{{ $demoRequest->telefono }}">{{ $demoRequest->telefono }}</a>
                                        @else
                                            <span class="text-muted">No especificado</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Tipo Documento:</td>
                                    <td>{{ $demoRequest->tipo_documento }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Número Documento:</td>
                                    <td>{{ $demoRequest->numero_documento ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Cargo/Puesto:</td>
                                    <td>{{ $demoRequest->cargo_puesto ?: 'No especificado' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Empresa -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-building"></i> Información de la Empresa
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Empresa:</td>
                                    <td>{{ $demoRequest->empresa }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">RUC:</td>
                                    <td>{{ $demoRequest->ruc_empresa ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Giro:</td>
                                    <td>{{ $demoRequest->giro_empresa ?: 'No especificado' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Departamento:</td>
                                    <td>{{ $demoRequest->departamento?->nombre ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Provincia:</td>
                                    <td>{{ $demoRequest->provincia?->nombre ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Ciudad:</td>
                                    <td>{{ $demoRequest->ciudad ?: 'No especificado' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($demoRequest->direccion)
                        <div class="mt-3">
                            <strong>Dirección:</strong><br>
                            <span class="text-muted">{{ $demoRequest->direccion }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del Demo -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-play-circle"></i> Información del Demo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Tipo de Demo:</strong>
                        <span class="badge badge-info ml-2">{{ $demoRequest->tipo_demo_label }}</span>
                    </div>

                    @if($demoRequest->necesidades_especificas)
                        <div class="mb-3">
                            <strong>Necesidades Específicas:</strong><br>
                            <div class="bg-light p-3 rounded mt-2">
                                {{ $demoRequest->necesidades_especificas }}
                            </div>
                        </div>
                    @endif

                    @if($demoRequest->comentarios)
                        <div class="mb-3">
                            <strong>Comentarios Adicionales:</strong><br>
                            <div class="bg-light p-3 rounded mt-2">
                                {{ $demoRequest->comentarios }}
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Acepta Términos:</strong>
                            <span class="badge {{ $demoRequest->acepta_terminos ? 'badge-success' : 'badge-danger' }}">
                                {{ $demoRequest->acepta_terminos ? 'Sí' : 'No' }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Acepta Marketing:</strong>
                            <span class="badge {{ $demoRequest->acepta_marketing ? 'badge-success' : 'badge-secondary' }}">
                                {{ $demoRequest->acepta_marketing ? 'Sí' : 'No' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <strong>Origen de la Solicitud:</strong>
                        <span class="badge badge-secondary">{{ ucfirst($demoRequest->origen_solicitud) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Estado Actual -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Estado Actual
                    </h6>
                </div>
                <div class="card-body text-center">
                    @php
                        $badgeClass = match($demoRequest->estado) {
                            'pendiente' => 'warning',
                            'contactado' => 'info',
                            'programado' => 'secondary',
                            'completado' => 'success',
                            'rechazado' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    <div class="mb-3">
                        <span class="badge badge-{{ $badgeClass }} badge-lg" style="font-size: 1.1em;">
                            {{ $demoRequest->estado_label }}
                        </span>
                    </div>

                    @if($demoRequest->fecha_contacto)
                        <div class="text-muted mb-2">
                            <i class="fas fa-phone"></i>
                            Contactado: {{ $demoRequest->fecha_contacto->format('d/m/Y H:i') }}
                        </div>
                    @endif

                    @if($demoRequest->fecha_demo_programada)
                        <div class="text-muted mb-2">
                            <i class="fas fa-calendar"></i>
                            Demo programado: {{ $demoRequest->fecha_demo_programada->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notas Internas -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sticky-note"></i> Notas Internas
                    </h6>
                </div>
                <div class="card-body">
                    @if($demoRequest->notas_internas)
                        <div class="bg-light p-3 rounded">
                            {{ $demoRequest->notas_internas }}
                        </div>
                    @else
                        <p class="text-muted text-center">No hay notas internas</p>
                    @endif
                </div>
            </div>

            <!-- Historial -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history"></i> Historial
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Solicitud Creada</h6>
                                <p class="timeline-text">{{ $demoRequest->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if($demoRequest->fecha_contacto)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Contactado</h6>
                                    <p class="timeline-text">{{ $demoRequest->fecha_contacto->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($demoRequest->fecha_demo_programada)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-secondary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Demo Programado</h6>
                                    <p class="timeline-text">{{ $demoRequest->fecha_demo_programada->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($demoRequest->estado === 'completado')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Demo Completado</h6>
                                    <p class="timeline-text">{{ $demoRequest->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $demoRequest->email }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope"></i> Enviar Email
                        </a>
                        
                        @if($demoRequest->telefono_celular)
                            <a href="tel:{{ $demoRequest->telefono_celular }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-phone"></i> Llamar Celular
                            </a>
                        @endif

                        @if($demoRequest->telefono)
                            <a href="tel:{{ $demoRequest->telefono }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-phone"></i> Llamar Fijo
                            </a>
                        @endif

                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#estadoModal">
                            <i class="fas fa-edit"></i> Cambiar Estado
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para cambiar estado -->
    <div class="modal fade" id="estadoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.demo-requests.update-estado', $demoRequest) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-control" required>
                                @foreach(\App\Models\DemoRequest::ESTADOS as $key => $label)
                                    <option value="{{ $key }}" {{ $demoRequest->estado == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_demo_programada" class="form-label">
                                Fecha del Demo (solo para estado "Programado")
                            </label>
                            <input type="datetime-local" 
                                   name="fecha_demo_programada" 
                                   id="fecha_demo_programada" 
                                   class="form-control"
                                   value="{{ $demoRequest->fecha_demo_programada?->format('Y-m-d\TH:i') }}">
                        </div>

                        <div class="mb-3">
                            <label for="notas_internas" class="form-label">Notas Internas</label>
                            <textarea name="notas_internas" 
                                      id="notas_internas" 
                                      class="form-control" 
                                      rows="4">{{ $demoRequest->notas_internas }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -37px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #e9ecef;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -31px;
    top: 14px;
    width: 2px;
    height: calc(100% + 6px);
    background-color: #e9ecef;
}

.timeline-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.timeline-text {
    font-size: 12px;
    color: #6c757d;
    margin: 0;
}

.badge-lg {
    padding: 0.5rem 1rem;
}
</style>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session('success') }}');
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session('error') }}');
        });
    </script>
@endif
@endsection