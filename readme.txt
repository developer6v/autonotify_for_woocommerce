=== Autonotify For Woocommerce ===
Contributors: techsourei
Tags: autonotify, automate, woocommerce, messages, abandoned cart
Requires at least: 6.2
Tested up to: 6.7
Stable tag: 1.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Autonotify for WooCommerce is a plugin that seamlessly integrates WooCommerce with the Autonotify platform, enabling automated WhatsApp message notifications based on order statuses and abandoned cart.

== External Services ==

This plugin connects to the **Autonotify API** to manage and transmit essential information related to order status updates and abandoned cart messages. The Autonotify API is used to automate communication and workflow for store owners using this plugin.

Data Sent:
- Order Status Information: When an order is created or updated, the plugin sends the order details to the Autonotify API.
- Abandoned Cart Data: The plugin sends information about abandoned carts, including user data like cart contents.
- Client Data: The plugin sends information about the client on both cases, when an order is created or when a cart is abandoned by a client.

This communication happens through secure HTTP requests to the API at `https://apiautonotify.sourei.com.br`.

When Data is Sent:
- When an order is placed or updated in the WooCommerce system.
- When a cart is abandoned and the plugin sends a reminder notification.

The Autonotify API is provided by **Sourei Technologies**. For more details, please refer to the following links:
- https://autonotify.com.br/#duvidas
- https://autonotify.com.br/

Why this is Necessary:
This service is required for essential functionality, including authentication tokens, order status updates, and abandoned cart notifications. Your data is handled securely, and communication with the API is done over HTTPS.

