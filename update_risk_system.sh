#!/bin/bash

# Script para actualizar automáticamente el sistema de riesgo
# Se puede ejecutar con cron job para automatización

# Cambiar al directorio del proyecto
cd "$(dirname "$0")"

# Verificar que PHP y Laravel estén disponibles
if ! command -v php &> /dev/null; then
    echo "ERROR: PHP no está instalado o no está en el PATH"
    exit 1
fi

# Log file
LOG_FILE="storage/logs/risk_update.log"

# Función para logging
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

log "Iniciando actualización automática del sistema de riesgo"

# Ejecutar la actualización del sistema de riesgo
if curl -s -f -X POST "http://127.0.0.1:8000/api/v1/risk/update-by-time" > /dev/null; then
    log "✅ Sistema de riesgo actualizado exitosamente via API"
else
    log "❌ Error al actualizar via API, intentando con comando artisan"
    
    # Fallback: intentar con comando artisan si la API falla
    if php artisan risk:update; then
        log "✅ Sistema de riesgo actualizado exitosamente via comando"
    else
        log "❌ Error al actualizar el sistema de riesgo"
        exit 1
    fi
fi

log "Actualización automática completada"