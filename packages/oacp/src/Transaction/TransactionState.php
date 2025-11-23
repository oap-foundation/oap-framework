<?php

namespace OAP\Commerce\Transaction;

class TransactionState
{
    const INIT = 'INIT';
    const NEGOTIATING = 'NEGOTIATING';
    const OFFER_RECEIVED = 'OFFER_RECEIVED';
    const ORDER_PENDING = 'ORDER_PENDING';
    const ORDER_CONFIRMED = 'ORDER_CONFIRMED';
    const COMPLETED = 'COMPLETED';
    const CANCELLED = 'CANCELLED';
}
