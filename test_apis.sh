#!/bin/bash
echo "🧪 PRUEBA DE APIs - FASE 5"
echo "========================="
echo ""

echo "📋 1. Probando API de verificación de email:"
curl -s -X GET "http://127.0.0.1:8000/api/v1/forms/check-email?email=test@nuevo.com" \
     -H "Accept: application/json" \
     -H "X-Requested-With: XMLHttpRequest" || echo "Error en API email"

echo ""
echo ""

echo "📋 2. Probando API de validación de documento:"
curl -s -X POST "http://127.0.0.1:8000/api/v1/forms/check-document" \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -H "X-Requested-With: XMLHttpRequest" \
     -d '{"tipo_documento": "RUC", "numero_documento": "20123456789"}' || echo "Error en API documento"

echo ""
echo ""

echo "✅ Pruebas completadas"
