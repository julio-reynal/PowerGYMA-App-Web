# Sistema de Actualización Automática de Riesgo - PowerGYMA

Este documento explica cómo configurar la actualización automática del sistema de riesgo.

## 🔄 Funcionalidades Implementadas

### 1. Actualización Automática al Subir Excel
- **Cuándo**: Cada vez que se sube y procesa un archivo Excel
- **Cómo**: Automáticamente integrado en el `ExcelController`
- **Datos**: Utiliza los datos reales del Excel procesado

### 2. Actualización Manual desde Admin Dashboard
- **Ubicación**: Panel de administración > Botón "Actualizar Sistema de Riesgo"
- **Funcionalidad**: Actualiza el sistema con datos calculados basados en la hora actual
- **Acceso**: Solo administradores

### 3. Actualización Programada por Tiempo
- **Endpoints API**: `/api/v1/risk/update-by-time`
- **Scripts**: `update_risk_system.ps1` (Windows) y `update_risk_system.sh` (Linux)

## 📅 Configuración de Automatización por Horario

### Windows - Programador de Tareas

1. **Abrir Programador de Tareas**
   ```
   Ejecutar > taskschd.msc
   ```

2. **Crear Tarea Básica**
   - Nombre: "PowerGYMA - Actualizar Sistema de Riesgo"
   - Descripción: "Actualización automática del sistema de riesgo cada hora"

3. **Desencadenador**
   - Frecuencia: Diariamente
   - Repetir cada: 1 hora
   - Durante: 1 día

4. **Acción**
   - Programa: `PowerShell.exe`
   - Argumentos: `-ExecutionPolicy Bypass -File "C:\xampp\htdocs\Nueva carpeta\$RSO45PZ\PowerGYMA-App-Web\update_risk_system.ps1"`
   - Iniciar en: `C:\xampp\htdocs\Nueva carpeta\$RSO45PZ\PowerGYMA-App-Web`

### Linux/Unix - Cron Job

1. **Editar Crontab**
   ```bash
   crontab -e
   ```

2. **Agregar Línea para Ejecutar Cada Hora**
   ```bash
   0 * * * * /path/to/PowerGYMA-App-Web/update_risk_system.sh
   ```

3. **O Cada 30 Minutos**
   ```bash
   */30 * * * * /path/to/PowerGYMA-App-Web/update_risk_system.sh
   ```

## 🖥️ Métodos de Actualización

### Método 1: API REST (Recomendado)
```bash
curl -X POST http://127.0.0.1:8000/api/v1/risk/update-by-time
```

### Método 2: Comando Artisan
```bash
php artisan risk:update
```

### Método 3: Botón Manual en Dashboard
- Acceder al panel de administración
- Hacer clic en "Actualizar Sistema de Riesgo"
- El sistema se actualiza inmediatamente

## 📊 Datos que se Actualizan

### Evaluación Diaria
- **Nivel de riesgo**: Calculado basado en la hora del día
- **Horario pico**: Generado dinámicamente (típicamente 18:00-21:00)
- **Datos horarios**: 24 valores de consumo simulado
- **Métricas**:
  - Consumo total (kWh)
  - Demanda máxima (kW)
  - Factor de potencia
  - Costo total (S/)
  - Eficiencia (%)

### Datos Mensuales
- **Progreso del mes**: Días evaluados / Total días del mes
- **Calendario de riesgo**: Color por día según nivel
- **Estado**: Automáticamente marcado como "evaluado"

## 🎯 Lógica de Cálculo de Riesgo

### Por Horario del Día
- **18:00-22:00**: Alto/Crítico riesgo (horario pico nocturno)
- **08:00-12:00**: Moderado/Alto riesgo (horario pico matutino)  
- **13:00-17:00**: Moderado riesgo (horario tarde)
- **23:00-07:00**: Bajo/Muy Bajo riesgo (horario valle)

### Por Datos de Excel
- Utiliza los valores reales del archivo procesado
- Mantiene la precisión de los datos empresariales
- Actualiza tanto evaluación diaria como datos mensuales

## 🔍 Monitoreo y Logs

### Logs de Aplicación
```
storage/logs/laravel.log
storage/logs/risk_update.log
```

### Verificar Estado
```bash
curl http://127.0.0.1:8000/api/v1/risk/status
```

### Dashboard Admin
- Ve el botón de actualización manual
- Recibe notificaciones de éxito/error
- La página se recarga automáticamente tras la actualización

## ⚙️ Configuración Avanzada

### Personalizar Frecuencia
Editar los scripts para cambiar la frecuencia de actualización:
- Cada 15 minutos: `*/15 * * * *`
- Cada 2 horas: `0 */2 * * *`
- Solo horarios laborales: `0 8-18 * * 1-5`

### Modo de Desarrollo
Para pruebas manuales:
```bash
# Ejecutar script directamente
PowerShell.exe -File update_risk_system.ps1

# O con comando artisan
php artisan risk:update --force
```

## 🚨 Solución de Problemas

### Error: "API no responde"
1. Verificar que Laravel esté ejecutándose
2. Comprobar que la URL sea correcta
3. Revisar logs de aplicación

### Error: "Comando no encontrado"
1. Verificar que PHP esté en el PATH
2. Ejecutar desde el directorio correcto del proyecto
3. Verificar permisos de archivos

### Error: "Base de datos no conecta"
1. Verificar configuración `.env`
2. Comprobar que la base de datos esté activa
3. Revisar credenciales de conexión

## 📈 Resultados Esperados

Después de la implementación:
- ✅ Sistema se actualiza automáticamente cada hora
- ✅ Datos se sincronizan al subir Excel
- ✅ Dashboard muestra información actual
- ✅ Progreso del mes se actualiza diariamente
- ✅ Nivel de riesgo refleja horarios reales de consumo