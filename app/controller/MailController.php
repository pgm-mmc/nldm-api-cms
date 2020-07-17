<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class MailController
 * 
 * @package \App\Controlller
 */
class MailController
{
    public function send(Request $request, Response $response)
    {
        $param  = $request->getQueryParams();

        if (isset($param['first_name']) && isset($param['last_name']) && isset($param['email']) && isset($param['message'])) {
            $to = "markkirshner.m.chico@smretail.com";
            $subject = "Jinkee Cosmetics (DEV)";
            $msg = "Name: " . $param['first_name'] . " " . $param['last_name'] . "\n" .
                "Mobile: " . $param['mobile'] . "\n" .
                "Email: " . $param['email'] . "\n" .
                "Message: " . $param['message'] . "\n";
            $headers = "From: Hello <hello@jinkeecosmetics.com>" . "\r\n";
            //"CC: rhyanmanlangit@gmail.com";

            // send email
            mail($to, $subject, $msg, $headers);

            return $response->withJson(['status' => true]);
        }

        return $response->withJson(['status' => false]);
    }
}