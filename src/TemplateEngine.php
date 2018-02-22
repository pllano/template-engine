<?php
/**
 * This file is part of the Adapter Template Engine
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/pllano/template-engine
 * @version 1.0.1
 * @package pllano.template-engine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Pllano\Adapter;
 
use Pllano\Adapter\Renderer\PhpRenderer;
use Pllano\Adapter\Renderer\Arhone\Template as Arhone;
use Pllano\Adapter\Renderer\WebSun\Template as WebSun;
// use Pllano\Adapter\Renderer\Twig;
// use Pllano\Adapter\Renderer\Blade;
// use Pllano\Adapter\Renderer\Smarty;
// use Pllano\Adapter\Renderer\Dwoo;
// use Pllano\Adapter\Renderer\Fenom;
// use Pllano\Adapter\Renderer\Mustache;
// https://packagist.org/packages/latte/latte

// --- use Pllano\Adapter\Renderer\Volt;
// https://packagist.org/packages/liquid/liquid
// https://github.com/feulf/raintpl3
// https://github.com/FoilPHP/Foil
// https://github.com/Talesoft/tale-pug

// https://packagist.org/packages/projek-xyz/slim-plates
// https://github.com/EFTEC/BladeOne
// https://packagist.org/packages/pagekit/razr
// https://github.com/dermatthes/text-template

// !! item !!
// ?? item ??
// $$ item $$
// ## item ##
// @@ item @@
// ** item **
// ^^ item ^^
// ( item )
// (( item ))
// { item }
// {{ item }}
// [ item ]
// [[ item ]]
// html //
/* html */

class TemplateEngine
{
    private $config;
	private $package;
    protected $options;
    protected $loader;
    protected $render;
    protected $data;
    protected $template_engine = 'phprenderer';
    protected $renderer;
    protected $template;
    protected $install = true;
    protected $vendor = 'PhpRenderer';
 
    public function __construct($config = [], $package = [], $template = null, $vendor = null)
    {
        // Подключаем конфиг из конструктора
        if(isset($config)) {
            $this->config = $config;
        }
        if(isset($package)) {
            $this->package = $package;
        }
        if(isset($vendor)) {
            if (class_exists($vendor)) {
                $this->vendor = $vendor;
            }
        }
        if(isset($template)) {
            $this->template = $template;
        } else {
            $this->template = $this->config['template']['front_end']['themes']['template'];
        }
        // Подключаем конфиг из конструктора
        if(isset($config['settings']["install"]["status"])) {
            $this->install = $config['settings']["install"]["status"];
        }
        // Получаем название шаблонизатора
        if (isset($this->config['template']['front_end']['template_engine'])) {
            $this->template_engine = strtolower($this->config['template']['front_end']['template_engine']);
        }
 
        $this->renderer();
 
    }
 
    public function renderer()
    {
        $themes = $this->config['template']['front_end']['themes'];
		print_r($themes);
        $cache = false;
        $strict_variables = false;

		$template_dir = null;
		if (file_exists($themes['dir']."".$themes['templates']."/".$this->template."/layouts")) {
            $template_dir = $themes['dir']."".$themes['templates']."/".$this->template."/layouts";
		} elseif (file_exists($themes['dir']."".$themes['templates']."/".$this->template."/layout")) {
            $template_dir = $themes['dir']."".$themes['templates']."/".$this->template."/layout";
		} elseif (file_exists($themes['dir']."".$themes['templates']."/".$this->template)) {
		    $template_dir = $themes['dir']."".$themes['templates']."/".$this->template;
		} elseif (file_exists($themes['dir']."/".$this->template)) {
		    $template_dir = $themes['dir']."/".$this->template;
		}

        if ($this->install != null) {
            if (isset($this->template_engine)) {
                $template_engine = strtolower($this->template_engine);
                if ($template_engine == 'twig') {
 
                    if (isset($this->config['template']['front_end']['cache'])) {
                        if ((int)$this->config['template']['front_end']['cache'] == 1) {
                            $cache = __DIR__ .''.$this->package['twig.twig']['settings']['cache_dir'];
                            if (!file_exists($cache)) {mkdir($cache, 0777, true);}
                            $strict_variables = $this->package['twig.twig']['settings']['strict_variables'];
                        }
                    }
                    $loader = new \Twig_Loader_Filesystem($template_dir);
                    $this->renderer = new \Twig_Environment($loader, ['cache' => $cache, 'strict_variables' => $strict_variables]);
 
                } elseif ($template_engine == 'blade') {
 
                    $this->renderer = new Blade($template_dir, $this->package['blade.blade']['settings']['cache_dir']);
 
                } elseif ($template_engine == 'smarty') {
 
                    $this->renderer = new \Smarty();
                    $this->renderer->setTemplateDir($template_dir);
                    if (isset($this->config['template']['front_end']['cache'])) {
                        if ((int)$this->config['template']['front_end']['cache'] == 1) {
                            if (isset($this->package['smarty.smarty']['settings']['cache_dir'])) {
                                $this->renderer->setCacheDir($this->package['smarty.smarty']['settings']['cache_dir']);
                            }
                        }
                    }
                    if (isset($this->config['template']['smarty']['compile_dir'])) {
                        $this->renderer->setCompileDir($this->package['smarty.smarty']['settings']['compile_dir']);
                    }
                    if (isset($this->config['template']['smarty']['plugins_dir'])) {
                        $this->renderer->addPluginsDir($this->package['smarty.smarty']['settings']['plugins_dir']);
                    }
 
                } elseif ($template_engine == 'mustache') {
 
                    $this->renderer = new \Mustache_Engine($this->package['mustache.mustache']['settings']);
 
                } elseif ($template_engine == 'phprenderer') {
 
                    $this->renderer = new PhpRenderer($template_dir);
 
                } elseif ($template_engine == 'dwoo') {
                
                    $this->renderer = new \Dwoo\Core(); // Create a Dwoo core object
                    $this->renderer->setCompileDir($this->package['dwoo.dwoo']['settings']['compile_dir']); // Folder to store compiled templates
                    $this->renderer->setTemplateDir($template_dir); // Folder containing .tpl files
                     
                } elseif ($template_engine == 'fenom') {
 
                    $options = [];
                    if($this->package['fenom.fenom']['settings']['disable_cache'] == 1){
                        $options['disable_cache'] = true;
                    }
                    if($this->package['fenom.fenom']['settings']['force_compile'] == 1){
                        $options['force_compile'] = true;
                    }
                    if($this->package['fenom.fenom']['settings']['compile_check'] == 1){
                        $options['compile_check'] = true;
                    }
					$cache = __DIR__ .''.$this->package['fenom.fenom']['settings']['cache_dir'];
                    if (!file_exists($cache)) {mkdir($cache, 0777, true);}
                    //$this->renderer = new \Fenom(new \Fenom\Provider($template_dir));
                    //$this->renderer->setCompileDir($cache);
                    //$this->renderer->setOptions($options);
                    $this->renderer = \Fenom::factory($template_dir, $cache, $options);
                     
                } elseif ($template_engine == 'websun') {
                
                    $this->renderer = new WebSun($this->package['websun.websun']['settings']);
                     
                } elseif ($template_engine == 'arhone') {
                
                    $this->renderer = new Arhone($this->package['arhone.arhone']['settings']);
                     
                } else {
				    // Если подключается шаблонизатор для которого нет стандартной адаптации
					// Шаблонизатору передается конфигурация из пакета
					$template_package = [];
					if (isset($this->config['template']['front_end']['template_package'])) {
					    $template_package = $this->config['template']['front_end']['template_package'];
						$this->renderer = new $this->vendor($this->package[$template_package]['settings']);
					} else {
					    // Если конфигурация не найдена
					    $this->renderer = new $this->vendor();
					}
                }
            }
            
        } else {
            $loader = new \Twig_Loader_Filesystem($this->config['template']['front_end']['themes']['dir']."/".$themes['templates']."/install");
            $this->renderer = new \Twig_Environment($loader, ['cache' => false, 'strict_variables' => false]);
        }
 
        return $this->renderer;
 
    }
 
