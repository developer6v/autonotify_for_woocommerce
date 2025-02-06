<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
// FrontEnd
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Views/index.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Config/Theme/assets.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Config/Theme/menu.php';


//Backend
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Config/Api/env.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Config/Api/endpoints.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Config/Database/autonotify_table_manager.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Core/hooks.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Services/index.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Controllers/index.php';

// Woocommerce
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Config/Woocommerce/abandoned-cart-hook.php';

?>