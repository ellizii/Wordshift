<?php
namespace Wp\Core;

class Exceptions
{
    private static $instance = null;
    private $response = null;
    /**
     * Message level short codes
     * @var array


        E_ERROR,  Фатальные ошибки времени выполнения. Это неустранимые средствами самого скрипта ошибки,
                  такие как ошибка распределения памяти и т.п. Выполнение скрипта в таком случае прекращается.

        E_WARNING, Предупреждения времени выполнения (не фатальные ошибки). Выполнение скрипта в таком случае не прекращается.

        E_PARSE,  Ошибки на этапе компиляции. Должны генерироваться только парсером.
        E_NOTICE, Уведомления времени выполнения. Указывают на то, что во время выполнения скрипта произошло
                  что-то, что может указывать на ошибку, хотя это может происходить и при обычном выполнении программы.

        E_CORE_ERROR,  Фатальные ошибки, которые происходят во время запуска РНР. Такие ошибки схожи с E_ERROR,
                       за исключением того, что они генерируются ядром PHP.

        E_CORE_WARNING,  Предупреждения (не фатальные ошибки), которые происходят во время начального запуска РНР.
                         Такие предупреждения схожи с E_WARNING, за исключением того, что они генерируются ядром PHP.

        E_COMPILE_ERROR,  Фатальные ошибки на этапе компиляции. Такие ошибки схожи с E_ERROR, за исключением того,
                          что они генерируются скриптовым движком Zend.

        E_COMPILE_WARNING,  Предупреждения на этапе компиляции (не фатальные ошибки). Такие предупреждения схожи
                             с E_WARNING, за исключением того, что они генерируются скриптовым движком Zend.
        E_USER_ERROR,  Сообщения об ошибках, сгенерированные пользователем. Такие ошибки схожи с E_ERROR,
                         за исключением того, что они генерируются в коде скрипта средствами функции PHP trigger_error().
        E_USER_WARNING,  Предупреждения, сгенерированные пользователем. Такие предупреждения схожи с E_WARNING,
                         за исключением того, что они генерируются в коде скрипта средствами функции PHP trigger_error().
        E_USER_NOTICE,  Уведомления, сгенерированные пользователем. Такие уведомления схожи с E_NOTICE,
                         за исключением того, что они генерируются в коде скрипта, средствами функции PHP trigger_error().
        E_STRICT,  Включаются для того, чтобы PHP предлагал изменения в коде, которые обеспечат лучшее
                     взаимодействие и совместимость кода. 	Не включены в E_ALL вплоть до PHP 5.4.0
        E_RECOVERABLE_ERROR,  Фатальные ошибки с возможностью обработки. Такие ошибки указывают, что, вероятно,
                             возникла опасная ситуация, но при этом, скриптовый движок остается в стабильном
                             состоянии. Если такая ошибка не обрабатывается функцией, определенной пользователем
                             для обработки ошибок (см. set_error_handler()), выполнение приложения прерывается,
                             как происходит при ошибках E_ERROR. 	Начиная с PHP 5.2.0
        E_DEPRECATED,  Уведомления времени выполнения об использовании устаревших конструкций.
                         Включаются для того, чтобы получать предупреждения о коде, который не будет работать
                         в следующих версиях PHP. 	Начиная с PHP 5.3.0
        E_USER_DEPRECATED,  Уведомления времени выполнения об использовании устаревших конструкций,
                             сгенерированные пользователем. Такие уведомления схожи с E_DEPRECATED за исключением
                             того, что они генерируются в коде скрипта, с помощью функции PHP trigger_error().
                             Начиная с PHP 5.3.0
        E_ALL            Все поддерживаемые ошибки и предупреждения, за исключением ошибок E_STRICT до PHP 5.4.0.
                         32767 в PHP 5.4.x, 30719 в PHP 5.3.x, 6143 в PHP 5.2.x, 2047 ранее
  */

