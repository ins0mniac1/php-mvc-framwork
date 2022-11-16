<p>
    <h1>Tiny PHP 8 MVC Framework</h1>
</p>


## Introduction

PHP MVC Framework is done only for testing, learning and showing purposes. It's not recommended for large projects. It can be used for small projects (portfolio, landings etc.)
Only installed package is:
```bash
"vlucas/phpdotenv": "^5.5"
```

Everything else is written from scratch!

## Features

- PHP >= v8.0 are supported;
- Work with MySQL db;
- Easy setup, no additional configuration;
- Easy to use.

## Official Documentation

- [Installation](#install);
- [How to use](#how-to-use);
- [Global methods](#global-methods);
- [Commands](#commands).


## Installation
<span class="anchor" id="install"></span>

After the application is cloned, You must run  
```bash 
$ composer install 
```
You must create .env file in root folder with keys from .env.example


Application can be started by command
```bash 
$ php mvc.php start
```

> **NOTE :** To start the project it's necessary to provide your database credentials in .env file and run the db server. 

Now you can run the application in browser on http://localhost:8001 (if you are not changed the appPort value in .env)

## How To Use
<span class="anchor" id="how-to-use"></span>

The framework is closer to Laravel as type of work and usage. 
You can create controllers, models and seeders with command (see [Commands](#commands)),
registering routes and assign registered routes to controller's methods in routes/routes.php, use middlewares, request and response classes.
Framework include base Validator that can validate by the rules in Core/Validator/RulesAndMessages class.

The usage of every functionality is shown in example controllers, models, seeders and configuration files.

### Controllers
The controllers can be found in Http/Controllers folder. Every custom controller should extend base class Controller.
In controllers You can:
- register middleware in constructor or in method by new instance of middleware or alias registered in config/middlewares.php -> $this->middleware('auth') OR $this->middleware(new AuthMiddleware()) will activate middleware. You can provide only one method that can be guarded by middleware, i.e. in constructor you can register middleware with $this->middleware('auth', 'store,) OR $this->middleware(new AuthMiddleware('store')) and this will restrict access of not-logged users to the "store" method; 
- change base layout for whole controller or only for some method with $this->setLayout('path-to-layout');
- render view file for every method with $this->render('folder/subfolder/viewfile') (for example - you can render login view file with $this->render('auth/login') and this will load Resources/views/auth/login.inso.php file);
- can load new instances of Models, set their properties and manage them,
- can provide variables to view files;
- and many others stuffs.


### Models
Models can be  found in Models/ folder. Every custom model should extend base Core/Model class. Every model must have properties named such as columns in db for the current table.

In base usage, The classname of Model will be the table name in database. This can be changed by protected property $table, 
i.e. if You want Profile model to be responsible for users_profiles table in db, you must rewrite the property in Profile model - protected static string $table = 'users_profiles';

Every model have access to create() and update() methods.
If you want to insert data in db table, you must:

1. Load data for the given model with $model->loadData($data), where $model is instance of Model, $data is the data that you want to insert;
2. Call $model->create() method, which can return 'true' if inserting is successful or PDO exception message if inserting is not successful.


> **NOTE :** The migrations are not automatically created. You must create migration file (examples are in database/migrations) and every migration file must begin with m00XXX_name_of_class  and must be class extends database/Migration.php

### Middlewares
Middlewares can be found in Http/Middlewares/ folder and every middleware must extend Core/Middlewares/BaseMiddleware class. 

At the current moment Middlewares intercept only Request (before middlewares in Laravel) and can't intercept Response. 
At the current moment Middlewares can be registered only in controllers (and not in Router).

### Routes and Router
Every route should be registered in routes/routes.php:

```bash
router()->get('/login', [LoginController::class, 'index']);
router()->post('/login', [LoginPostController::class, 'index']);
router()->get('/', 'home'); (will return view file with name home.inso.php in Resources/views/ folder)
```

### Views
All views are in Resources/views/ folder and are with extension .inso.php (Why not?)
Every view file extend Resources/views/lauouts/main.inso.php file as replace {{content}} with view file content

You can set custom title for every view file (as is shown in Resources/views/auth/profile.inso.php) with:

```bash
<?php
setPageTitle('cool-title-only-for-this-page');
?>
```

You can use form and form fields (as is shown in Resources/views/contact.inso.php)

```bash
<?php $form = Form::begin('', 'w-50 mx-auto mt-5') ;?>
<?php $form->setErrors($errors) ;?>
<?= $form->inputField($model, 'Subject', 'subject',  'text') ;?>
<?= $form->inputField($model, 'Enter your email', 'sender',  'email') ;?>
<?= $form->textareaField($model,  'Message', 'about') ;?>
<?= $form->button('Send', 'submit', 'btn btn-primary') ;?>
<?= Form::end() ;?>
?>
```


## Global methods
<span class="anchor" id="global-methods"></span>

Global methods are function, that can be used everywhere in application:

To start application.
```bash
startApp($rootPath, $routes = null, bool $shouldRun = true)
```

Return provided in startApp() root path 
```bash
rootPath()
```

Get configuration files in config/ folder
```bash
config($relativePath = '', $rootPath = null)
```
IE
```bash
config('app')
```
will return config/app.php and
```bash
config('app.db')
```
will return db array in config/app.php



Get current instance of Core/Application.php
```bash
app()
```

Get current instance of Core/Request.php
```bash
request()
```

Get current instance of Core/Response.php
```bash
response()
```

Redirect to provided path
```bash
redirect(string $path = '/')
```

Get current instance of Core/DB/Database.php
```bash
db()
```

Get current instance of Core/View.php
```bash
view()
```

Set title property of Core/View.php
```bash
setPageTitle()
```
Get title property of Core/View.php
```bash
getPageTitle()
```

Get current instance of Core/Router.php
```bash
router()
```

Get current instance of Core/Session.php
```bash
session()
```

Set flash messages in Core/Session.php
```bash
setFlash($key, $value)
```

Get flash messages from Core/Session.php
```bash
getFlash($key)
```

Get authenticated user (instance of Models/Auth/User.php) or null
```bash
auth()
```

Set current action to property of Core/Application.php
```bash
setAction(string $action)
```

Get current action from Core/Application.php
```bash
getAction()
```

Get is current user guest
```bash
isGuest()
```

Get is current user authenticated
```bash
isAuth()
```

Dump and die - show dumped data
```bash
dd(...$data)
```


## Commands
<span class="anchor" id="commands"></span>
The application provides small set of commands (just to show that I can code it by myself)

Every command must start with php mvc.php

Start application with:
```bash
$ php mvc.php start
```

Migrate all not-applied migrations in database/migration:
```bash
$ php mvc.php migrate
```

Drop all applied migrations in database/migration:
```bash
$ php mvc.php drop
```

Drop all applied migrations in database/migration and apply them again :
```bash
$ php mvc.php fresh
```

Run $php mvc.php migrate and seed all data in seeders called (orderly) in database/seeders/DataBaseSeeder:
```bash
$ php mvc.php seed
```

Create new Model class in Models/ Folder
```bash
$ php mvc.php model Directory/ModelName
```

Example 1:

```bash
$ php mvc.php model User/Profile
```
This command will create Profile.php in Models/User/ folder


Example 2:

```bash
$ php mvc.php model Post
```
This command will create Post.php in Models/ folder

Create new Controller class in Http/Controllers/ Folder
```bash
$ php mvc.php controller Directory/Controller
```
Example 1:

```bash
$ php mvc.php controller User/Profile
```
This command will create ProfileController.php in Http/Controllers/User/ folder

Example 2:

```bash
$ php mvc.php controller Home
```
This command will create HomeController.php in Http/Controllers/ folder

Create new Seeder class in database/seeders/ Folder
```bash
$ php mvc.php seeder SeederName Directory/ModelName
```
Example 1:

```bash
$ php mvc.php seeder UsersTable Auth/User
```
This command will create UsersTableSeeder.php in database/seeders/ folder

Example 2:

```bash
$ php mvc.php seeder Posts Post
```
This command will create PostsSeeder.php in database/seeders/ folder


> **NOTE :** After seeder is created, it should be registered in DataBaseSeeder class in order you need:
> ```bash
> public function seeders(): array
>    {
>        return [
>            RoleTableSeeder::class,
>            UserTableSeeder::class,
>        ];
>    }
> ```


Get more information about all the commands:"
```bash
$ php mvc.php help
```



> **NOTE :** You can execute every command with -h or --help key and this will provide you information only for this command!
> Example 1:
> ```bash
> $ php mvc.php model -h
> ```
> will provide you information only for command responsible for model creating
> Example 2:
> ```bash
> $ php mvc.php start --help
>```
> will provide you information only for command responsible for starting the application

