<?php /**
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
 
namespace Pllano\Adapter\Renderer\WebSun;
 
/**
    * Websun template parser by Mikhail Serov (1234ru at gmail.com)
    * http://webew.ru/articles/3609.webew
    * 2010-2018 (c)
    *
    * Class Template
*/
 
class Run
{
    /**
        * Функция-обёртка для быстрого вызова класса.
        * принимает шаблон в виде пути к нему
        *
        * @param $data
        * @param $template_path
        * @param bool|FALSE $templates_root_dir
        * @param bool|FALSE $no_global_vars
        * @return mixed
    */
    // $profiling = FALSE - пока убрали
    public function parse_template_path($data, $template_path, $templates_root_dir = FALSE, $no_global_vars = FALSE)
    {
        $template = new Template(array(
        'data' => $data, 
        'templates_root' => $templates_root_dir,
        'no_global_vars' => $no_global_vars
        ));
        $tpl = $template->get_template($template_path);
        $template->templates_current_dir = pathinfo( $template->template_real_path($template_path), PATHINFO_DIRNAME ) . '/';
        $string = $template->parse_template($tpl);
        return $string;
    }
 
    /**
        * Функция-обёртка для быстрого вызова класса
        * принимает шаблон непосредственно в виде кода
        *
        * @param $data
        * @param $template_code
        * @param bool|FALSE $templates_root_dir
        * @param bool|FALSE $no_global_vars
        * @return mixed
    */
    // profiling пока убрали
    public function parse_template($data, $template_code, $templates_root_dir = FALSE, $no_global_vars = FALSE)
    {
        $template = new Template(array(
            'data' => $data, 
            'templates_root' => $templates_root_dir,
            'no_global_vars' => $no_global_vars 
        ));
        $string = $template->parse_template($template_code);
        return $string;
    }
 
}
 