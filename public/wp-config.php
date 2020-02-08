<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wp' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '<VZi7$AN-Qu(~2us;GED@z)tz~nN ;A@l=:Y$HjmY<,@A0N[=oY?=d6!y:!S{UtQ' );
define( 'SECURE_AUTH_KEY',  'TJ/+;R1S8IWfsZP558qF34,.*83Ic^jX1v7</&,ayzTElbP.W$<>%tC8(#=b%*7Z' );
define( 'LOGGED_IN_KEY',    'A0z0D%SJu#7[wQ#KA~jQ^17X ++>W&GQhYXIR&I.-<N5ty(S$vSA,n_vMb}90G(M' );
define( 'NONCE_KEY',        '2l&XYV4^B?,9Upe0AjGEv7=4!F%1=mPDl6H86&LLHF5P*>+*s9:1_mEL*z:R~q1e' );
define( 'AUTH_SALT',        'PsXBEqO2zi!L3GX WgUq(JuE` $D27 s{B P,e,*ycGb;Y*d$.|SiXHRHe1wr(:%' );
define( 'SECURE_AUTH_SALT', '#L9<M_ 61GKW[@{q6ipnij*f$8`gDC8OA#d3NwRvs+wXkg}[U0Nd{,xUXr1V^a<G' );
define( 'LOGGED_IN_SALT',   'c66?dWPm(3i)U{@kc2u=8yZ4?1FZi5tUQV=lNc#fg=NAlFUqi +F3B/}zmr$3NZe' );
define( 'NONCE_SALT',       '}f!EavhN]sh8(VMd/58#ew}o6Ao*3>_(2TrW7WeeJ4NasNY$P~9cHUILA(NC{Nl~' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wps_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', TRUE );


/** Инициализирует переменные WordPress и подключает файлы. */
require_once(WP_PUBLIC . 'wp-settings.php');
