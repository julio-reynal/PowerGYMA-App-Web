# 📊 FORMATO DE ARCHIVO EXCEL PARA POWER GYMA

## 📋 **ESTRUCTURA REQUERIDA DEL ARCHIVO**

El archivo Excel debe contener **DOS SECCIONES PRINCIPALES** en la misma hoja:

---

## 🎯 **SECCIÓN 1: REVISIÓN DE RIESGO DIARIO**

### **Formato requerido:**
```
FECHA: 25-ago
RIESGO: Alto
HORA INICIO: 19:00
HORA FIN: 20:00
```

### **📝 Detalles importantes:**
- **FECHA:** Formato obligatorio `DD-MMM` (ejemplo: `25-ago`, `15-dic`)
- **RIESGO:** Valores permitidos: `Muy Bajo`, `Bajo`, `Moderado`, `Alto`, `Crítico`, `No procede`
- **HORA INICIO/FIN:** Formato `HH:MM` (ejemplo: `19:00`, `08:30`)

### **📅 Abreviaciones de meses aceptadas:**
- Enero: `ene` | Febrero: `feb` | Marzo: `mar` | Abril: `abr`
- Mayo: `may` | Junio: `jun` | Julio: `jul` | Agosto: `ago`
- Septiembre: `sep` | Octubre: `oct` | Noviembre: `nov` | Diciembre: `dic`

---

## 📅 **SECCIÓN 2: REVISIÓN DE RIESGO MENSUAL**

### **Formato de tabla requerido:**
```
1-ago    Bajo
2-ago    Alto
3-ago    Moderado
4-ago    Bajo
5-ago    No procede
...
31-ago   Alto
```

### **📝 Detalles importantes:**
- **Primera columna:** Fecha en formato `DD-MMM`
- **Segunda columna:** Nivel de riesgo
- **Una fila por cada día del mes**
- **Días no laborables:** Usar `No procede`

---

## ✅ **NIVELES DE RIESGO VÁLIDOS**

| Nivel | Descripción | Color en Dashboard |
|-------|-------------|-------------------|
| `Muy Bajo` | Condiciones óptimas | 🟢 Verde |
| `Bajo` | Condiciones favorables | 🟢 Verde |
| `Moderado` | Precaución recomendada | 🟡 Amarillo |
| `Alto` | Medidas preventivas necesarias | 🟠 Naranja |
| `Crítico` | Acción inmediata requerida | 🔴 Rojo |
| `No procede` | Evaluación no aplicable | ⚪ Gris |

---

## 📄 **EJEMPLO COMPLETO DE ARCHIVO EXCEL**

### **Hoja 1: "Datos de Riesgo"**

```
FECHA: 25-ago
RIESGO: Alto  
HORA INICIO: 19:00
HORA FIN: 20:00

1-ago    Bajo
2-ago    Alto
3-ago    Moderado
4-ago    Bajo
5-ago    No procede
6-ago    Alto
7-ago    No procede
8-ago    Bajo
9-ago    Alto
10-ago   Moderado
11-ago   Bajo
12-ago   Alto
13-ago   Moderado
14-ago   Alto
15-ago   Bajo
16-ago   Alto
17-ago   Alto
18-ago   Bajo
19-ago   Moderado
20-ago   Alto
21-ago   Alto
22-ago   Bajo
23-ago   Alto
24-ago   Moderado
25-ago   Alto
26-ago   Moderado
27-ago   Alto
28-ago   Bajo
29-ago   Bajo
30-ago   Alto
31-ago   Moderado
```

---

## ⚠️ **ERRORES COMUNES A EVITAR**

### **❌ Formatos incorrectos:**
- ~~`25/08/2025`~~ → ✅ `25-ago`
- ~~`Medio`~~ → ✅ `Moderado`
- ~~`19:00:00`~~ → ✅ `19:00`
- ~~`N/A`~~ → ✅ `No procede`

### **❌ Estructura incorrecta:**
- No mezclar las secciones
- No dejar filas vacías entre los datos
- No usar más de una hoja
- No cambiar el orden de las secciones

---

## 📁 **ARCHIVOS SOPORTADOS**

- ✅ **Excel:** `.xlsx`, `.xls`
- ✅ **CSV:** `.csv`
- ✅ **Tamaño máximo:** 10MB

---

## 🔄 **PROCESO DE CARGA**

1. **Subir archivo** en "Gestión Excel"
2. **Validación automática** del formato
3. **Procesamiento** de datos
4. **Actualización** automática de dashboards
5. **Notificación** de éxito o errores

---

## 📞 **SOPORTE**

Si tienes problemas con el formato:
- Descarga la **plantilla de ejemplo**
- Revisa esta documentación
- Contacta al administrador del sistema
