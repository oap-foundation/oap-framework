<?php

namespace OAP\Commerce\Validation;

class SchemaValidator
{
    public function validateSchema(array $jsonLd): bool
    {
        // Basic check for @type
        return isset($jsonLd['@type']);
    }

    public function validateProduct(array $productJson): bool
    {
        // Check for required Schema.org Product fields
        $required = ['name', 'offers']; // Simplified
        foreach ($required as $field) {
            if (!isset($productJson[$field])) {
                return false;
            }
        }
        return true;
    }
}
