@extends('layouts.admin')

@section('title', 'Gestión de Excel')
@section('page-title', 'Gestión de Archivos Excel')
@section('page-description', 'Carga, procesa y administra datos de riesgo empresarial.')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Gestión de Excel</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Carga y procesa archivos para el análisis de riesgo.</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="downloadTemplate()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105 flex items-center gap-2">
                <i class="fas fa-download"></i>
                <span>Descargar Ejemplo CSV</span>
            </button>
            <button onclick="window.location.reload()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm transition-all">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <!-- Upload Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
        <form id="uploadForm" action="{{ route('admin.excel.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="csv_year" value="{{ date('Y') }}">
            <div id="dropZone" class="border-4 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-700">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <i class="fas fa-cloud-upload-alt text-6xl text-gray-400 dark:text-gray-500 transition-all duration-300"></i>
                    <p class="text-xl font-semibold text-gray-700 dark:text-gray-200">Arrastra y suelta tu archivo aquí</p>
                    <p class="text-gray-500 dark:text-gray-400">o</p>
                    <label for="fileInput" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md cursor-pointer transition-transform transform hover:scale-105">Seleccionar Archivo</label>
                    <input type="file" id="fileInput" name="excel_file" class="hidden" accept=".csv,.txt">
                    <p class="text-xs text-gray-400 dark:text-gray-500 pt-2">Soportado: CSV (Max 10MB)</p>
                </div>
            </div>
        </form>
        
        <!-- File Preview & Progress -->
        <div id="upload-status-area" class="mt-6 space-y-4 hidden">
            <div id="filePreview" class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 flex items-center justify-between hidden">
                <div class="flex items-center gap-4">
                    <i class="fas fa-file-csv text-3xl text-green-500"></i>
                    <div>
                        <p id="fileName" class="font-bold text-gray-800 dark:text-gray-100"></p>
                        <p id="fileSize" class="text-sm text-gray-500 dark:text-gray-400"></p>
                    </div>
                </div>
                <button id="removeFileBtn" class="text-red-500 hover:text-red-700"><i class="fas fa-times-circle text-2xl"></i></button>
            </div>

            <div id="uploadProgress" class="hidden">
                <div class="flex justify-between mb-1">
                    <span id="progressText" class="text-base font-medium text-blue-700 dark:text-blue-400">Subiendo...</span>
                    <span id="progressPercentage" class="text-sm font-medium text-blue-700 dark:text-blue-400">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div id="progressFill" class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>
            
            <button type="submit" form="uploadForm" id="uploadBtn" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition-transform transform hover:scale-105 flex items-center justify-center gap-2 hidden">
                <i class="fas fa-upload"></i>
                <span>Iniciar Carga y Procesamiento</span>
            </button>
        </div>
    </div>

    <!-- Uploaded Files Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="p-6 border-b border-gray-200 dark:border-gray-600">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Historial de Cargas</h3>
        </div>
        
        @if($uploads && $uploads->count() > 0)
            <div class="overflow-x-auto">
                @include('admin.excel.partials.files-table', ['uploads' => $uploads])
            </div>
            @if($uploads->hasPages())
                <div class="p-6 border-t border-gray-200 dark:border-gray-600">
                    {{ $uploads->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16 text-gray-500 dark:text-gray-400">
                <i class="fas fa-file-excel text-7xl mb-6 opacity-30 text-gray-400"></i>
                <h3 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">No hay archivos</h3>
                <p>Aún no se han cargado archivos. Utiliza el formulario de arriba para empezar.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const uploadForm = document.getElementById('uploadForm');
        const uploadStatusArea = document.getElementById('upload-status-area');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const removeFileBtn = document.getElementById('removeFileBtn');
        const uploadBtn = document.getElementById('uploadBtn');
        const progressContainer = document.getElementById('uploadProgress');
        const progressFill = document.getElementById('progressFill');
        const progressText = document.getElementById('progressText');
        const progressPercentage = document.getElementById('progressPercentage');

        const setActive = (active) => dropZone.classList.toggle('border-blue-500', active);

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => document.body.addEventListener(e, p => p.preventDefault()));
        ['dragenter', 'dragover'].forEach(e => dropZone.addEventListener(e, () => setActive(true)));
        ['dragleave', 'drop'].forEach(e => dropZone.addEventListener(e, () => setActive(false)));

        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length) {
                handleFile(files[0]);
            }
        });

        fileInput.addEventListener('change', e => {
            if (e.target.files.length) {
                handleFile(e.target.files[0]);
            }
        });

        removeFileBtn.addEventListener('click', resetUploader);

        function handleFile(file) {
            if (!file.type.match('text/csv') && !file.name.endsWith('.txt')) {
                alert('Error: Solo se permiten archivos CSV o TXT.');
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                alert('Error: El archivo no debe superar los 10MB.');
                return;
            }

            fileInput.files = new DataTransfer().files; // Clear previous selection
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;

            fileName.textContent = file.name;
            fileSize.textContent = `${(file.size / 1024).toFixed(1)} KB`;
            uploadStatusArea.classList.remove('hidden');
            filePreview.classList.remove('hidden');
            uploadBtn.classList.remove('hidden');
            dropZone.classList.add('hidden');
        }

        function resetUploader() {
            fileInput.value = '';
            uploadStatusArea.classList.add('hidden');
            filePreview.classList.add('hidden');
            uploadBtn.classList.add('hidden');
            progressContainer.classList.add('hidden');
            dropZone.classList.remove('hidden');
            progressFill.style.width = '0%';
            progressPercentage.textContent = '0%';
        }

        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!fileInput.files.length) return;

            uploadBtn.disabled = true;
            uploadBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Procesando...`;
            progressContainer.classList.remove('hidden');

            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progressFill.style.width = `${percentComplete.toFixed(0)}%`;
                    progressPercentage.textContent = `${percentComplete.toFixed(0)}%`;
                    progressText.textContent = `Subiendo...`;
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    progressText.textContent = '¡Completado!';
                    progressFill.classList.remove('bg-blue-600');
                    progressFill.classList.add('bg-green-600');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    handleError(xhr.responseText);
                }
            });

            xhr.addEventListener('error', () => handleError('Error de red al intentar subir el archivo.'));

            xhr.open('POST', this.action, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.send(formData);
        });

        function handleError(errorMsg) {
            progressText.textContent = '¡Error!';
            progressFill.classList.remove('bg-blue-600');
            progressFill.classList.add('bg-red-600');
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = `<i class="fas fa-upload"></i> Reintentar Carga`;
            try {
                const errorObj = JSON.parse(errorMsg);
                if(errorObj.message) alert(`Error: ${errorObj.message}`);
            } catch (e) {
                alert(`Error inesperado: ${errorMsg}`);
            }
        }

        // Check for processing files on page load
        const processingFiles = document.querySelectorAll('.status-processing');
        if (processingFiles.length > 0) {
            setTimeout(() => window.location.reload(), 15000);
        }
    });

    function downloadTemplate() {
        // Descargar el archivo de ejemplo real desde el servidor
        const link = document.createElement('a');
        link.href = '{{ asset("plantilla_excel/plantilla_riesgo_ejemplos.csv") }}';
        link.download = 'plantilla_riesgo_ejemplos.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endpush