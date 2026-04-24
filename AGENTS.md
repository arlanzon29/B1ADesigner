# Documentación del Proyecto

## Arquitectura

- **Backend**: PHP/Laravel (Web API REST)
- **Frontend**: React + Vite (JavaScript)
- **Base de datos**: MariaDB (XAMPP)

## Estructura del Proyecto

### Backend (Laravel)

```
proyecto-laravel/
├── app/
│   ├── Http/Controllers/    # Controladores API
│   ├── Models/            # Modelos Eloquent
│   ├── Interfaces/         # Contratos de repositorios
│   └── Repositories/      # Implementaciones
├── routes/
│   └── api.php           # Rutas API REST
├── database/migrations/  # Migraciones BD
└── ...
```

### Frontend (React + Vite)

```
FrontendReact/
├── index.html
├── vite.config.js
├── package.json
├── src/
│   ├── main.jsx
│   ├── App.jsx
│   ├── config/          # Configuraciones (API, etc.)
│   ├── pages/          # Componentes de páginas
│   └── services/       # Servicios API
└── dist/              # Build de producción
```

## Estado

- XAMPP: Apache (puerto 81), MariaDB ✓
- Laravel: Composer install ✓, APP_KEY ✓, Migraciones ✓
- Base de datos: laravel ✓
- VirtualHost configurado ✓

## Configuración VirtualHost

1. Editar `D:\php\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Agregar:
```apache
<VirtualHost *:81>
    DocumentRoot "D:/php/primerproyecto/proyecto-laravel/public"
    ServerName localhost
</VirtualHost>
```
3. Reiniciar Apache

## Flujo de trabajo

1. Diseñar modelos en especificaciones
2. Crear migraciones Laravel
3. Crear modelos Eloquent
4. Crear controlador y rutas API
5. Crear interfaz y repositorio
6. Crear frontend React
7. Ejecutar build y verificar

## Estructura de Especificaciones

```
especificaciones/
├── base-de-datos/    # Esquemas y diseño de BD
└── pantallas/       # Especificaciones de pantallas
```

## Referencias

- Skill: `.opencode/skills/componente-php/SKILL.md`
- Análisis: `.opencode/skills/crear-analisis/SKILL.md`