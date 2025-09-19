# Script PowerShell para actualizar automáticamente el sistema de riesgo
# Se puede ejecutar con Programador de tareas de Windows para automatización

# Cambiar al directorio del script
Set-Location -Path $PSScriptRoot

# Log file
$LogFile = "storage\logs\risk_update.log"

# Función para logging
function Write-Log {
    param($Message)
    $Timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    $LogEntry = "[$Timestamp] $Message"
    Write-Output $LogEntry
    Add-Content -Path $LogFile -Value $LogEntry
}

Write-Log "Iniciando actualización automática del sistema de riesgo"

try {
    # Intentar actualizar via API
    $Response = Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/v1/risk/update-by-time" -Method POST -ErrorAction Stop
    
    if ($Response.StatusCode -eq 200) {
        Write-Log "✅ Sistema de riesgo actualizado exitosamente via API"
    } else {
        Write-Log "⚠️ Respuesta inesperada de la API: $($Response.StatusCode)"
    }
} catch {
    Write-Log "❌ Error al actualizar via API: $($_.Exception.Message)"
    Write-Log "Intentando con comando artisan..."
    
    try {
        # Fallback: ejecutar comando artisan
        $ArtisanResult = & php artisan risk:update 2>&1
        if ($LASTEXITCODE -eq 0) {
            Write-Log "✅ Sistema de riesgo actualizado exitosamente via comando"
        } else {
            Write-Log "❌ Error al ejecutar comando artisan: $ArtisanResult"
            exit 1
        }
    } catch {
        Write-Log "❌ Error crítico al actualizar el sistema: $($_.Exception.Message)"
        exit 1
    }
}

Write-Log "Actualización automática completada"