    public function render($render = null, $data = [])
    { 
        if(isset($render)) {
            $this->render = $render;
        }
        if(isset($data)) {
            $this->data = $data;
        } 
        if ($this->install != null) {    
            if (isset($this->template_engine)) {
                $template_engine = strtolower($this->template_engine);
                if ($template_engine == 'twig') {
 
                    return $this->renderer->render($this->render, $this->data);
 
                } elseif ($template_engine == 'blade' || $template_engine == 'phprenderer') {
 
                   return $this->renderer->render([], $this->render, $this->data);
 
                } elseif ($template_engine == 'smarty') {
 
                    $this->renderer->assign($this->data);
                    return $this->renderer->fetch($this->render);
 
                } elseif ($template_engine == 'mustache') {
 
                    return $this->renderer->render($this->render, $this->data);
 
                } elseif ($template_engine == 'dwoo') {
 
                    return $this->renderer->get($this->render, $this->data);
 
                } elseif ($template_engine == 'fenom') {
 
                    return $this->renderer->fetch($this->render, $this->data);
 
                } elseif ($template_engine == 'websun') {
 
                    return $this->renderer->render($this->render, $this->data);
 
                }  elseif ($template_engine == 'arhone') {
 
                    return $this->renderer->render($this->render, $this->data);
 
                } else {
 
                    if(method_exists($this->renderer,'render')) {
                        return $this->renderer->render($this->render, $this->data);
                    } elseif(method_exists($this->renderer,'fetch')) {
                        return $this->renderer->fetch($this->render, $this->data);
                    } elseif(method_exists($this->renderer,'get')) {
                        return $this->renderer->get($this->render, $this->data);
                    } else {
                        return null;
                    }
 
                }
            } else {
                $this->file_extension();
            }
        } else {
            return $this->renderer->render($this->render, $this->data);
        }
    }
 
    public function file_extension()
    {
        if(isset($this->render)) {
            if (strripos($this->render, '.twig') === true || strripos($this->render, '.html') === true) {
                $this->template_engine = 'twig';
            } elseif (strripos($this->render, '.smarty') === true || strripos($this->render, '.tpl') === true) {
                $this->template_engine = 'smarty';
            } elseif (strripos($this->render, '.blade') === true) {
                $this->template_engine = 'blade';
            } elseif (strripos($this->render, '.mustache') === true) {
                $this->template_engine = 'mustache';
            } elseif (strripos($this->render, '.dwoo') === true) {
                $this->template_engine = 'dwoo';
            } elseif (strripos($this->render, '.fenom') === true) {
                $this->template_engine = 'fenom';
            } elseif (strripos($this->render, '.phtml') === true || strripos($this->render, '.php') === true) {
                $this->template_engine = 'phprenderer';
            } elseif (strripos($this->render, '.websun') === true) {
                $this->template_engine = 'websun';
            } elseif (strripos($this->render, '.arhone') === true) {
                $this->template_engine = 'arhone';
            }
 
            if(isset($this->template_engine)) {
                $this->renderer();
            }
        }
    }
 
}
 