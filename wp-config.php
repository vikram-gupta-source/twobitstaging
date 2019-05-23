<?php
# Database Configuration
define( 'DB_NAME', 'wp_twobitdev' );
define( 'DB_USER', 'twobitdev' );
define( 'DB_PASSWORD', 'tcKnttka7Y0u78kee7km' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'x* 2+KcKu68^B5vCW`HYZztv;sY+nf`+KbP!dX b7@$ k.8png+^jdAjK~ YYK^+');
define('SECURE_AUTH_KEY',  'd*9+8}<b<|,%a*C>(q><b@n5+>;X8Pt7F-}.:xX./I.B1NDlahT7p|D&.etaTa-Z');
define('LOGGED_IN_KEY',    '^-JVxWm*hJmBh;?%|fULZ?+Aln!N=9?{}>!@tI6Yy-^NU>qiH(4|E5TcAi`=dt6A');
define('NONCE_KEY',        'bGIk<a0b2qfAp7pqmMVX4-r|)JN, j3K+NZ;C/@DOmcB@W*eX6HxeE2HL;V$s5D%');
define('AUTH_SALT',        '26H[i!_}b)s.GE@KS% kLQ&tygYq=Z,f -B#,t+V``EqSBHq+zg+ZoJJEKf|oh_s');
define('SECURE_AUTH_SALT', 'I<|L~A?{iG&)URNKW0_44QLNaRQlG={0+hO2E!F]wcja/9WN] LU8CL>`3s16B,.');
define('LOGGED_IN_SALT',   'U!HU[tVS& pYHO3LnS@@_dsURKm_;4P-EFI>U^Nq%>kq%T&!%sb +W(hz*wLol.p');
define('NONCE_SALT',       'O3!9j,*-wh%p`x%+rarn`+a+:>mMwHBv1[|-`9YZePi:0zzUvkQi+l~+c9.);sX&');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'twobitdev' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '3ba19f123599f43b64c93511a60cdd55fbe378ab' );

define( 'WPE_CLUSTER_ID', '100856' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'twobitdev.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-100856', );

$wpe_special_ips=array ( 0 => '146.148.38.157', );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );
define('WPLANG','');

# WP Engine ID


define('PWP_DOMAIN_CONFIG', 'twobitdev.wpengine.com' );

# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', __DIR__ . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
