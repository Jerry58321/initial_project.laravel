<?php

namespace App\Traits;

use Notification;

trait ServiceTrait
{
    /**
     * @param Exception $e
     */
    protected function sentErrorMsgToSlack(\Exception $e)
    {
        $url = request()->server('REQUEST_URI');
        $title = "*" . date('Y-m-d H:i:s') . "*  " . $url . PHP_EOL;
        $codeMsg = 'Line:' . $e->getLine() . ' ' . $e->getFile() . PHP_EOL;
        $body = urldecode($e->getMessage());

        $send = [
            'title' => $title,
            'body' => $codeMsg . $body
        ];

        $when = \Carbon\Carbon::now()->addSeconds(5);
        Notification::send(
            new \App\Notifications\Route\RouteForSlack(),
            (new \App\Notifications\SlackErrorMsgPublish($send))->delay($when)
        );
    }
}