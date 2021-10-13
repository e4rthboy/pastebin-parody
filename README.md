# Pastebin Parody
Pastebin Parody is a project that imitates [pastebin.com](https://pastebin.com) website. It is based on [Yii2 Framework](https://www.yiiframework.com/) and PHP 7.4 version.

# Installation

### Prerequisites
- Docker CE, Docker-Compose
- Make

## 1. Deploying development environment
### 1.1 Docker containers management

#### Preparing the project for the first time:

- Copy the Apache2 and MySQL configurations to the laradock directory:
```
$ cp -r utils/config/* laradock
```

- Copy the `.env.example` file to `.env`:
```
$ cp laradock/.env.example laradock/.env
```

- Run the `$ make build` script from root of the project to build Docker containers.

It may take quite a long time before the necessary Docker images are built.

---

To start containers, run the `$ make run` script from root of the project.

To work with the project console (launching Yii commands, console commands, etc.), simply run
script `$ make bash`. 

After that you will be taken to the console of the container *workspace* under the user *laradock*, in the subdirectory
`/var/www`. For further work with the project, you will have to launch scripts from this subdirectory.

To stop containers, run the command `$ make stop`.

### 1.2 Database creation

Firstly you need to run `$ make mysql_shell` script, that will take you to MySQL Shell environment.

After that execute this command:
```
mysql -u root -p < /docker-entrypoint-initdb.d/createdb.sql
```
This command creates two databases: `pastebin_parody_db` and `pastebin_parody_test_db` (for the autotests execution):

Default *username:password* combination is a *root:root*.

## 2. Project initialization
### 2.1 Yii Framework deployment

In the project directory (make sure you are in *workspace* container console environment) you have to run these commands:

- *Dependencies installation*
```
$ composer install --prefer-dist --dev
```

- *Initialization of the project local configuration*
```
$ php init --env=Development --overwrite=y
```

- *Applying migrations*
```
$ php yii migrate/up --interactive=0
$ php yii_test migrate/up --interactive=0
```

- *Initialization of initial data*
```
$ php yii app/init
```

- *Loading fixtures*
```
$ php yii fixture/load --interactive=0 "*"
```

### 2.2 Access to the site through a local browser

To setup access to the project through a browser, add the following correspondence to the `/etc/hosts` file of your machine:
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
Password: secret
```
