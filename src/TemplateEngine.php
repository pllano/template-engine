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
 
use Psr\Http\Message\ResponseInterface as Response;
use Pllano\Adapter\Renderer\PhpRenderer;
// use Pllano\Adapter\Renderer\Smarty;
// use Pllano\Adapter\Renderer\Blade;
 
class TemplateEngine
{
    private $config;
    protected $options;
    protected $loader;
    protected $response;
    protected $render;
    protected $data;
    protected $template_engine;
    protected $renderer;
    protected $template;
    protected $install = null;
 
    public function __construct($config = [], $template = null)
    {
        // Подключаем конфиг из конструктора
        if(isset($config)) {
            $this->config = $config;
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
            $this->template_engine = $this->config['template']['front_end']['template_engine'];
        } else {
            $this->template_engine = 'twig';
        }
 
        $this->renderer();
    }
 
    public function render(Response $response, $render = null, $data = [])
    {
        $this->response = $response;
        if(isset($render)) {
            $this->render = $render;
        }
        if(isset($data)) {
            $this->data = $data;
        }
        $template_engine = strtolower($this->template_engine);
		if ($this->install != null) {
            if ($template_engine == 'twig') {
 
                return $this->renderer->render($this->render, $this->data);
 
            } elseif ($template_engine == 'blade' || $template_engine == 'phprenderer') {
 
                return $this->renderer->render($this->response, $this->render, $this->data);
 
            } elseif ($template_engine == 'smarty') {
 
                $this->renderer->assign($this->data);
                return $this->renderer->fetch($this->render);
 
            } elseif ($template_engine == 'mustache') {
 
                return $this->renderer->render($this->response, $this->render, $this->data);
 
            } else {
 
                return $this->renderer->render($this->response, $this->render, $this->data);
 
            }
		} else {
		    return $this->renderer->render($this->render, $this->data);
		}
    }

    public function renderer()
    {
        $themes = $this->config['template']['front_end']['themes'];
        $template_engine = strtolower($this->template_engine);
        $cache = false;
        $strict_variables = false;
		
		$paths = $this->config["settings"]["themes"]["front_end_dir"]."/".$themes['templates']."/".$this->template."/layouts";
 
        if ($this->install != null) {
            if ($template_engine == 'twig') {
 
                if (isset($this->config['template']['twig']['cache_state'])) {
                    if ((int)$this->config['template']['twig']['cache_state'] == 1) {
                        $cache = __DIR__ .''.$this->config['template']['twig']['cache_dir'];
                        $strict_variables = $this->config['template']['twig']['strict_variables'];
                    }
                }
                $loader = new \Twig_Loader_Filesystem($paths);
                $this->renderer = new \Twig_Environment($loader, ['cache' => $cache, 'strict_variables' => $strict_variables]);
 
            } elseif ($template_engine == 'blade') {
 
				$this->renderer = new Blade($paths, $this->config['template']['blade']['cache_dir']);
 
            } elseif ($template_engine == 'smarty') {
 
                $this->renderer = new \Smarty();
                $this->renderer->setTemplateDir($paths);
 
				if (isset($this->config['template']['smarty']['cache_state'])) {
                    if ((int)$this->config['template']['smarty']['cache_state'] == 1) {
                        if (isset($this->config['template']['smarty']['cache_dir'])) {
                            $this->renderer->setCacheDir($this->config['template']['smarty']['cache_dir']);
                        }
                    }
				}
 
                if (isset($this->config['template']['smarty']['compile_dir'])) {
                    $this->renderer->setCompileDir($this->config['template']['smarty']['compile_dir']);
                }
 
                if (isset($this->config['template']['smarty']['plugins_dir'])) {
                    $this->renderer->addPluginsDir($this->config['template']['smarty']['plugins_dir']);
                }
 
            } elseif ($template_engine == 'mustache') {
                $this->renderer = null;
            } elseif ($template_engine == 'phprenderer') {
                $this->renderer = new PhpRenderer($paths);
            } else {
                $this->renderer = new $this->template_engine($paths, $this->config);
            }
        } else {
            $loader = new \Twig_Loader_Filesystem($this->config["settings"]["themes"]["front_end_dir"]."/".$themes['templates']."/install");
            $this->renderer = new \Twig_Environment($loader, ['cache' => false, 'strict_variables' => false]);
        }
 
        return $this->renderer;
 
    }
 
}
 