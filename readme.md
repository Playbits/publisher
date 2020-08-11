## The Publisher App
base_url : http://localhost:800

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

Known Issue. 

As PHP doesn't support concurrency the application breaks while pushing data to topic url with the same base_url

we can bypass this by deployment with php-fpm using fastcgi.