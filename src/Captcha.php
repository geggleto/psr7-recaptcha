<?php
/**
 * Created by PhpStorm.
 * User: Glenn
 * Date: 2015-11-16
 * Time: 10:18 AM
 */

namespace Geggleto\Service;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReCaptcha\ReCaptcha;

class Captcha
{
    /** @var \ReCaptcha\ReCaptcha */
    protected $recaptcha;

    public function __construct (ReCaptcha $reCaptcha)
    {
        $this->recaptcha = $reCaptcha;
    }

    public function __invoke (
        ServerRequestInterface $requestInterface,
        ResponseInterface $responseInterface,
        callable $next)
    {
        $valid = $this->verify(
            $requestInterface->getParam('g-recaptcha-response'),
            $requestInterface->getServerParams()['REMOTE_ADDR']
        );

        if ($valid) {
            return $next($requestInterface, $responseInterface);
        } else {
            throw new \Exception("Captcha Failed");
        }
    }

    /**
     * @param $response
     * @param $ip
     * @return bool
     */
    public function verify($response, $ip) {

        $resp = $this->recaptcha->verify($response, $ip);
        if ($resp->isSuccess()) {
            return true;
        } else {
            return false;
        }
    }
}