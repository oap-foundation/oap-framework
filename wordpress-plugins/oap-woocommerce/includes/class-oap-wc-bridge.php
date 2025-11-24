<?php

class OAP_WC_Bridge
{

    private static $instance = null;
    private $namespace = 'oap/v1';

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes()
    {
        // OACP: Search Products
        register_rest_route($this->namespace, '/search', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'search_products'),
            'permission_callback' => '__return_true', // Public for demo
        ));

        // OACP: Create Order
        register_rest_route($this->namespace, '/order', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array($this, 'create_order'),
            'permission_callback' => '__return_true',
        ));
    }

    /**
     * Search WooCommerce Products
     */
    public function search_products($request)
    {
        $query = $request->get_param('q');

        $args = array(
            'status' => 'publish',
            'limit' => 10,
            's' => $query,
        );

        $products = wc_get_products($args);
        $results = array();

        foreach ($products as $product) {
            $results[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'description' => strip_tags($product->get_short_description()),
                'price' => $product->get_price(),
                'currency' => get_woocommerce_currency(),
                'image' => wp_get_attachment_url($product->get_image_id()),
                'permalink' => $product->get_permalink(),
                'seller_did' => 'did:web:' . parse_url(get_site_url(), PHP_URL_HOST)
            );
        }

        return new WP_REST_Response(array(
            'status' => 'success',
            'count' => count($results),
            'results' => $results
        ), 200);
    }

    /**
     * Create WooCommerce Order from OAP Request
     */
    public function create_order($request)
    {
        $params = $request->get_json_params();

        if (empty($params['product_id'])) {
            return new WP_REST_Response(array('error' => 'Missing product_id'), 400);
        }

        try {
            $address = array(
                'first_name' => 'OAP',
                'last_name' => 'Agent',
                'email' => 'agent@oap.network',
                'phone' => '123-123-123',
                'address_1' => 'Digital Street 1',
                'city' => 'Cyberspace',
                'state' => '',
                'postcode' => '00000',
                'country' => 'US'
            );

            $order = wc_create_order();
            $order->add_product(wc_get_product($params['product_id']), 1);
            $order->set_address($address, 'billing');
            $order->set_address($address, 'shipping');
            $order->set_payment_method('oap_payment'); // We would need to register this gateway
            $order->calculate_totals();
            $order->update_status('processing', 'Order created via OAP Agent', true);

            return new WP_REST_Response(array(
                'status' => 'success',
                'order_id' => $order->get_id(),
                'total' => $order->get_total(),
                'currency' => $order->get_currency()
            ), 201);

        } catch (Exception $e) {
            return new WP_REST_Response(array('error' => $e->getMessage()), 500);
        }
    }
}
