# Pllano\Adapter\TemplateEngine
Support for popular templates engine for the Slim Framework or API Shop

Поддержка популярных шаблонизаторов для Slim Framework или API Shop
## Планируется поддержка всех популярных шаблонизаторов: 
- [`Twig`](https://github.com/twigphp/Twig) - Original - по умолчанию
- [`PhpRenderer`](https://github.com/slimphp/PHP-View) - Slim PHP-View
- `Blade` - Original - в разработке
- `Smarty` - Original - в разработке
- `Mustache` - в разработке
- `Volt` - в разработке
- `Dwoo` - в разработке
## Использование
Для переключения шаблонизатора достаточно передать его название конструктору в массиве конфигурации
```php
$config['template']['front_end']['template_engine'] = 'twig';
// или
$config['template']['front_end']['template_engine'] = 'blade';
// или
$config['template']['front_end']['template_engine'] = 'smarty';
// или
$config['template']['front_end']['template_engine'] = 'mustache';
// или
$config['template']['front_end']['template_engine'] = 'phprenderer';
// или
$config['template']['front_end']['template_engine'] = 'volt';
// или
$config['template']['front_end']['template_engine'] = 'dwoo';
```
### Twig
```php
require __DIR__ . '/../vendor/autoload.php';
 
use Slim\Http\Request;
use Slim\Http\Response;
use Pllano\Adapter\TemplateEngine as Template;
 
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
                "template_engine" => "twig",
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
 
    return new Template($config);
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
### Twig - Вывод в шаблоне `file_name.twig`
В файле шаблона 
``` html
<!DOCTYPE html>
<html lang="en">
    <body>
        {{ name }}
    </body>
</html>
```
### Smarty - Вывод в шаблоне `file_name.tpl`
``` html
<!DOCTYPE html>
<html lang="en">
    <body>
        { $name }
    </body>
</html>
```
### Blade - Вывод в шаблоне `file_name.php`
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

Лицензия TemplateEngine
-------

The MIT License (MIT). Please see [LICENSE](https://github.com/pllano/template-processor/blob/master/LICENSE) for more information.

