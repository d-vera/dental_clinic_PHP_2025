# 🏥 Sistema de Gestión de Clínica Médica

Sistema web completo desarrollado en PHP y MySQL para la gestión integral de una clínica médica, incluyendo pacientes, médicos, servicios y más.

## 📋 Características Principales

### ✅ Requerimientos Cumplidos

- ✔️ **2 Módulos CRUD Completos**
  - Gestión de Pacientes (CRUD completo)
  - Gestión de Médicos (CRUD completo)
  
- ✔️ **Validaciones Frontend y Backend**
  - HTML5 validation
  - JavaScript validation en tiempo real
  - PHP validation en servidor
  - Prevención de SQL injection
  
- ✔️ **Diseño Responsivo**
  - Bootstrap 5 implementado
  - Compatible con PC, tablet y móvil
  - Diseño moderno y funcional
  
- ✔️ **Sistema de Autenticación**
  - Login con roles (Administrador y Usuario)
  - Sesiones seguras
  - Control de acceso por roles
  
- ✔️ **Reportes en PDF**
  - Reporte de pacientes
  - Reporte de médicos
  - Función de impresión integrada
  
- ✔️ **Funcionalidades Adicionales**
  - Búsqueda y filtrado en tablas
  - Carga de imágenes (fotos de perfil)
  - Menú de navegación completo
  - 5+ páginas del sistema

## 🗂️ Estructura del Proyecto

```
4. final_project/
├── config/
│   ├── database.php          # Configuración de base de datos
│   └── session.php            # Manejo de sesiones
├── includes/
│   ├── header.php             # Header común
│   └── footer.php             # Footer común
├── pages/
│   ├── pacientes/
│   │   ├── index.php          # Listado de pacientes
│   │   ├── create.php         # Crear paciente
│   │   ├── edit.php           # Editar paciente
│   │   ├── view.php           # Ver detalles
│   │   └── report_pdf.php     # Reporte PDF
│   ├── medicos/
│   │   ├── index.php          # Listado de médicos
│   │   ├── create.php         # Crear médico
│   │   ├── edit.php           # Editar médico
│   │   ├── view.php           # Ver detalles
│   │   └── report_pdf.php     # Reporte PDF
│   ├── servicios.php          # Página de servicios
│   └── contacto.php           # Página de contacto
├── assets/
│   ├── css/
│   │   └── style.css          # Estilos personalizados
│   └── js/
│       └── main.js            # JavaScript personalizado
├── uploads/
│   ├── pacientes/             # Fotos de pacientes
│   └── medicos/               # Fotos de médicos
├── database.sql               # Script de base de datos
├── index.php                  # Página principal
├── login.php                  # Página de login
├── logout.php                 # Cerrar sesión
└── README.md                  # Este archivo
```

## 🚀 Instalación

### Requisitos Previos

- XAMPP (o similar con Apache, PHP 7.4+, MySQL)
- Navegador web moderno
- Editor de código (opcional)

### Pasos de Instalación

1. **Copiar el proyecto**
   ```
   Copiar la carpeta "4. final_project" a:
   C:\xampp\htdocs\fourthBim\
   ```

2. **Iniciar servicios XAMPP**
   - Abrir XAMPP Control Panel
   - Iniciar Apache
   - Iniciar MySQL

3. **Crear la base de datos**
   - Abrir phpMyAdmin: http://localhost/phpmyadmin
   - Crear nueva base de datos llamada: `clinica_medica`
   - Importar el archivo `database.sql` o ejecutar el script SQL

