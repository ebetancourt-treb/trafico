# Tráfico Soluciones Viales - Website + Admin Panel

## Stack
- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade + Tailwind CSS (CDN) + Lucide Icons
- **Auth:** Laravel Breeze (ya instalado)
- **DB:** MySQL / SQLite

---

## Instalación paso a paso

### 1. Clonar tu repo y copiar archivos

```bash
git clone <tu-repo> trafico-web
cd trafico-web
```

Copia las carpetas del ZIP descargado dentro de tu proyecto Laravel:
- `app/` → sobrescribe/agrega modelos y controllers
- `database/` → sobrescribe migraciones y seeders
- `resources/views/` → agrega layouts y vistas
- `routes/web.php` → reemplaza el archivo de rutas

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar .env

```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` con tus datos de base de datos:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trafico_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Registrar el ViewServiceProvider

**Para Laravel 12** edita `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ViewServiceProvider::class,  // ← Agregar esta línea
];
```

### 5. Migrar y sembrar datos

```bash
php artisan migrate --seed
php artisan storage:link
```

### 6. Levantar el servidor

```bash
php artisan serve
```

---

## URLs principales

| URL | Descripción |
|---|---|
| `http://localhost:8000` | Sitio público |
| `http://localhost:8000/admin/login` | Login del admin |
| `http://localhost:8000/admin` | Panel de administración |

## Credenciales de admin por defecto

```
Email:    admin@trafico.com
Password: password
```

**⚠️ Cambia la contraseña después del primer login.**

---

## Estructura de archivos generados

```
app/
├── Http/Controllers/
│   ├── PageController.php          # Páginas públicas
│   ├── ContactController.php       # Formulario de contacto
│   └── Admin/
│       ├── AdminController.php     # Dashboard + Auth
│       ├── SlideController.php     # CRUD Slides
│       ├── SectionController.php   # CRUD Secciones
│       ├── CompanyValueController.php
│       ├── ProductCategoryController.php
│       ├── ProductController.php
│       ├── IndustryController.php
│       ├── GalleryController.php
│       ├── ContactMessageController.php
│       └── SiteSettingController.php
├── Models/
│   ├── SiteSetting.php
│   ├── Slide.php
│   ├── Section.php
│   ├── CompanyValue.php
│   ├── ProductCategory.php
│   ├── Product.php
│   ├── Industry.php
│   ├── GalleryImage.php
│   └── ContactMessage.php
└── Providers/
    └── ViewServiceProvider.php

database/
├── migrations/                     # 8 migraciones
└── seeders/
    └── DatabaseSeeder.php          # Datos iniciales del PDF

resources/views/
├── layouts/
│   ├── public.blade.php            # Layout del sitio
│   └── admin.blade.php             # Layout del panel
├── public/
│   ├── home.blade.php
│   ├── about.blade.php
│   ├── products.blade.php
│   ├── product-category.blade.php
│   ├── gallery.blade.php
│   ├── industries.blade.php
│   └── contact.blade.php
└── admin/
    ├── login.blade.php
    ├── dashboard.blade.php
    ├── slides/         (index + form)
    ├── sections/       (index + form)
    ├── values/         (index + form)
    ├── product-categories/ (index + form)
    ├── products/       (index + form)
    ├── industries/     (index + form)
    ├── gallery/        (index + form)
    ├── messages/       (index + show)
    └── settings/       (index)

routes/
└── web.php                         # Todas las rutas
```

---

## Notas técnicas

- **Tailwind CDN:** Para producción, migra a Vite + Tailwind compilado
- **Imágenes:** Se guardan en `storage/app/public/` vía `php artisan storage:link`
- **Settings globales:** Compartidos en todas las vistas vía `ViewServiceProvider`
- **Spatie Permissions:** Ya lo tienes instalado si necesitas roles más granulares
