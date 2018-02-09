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
### Выбор шаблонизатора
Для переключения шаблонизатора достаточно передать его название конструктору в массиве конфигурации или изменить в файле конфигурации
```php
$settings['template']['front_end']['template_engine'] = 'twig';
// или: blade, smarty, mustache, phprenderer, volt, dwoo
```
### Конфигурация для шаблонизаторов
```php
require __DIR__ . '/../vendor/autoload.php';
 
use Slim\Http\Request;
use Slim\Http\Response;
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
### Twig - Вывод в шаблоне `file_name.html`
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
### Конфигурация `config.json`
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
				"dir_name": "\/..\/..\/themes"
			}
		},
		"back_end": {
			"template_engine": "twig",
			"themes": {
				"template": "admin",
				"templates": "templates",
				"dir_name": "\/..\/..\/themes"
			}
		},
		"twig": {
			"cache_state": 0,
			"strict_variables": 0,
			"cache_dir": "\/..\/..\/cache\/_twig_cache"
		},
		"blade": {
			"cache_state": 0,
			"cache_dir": "\/..\/..\/cache\/_blade_cache"
		},
		"smarty": {
			"cache_state": 0,
			"cache_dir": "\/..\/..\/cache\/_smarty_cache",
			"compile_dir": 0,
			"plugins_dir": 0
		},
		"mustache": {
			"cache_state": 0,
			"cache_dir": "\/..\/..\/cache\/_mustache_cache"
		},
		"volt": {
			"cache_state": 0,
			"cache_dir": "\/..\/..\/cache\/_volt_cache"
		},
		"dwoo": {
			"cache_state": 0,
			"cache_dir": "\/..\/..\/cache\/_dwoo_cache"
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

