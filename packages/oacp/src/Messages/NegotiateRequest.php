<?php

namespace OAP\Commerce\Messages;

class NegotiateRequest
{
    public array $criteria;
    public array $budget;
    public string $category;

    public function __construct(array $criteria, array $budget, string $category)
    {
        $this->criteria = $criteria;
        $this->budget = $budget;
        $this->category = $category;
    }

    public function toArray(): array
    {
        return [
            '@type' => 'NegotiateRequest',
            'criteria' => $this->criteria,
            'budget' => $this->budget,
            'category' => $this->category
        ];
    }
}
