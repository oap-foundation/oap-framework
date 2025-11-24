<?php

/**
 * Class OAP_Agent_Interface
 * 
 * This class provides a simplified API for Chat Plugins (like wp-straico-chat)
 * to interact with the OAP Framework.
 * 
 * Usage in Chat Plugin:
 * if ( class_exists( 'OAP_Agent_Interface' ) ) {
 *     $results = OAP_Agent_Interface::search_products( 'laptop' );
 * }
 */
class OAP_Agent_Interface
{

    /**
     * Search for products or services in the OAP network.
     * 
     * @param string $query The search term (e.g., "MacBook Pro", "Translation Service")
     * @return array List of found items with details (price, seller_did, etc.)
     */
    public static function search_products($query)
    {
        $bridge = OAP_Bridge::get_instance();
        return $bridge->search_products($query);
    }

    /**
     * Initiate a negotiation or get a concrete offer for a product.
     * 
     * @param string $product_id The ID of the product found in search
     * @param string $seller_did The DID of the seller
     * @return array The offer details including final price and terms
     */
    public static function get_offer($product_id, $seller_did)
    {
        // In a real flow, this would send a NegotiateRequest
        // For demo, we return a mock offer
        return array(
            'status' => 'offer_received',
            'offer_id' => uniqid('offer_'),
            'product_id' => $product_id,
            'price' => 2499.00, // Mock price
            'currency' => 'EUR',
            'valid_until' => time() + 3600
        );
    }

    /**
     * Place a binding order.
     * 
     * @param string $offer_id The ID of the accepted offer
     * @return array Order confirmation details
     */
    public static function place_order($offer_id)
    {
        $bridge = OAP_Bridge::get_instance();
        // Mock: extract product_id/seller from offer_id logic
        return $bridge->create_order('mock_product', 'did:web:seller.test');
    }

    /**
     * Authorize a payment for an order.
     * 
     * @param string $order_id The ID of the confirmed order
     * @return array Payment receipt and status
     */
    public static function pay_order($order_id)
    {
        $bridge = OAP_Bridge::get_instance();
        // Mock amount
        return $bridge->authorize_payment($order_id, 2499.00, 'EUR');
    }
}
