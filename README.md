# Silex Scaffolding

[![Latest Stable Version](https://img.shields.io/packagist/v/cekurte/silex-scaffolding.svg?style=flat-square)](https://packagist.org/packages/cekurte/silex-scaffolding)
[![License](https://img.shields.io/packagist/l/cekurte/silex-scaffolding.svg?style=flat-square)](https://packagist.org/packages/cekurte/silex-scaffolding)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/279f673f-284b-4463-8b83-a268b938a5c5/mini.png)](https://insight.sensiolabs.com/projects/279f673f-284b-4463-8b83-a268b938a5c5)

- Just a simple scaffolding project to Silex MicroFramework.
- **contribute with this project**!

## Creating a new Project

The package is available on [Packagist](http://packagist.org/packages/cekurte/silex-scaffolding).
The source files is [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) compatible.
Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.

```shell
composer create-project cekurte/silex-scaffolding path/
```

## Documentation

The directory structure is the following:

- **app/**: this directory contains one file that permit you to run your app in console mode;
- **bin/**: it stores the files that run with the git hooks;
- **build/**: used by phpunit to build a report of source code coverage (see the [phpunit.xml.dist](https://github.com/jpcercal/silex-scaffolding/blob/master/phpunit.xml.dist));
- **config/**: this directory contains the configuration files of your all service providers. And contains too the app.php and app.console.php this files are used to create a new Silex Application and register your providers;
- **public/**: it is your public folder (in other installations, this directory can be called as htdocs, www, and more);
- **src/**: Your must put your source files here, by default only one namespace was created called [App](https://github.com/jpcercal/silex-scaffolding/tree/master/src/App) (see the [composer.json](https://github.com/jpcercal/silex-scaffolding/blob/master/composer.json) file to register other namespaces);
- **storage/**: it stores the log, cache, doctrine (migrations and proxies) and internationalization files;
- **test/**: in this directory you must put your php unit test files, by default only namespace was created called [App\Test](https://github.com/jpcercal/silex-scaffolding/tree/master/test/App) (see the [composer.json](https://github.com/jpcercal/silex-scaffolding/blob/master/composer.json) file to register other namespaces);
- **vendor/**: used by composer to manage the dependencies of your project;

This project use of environment variables to setup the service providers, then, before of all you must copy the content of [.env.example](https://github.com/jpcercal/silex-scaffolding/blob/master/.env.example), create a file called .env, paste the content copied and adjust the values of variables.

This project is compatible with PHP built-in server, to start the server you must run the following command:

```shell
php -S 0.0.0.0:8000 -t public/ public/index.php
```

Thanks guys! If you liked of this library, give me a *star* and contribute with this project **=)**.

Contributing
------------

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Make your changes
4. Run the tests, adding new ones for your own code if necessary (`vendor/bin/phpunit`)
5. Commit your changes (`git commit -am 'Added some feature'`)
6. Push to the branch (`git push origin my-new-feature`)
7. Create new Pull Request
