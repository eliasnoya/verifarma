## VERIFARMA CHALLENGE - NOYA ELIAS

Hola! buenas. Mi nombre es Elías y esta es la resolución del Challenge enviado por Valería.
<br/>
Dejo aquí algunos comentarios sobre usos y planteos del codigo aquí presentado.

<hr/>

1. Stack: Mysql, PHP 8.2, Laravel 10. (Nginx y PHP-FPM en contenedor)

Ejecutar con docker-compose (no linkeado por volumen)

```bash
git clone https://github.com/eliasnoya/verifarma-challenge.git
cd verifarma-challenge
docker-compose up
docker exec enoya_verifarma_api php /api/artisan migrate --seed
```

Ejecutar local (se debe tener composer php 8.2 y una base de datos instalada + configuración en .env o variables de entorno):

```bash
git clone https://github.com/eliasnoya/verifarma-challenge.git
cd verifarma-challenge
composer install
php artisan migrate --seed
php artisan serve
```

<b>HTTP Port Exposed 8001</b>
<br/>
<b>MYSQL Port Exposed 3307</b>

2. Ejecutar TEST

Desde Container:

```bash
docker exec enoya_verifarma_api php /api/artisan test
```

Local:

```bash
php artisan test
```

En tests/Unit existen pruebas sobre el dominio (allí hay 3 ejemplos del control de error sobre dominio requerido)
<br/>
En tests/Feature existen tests para los 3 endpoint del challenge.

3. Se plantea una resolución del challenge con una arquitectura Hexagonal (separado en capas de Aplicación, Dominio e Infraestructura)
4. El code analizer utilizado fue [PHPStan](https://phpstan.org/) en Nivel 2 y en VSCode usé [SonarLint Extension](https://marketplace.visualstudio.com/items?itemName=SonarSource.sonarlint-vscode) para revisión en tiempo de escritura.

```bash
.\vendor\bin\phpstan analyze src --level 2
```

5. El code formatter utilizado fue Pint

```bash
 .\vendor\bin\pint .\src\
```

6. Documentación con Cliente HTTP Postman ubicada en <root>/Postman.json se encuentra formato 2.1 y tiene los 3 request para ejecutarlos secuencialmente y probar (Create->Get->Find) los 3 endpoints. La unica variable de entorno es base_url (setear en http://127.0.0.1:8001 en caso de usar el contenedor incluido)  
   

7. La solución de Log y Tracing implementada es 100% la capa de infrastructure (abstracto al dominio) con un Middelware
   [VER AQUI](https://github.com/eliasnoya/verifarma-challenge/blob/main/src/Shared/Infrastructure/Middleware/HttpLoggerMiddleware.php)
   El mismo, guarda tanto el request como el response en una table en la base de datos llamada "logs"

8. La gestion de errores la hace \Src\Shared\Infrastructure\SharedExceptionHandler en la implementación, con una funcionalidad básica separando los errores de dominio de infraesutrctura con el método reportable()

9. En el docker-compose up se realiza la migración de la base de datos con 1 seeders para agregar 2 farmacias con 4 direcciones
   [VER AQUI](https://github.com/eliasnoya/verifarma-challenge/blob/main/database/seeders/DatabaseSeeder.php)

10. Todo el codigo fuente de la app esta en /src excepto /test, /database/migrations y /database/seeders.
    Se quito todo lo de /app default de laravel para mayor simplicidad
    @see /bootstrap/app.php
