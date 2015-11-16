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
 
 
 
