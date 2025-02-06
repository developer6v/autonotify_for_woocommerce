<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

require_once AUTONOTIFY_PLUGIN_DIR . 'src/Services/Api/validate_token.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Services/Api/send_autonotify.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Services/Database/save_token_database.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Services/Woocommerce/getOrderData.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Services/Woocommerce/getResetPasswordData.php';
require_once AUTONOTIFY_PLUGIN_DIR . 'src/Services/Woocommerce/getAbandonedCartData.php';

?>   