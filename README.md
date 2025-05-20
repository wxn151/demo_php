# Proyecto PHP + MySQL 🐘

Construido con ❤️ en PHP y HTML como en los viejos tiempos.

---

### ⚙️ Requisitos

- PHP 7.4 o superior
- MySQL / MariaDB
- Composer

---

### 🧪 Cómo iniciar

- Configura tu instancia MySQL
    
        Ejecuta el archivo `sql/schema.sql`.
  - Configura los datos de conexión en `api/db.php`. 
  - Instala las dependencias:

      ```bash
      composer install
      ```
    - Levanta el servidor local:
      ```bash
      php -S localhost:8000
      ```

Abre en el navegador: http://localhost:8000

### Estructura
```
  demo
    ├── auth.js
    ├── home.html
    ├── index.html
    ├── profile.js
    ├── register.html
    ├── style.css
    ├── api
    │    ├── db.php
    │    ├── jwt.php
    │    ├── login.php
    │    ├── profile.php
    │    ├── register.php
    │    └──update_profile.php
    │
    └── sql
         └──schema.sql
```
### Contribuciones
¿Ideas, errores o mejoras? ¡Son bienvenidas! Abrí un issue o un pull request.
