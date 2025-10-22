# Sección Nosotros - PowerGYMA

## Descripción
Página "Nosotros" de PowerGYMA que presenta la empresa, su misión, visión, valores y equipo.

## Estructura de la Página

### 1. Hero Section
- **Ubicación**: Top de la página
- **Contenido**: 
  - Título principal: "Somos tu aliado estratégico en energía"
  - Subtítulo: "Energía inteligente, decisiones estratégicas"
  - CTA Button: "Conoce más"
- **Imagen**: `d59ee7973d60e759cd7c99ad2637afa915d0bfe8.png`
- **Características**: 
  - Fondo con overlay de opacidad
  - Líneas decorativas animadas
  - Diseño responsive

### 2. Quiénes Somos
- **Ubicación**: Segunda sección
- **Contenido**:
  - Descripción de la empresa
  - Iconos de características:
    - Análisis de Datos
    - Eficiencia Energética
  - Imagen del equipo trabajando
- **Imágenes**:
  - `5e000563e99ca661005cbb407cf4f754485b5878.png` (equipo)
  - `ecc850cd1dd65210bc095a061bebc08fd56bd05e.svg` (análisis)
  - `a806b20c6145735ac6240cd2839f89e18c6cb6fa.svg` (eficiencia)
- **Iconos decorativos**:
  - `ecb12b9859ad18bd57dcb26f82ece97dd7bcc26a.svg`
  - `759a2638106b5cf00daa4f3f1063068d6e4f56af.svg`

### 3. Misión y Visión
- **Ubicación**: Tercera sección
- **Contenido**:
  - Tarjeta de Misión con icono
  - Tarjeta de Visión con icono
- **Imágenes**:
  - `48b44baef915d04b6ce61e8ab8457396c5ad456c.svg` (misión)
  - `32f9d91764c033d8d63ff8068c68e4d1a13e7a88.svg` (visión)
- **Características**:
  - Grid de 2 columnas
  - Tarjetas con fondo oscuro
  - Iconos con background naranja

### 4. Call to Action (CTA)
- **Ubicación**: Cuarta sección
- **Contenido**:
  - Título: "¿Listo para optimizar tu consumo energético?"
  - Subtítulo: "Transformamos tus datos en soluciones energéticas inteligentes"
  - Botón: "Solicita una consulta gratuita"
- **Características**:
  - Fondo con gradiente
  - Enlace a página de contacto
  - Diseño centrado

### 5. Nuestros Valores
- **Ubicación**: Quinta sección
- **Contenido**: 5 valores principales
  1. **Innovación**
     - Icono: `63cf36c0cfc804a522effff2b841b91c460147f6.svg`
     - Descripción: "Aplicamos tecnologías y enfoques modernos para resolver desafíos complejos."
  
  2. **Confianza**
     - Icono: `9efee88f7df4e2b2971a76729057db606105f495.svg`
     - Descripción: "Establecemos relaciones sólidas y transparentes con nuestros clientes."
  
  3. **Compromiso**
     - Icono: `a9c86350f83abaca59d25c12ba133064283e8269.svg`
     - Descripción: "Nos enfocamos en resultados tangibles y sostenibles."
  
  4. **Eficiencia**
     - Icono: `ec014410ebfdf722f1eb2f6075694431928c1a1b.svg`
     - Descripción: "Optimizamos recursos energéticos y empresariales para generar valor."
  
  5. **Responsabilidad**
     - Icono: `4d62fca146931f6c253e459ba61246566a3c5a06.svg`
     - Descripción: "Promovemos el desarrollo sostenible y el uso consciente de la energía."

- **Características**:
  - Grid de 5 columnas (responsive)
  - Tarjetas con borde inferior naranja
  - Iconos con background circular

### 6. Conoce a Nuestro Equipo
- **Ubicación**: Última sección
- **Contenido**: 2 miembros del equipo
  
  1. **Marco Hernandez**
     - Foto: `b6beba38f53b28f29e855075ab49ad574e2b550f.png`
     - Cargo: "Gerencia General"
     - LinkedIn: https://www.linkedin.com/in/marco-hernandez-mendoza-0b156052/
     - Icono LinkedIn: `783d89024f935bb79f8761caf4b8649327e4a44f.svg`
  
  2. **Guido Yauri**
     - Foto: `0c8b8746bf570f1ab539b63133f3e07ca3366fcd.png`
     - Cargo: "Directora de Operaciones"
     - LinkedIn: https://www.linkedin.com/in/guidoyauri/
     - Icono LinkedIn: `57e07a97f18b65e6a60c67084b4d044da4a38167.svg`

- **Características**:
  - Tarjetas centradas
  - Fotos circulares con borde naranja
  - Enlaces a LinkedIn
  - Efecto hover en tarjetas

## Estructura de Archivos

