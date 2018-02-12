# Pllano\Adapter\TemplateEngine
Support for popular templates engine for the Slim Framework or API Shop

Поддержка популярных шаблонизаторов для Slim Framework или API Shop
## Планируется поддержка всех популярных шаблонизаторов: 
- [`Twig`](https://github.com/twigphp/Twig) - Original - по умолчанию
- [`PhpRenderer`](https://github.com/slimphp/PHP-View) - Slim PHP-View
- [`Smarty`](https://github.com/smarty-php/smarty) - Original
- [`Blade`](https://github.com/illuminate/view) - в разработке
- [`Fenom`](https://github.com/fenom-template/fenom) - Original
- [`Dwoo`](https://github.com/dwoo-project/dwoo) - Original
- [`Mustache`](https://github.com/bobthecow/mustache.php) - Original
### Альтернативные
- [`WebSun`](https://github.com/1234ru/websun) - идет в комплекте с TemplateEngine как класс \Pllano\Adapter\Renderer\WebSun
- [`Arhone`](https://github.com/arhone/template) - идет в комплекте с TemplateEngine как класс \Pllano\Adapter\Renderer\Arhone
- Вы можете подключить свой шаблонизатор
## Использование
### Выбор шаблонизатора
Для переключения шаблонизатора достаточно передать его название конструктору в массиве конфигурации или изменить в файле конфигурации
```php
$settings['template']['front_end']['template_engine'] = 'twig';
// или: phprenderer, smarty, dwoo, blade, mustache, fenom
```
Второй метод автоматический. Если не определен шаблонизатор в `$settings['template']['front_end']['template_engine']` то `TemplateEngine` будет определять шаблонизатор по расширению файла
```php
$render = 'file_name.html'; // = twig
// .php или .phtml = phprenderer
// .html или .twig или .twig.tpl или .twig.* = twig
// .blade или .blade.php или .blade.* = blade
// .smarty или .smarty.php или .smarty.tpl или .smarty.* = smarty
// .mustache или .mustache.php или .mustache.tpl или .mustache.* = mustache
// .dwoo или .dwoo.php или .dwoo.tpl или .dwoo.* = dwoo
// .websun или .websun.php или .websun.tpl или .websun.* = websun
// .arhone или .arhone.php или .arhone.tpl или .arhone.* = arhone
```
### Конфигурация для шаблонизаторов
```php
require __DIR__ . '/../vendor/autoload.php';
 
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Pllano\Adapter\TemplateEngine as Template;
 
// Конфигурация
$settings = json_decode(file_get_contents(__DIR__ . '/../../config.json'), true);
 
$app = new \Slim\App($settings);
 
$container = $app->getContainer();
 
$container['view'] = function () {
    $settings = json_decode(file_get_contents(__DIR__ . '/../../config.json'), true);
    // Изменить после получения конфигурации
    $settings['template']['front_end']['template_engine'] = 'twig';
    // или: blade, smarty, mustache, phprenderer, volt, dwoo
    return new Template($settings);
};
 
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
 
    // Название файла для рендера
    $render = 'file_name.html';
 
    // Массив с контентом для шаблонизатора
    $data = [
        'name' => $args['name']
    ];
 
    // Рендерим
    return $this->view->render($response, $render, $data);
 
});

$app->run();
```
## Вывод в шаблоне

### Twig, Mustache
``` html
<!DOCTYPE html>
<html lang="en">
    <body>
        {{ name }}
    </body>
</html>
```
### Smarty
``` html
<!DOCTYPE html>
<html lang="en">
    <body>
        { $name }
    </body>
</html>
```
### Fenom
``` html
<!DOCTYPE html>
<html lang="en">
    <body>
        {$name}
    </body>
</html>
```
### Blade
``` html
<!DOCTYPE html>
<html lang="en">
    <body>
        {{ $name }}
    </body>
</html>
```
### PhpRenderer
```
<!DOCTYPE html>
<html lang="en">
    <body>
        <?php echo $name; ?>
    </body>
</html>
```
## Конфигурация `config.json`
```json
{
    "settings": {
        "debug": 0,
        "displayErrorDetails": 0
    },
    "template": {
        "front_end": {
            "template_engine": "twig",
            "themes": {
                "template": "mini-mo",
                "templates": "templates",
                "dir_name": "\/..\/themes"
            }
        },
        "back_end": {
            "template_engine": "twig",
            "themes": {
                "template": "admin",
                "templates": "templates",
                "dir_name": "\/..\/themes"
            }
        },

        "twig": {
            "cache_state": 0,
            "strict_variables": 0,
            "cache_dir": "\/..\/cache\/_twig_cache"
        },
        "smarty": {
            "cache_state": 0,
            "cache_dir": "\/..\/cache\/_smarty_cache",
            "compile_dir": "",
            "plugins_dir": ""
        },
        "blade": {
            "cache_state": 0,
            "strict_variables": 0,
            "cache_dir": "\/..\/cache\/_twig_cache"
        },
        "fenom": {
            "cache_state": 0,
            "cache_dir": "\/..\/cache\/_fenom_cache",
            "disable_cache": 0,
            "force_compile": 0,
            "compile_check": 0
        },
        "mustache": {
            "cache_state": 0
        },
        "dwoo": {
            "cache_state": 0
        },
        "websun": {
            "cache_state": 0
        },
        "arhone": {
            "cache_state": 0
        }
    }
}
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

