<?php

class OAP_Mock_Data
{

    public static function get_products()
    {
        return array(
            array(
                'id' => 'prod_macbook_pro_m4',
                'name' => 'MacBook Pro M4 16"',
                'description' => 'Latest Apple Silicon, 32GB RAM, 1TB SSD',
                'price' => 2499.00,
                'currency' => 'EUR',
                'category' => 'Electronics',
                'seller_did' => 'did:web:seller.test'
            ),
            array(
                'id' => 'prod_iphone_16',
                'name' => 'iPhone 16 Pro',
                'description' => 'Titanium finish, 256GB',
                'price' => 1199.00,
                'currency' => 'EUR',
                'category' => 'Electronics',
                'seller_did' => 'did:web:seller.test'
            ),
            array(
                'id' => 'service_translation_ai',
                'name' => 'AI Translation Service',
                'description' => 'High-quality neural translation (EN <-> DE)',
                'price' => 0.05,
                'currency' => 'EUR',
                'unit' => 'per_request',
                'category' => 'Service',
                'seller_did' => 'did:web:seller.test'
            )
        );
    }

    public static function search($query)
    {
        $products = self::get_products();
        $results = array();

        foreach ($products as $product) {
            if (stripos($product['name'], $query) !== false || stripos($product['description'], $query) !== false) {
                $results[] = $product;
            }
        }

        return $results;
    }
}