```
resources/views/nosotros/
└── index.blade.php          # Vista principal

public/assets/images/nosotros/
├── d59ee7973d60e759cd7c99ad2637afa915d0bfe8.png  # Hero background
├── 5e000563e99ca661005cbb407cf4f754485b5878.png  # Team image
├── b6beba38f53b28f29e855075ab49ad574e2b550f.png  # Marco Hernandez
├── 0c8b8746bf570f1ab539b63133f3e07ca3366fcd.png  # Guido Yauri
├── ecc850cd1dd65210bc095a061bebc08fd56bd05e.svg  # Análisis de Datos
├── a806b20c6145735ac6240cd2839f89e18c6cb6fa.svg  # Eficiencia Energética
├── 48b44baef915d04b6ce61e8ab8457396c5ad456c.svg  # Misión
├── 32f9d91764c033d8d63ff8068c68e4d1a13e7a88.svg  # Visión
├── 63cf36c0cfc804a522effff2b841b91c460147f6.svg  # Innovación
├── 9efee88f7df4e2b2971a76729057db606105f495.svg  # Confianza
├── a9c86350f83abaca59d25c12ba133064283e8269.svg  # Compromiso
├── ec014410ebfdf722f1eb2f6075694431928c1a1b.svg  # Eficiencia
├── 4d62fca146931f6c253e459ba61246566a3c5a06.svg  # Responsabilidad
├── 783d89024f935bb79f8761caf4b8649327e4a44f.svg  # LinkedIn 1
├── 57e07a97f18b65e6a60c67084b4d044da4a38167.svg  # LinkedIn 2
├── ecb12b9859ad18bd57dcb26f82ece97dd7bcc26a.svg  # Decorative icon 1
└── 759a2638106b5cf00daa4f3f1063068d6e4f56af.svg  # Decorative icon 2

public/css/
└── nosotros.css             # Estilos personalizados
```

## Rutas

### Ruta Principal
- **URL**: `/nosotros`
- **Nombre**: `nosotros`
- **Controlador**: Ninguno (closure en web.php)
- **Vista**: `resources/views/nosotros/index.blade.php`

### Definición en web.php
```php
Route::get('/nosotros', function () {
    return view('nosotros.index');
})->name('nosotros');
```

## Diseño y Estilos

### Tecnologías
- **Framework CSS**: Tailwind CSS
- **Estilos adicionales**: CSS personalizado (`nosotros.css`)
- **Layout**: `layouts.app`

### Colores Principales
- **Primario**: `#fa8c16` (Naranja)
- **Secundario**: `#1a3a6c` (Azul oscuro)
- **Fondo**: `#121212` (Negro)
- **Texto**: `#e0e0e0` (Gris claro)
- **Fondo oscuro**: `#152846` (Azul muy oscuro)
- **Neutral**: `#0a0a0a` (Negro puro)

### Responsive Design
- **Desktop**: Layout completo con todas las columnas
- **Tablet**: Grid adaptado a 2 columnas
- **Mobile**: Stack vertical de 1 columna

## Características Especiales

### Efectos Visuales
1. **Líneas decorativas animadas** en hero section
2. **Efectos de blur** en fondos decorativos
3. **Gradientes** en divisores y CTA
4. **Hover effects** en tarjetas y botones
5. **Transiciones suaves** en todos los elementos interactivos

### Interactividad
1. Enlaces a LinkedIn de miembros del equipo
2. Botón CTA que redirige a contacto
3. Efectos hover en tarjetas
4. Imágenes con lazy loading

### Accesibilidad
1. Alt text en todas las imágenes
2. Estructura semántica HTML5
3. Contraste adecuado de colores
4. Enlaces descriptivos

## Integración con el Proyecto

### Navegación
- Agregar enlace en el header/navbar principal
- Actualizar menú de navegación si existe

### SEO
- Title: "Nosotros - PowerGYMA"
- Meta description: Incluir en el futuro
- Open Graph tags: Considerar agregar

## Mantenimiento

### Actualizar Contenido
Para actualizar el contenido de la página:
1. Editar `resources/views/nosotros/index.blade.php`
2. Modificar textos directamente en el HTML
3. Los cambios se reflejarán inmediatamente

### Actualizar Imágenes
Para cambiar imágenes:
1. Reemplazar archivos en `public/assets/images/nosotros/`
2. Mantener los mismos nombres de archivo o actualizar referencias en el blade
3. Optimizar imágenes antes de subir (PNG/SVG)

### Agregar Miembros del Equipo
Para agregar más miembros:
1. Agregar foto en `public/assets/images/nosotros/`
2. Copiar estructura de tarjeta existente
3. Actualizar información y enlaces

## Testing

### Checklist de Pruebas
- [ ] Página carga correctamente en `/nosotros`
- [ ] Todas las imágenes se muestran
- [ ] Enlaces a LinkedIn funcionan
- [ ] Botón CTA redirige a contacto
- [ ] Responsive design funciona en mobile/tablet/desktop
- [ ] Efectos hover funcionan correctamente
- [ ] Estilos CSS se aplican correctamente

## Referencia de Diseño
- **Figma**: https://www.figma.com/design/p4nwBVmzQf0SGzegMdKaV4/Pagina--PowerGYMA--1-?node-id=415-22164&m=dev
- **Node ID**: 415-22164

## Notas Adicionales
- El diseño sigue fielmente el diseño de Figma proporcionado
- Todas las imágenes fueron extraídas automáticamente usando MCP de Figma
- La página está completamente responsive
- Los estilos utilizan Tailwind CSS con clases personalizadas
