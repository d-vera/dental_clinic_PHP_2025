# 🚀 Guía Rápida - Sistema de Clínica Médica

## 📦 Instalación en 3 Pasos

### 1. Iniciar XAMPP
```
✓ Apache: Start
✓ MySQL: Start
```

### 2. Crear Base de Datos
```
1. Ir a: http://localhost/phpmyadmin
2. Crear BD: clinica_medica
3. Importar: database.sql
```

### 3. Acceder al Sistema
```
URL: http://localhost/fourthBim/4. final_project/
Usuario: admin
Contraseña: admin123
```

---

## 🎯 Funcionalidades Principales

### 👥 Módulo de Pacientes
| Acción | Ruta |
|--------|------|
| Listar | `/pages/pacientes/index.php` |
| Crear | `/pages/pacientes/create.php` |
| Editar | `/pages/pacientes/edit.php?id=X` |
| Ver | `/pages/pacientes/view.php?id=X` |
| PDF | `/pages/pacientes/report_pdf.php` |

**Campos:**
- Nombre, Apellido, Fecha Nacimiento, Edad
- Género, Teléfono, Email, Dirección
- Tipo Sangre, Alergias, Historial Médico
- Foto de perfil

### 👨‍⚕️ Módulo de Médicos
| Acción | Ruta |
|--------|------|
| Listar | `/pages/medicos/index.php` |
| Crear | `/pages/medicos/create.php` |
| Editar | `/pages/medicos/edit.php?id=X` |
| Ver | `/pages/medicos/view.php?id=X` |
| PDF | `/pages/medicos/report_pdf.php` |

**Campos:**
- Nombre, Apellido, Especialidad
- Cédula Profesional, Teléfono, Email
- Dirección, Horario de Atención
- Estado (Activo/Inactivo), Foto

---

## 🔐 Sistema de Usuarios

### Roles Disponibles

#### 👑 Administrador
```
Usuario: admin
Contraseña: admin123
Permisos: Acceso completo
```

#### 👤 Usuario Regular
```
Usuario: usuario
Contraseña: admin123
Permisos: Acceso básico
```

---

## 📄 Páginas del Sistema

| Página | Descripción | Requiere Login |
|--------|-------------|----------------|
| `/index.php` | Inicio/Dashboard | No |
| `/login.php` | Iniciar sesión | No |
| `/logout.php` | Cerrar sesión | Sí |
| `/pages/pacientes/` | Gestión de pacientes | Sí |
| `/pages/medicos/` | Gestión de médicos | Sí |
| `/pages/servicios.php` | Servicios médicos | No |
| `/pages/contacto.php` | Formulario contacto | No |

---

## 🔍 Características Técnicas

### ✅ Validaciones Implementadas

**Frontend:**
- HTML5 required, pattern, min, max
- JavaScript en tiempo real
- Cálculo automático de edad
- Formato de email y teléfono

**Backend:**
- Validación de campos vacíos
- Validación de formato email
- Prevención SQL injection
- Verificación de duplicados
- Sanitización de datos

### 🎨 Diseño Responsivo

**Breakpoints:**
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

**Framework:** Bootstrap 5.3.2

---

## 📊 Base de Datos

### Tablas Principales

```sql
usuarios (id, username, password, nombre_completo, email, rol, foto)
pacientes (id, nombre, apellido, fecha_nacimiento, edad, genero, ...)
medicos (id, nombre, apellido, especialidad, cedula_profesional, ...)
citas (id, paciente_id, medico_id, fecha_cita, motivo, estado)
```

### Relaciones
- `citas.paciente_id` → `pacientes.id`
- `citas.medico_id` → `medicos.id`

---

## 🛠️ Comandos Útiles

### Backup de Base de Datos
```bash
# Desde phpMyAdmin: Exportar → SQL
# O usar línea de comandos:
mysqldump -u root -p clinica_medica > backup.sql
```

### Restaurar Base de Datos
```bash
mysql -u root -p clinica_medica < backup.sql
```

### Limpiar Sesiones
```php
// En navegador: Borrar cookies y caché
// O ejecutar:
session_destroy();
```

---

## 🎯 Atajos de Teclado

| Acción | Atajo |
|--------|-------|
| Imprimir | `Ctrl + P` |
| Guardar PDF | `Ctrl + P` → Guardar como PDF |
| Buscar en página | `Ctrl + F` |
| Recargar | `F5` o `Ctrl + R` |

---

## 📱 Funciones JavaScript

```javascript
// Calcular edad automáticamente
calcularEdad(fechaNacimiento)

// Validar email
validarEmail(email)

// Validar teléfono
validarTelefono(telefono)

// Buscar en tabla
buscarEnTabla(inputId, tableId)

// Confirmar eliminación
confirmarEliminacion(mensaje)

// Previsualizar imagen
previsualizarImagen(input, previewId)
```

---

## 🐛 Solución Rápida de Problemas

### Error: "Cannot connect to database"
```
✓ Verificar MySQL corriendo
✓ Verificar nombre BD: clinica_medica
✓ Revisar config/database.php
```

### Error: "Page not found"
```
✓ Verificar Apache corriendo
✓ Ruta correcta: /fourthBim/4. final_project/
✓ Archivo existe en carpeta
```

### Imágenes no se muestran
```
✓ Crear carpetas: uploads/pacientes/ y uploads/medicos/
✓ Verificar permisos de escritura
✓ Revisar ruta en código
```

### No puedo iniciar sesión
```
✓ Importar database.sql correctamente
✓ Usuario: admin (minúsculas)
✓ Contraseña: admin123 (sin espacios)
✓ Cookies habilitadas
```

---

## 📈 Estadísticas del Proyecto

```
Archivos PHP: 20+
Líneas de código: 3000+
Tablas BD: 4
Módulos CRUD: 2
Páginas: 15+
Validaciones: Frontend + Backend
Responsive: ✓
PDF Reports: ✓
```

---

## 🎓 Requerimientos Cumplidos

- ✅ 2 Tablas principales (Pacientes y Médicos)
- ✅ CRUD completo en ambas tablas
- ✅ Validaciones frontend (HTML5 + JS)
- ✅ Validaciones backend (PHP)
- ✅ Bootstrap 5 implementado
- ✅ Diseño responsivo (PC, tablet, móvil)
- ✅ Menú de navegación funcional
- ✅ Búsqueda y filtrado en tablas
- ✅ Login con roles (Admin y Usuario)
- ✅ Reportes en PDF
- ✅ Carga de imágenes
- ✅ 5+ secciones del sistema

---

## 📞 Información de Contacto del Sistema

```
Clínica Médica
Av. Independencia #123
Santo Domingo, República Dominicana

Tel: +1 (809) 555-0100
Emergencias: +1 (809) 555-0911
Email: info@clinicamedica.com
```

---

## 🔗 Enlaces Rápidos

- **Sistema:** http://localhost/fourthBim/4. final_project/
- **phpMyAdmin:** http://localhost/phpmyadmin
- **Documentación completa:** README.md
- **Instalación:** INSTALACION.txt

---

## ⚡ Tips y Trucos

1. **Búsqueda rápida:** Usa la barra de búsqueda en cada módulo
2. **Reportes:** Click en "Reporte PDF" para exportar datos
3. **Impresión:** Usa Ctrl+P en cualquier página
4. **Edad automática:** Al seleccionar fecha de nacimiento, la edad se calcula sola
5. **Fotos:** Arrastra y suelta imágenes en el campo de foto
6. **Validación:** Los campos con * son obligatorios

---

**Última actualización:** Octubre 2025  
**Versión:** 1.0.0  
**Desarrollado para:** Curso de Programación Web
