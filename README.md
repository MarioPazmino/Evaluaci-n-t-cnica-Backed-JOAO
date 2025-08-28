# 🚀 Evaluación Técnica Backend - CRUD de Clientes

Sistema completo de gestión de clientes desarrollado con **Laravel 12** que implementa un CRUD con arquitectura limpia y mejores prácticas.

## 📋 Características Implementadas

### ✅ Requisitos Obligatorios
- **CRUD Completo de Clientes** (Crear, Leer, Actualizar, Eliminar)
- **Validaciones robustas** (nombre requerido, email único y válido, teléfono opcional)
- **API REST** con respuestas JSON estructuradas
- **Base de datos MySQL** con migraciones

### 🔥 Características Adicionales (Requisitos Opcionales)
- **Búsqueda y filtrado** de clientes en tiempo real
- **Paginación** para grandes volúmenes de datos
- **Validación de email en vivo** (verificar si ya existe)
- **Edición completa** de clientes con validaciones
- **CORS configurado** para frontend
- **Datos de prueba** con Factory pattern

## 🏗️ Arquitectura y Decisiones Técnicas

### Patrón de Responsabilidad Única (SRP)
```
📁 Estructura del proyecto:
├── app/Http/Controllers/ClienteController.php    # Manejo de HTTP requests
├── app/Http/Requests/StoreClienteRequest.php     # Validaciones para crear
├── app/Http/Requests/UpdateClienteRequest.php    # Validaciones para actualizar
├── app/Http/Resources/ClienteResource.php        # Formato de respuestas JSON
├── app/Services/ClienteService.php               # Lógica de negocio
├── app/Models/Cliente.php                        # Modelo de datos
└── database/factories/ClienteFactory.php         # Generación de datos de prueba
```

### Decisiones Técnicas

1. **Service Layer Pattern**: Separación de la lógica de negocio del controlador
2. **Request Classes**: Validaciones centralizadas y reutilizables
3. **Resource Classes**: Transformación consistente de datos para API
4. **Factory Pattern**: Generación de datos de prueba realistas con Faker
5. **Repository Pattern implícito**: A través de Eloquent ORM
6. **Validation Rules diferenciadas**: Diferentes reglas para crear vs actualizar

## 🛠️ Instalación y Configuración

### Prerrequisitos
- PHP 8.4+
- Composer
- MySQL 8.0+
- Node.js (opcional, para assets)

### 1. Clonar el repositorio
```bash
git clone https://github.com/MarioPazmino/Evaluaci-n-t-cnica-Backed-JOAO.git
cd Evaluaci-n-t-cnica-Backed-JOAO
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar el entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Configurar base de datos
Editar el archivo `.env` con tus credenciales de MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_clientes
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### 5. Crear base de datos
```sql
CREATE DATABASE laravel_clientes;
```

### 6. Ejecutar migraciones y seeders
```bash
php artisan migrate:fresh --seed
```

### 7. Iniciar servidor
```bash
php artisan serve
```

La API estará disponible en: `http://127.0.0.1:8000`

## 🌐 Endpoints de la API

### Clientes
| Método | Endpoint | Descripción | Parámetros |
|--------|----------|-------------|------------|
| `GET` | `/api/clientes` | Listar todos los clientes | `?search=texto&paginate=true&per_page=10` |
| `POST` | `/api/clientes` | Crear nuevo cliente | `nombre, email, telefono` |
| `PUT` | `/api/clientes/{id}` | Actualizar cliente | `nombre, email, telefono` |
| `DELETE` | `/api/clientes/{id}` | Eliminar cliente | - |
| `GET` | `/api/clientes/check-email/{email}` | Verificar si email existe | `?exclude_id=123` |

### Ejemplos de uso

#### Listar clientes
```bash
curl -X GET http://127.0.0.1:8000/api/clientes
```

#### Crear cliente
```bash
curl -X POST http://127.0.0.1:8000/api/clientes \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Mario Pazmiño",
    "email": "mario@example.com",
    "telefono": "+1234567890"
  }'
```

#### Búsqueda con paginación
```bash
curl -X GET "http://127.0.0.1:8000/api/clientes?search=juan&paginate=true&per_page=5"
```

#### Verificar email
```bash
curl -X GET http://127.0.0.1:8000/api/clientes/check-email/juan@example.com
```

## 📊 Estructura de Respuestas

### Respuesta Exitosa
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Juan Pérez",
      "email": "juan@example.com",
      "telefono": "+1234567890",
      "created_at": "2025-08-28 17:30:00",
      "updated_at": "2025-08-28 17:30:00"
    }
  ]
}
```

### Respuesta con Paginación
```json
{
  "success": true,
  "data": [...],
  "pagination": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 10,
    "total": 25,
    "from": 1,
    "to": 10
  }
}
```

### Respuesta de Error
```json
{
  "success": false,
  "message": "Error de validación",
  "errors": {
    "email": ["Este email ya está registrado."]
  }
}
```

## 🧪 Testing

### Datos de Prueba
El sistema incluye un seeder que genera 10 clientes de prueba con datos realistas:
```bash
php artisan db:seed --class=ClienteSeeder
```

### Comandos Útiles
```bash
# Limpiar y regenerar base de datos
php artisan migrate:fresh --seed

# Ver todas las rutas
php artisan route:list

# Limpiar caché
php artisan cache:clear
```

## 🔒 Validaciones Implementadas

### Crear Cliente
- `nombre`: Requerido, máximo 255 caracteres
- `email`: Requerido, formato válido, único en la tabla
- `telefono`: Opcional, máximo 20 caracteres

### Actualizar Cliente
- `nombre`: Requerido, máximo 255 caracteres
- `email`: Requerido, formato válido, único (excepto el registro actual)
- `telefono`: Opcional, máximo 20 caracteres

## 🚀 Características Avanzadas

### 1. Búsqueda Inteligente
Busca en múltiples campos simultáneamente:
```php
GET /api/clientes?search=juan
```

### 2. Validación de Email en Vivo
Perfecto para validación en tiempo real en el frontend:
```php
// Verificar si email existe
GET /api/clientes/check-email/nuevo@email.com

// Excluir ID actual (para edición)
GET /api/clientes/check-email/nuevo@email.com?exclude_id=5
```

### 3. Paginación Flexible
```php
GET /api/clientes?paginate=true&per_page=15
```

## 📈 Escalabilidad y Mejores Prácticas

1. **Inyección de Dependencias**: Controllers reciben Services via constructor
2. **Factory Pattern**: Datos de prueba generados dinámicamente
3. **Resource Transformers**: Respuestas API consistentes
4. **Request Validation**: Validaciones centralizadas y reutilizables
5. **Service Layer**: Lógica de negocio separada de HTTP concerns
6. **CORS Ready**: Configurado para consumo desde frontend

## 🔧 Configuración de Desarrollo

### Variables de Entorno Importantes
```env
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
```

### Extensions PHP Requeridas
- `pdo_mysql`
- `mbstring`
- `fileinfo`
- `json`
- `openssl`

## 📝 Notas del Desarrollador

Este proyecto demuestra:
- **Arquitectura limpia** siguiendo principios SOLID
- **Código mantenible** con separación clara de responsabilidades
- **API robusta** con manejo de errores y validaciones
- **Escalabilidad** preparada para crecimiento futuro
- **Mejores prácticas** de Laravel y desarrollo web

---

**Desarrollado por**: Mario Pazmiño  
**Framework**: Laravel 12  
**Base de Datos**: MySQL  
**Arquitectura**: API REST con Clean Architecture
