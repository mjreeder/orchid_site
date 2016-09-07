# Slim Framework 3 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

That's it! Now go build something cool.

### Notes ###

The 'docs' folder is the 'dist' folder from [https://github.com/jensoleg/swagger-ui](https://github.com/jensoleg/swagger-ui), a cleaner and more mobile friendly fork of the original Swagger-UI.


Within the 'docs/index.html' is a line that says:
```javascript
var url = window.location.toString().replace(/\/*#?.*/, '/orchid_site/swagger.php');
```
It's purpose is to tell the frontend where the Swagger JSON is at. Upon web host changes, this may need modified.