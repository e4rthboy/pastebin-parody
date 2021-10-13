# Pastebin Parody
Pastebin Parody is a project that imitates [pastebin.com](https://pastebin.com) website. It is based on [Yii2 Framework](https://www.yiiframework.com/) and PHP 7.4 version.

# Installation

### Prerequisites
- Docker CE, Docker-Compose
- Make

## 1. Deploying development environment
### 1.1 Docker containers management

When preparing the project for the first time, you need to copy the Apache2 and MySQL configurations to the laradock directory:
```
$ cp -r utils/config/* ../laradock
```

To build containers, run the `$ make build` script from root of the project. It may take quite a long time before the necessary Docker images will be built.

To start containers, just run the `$ make run` script from root of the project.

To work with the project console (launching Yii commands, console commands, etc.), just run
script `$ make bash`. 

In this case, you will be taken to the console of the container *workspace* under the user *laradock*, in the subdirectory
`/var/www`. For further work with the project, you will have to launch scripts from this subdirectory.

To stop containers, run the command `$ make stop`.

### 1.2 Database creation

Firstly you need to run `$ make mysql_shell` script, that will take you to MySQL Shell environment.

After that execute this command:
```
mysql -u root -p < /docker-entrypoint-initdb.d/createdb.sql
```
This command creates two databases: `pastebin_parody_db` and `pastebin_parody_test_db` (to execute autotests):

Default *username:password* combination is a *root:root*.

## 2. Project initialization
### 2.1 Yii Framework deployment

In the project directory (make sure you are in *workspace* container) you have to run these commands:

- *Dependencies installation*
```
composer install --prefer-dist --dev
```

- *Initialization of the project local folders*
```
./init --env=Development --overwrite=y
```

- *Applying migrations*
```
./yii migrate/up --interactive=0
```

- *Initialization of initial data*
```
./yii app/init
```

- *Loading fixtures*
```
./yii fixture/load --interactive=0 "*"
```

### 2.2 Access to the site through a local browser

To setup the access to the project through a browser, add the following correspondence to the `/etc/hosts` file of your machine:

```
127.0.0.1   pastebin-parody.local
```

To access the admin section use this URL:
```
http://pastebin-parody.local/admin
```

Admin credentials:
```
Login: admin
Password: secret123
```
