<?php

class OAP_Bridge
{

    private static $instance = null;
    private $did = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        // Initialize REST API
        add_action('rest_api_init', array($this, 'register_rest_routes'));

        // Initialize Agent Identity (Mock for now)
        $this->initialize_identity();
    }

    public function register_rest_routes()
    {
        $controller = new OAP_REST_Controller();
        $controller->register_routes();
    }

    private function initialize_identity()
    {
        // In a real scenario, we would load the DID from the database or a secure keystore.
        // For this demo, we generate a deterministic did:web based on the site URL.
        $site_url = get_site_url();
        $domain = parse_url($site_url, PHP_URL_HOST);
        $this->did = 'did:web:' . $domain;
    }

    public function get_did()
    {
        return $this->did;
    }

    /**
     * Search for products using OACP (Mock implementation)
     */
    public function search_products($query)
    {
        // Use Mock Data for the demo
        $results = OAP_Mock_Data::search($query);

        return array(
            'status' => 'success',
            'query' => $query,
            'count' => count($results),
            'results' => $results
        );
    }

    /**
     * Create an order using OACP
     */
    public function create_order($product_id, $seller_did)
    {
        return array(
            'status' => 'pending',
            'order_id' => uniqid('order_'),
            'product_id' => $product_id,
            'seller' => $seller_did
        );
    }

    /**
     * Authorize payment using OAPP (Mock)
     */
    public function authorize_payment($order_id, $amount, $currency)
    {
        $tx_id = uniqid('tx_');
        $timestamp = date('c');

        // Mock QES Signature (Qualified Electronic Signature)
        $mock_signature = base64_encode(hash_hmac('sha256', $order_id . $amount . $currency, 'mock_private_key', true));

        return array(
            'type' => 'PaymentConfirmation',
            'id' => uniqid('urn:uuid:'),
            'threadId' => $order_id,
            'createdTime' => $timestamp,
            'status' => 'COMPLETED',
            'payment' => array(
                'transactionId' => $tx_id,
                'amount' => array(
                    'value' => $amount,
                    'currency' => $currency
                ),
                'status' => 'SETTLED',
                'method' => 'OAPP_MOCK_BANK'
            ),
            'receipt' => array(
                'issuer' => 'did:web:mock-bank.example',
                'digest' => hash('sha256', $tx_id . $timestamp),
                'signature' => $mock_signature,
                'signatureType' => 'EidasQES'
            )
        );
    }
}
