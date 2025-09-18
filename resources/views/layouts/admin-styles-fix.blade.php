<!-- Estilos corregidos para integración completa con el sistema de temas del dashboard -->
<style>
/* === CORRECCIÓN DE ESTILOS PARA MODO OSCURO/CLARO === */

/* Reemplazar todas las variables CSS personalizadas con clases de Tailwind */
.detail-card, .stat-card, .users-table, .files-table, .upload-container {
    @apply bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700;
}

.card-header, .table-header, .files-header {
    @apply bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 p-6;
}

.card-title, .table-title, .files-title {
    @apply text-xl font-semibold text-gray-800 dark:text-gray-100;
}

.info-grid, .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.info-item {
    @apply p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border-l-4 border-blue-500;
    transition: all 0.3s ease;
}

.info-item:hover {
    @apply bg-blue-50 dark:bg-blue-900 transform translate-x-1;
}

.info-label {
    @apply font-semibold text-gray-700 dark:text-gray-300 text-sm uppercase tracking-wide;
}

.info-value {
    @apply text-gray-900 dark:text-gray-100 font-medium text-base;
}

.info-value.empty {
    @apply text-gray-500 dark:text-gray-400 italic;
}

/* Status badges corregidos */
.status-badge {
    @apply px-3 py-1 rounded-full text-sm font-bold uppercase inline-flex items-center gap-2 shadow-md;
}

.status-pendiente, .status-pending {
    @apply bg-yellow-500 text-white;
}

.status-contactado {
    @apply bg-blue-500 text-white;
}

.status-programado {
    @apply bg-indigo-500 text-white;
}

.status-completado, .status-completed {
    @apply bg-green-500 text-white;
}

.status-rechazado, .status-failed {
    @apply bg-red-500 text-white;
}

.status-processing {
    @apply bg-yellow-500 text-white;
    animation: pulse 2s infinite;
}

/* Badges de roles y estados */
.badge {
    @apply px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide;
}

.badge-admin {
    @apply bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200;
}

.badge-cliente {
    @apply bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200;
}

.badge-demo {
    @apply bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200;
}

.badge-active {
    @apply bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200;
}

.badge-inactive {
    @apply bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200;
}

/* Boolean badges */
.boolean-badge {
    @apply px-2 py-1 rounded-full text-xs font-semibold uppercase;
}

.boolean-true {
    @apply bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200;
}

.boolean-false {
    @apply bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200;
}

/* Formularios */
.form-group {
    @apply mb-5;
}

.form-label {
    @apply block font-semibold text-gray-700 dark:text-gray-300 mb-2 text-sm;
}

.form-input {
    @apply w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base;
    transition: all 0.3s ease;
}

.form-input:focus {
    @apply outline-none ring-2 ring-blue-500 border-blue-500;
}

.search-input {
    @apply px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100;
}

.search-input:focus {
    @apply outline-none ring-2 ring-blue-500 border-blue-500;
}

/* Botones */
.btn {
    @apply px-4 py-2 rounded-lg font-semibold text-sm inline-flex items-center gap-2 transition-all duration-200;
}

.btn:hover {
    @apply transform -translate-y-0.5 shadow-lg;
}

.btn-primary {
    @apply bg-blue-600 hover:bg-blue-700 text-white;
}

.btn-success {
    @apply bg-green-600 hover:bg-green-700 text-white;
}

.btn-warning {
    @apply bg-yellow-600 hover:bg-yellow-700 text-white;
}

.btn-danger {
    @apply bg-red-600 hover:bg-red-700 text-white;
}

.btn-info {
    @apply bg-cyan-600 hover:bg-cyan-700 text-white;
}

.btn-sm {
    @apply px-3 py-1 text-sm;
}

/* Action buttons */
.btn-action {
    @apply p-2 rounded-full border-none cursor-pointer transition-all duration-300 flex items-center justify-center;
    width: 2.5rem;
    height: 2.5rem;
}

