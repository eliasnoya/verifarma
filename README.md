## VERIFARMA CHALLENGE - NOYA ELIAS

Hola! buenas. Mi nombre es Elías y esta es la resolución del Challenge enviado por Valería.
<br/>
Dejo aquí algunos comentarios sobre usos y planteos del codigo aquí presentado.

<hr/>

1. Stack & Services: Mysql, PHP 8.2, Laravel 10, Supervisor, Nginx y PHP-FPM

Ejecutar con docker-compose (no linkeado por volumen)

```bash
git clone https://github.com/eliasnoya/verifarma.git
cd verifarma
docker-compose up
docker exec enoya_verifarma_api php /api/artisan migrate --seed
```

Ejecutar local (se debe tener composer, php 8.2 y una base de datos instalada + configuración en .env):

```bash
git clone https://github.com/eliasnoya/verifarma.git
cd verifarma
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

6. Documentación con Cliente HTTP Postman ubicada en <root>/Postman.json se encuentra formato 2.1 y tiene los 3 request para ejecutarlos secuencialmente y probar (Create->Get->Find) los 3 endpoints. La unica variable de entorno es base_url (setear en "http://127.0.0.1:8001" en caso de usar el contenedor incluido)  
   

7. La solución de Log y Tracing propuesta es 100% la capa de infrastructure (abstracto al dominio) con un Middelware [VER AQUI](https://github.com/eliasnoya/verifarma-challenge/blob/main/src/Shared/Infrastructure/Middleware/HttpLoggerMiddleware.php). El mismo, guarda tanto el request como el response en una table en la base de datos llamada "logs"

8. La gestion de errores en la implementación la realiza unicamente [SharedExceptionHander](https://github.com/eliasnoya/verifarma/blob/main/src/Shared/Infrastructure/SharedExceptionHandler.php), separando los errores de cada capa involucrada con el método reportable() (Se genero contratos/abstracciones para diferenciar las excepciones de Dominio)

9. Deje un seeder que crea 2 farmacias en 4 direcciones para probar pero no es necesario ejecutarlos para que funcione la api [VER AQUI](https://github.com/eliasnoya/verifarma-challenge/blob/main/database/seeders/DatabaseSeeder.php)

10. Todo el codigo fuente de la app esta en <root>/src excepto <root>/test, <root>/database/migrations y <root>/database/seeders. Se quito todo lo de <root>/app default de laravel para mayor simplicidad
    [VER LARAVEL BOOTSTRAP](https://github.com/eliasnoya/verifarma/blob/main/bootstrap/app.php)
