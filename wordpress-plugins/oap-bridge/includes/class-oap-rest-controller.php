<?php

class OAP_REST_Controller extends WP_REST_Controller
{

    protected $namespace = 'oap/v1';

    public function register_routes()
    {
        // Endpoint to receive messages (OACP/OAEP/OAPP envelopes)
        register_rest_route($this->namespace, '/inbox', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array($this, 'handle_inbox_message'),
            'permission_callback' => '__return_true', // Should be secured in production
        ));

        // Endpoint to resolve public DID document
        register_rest_route($this->namespace, '/did', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'get_did_document'),
            'permission_callback' => '__return_true',
        ));
    }

    public function handle_inbox_message($request)
    {
        $params = $request->get_json_params();

        // Here we would dispatch the message to the correct protocol handler (OAEP, OACP, OAPP)
        // For now, just log it and return success.

        error_log('OAP Inbox received: ' . print_r($params, true));

        return new WP_REST_Response(array(
            'status' => 'received',
            'timestamp' => time()
        ), 200);
    }

    public function get_did_document($request)
    {
        $bridge = OAP_Bridge::get_instance();
        $did = $bridge->get_did();

        // Minimal DID Document
        $doc = array(
            '@context' => 'https://www.w3.org/ns/did/v1',
            'id' => $did,
            'verificationMethod' => array(
                array(
                    'id' => $did . '#key-1',
                    'type' => 'Ed25519VerificationKey2020',
                    'controller' => $did,
                    // Mock public key
                    'publicKeyMultibase' => 'z6MkpTHR8VNsBxYAAWh0...'
                )
            ),
            'authentication' => array(
                $did . '#key-1'
            )
        );

        return new WP_REST_Response($doc, 200);
    }
}
