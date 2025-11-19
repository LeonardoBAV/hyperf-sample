<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'enable' => true,
    'port' => 9500,
    'json_dir' => BASE_PATH . '/storage/swagger',
    'url' => '/swagger',
    'auto_generate' => true,
    'scan' => [
        'paths' => [BASE_PATH . '/app'],
    ],
    'processors' => [
        // users can append their own processors here
    ],
    'server' => [
        'http' => [
            'servers' => [
                [
                    'url' => 'http://127.0.0.1:9501',
                    'description' => 'Public API',

                ],
            ],
            'info' => [
                'title' => 'Hyperf Product API',
                'description' => 'This is a product API with Hyperf, to study the usage of non-blocking IO in Hyperf',
                'version' => '1.0.0',
            ],
        ],
    ],
    'html' => <<<'HTML'
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="SwaggerUI" />
    <title>SwaggerUI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist@4.5.0/swagger-ui.css" />
  </head>
  <body>
  <div id="swagger-ui"></div>
  <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@4.5.0/swagger-ui-bundle.js" crossorigin></script>
  <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@4.5.0/swagger-ui-standalone-preset.js" crossorigin></script>
  <script>
    window.onload = () => {
      window.ui = SwaggerUIBundle({
        url: '/http.json',
        dom_id: '#swagger-ui',
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIStandalonePreset
        ],
        layout: "StandaloneLayout",
      });
    };
  </script>
  </body>
</html>
HTML,
];
