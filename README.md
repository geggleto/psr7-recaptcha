# psr7-recaptcha

## Configuration

This middleware helps you guard your application with ReCaptcha.
You can use it as a middleware or even just as an object in your service layer

This package uses the "google/recaptcha" package to handle the bulk of the lifting.
   
## Usage

The class is invokable

```php
$container[Recaptcha::class] = new \ReCaptcha\ReCaptcha($key);

$recaptcha = new \Geggleto\Service\Captcha($container[Recaptcha::class]);

//As Middleware
$app->post('/login', 'Auth:login')->add($recaptcha);

//Anywhere else
$recaptcha->verify($response, $ip);

```

```php
// Slim 3 Example
// Container File
//...
use Geggleto\Service\Captcha;
use ReCaptcha\ReCaptcha;
//...
    Captcha::class => function ($c) {
        return new Captcha($c[ReCaptcha::class]);
    },
    ReCaptcha::class => function ($c) {
        return new ReCaptcha($c['captcha']['key']);
    },
    'errorHandler' => function ($c) { //CUSTOM Error Handler
        return function (\Slim\Http\Request $request, \Slim\Http\Response $response, $exception) use ($c) {
            return $c['view']->render($response, "errors/servererror.twig", ["exception" => $exception]);
        };
    }    
//...

//In routes.php

//Grab the instance from the Container
$captcha = $app->getContainer()->get(Captcha::class);

//Applying it to routes
$app->post('/signin', Home::class.':processLogin')->add($captcha);
$app->post('/forgot', Home::class.':processForgot')->add($captcha);
$app->post('/recover/{key}', Home::class.':processRecover')->add($captcha);

```
 
 
 
