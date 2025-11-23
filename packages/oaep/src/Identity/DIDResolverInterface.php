<?php

namespace OAP\Core\Identity;

interface DIDResolverInterface
{
    public function resolve(string $did): ?DIDDocument;
}
