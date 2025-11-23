<?php

namespace OAP\Commerce\Transaction;

use OAP\Commerce\Messages\NegotiateRequest;
use OAP\Commerce\Messages\OfferResponse;
use OAP\Commerce\Messages\OrderRequest;
use OAP\Commerce\Messages\OrderConfirmation;
use Exception;

class CommerceTransaction
{
    private string $transactionId;
    private string $currentState;

    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
        $this->currentState = TransactionState::INIT;
    }

    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    public function createNegotiation(array $criteria): NegotiateRequest
    {
        if (!$this->canTransitionTo(TransactionState::NEGOTIATING)) {
            throw new Exception("Invalid state transition to NEGOTIATING from " . $this->currentState);
        }
        $this->currentState = TransactionState::NEGOTIATING;

        // Dummy data construction for the request
        return new NegotiateRequest($criteria, ['amount' => 1000, 'currency' => 'EUR'], 'https://schema.org/Product');
    }

    public function createOffer(NegotiateRequest $request, array $productData): OfferResponse
    {
        // In a real scenario, this would be called by the seller agent upon receiving a NegotiateRequest
        // For the state machine of the BUYER, receiving an offer transitions to OFFER_RECEIVED

        if (!$this->canTransitionTo(TransactionState::OFFER_RECEIVED)) {
            throw new Exception("Invalid state transition to OFFER_RECEIVED from " . $this->currentState);
        }
        $this->currentState = TransactionState::OFFER_RECEIVED;

        return new OfferResponse($productData, ['amount' => 999, 'currency' => 'EUR'], date('c', strtotime('+1 day')));
    }

    public function acceptOffer(OfferResponse $offer, $userIdentity): OrderRequest
    {
        if (!$this->canTransitionTo(TransactionState::ORDER_PENDING)) {
            throw new Exception("Invalid state transition to ORDER_PENDING from " . $this->currentState);
        }
        $this->currentState = TransactionState::ORDER_PENDING;

        return new OrderRequest('offer_123', [], []);
    }

    public function confirmOrder(OrderRequest $request): OrderConfirmation
    {
        if (!$this->canTransitionTo(TransactionState::ORDER_CONFIRMED)) {
            throw new Exception("Invalid state transition to ORDER_CONFIRMED from " . $this->currentState);
        }
        $this->currentState = TransactionState::ORDER_CONFIRMED;

        return new OrderConfirmation('order_123', 'CONFIRMED', []);
    }

    public function canTransitionTo(string $nextState): bool
    {
        $transitions = [
            TransactionState::INIT => [TransactionState::NEGOTIATING],
            TransactionState::NEGOTIATING => [TransactionState::OFFER_RECEIVED, TransactionState::CANCELLED],
            TransactionState::OFFER_RECEIVED => [TransactionState::ORDER_PENDING, TransactionState::NEGOTIATING, TransactionState::CANCELLED],
            TransactionState::ORDER_PENDING => [TransactionState::ORDER_CONFIRMED, TransactionState::CANCELLED],
            TransactionState::ORDER_CONFIRMED => [TransactionState::COMPLETED, TransactionState::CANCELLED],
            TransactionState::COMPLETED => [],
            TransactionState::CANCELLED => []
        ];

        return in_array($nextState, $transitions[$this->currentState] ?? []);
    }
}
