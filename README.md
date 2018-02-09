# templateProcessor
Поддержка популярных шаблонизаторов для API Shop
## Поддерживаемые шаблонизаторы: 
- `Twig`
- `Smarty`
- `Blade`
- `Mustache`
- `PhpRenderer`

## Использование
```php
require __DIR__ . '/../vendor/autoload.php';
 
$slim_config['settings'] = [
    "debug" => true,
    "displayErrorDetails" => true
];
 
$app = new \Slim\App($slim_config);
 
$container = $app->getContainer();
$container['view'] = function () {
    // Конфигурация
    $config = [
        "template" => [
            "front_end" => [
                "processor" => "twig",
                "themes" => [
                    "template" => "template_name",
                    "templates" => "templates",
                    "dir" => "/../../themes"
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
 
$app->get('/', function (Request $request, Response $response, array $args) {
    // Название файла для рендера
    $render = 'index.twig';
    // Массив с контентом для шаблонизатора
    $view = [];
    // Рендерим
    return $this->view->render($response, $render, $view);
});

$app->run();
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

