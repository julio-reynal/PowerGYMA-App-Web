<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 rounded-l-lg">Archivo</th>
                <th scope="col" class="px-6 py-3">Estado</th>
                <th scope="col" class="px-6 py-3 text-center">Registros</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Usuario</th>
                <th scope="col" class="px-6 py-3 text-center rounded-r-lg">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($uploads as $upload)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 p-3 rounded-full">
                                <i class="fas fa-file-csv fa-lg"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 dark:text-gray-100">{{ $upload->original_filename ?? $upload->filename }}</div>
                                <div class="text-xs text-gray-500">{{ number_format($upload->file_size / 1024, 1) }} KB</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusConfig = [
                                'completed' => ['bg' => 'bg-green-100 dark:bg-green-900', 'text' => 'text-green-800 dark:text-green-200', 'icon' => 'fas fa-check-circle'],
                                'failed' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-800 dark:text-red-200', 'icon' => 'fas fa-times-circle'],
                                'processing' => ['bg' => 'bg-blue-100 dark:bg-blue-900', 'text' => 'text-blue-800 dark:text-blue-200', 'icon' => 'fas fa-spinner fa-spin'],
                                'pending' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-200', 'icon' => 'fas fa-clock'],
                            ];
                            $config = $statusConfig[$upload->status] ?? $statusConfig['pending'];
                        @endphp
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $config['bg'] }} {{ $config['text'] }} inline-flex items-center gap-2">
                            <i class="{{ $config['icon'] }}"></i>
                            <span>{{ $upload->status_text }}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ number_format($upload->records_processed ?? 0) }}</div>
                        @if($upload->processing_summary && isset($upload->processing_summary['total_rows']))
                            <div class="text-xs text-gray-500">de {{ number_format($upload->processing_summary['total_rows']) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold">{{ $upload->created_at->isoFormat('LL') }}</div>
                        <div class="text-xs text-gray-500">{{ $upload->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-sm text-gray-600 dark:text-gray-300">
                                {{ strtoupper(substr($upload->adminUser->name ?? 'S', 0, 2)) }}
                            </div>
                            <span class="font-medium text-gray-800 dark:text-gray-200">{{ $upload->adminUser->name ?? 'Sistema' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('admin.excel.show', $upload) }}" class="text-gray-500 hover:text-blue-600 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" title="Ver Detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($upload->status === 'failed')
                                <form method="POST" action="{{ route('admin.excel.reprocess', $upload) }}">
                                    @csrf
                                    <button type="submit" class="text-gray-500 hover:text-yellow-600 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" title="Reprocesar">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.excel.destroy', $upload) }}" onsubmit="return confirm('¿Estás seguro de eliminar este archivo y sus registros asociados?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-red-600 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
