# Sistema de Administración de Clínicas

Este proyecto es un sistema de administración para clínicas que incluye un backend desarrollado en Laravel y un frontend en Vue.js.

## Estructura del Proyecto

- `backend/`: Contiene el código del backend desarrollado en Laravel.
- `frontend/`: Contiene el código del frontend desarrollado en Vue.js.

## Configuración

```bash

### Clonar el Repositorio
git clone https://github.com/tu-usuario/adm-clinica.git
cd adm-clinica


### Instalación del Backend (Laravel)
cd backend
composer install

### Configuración del Backend
cp .env.example .env
php artisan key:generate
php artisan migrate --seed


## Instalación del Frontend (Vue.js)
cd frontend
npm install


## Ejecución del Proyecto
Para ejecutar el backend (Laravel), desde la carpeta backend/:
php artisan serve


Para ejecutar el frontend (Vue.js), desde la carpeta frontend/:
npm run serve





