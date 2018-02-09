# BasicSyntax

```
/*
// Базовый синтаксис Twig
http://laravel.su/docs/5.2/blade
https://laravel.ru/docs/v5/blade
*/
/*
// Базовый синтаксис Twig
 
{{ сказать что-то }}
{% сделать что-то %}
 
Переменные, вывод
 
{{ sitename }}
{{ user.name }}
{{ foo['bar'] }}
 
Глобальные
 
{{ _context }} - текущий контекст
{{ _self }} - этот шаблон
{{ _charset }} - кодировка
 
app.security - Контекст безопасности
app.user - Текущий пользователь
app.request - Запрос
app.session - Сессия
app.environment - Текущее окружение (dev, prod)
app.debug - Флаг отладки (boolean)


Присвоение

{% set foo = 'bar' %}
{% set foo = [1,2] %} - массив
{% set foo = {'foo':'bar'} %} - массив с ключами
{% set foo = bar ~'baz' %} - с другой переменной


Выражения

Результаты выражений никогда не экранируются

{{ foo ? "Twig<br />" : "<br />Twig" }} {# не экранируется #}
 
{% set text = "Twig<br />" %}
{{ foo ? text : "<br />Twig" }} {# экранируется #}
 
{% set text = "Twig<br />" %}
{{ foo ? text|raw : "<br />Twig" }} {# не экранируется #}
 
{% set text = "Twig<br />" %}
{{ foo ? text|escape : "<br />Twig" }} {# не экранируется #}


Длинный текст

{% set message %}
  This is an error message.
{% endset %}


Управляющие структуры

if , elseif, else, for

Условия: even, odd, defined, sameas, null, divisibleby, constant, empty

{% if page is defined %}
  <h1>{{ pagetitle }}</h1>
{% endif %}
 
{% if users|length > 0 %}
        {% for user in users %}
            {{ user.username|e }}
        {% endfor %}
{% endif %}


Цикл

{% for user in users %}
  <li>{{ user.username }}</li>
{% else %}
no users
{% endfor %}
 
{% for i in 0..10 %}
<div class="{{ cycle(['odd', 'even'], i) }}">{{ i }}</div>
{% endfor %}


Фильтры

Один или несколько фильтров разделенных `|`

Полный список: date, format, replace, url_encode, json_encode, title, capitalize, upper, 
lower, striptags, join, reverse, length, sort, merge, default, keys, escape, e

{{ name|striptags|title }}
 
{{ list|join(‘, ‘)|title }}
 
{% filter upper %}
  This text becomes uppercase
{% endfilter %}


Функции

Встроенные: range, cycle, constant, random, attribute, block, parent, dump, date

{% for i in range(0, 3) %}
    {{ i }},
{% endfor %}


Экранирование

Экран для твиготэгов `raw`

{{ '{{twigvariable}}'| raw }}


Для html - `htmlspecialchars`

{{'<script>alert("script")</script>' | escape}}
 
{% autoescape 'html' %}
    {{ var }}
    {{ var|raw }}      {# var won't be escaped #}
    {{ var|escape }}   {# var won't be double-escaped #}
{% endautoescape %}


Включения (инклюды)

{% include 'relative/to/template/root/mypage.html' %}
{% include 'mypage.html' with {'key': 'value'} %} - с передачей переменных


Песочница

Сэндбокс необходимо подключать для непроверенных шаблонов,
функционал которых будет ограничен системой

{% sandbox %}
    {% include 'user.html' %}
{% endsandbox %}


Наследование

Механизм блоков - плейсхолдеры в родительском шаблоне, которые могут быть переопределены в дочернем.

base.html.twig

<html>
<body>
   <div id="content">{% block content %}{% endblock %}</div>
</body>
</html>


Директива extends указывает на наследуемый шаблон

Дочерний шаблон может содержать только переопределяемые блоки,
использование html вне блоков вызовет ошибку.

{% extends "base.html.twig" %}   {# <-- наследуем  #}
 
{% block content %}
    <h1>Index</h1>
    <p class="important">Переопределенный блок</p>
    
    {{ parent() }}
 
{% endblock %}


Для вывода контента родительского блока, используется функция `parent()`

Подробнее о блоках

Переводы i18n

{%trans “Hello world!” %}
 
Для длинного текста
{% trans %}
  Hello {{user.name}}
{% endtrans %}
 
{% trans %}
    Hey {{ name }}, I have one apple.
{% plural apple_count %}
    Hey {{ name }}, I have {{ count }} apples.
{% endtrans %}
*/
/*
// Базовый синтаксис Smarty
https://www.smarty.net/docsv2/ru/language.syntax.variables.tpl
{$foo}        <-- отображение простой переменной (не массив и не объект)
{$foo[4]}     <-- отображает 5-й элемент числового массива
{$foo.bar}    <-- отображает значение ключа "bar" ассоциативного массива, подобно PHP $foo['bar']
{$foo.$bar}   <-- отображает значение переменного ключа массива, подобно PHP $foo[$bar]
{$foo->bar}   <-- отображает свойство "bar" объекта
{$foo->bar()} <-- отображает возвращаемое значение метода "bar" объекта
{#foo#}       <-- отображает переменную "foo" конфигурационного файла
{$smarty.config.foo} <-- синоним для {#foo#}
{$foo[bar]}   <-- синтаксис доступен только в цикле section, см. {section}
{assign var=foo value='baa'}{$foo} <--  отображает "baa", см. {assign}
Также доступно множество других комбинаций
{$foo.bar.baz}
{$foo.$bar.$baz}
{$foo[4].baz}
{$foo[4].$baz}
{$foo.bar.baz[4]}
{$foo->bar($baz,2,$bar)} <-- передача параметра
{"foo"}       <-- статические значения также разрешены
{* отображает серверную переменную "SERVER_NAME" ($_SERVER['SERVER_NAME'])*}
{$smarty.server.SERVER_NAME}
*/
 ```
