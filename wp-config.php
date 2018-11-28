<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', 'blog');

/** MySQL数据库用户名 */
define('DB_USER', 'blog');

/** MySQL数据库密码 */
define('DB_PASSWORD', 'blogcc123456');

/** MySQL主机 */
define('DB_HOST', '172.21.1.17');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8mb4');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ')()+w-%vsK)@>xPnZ;n^p60_GK.jB^[(4Y5#q;i a[qGK{rO*@?jP6hXN;w!Y>]y');
define('SECURE_AUTH_KEY',  '?z. 8PyT8h3k;el}05C.:F,H1qO$(cQ BDCQ]nc=r]?:+GWk=YT1~_MrRFZlWqzl');
define('LOGGED_IN_KEY',    'K]`{v_Dz|+vBT&sk:DB4D6E(aV5FeV.c{O|VoGXW?L@9jS^N8;tpLjQTcBqHy{GV');
define('NONCE_KEY',        ',z,iQgapd:uiy|tafz_gaapfhl=D{prkiW~De5[%a`3W3L*2uFO6z`g%@ylu>N6i');
define('AUTH_SALT',        'UVY_[l Hrz5NIIlbmC*mf%+n~!7F6*K{/^8zb_n:QR)8|c@E)x6qs@gr;?<*$KmH');
define('SECURE_AUTH_SALT', 'U=`aAb!M:-M~?-G ]+M`kx8 79jQbZi/:K8%cc/=AsE@[4/:ct4`yz_Z]c|aF]C ');
define('LOGGED_IN_SALT',   '1/X%yz8Go1fb(LdB4l*NRD}3!f0Mi]nLCIGGUC>.G2wT_gTzO$b$|oP%yl6E[?rL');
define('NONCE_SALT',       'c#0tqR-2xL(_UumHu]7[9>XP KS(F_;hWl,%RBxJqI#VMgm.v(.-u$eeIFzP+ ?%');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
define('WP_TEMP_DIR', ABSPATH.'wp-content/tmp');

define("FS_METHOD", "direct");  

define("FS_CHMOD_DIR", 0777);  

define("FS_CHMOD_FILE", 0777); 
/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