4. **Configurar la conexión** (si es necesario)
   - Editar `config/database.php`
   - Ajustar credenciales de MySQL si son diferentes:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'clinica_medica');
   ```

5. **Acceder al sistema**
   ```
   http://localhost/fourthBim/4. final_project/
   ```

## 👤 Usuarios de Prueba

### Administrador
- **Usuario:** `admin`
- **Contraseña:** `admin123`
- **Permisos:** Acceso completo al sistema

### Usuario Regular
- **Usuario:** `usuario`
- **Contraseña:** `admin123`
- **Permisos:** Acceso a funcionalidades básicas

## 📊 Base de Datos

### Tablas Principales

#### 1. **usuarios**
- Gestión de usuarios del sistema
- Roles: administrador, usuario
- Autenticación con contraseñas hasheadas

#### 2. **pacientes** (CRUD 1)
- id, nombre, apellido
- fecha_nacimiento, edad, genero
- telefono, email, direccion
- tipo_sangre, alergias
- historial_medico, foto
- fecha_registro, ultima_actualizacion

#### 3. **medicos** (CRUD 2)
- id, nombre, apellido
- especialidad, cedula_profesional
- telefono, email, direccion
- horario_atencion, foto
- activo, fecha_registro

#### 4. **citas** (Relacional)
- Relaciona pacientes con médicos
- Gestión de citas médicas
- Estados: Pendiente, Confirmada, Completada, Cancelada

## 🎨 Tecnologías Utilizadas

### Frontend
- **HTML5** - Estructura semántica
- **CSS3** - Estilos personalizados
- **Bootstrap 5** - Framework CSS responsivo
- **Bootstrap Icons** - Iconografía
- **JavaScript** - Validaciones y funcionalidad dinámica

### Backend
- **PHP 7.4+** - Lenguaje del servidor
- **MySQL** - Base de datos relacional
- **MySQLi** - Extensión para conexión a BD

### Características de Seguridad
- Validación frontend y backend
- Escape de datos SQL
- Sesiones seguras
- Control de acceso por roles
- Passwords hasheados con bcrypt

## 📱 Funcionalidades por Módulo

### 🏠 Inicio (index.php)
- Dashboard con estadísticas
- Acceso rápido a módulos
- Información de la clínica
- Horarios de atención

### 👥 Pacientes
- **Listar:** Tabla con búsqueda y filtros
- **Crear:** Formulario con validaciones
- **Editar:** Actualización de datos
- **Ver:** Detalles completos del paciente
- **Eliminar:** Con confirmación
- **Reporte PDF:** Exportación de datos

### 👨‍⚕️ Médicos
- **Listar:** Tabla con búsqueda y filtros
- **Crear:** Formulario con validaciones
- **Editar:** Actualización de datos
- **Ver:** Detalles completos del médico
- **Eliminar:** Con confirmación
- **Reporte PDF:** Exportación de datos

### 💊 Servicios
- Catálogo de servicios médicos
- Información detallada
- Horarios y contacto

### 📧 Contacto
- Formulario de contacto
- Información de ubicación
- Horarios de atención
- Preguntas frecuentes

## 🔐 Sistema de Autenticación

### Login
- Validación de credenciales
- Manejo de sesiones
- Redirección según rol

### Control de Acceso
- Páginas protegidas requieren login
- Verificación de roles
- Logout seguro

## 📄 Reportes PDF

### Características
- Generación dinámica de PDF
- Diseño profesional
- Información del usuario que genera
- Fecha y hora del reporte
- Botón de impresión/descarga
- Compatible con todos los navegadores

### Tipos de Reportes
1. **Reporte de Pacientes**
   - Lista completa de pacientes
   - Datos principales
   - Filtrable por búsqueda

2. **Reporte de Médicos**
   - Lista completa de médicos
   - Especialidades
   - Estado (activo/inactivo)

## 🎯 Validaciones Implementadas

### Frontend (HTML5 + JavaScript)
- Campos requeridos
- Formato de email
- Formato de teléfono
- Fechas válidas
- Números en rangos específicos
- Cálculo automático de edad

### Backend (PHP)
- Validación de datos vacíos
- Validación de formato de email
- Verificación de duplicados
- Sanitización de datos
- Prevención de SQL injection
- Validación de archivos subidos

## 📸 Gestión de Imágenes

- Carga de fotos de perfil
- Formatos permitidos: JPG, JPEG, PNG, GIF
- Almacenamiento organizado por módulo
- Previsualización antes de guardar
- Eliminación de imágenes antiguas al actualizar

## 🔍 Búsqueda y Filtrado

- Búsqueda en tiempo real
- Filtrado por múltiples campos
- Resaltado de resultados
- Sin recarga de página

## 📱 Responsive Design

### Breakpoints
- **Mobile:** < 768px
- **Tablet:** 768px - 1024px
- **Desktop:** > 1024px

### Adaptaciones
- Menú hamburguesa en móvil
- Tablas con scroll horizontal
- Cards apiladas en móvil
- Botones adaptados al tamaño

## 🛠️ Mantenimiento

### Backup de Base de Datos
```sql
-- Exportar desde phpMyAdmin
-- O usar mysqldump:
mysqldump -u root -p clinica_medica > backup.sql
```

### Actualizar Datos de Prueba
```sql
-- Ejecutar queries directamente en phpMyAdmin
-- O modificar database.sql
```

## 🐛 Solución de Problemas

### Error de Conexión a BD
- Verificar que MySQL esté corriendo
- Revisar credenciales en `config/database.php`
- Confirmar que la BD existe

### Imágenes no se muestran
- Verificar permisos de carpeta `uploads/`
- Confirmar ruta correcta en código
- Revisar que el archivo exista

### Sesión no persiste
- Verificar que `session_start()` esté al inicio
- Revisar configuración de PHP
- Limpiar cookies del navegador

## 📝 Notas Importantes

1. **Contraseñas:** Las contraseñas están hasheadas con bcrypt
2. **Rutas:** Las rutas están configuradas para XAMPP en Windows
3. **Uploads:** Crear carpetas `uploads/pacientes/` y `uploads/medicos/` si no existen
4. **Permisos:** Asegurar permisos de escritura en carpeta uploads

## 👨‍💻 Desarrollo

### Agregar Nuevos Módulos
1. Crear carpeta en `pages/`
2. Implementar CRUD básico
3. Agregar al menú en `includes/header.php`
4. Actualizar base de datos si es necesario

### Personalización
- **Colores:** Modificar variables CSS en `assets/css/style.css`
- **Logo:** Cambiar en `includes/header.php`
- **Información:** Actualizar en `includes/footer.php`

## 📞 Soporte

Para dudas o problemas:
- Revisar este README
- Consultar comentarios en el código
- Verificar logs de PHP y MySQL

## 📄 Licencia

Proyecto educativo desarrollado para el curso de Programación Web.

## ✨ Características Destacadas

- ✅ Código limpio y comentado
- ✅ Arquitectura MVC simplificada
- ✅ Buenas prácticas de PHP
- ✅ Seguridad implementada
- ✅ UI/UX moderna y profesional
- ✅ Totalmente funcional
- ✅ Fácil de mantener y extender

---

**Desarrollado con ❤️ para el curso de Programación Web**

**Fecha:** Octubre 2025
**Versión:** 1.0.0
