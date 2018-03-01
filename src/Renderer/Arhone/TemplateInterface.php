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
 
declare(strict_types = 1);
 
namespace Pllano\Adapters\Template\Renderer\Arhone;
 
/**
 * Шаблонизатор
 *
 * Interface TemplateInterface
 * @package arhone\template
 * @author Алексей Арх <info@arh.one>
 */
 
interface TemplateInterface
{
 
    /**
     * Template constructor.
     *
     * @param array $config
     */
    public function __construct (array $config = []);
 
    /**
     * Возвращает загруженный шаблон
     *
     * @param mixed $path Путь к файлу шаблона или массив с путями
     * @param array $data Массив с переменными
     * @return string
     */
    public function render ($path, array $data = []) : string;
 
    /**
     * Устанавливает значение для переменной
     * Включение буферизации вывода
     *
     * @param string $name
     * @param mixed|null $value
     * @return mixed|void
     */
    public function set (string $name, $value = null);
 
    /**
     * Устанавливает значение для переменной по умолчанию
     * Включение буферизации вывода
     *
     * @param string $name
     * @param mixed|null $value
     * @return mixed|void
     */
    public function default (string $name, $value = null);
 
    /**
     * Дописывает значение в переменную
     * Включение буферизации вывода
     *
     * @param string $name
     * @param mixed|null $value
     * @return mixed
     */
    public function add (string $name, $value = null);
 
    /**
     * Получить содержимое текущего буфера и удалить его
     *
     * @param string $name
     * @return mixed
     */
    public function end (string $name);
 
    /**
     * Возвращает значение переменной
     * 
     * @param string $name
     * @return mixed
     */
    public function get (string $name);
 
    /**
     * Проверяет существование переменной
     * 
     * @param string $name
     * @return mixed
     */
    public function has (string $name);
 
    /**
     * Удаляет переменную
     *
     * @param string $name
     * @return mixed
     */
    public function delete (string $name);
 
    /**
     * htmlspecialchars() с исключениями
     *
     * @param string $text
     * @param array $tagList
     * @return string
     */
    public function specialChars (string $text, array $tagList = []) : string;
 
    /**
     * Очистить от комментарий
     *
     * @param string $text
     * @return string
     */
    public function clearComment (string $text) : string;
 
    /**
     * Очистить от переноса строк
     *
     * @param string $text
     * @return string
     */
    public function clearRN (string $text) : string;
 
    /**
     * Задаёт конфигурацию
     *
     * @param array $config
     * @return array
     */
    public function config (array $config) : array;
 
}
 