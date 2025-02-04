<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
// FrontEnd
require_once dirname(__FILE__) . '/../Views/index.php';
require_once 'Theme/assets.php';
require_once 'Theme/menu.php'; 

//Backend
require_once 'Api/env.php';
require_once 'Api/endpoints.php';
require_once 'Database/autonotify_table_manager.php';
require_once dirname(__FILE__) . '/../Core/hooks.php';
require_once dirname(__FILE__) . '/../Services/index.php';
require_once dirname(__FILE__) . '/../Controllers/index.php';

// Woocommerce
require_once 'Woocommerce/abandoned-cart-hook.php';

?>