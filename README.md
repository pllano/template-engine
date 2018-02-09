# templateProcessor
Поддержка популярных шаблонизаторов для Slim Framework или API Shop
## Поддерживаемые шаблонизаторы: 
- `Twig`
- `Smarty`
- `Blade`
- `Mustache`
- `PhpRenderer`

## Использование
### Twig
```php
require __DIR__ . '/../vendor/autoload.php';
 
use Slim\Http\Request;
use Slim\Http\Response;
 
// Конфигурация Slim
$settings = [
    "debug" => true,
    "displayErrorDetails" => true
];
 
$app = new \Slim\App($settings);
 
$container = $app->getContainer();
 
$container['view'] = function () {
    // Конфигурация для шаблонизаторов
    $config = [
        "template" => [
            "front_end" => [
                "processor" => "blade",
                "themes" => [
                    "template" => 'template_name',
                    "templates" => 'templates',
                    "dir" => __DIR__ . '/../../../../themes'
                ]
            ],
            "twig" => [
                    "cache" => [
                    "state" => true,
                    "dir" => __DIR__ . '/cache/_twig_cache'
                ],
                "strict_variables" => true
            ]
        ]
    ];
    // Адаптер (Вы можете написать свой адаптер)
    $vendor = '\Pllano\Adapter\TemplateProcessor';
    // Название текущего шаблона
    $template = '';
    return new $vendor($config, $template);
};
 
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    // Название файла для рендера
    $render = 'file_name.twig';
    // Массив с контентом для шаблонизатора
    $view = [
        'name' => $args['name']
    ];
    // Рендерим
    return $this->view->render($response, $render, $view);
});

$app->run();
```
В файле шаблона `file_name.twig`
``` html
<!DOCTYPE html>
<html lang="en">
    <body>
        {{ name }}
    </body>
</html>
```
### Blade
```php
require __DIR__ . '/../vendor/autoload.php';
 
use Slim\Http\Request;
use Slim\Http\Response;
 
// Конфигурация Slim
$settings = [
    "debug" => true,
    "displayErrorDetails" => true
];
 
$app = new \Slim\App($settings);
 
$container = $app->getContainer();
 
$container['view'] = function () {
    // Конфигурация для шаблонизаторов
    $config = [
        "template" => [
            "front_end" => [
                "processor" => "blade",
                "themes" => [
                    "template" => 'emplate_name',
                    "templates" => 'templates',
                    "dir" => __DIR__ . '/../../../../themes'
                ]
            ],
            "blade" => [
                "cache" => [
                    "state" => true,
                    "dir" => __DIR__ . '/cache/_blade_cache'
                ]
            ]
        ]
    ];
    // Адаптер (Вы можете написать свой адаптер)
    $vendor = '\Pllano\Adapter\TemplateProcessor';
    // Название текущего шаблона
    $template = '';
    return new $vendor($config, $template);
};
 
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    // Название файла для рендера
    $render = 'file_name.php';
    // Массив с контентом для шаблонизатора
    $view = [
        'name' => $args['name']
    ];
    // Рендерим
    return $this->view->render($response, $render, $view);
});

$app->run();
```
В файле шаблона `file_name.php`
``` html
<!DOCTYPE html>
<html lang="en">
    <body>
        {{ $name }}
    </body>
</html>
```
## Поддержка, обратная связь, новости

Общайтесь с нами через почту open.source@pllano.com

Если вы нашли баг в работе templateProcessor загляните в
[issues](https://github.com/pllano/template-processor/issues), возможно, про него мы уже знаем и
чиним. Если нет, лучше всего сообщить о нём там. Там же вы можете оставлять свои
пожелания и предложения.

За новостями вы можете следить по
[коммитам](https://github.com/pllano/template-processor/commits/master) в этом репозитории.
[RSS](https://github.com/pllano/template-processor/commits/master.atom).

Лицензия API Shop
-------

The MIT License (MIT). Please see [LICENSE](https://github.com/pllano/template-processor/blob/master/LICENSE) for more information.

