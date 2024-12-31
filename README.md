<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/Status-Active-brightgreen" alt="Project Status"></a>
<a href="#"><img src="https://img.shields.io/badge/Laravel-10.x-red" alt="Laravel Version"></a>
<a href="#"><img src="https://img.shields.io/badge/License-MIT-blue" alt="License"></a>
</p>

## About the Project

**Cálculos de IVA** es una aplicación web desarrollada con Laravel que permite realizar cálculos relacionados con el IVA (Impuesto al Valor Agregado) de manera fácil y eficiente. Incluye características como historial de cálculos, eliminación automática de datos y funcionalidades interactivas para mejorar la experiencia del usuario.

---

## Features

- **Hallar Precio Sin IVA (Precio + IVA):** Calcula el precio base a partir de un precio final con IVA incluido.
- **Hallar Precio Sin IVA (IVA):** Obtiene el precio base utilizando un porcentaje del IVA.
- **Hallar Precio Más IVA:** Calcula el precio total (base + IVA).
- **Historial de Cálculos:** Un listado dinámico de cálculos realizados, con opción para copiar o eliminar.
- **Eliminación Automática:** Los cálculos se eliminan del historial tras 30 minutos.

---

## Installation

```bash
# 1. Clona el repositorio
git clone https://github.com/tu_usuario/calculos-iva.git

# 2. Instala las dependencias
composer install

# 3. Configura tu archivo .env con las credenciales de tu base de datos

# 4. Ejecuta las migraciones
php artisan migrate

# 5. Inicia el servidor
php artisan serve

# 6. Accede al tablero principal en /dashboard
#    - Elige el tipo de cálculo que deseas realizar.
#    - Completa el formulario con los valores necesarios.
#    - Consulta el resultado en el historial.
#    - Usa las acciones disponibles (copiar o eliminar).
File Structure
Controladores
CalculationController: Gestiona la lógica de los cálculos y el historial.
Migraciones
create_calculations_table: Define la estructura de la tabla calculations.
Vistas
dashboard.blade.php: Tablero principal con formularios y el historial.
Scripts
delete-calculation.js: Gestión de eliminación dinámica en el historial.
copy-to-clipboard.js: Copiar resultados al portapapeles.
Dependencies
Laravel Framework
Bootstrap 5
Font Awesome
Contributing
Si deseas contribuir a este proyecto, por favor, realiza un fork del repositorio y crea un pull request con tus cambios.

License
Este proyecto está licenciado bajo la MIT license.

Todo el contenido relacionado con la instalación y el uso se encuentra dentro del mismo bloque de código. 😊