    public function __construct()
    {

        if(!defined('LOGS'))define('LOGS',WP_CONTENT.'/logs/logs.txt');
        $this->response = Response::getInstance();

            if (!ini_get('log_errors')) ini_set('log_errors', true);

            error_reporting(  E_CORE_ERROR |
                                    E_CORE_WARNING |
                                    E_COMPILE_ERROR |
                                    E_ERROR |
                                    E_WARNING |
                                    E_PARSE |
                                    E_USER_ERROR |
                                    E_USER_WARNING |
                                    E_RECOVERABLE_ERROR );
            set_error_handler(array($this, 'err_handler'));
            return $this;
    }

    public static function getInstance()
    {
        if (null === self::$instance) self::$instance = new self();
        return self::$instance;
    }

    public function err_handler($errno)
    {
        $l = error_reporting();
        if ($l & $errno) {
            switch ($errno) {
                case E_USER_ERROR:
                case E_ERROR: $type = 'Fatal Error';break;

                case E_USER_WARNING:
                case E_WARNING: $type = 'Warning'; break;

                case E_USER_NOTICE:
                case E_NOTICE:
                case @E_STRICT: $type = 'Notice'; break;

                case @E_RECOVERABLE_ERROR: $type = 'Catchable'; break;

                default: $type = 'Unknown Error'; break;
            }
                $this->exc_handler($type);
        }
        return false;
    }

    public function exc_handler($type_error)
    {
        $caller = debug_backtrace();
        $file='';
        $mess='';
        $line='';
        if('Fatal Error'===$type_error || 'Unknown Error'=== $type_error){
          $file = $caller[3]['file'];
          $line = $caller[3]['line'];
          $mess=  $caller[3]['args'][0];
        }else{
            $file = $caller[1]['args'][2];
            $line = $caller[1]['args'][3];
            $mess=  $caller[1]['args'][1];
        }

        $error = "<!DOCTYPE html>
            <html>
                <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <!--[if lt IE 9]><meta http-equiv='X-UA-Compatible' content='IE=edge'><![endif]-->
                <style>
                    html{height:100%;font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-size:10px;-webkit-tap-highlight-color:transparent}*,:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}
                    body{height:100%;margin:0;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}
                    button,h3,input{font-family:inherit}
                    h3{font-weight:bold;line-height:1.1;color:inherit;margin-top:0;margin-bottom:10px;font-size:24px}
                    .authform{width:500px;background-color:#e1e5ec;padding:25px 27px;margin: 0 auto;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px}
                </style>
                <title>$type_error</title>
                </head>
                <body style='text-align: center;'>
                    <table style='width:50%;height:50%;border:1px dotted;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px'>
                        <tbody>
                            <tr><td><div style='margin-bottom: 18px'>" . date('Y F d H:i:s') . "</div></td></tr>
                            <tr><td><div><h3>" . $type_error. "</h3></div></td></tr>
                            <tr><td style='padding: 20px'><div class='authform'>" . $mess . "<div style='margin-bottom: 18px'> File: " . $file. "</div></td></tr>
                            <tr><td><div style='margin-bottom: 18px'> Line:" . $line. "</div> </td></tr> 
                        </tbody>
                    </table>
                </body>
            </html>";
        if (WP_DEBUG) {


            $logs = date('Y F d H:i:s') .
                ' | ' . $type_error . ' >> ' . $mess . ' | ' .
                'File: ' . $file . ' | ' .
                'Line: ' . $line .PHP_EOL;

            error_log($logs, 3, LOGS);
             exit($error);

        }else{

            $logs = date('Y F d H:i:s') .
                ' | ' . $type_error . ' >> ' . $mess . ' | ' .
                'File: ' . $file . ' | ' .
                'Line: ' . $line .PHP_EOL;
            error_log($logs, 3, LOGS);
        }
    }

    public function show($message,$error_type=E_USER_ERROR,$headers=array())
    {
        if(WP_DEBUG) {
            $this->response->clearHeaders();
            if (is_array($headers) AND count($headers) > 0) $this->response->setHeaders($headers);
        }
        return trigger_error(htmlentities($message), $error_type);
    }
}
