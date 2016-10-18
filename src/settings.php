<?php
$c = [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ],
];

$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $data = [
            'status' => $exception->getCode(),
            'error' => true,
            'msg' => $exception->getMessage()
        ];
        return $c['response']->withStatus($exception->getCode() != 0 ? $exception->getCode(): 500)
                             ->withHeader('Content-Type', 'application/json')
                             ->write(json_encode($data));
    };
};
return $c;