.btn-action:hover {
    @apply transform -translate-y-1 shadow-lg;
}

.btn-view {
    @apply bg-blue-500 hover:bg-blue-600 text-white;
}

.btn-retry {
    @apply bg-yellow-500 hover:bg-yellow-600 text-white;
}

.btn-delete {
    @apply bg-red-500 hover:bg-red-600 text-white;
}

/* Tablas */
.table-wrapper {
    @apply overflow-x-auto;
}

table {
    @apply w-full border-collapse;
}

th {
    @apply bg-gray-50 dark:bg-gray-700 px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 text-sm uppercase tracking-wider border-b-2 border-gray-200 dark:border-gray-600;
}

td {
    @apply px-4 py-4 border-t border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-100;
}

tr:hover {
    @apply bg-gray-50 dark:bg-gray-700;
}

/* Upload zone */
.upload-zone, .drop-zone {
    @apply border-3 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-12 text-center cursor-pointer bg-gray-50 dark:bg-gray-800;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.upload-zone:hover, .drop-zone:hover {
    @apply border-blue-500 bg-blue-50 dark:bg-blue-900 transform -translate-y-1 shadow-lg;
}

.upload-zone.dragover, .drop-zone.drag-active {
    @apply border-green-500 bg-green-50 dark:bg-green-900 transform scale-102;
}

.upload-zone.uploading {
    @apply border-yellow-500 bg-yellow-50 dark:bg-yellow-900 pointer-events-none;
}

/* Progress bars */
.progress-bar {
    @apply w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden;
}

.progress-fill {
    @apply h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full transition-all duration-300;
}

/* Timeline */
.timeline-item {
    @apply flex gap-4 mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border-l-4 border-blue-500;
}

.timeline-icon {
    @apply w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center flex-shrink-0;
}

.timeline-content {
    @apply flex-1;
}

.timeline-title {
    @apply font-semibold text-gray-800 dark:text-gray-100 mb-1;
}

.timeline-date {
    @apply text-gray-500 dark:text-gray-400 text-sm;
}

/* User avatars */
.user-avatar {
    @apply w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center font-semibold mr-3;
}

/* File icons */
.file-icon-wrapper {
    @apply bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 p-3 rounded-full text-xl transition-all duration-300;
}

/* Stats cards específicos */
.stat-total .stat-icon {
    @apply bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400;
}

.stat-active .stat-icon {
    @apply bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400;
}

.stat-demo .stat-icon {
    @apply bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400;
}

.stat-admin .stat-icon {
    @apply bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400;
}

.stat-completed .stat-icon {
    @apply bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400;
}

.stat-failed .stat-icon {
    @apply bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400;
}

.stat-processing .stat-icon {
    @apply bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400;
}

/* Empty states */
.empty-state {
    @apply text-center py-16 px-8 text-gray-500 dark:text-gray-400;
}

.empty-icon {
    @apply text-6xl mb-8 opacity-30 text-blue-500;
}

.empty-title {
    @apply text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4;
}

.empty-description {
    @apply text-lg mb-8 max-w-md mx-auto;
}

/* Alerts y notificaciones */
.alert-success {
    @apply bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 p-4 rounded-lg border border-green-200 dark:border-green-700;
}

.alert-error {
    @apply bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 p-4 rounded-lg border border-red-200 dark:border-red-700;
}

.alert-warning {
    @apply bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 p-4 rounded-lg border border-yellow-200 dark:border-yellow-700;
}

.alert-info {
    @apply bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 p-4 rounded-lg border border-blue-200 dark:border-blue-700;
}

/* Responsive design */
@media (max-width: 768px) {
    .info-grid, .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-card, .stat-card {
        @apply mb-4;
    }
    
    .card-header, .table-header {
        @apply p-4;
    }
}

/* Animaciones y transiciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeInUp 0.5s ease-out;
}

.file-row {
    animation: slideInUp 0.4s ease-out;
}
</style>