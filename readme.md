## The Publisher App
base_url : http://localhost:800

Requirements
---
* PHP@7.3
* Composer 
* Docker and Docker-composer (optional)

Installation
```
$ composer install
```
Deployment with Docker

```
$ docker-compose up --build -d
```

Deployment with PHP
```
$ php -S localhost:8000 -t public 
OR
$ sh serve.sh
```

Test with codeception 
```
$ vendor/bin/codecept run --steps
```
Known Issue. 

As PHP doesn't support concurrency the application breaks while pushing data to topic url with the same base_url

we can bypass this by deployment with php-fpm using fastcgi.