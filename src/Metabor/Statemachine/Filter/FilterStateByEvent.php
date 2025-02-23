<?php

namespace Metabor\Statemachine\Filter;

use MetaborStd\Statemachine\StateInterface;

/**
 * @author otischlinger
 */
class FilterStateByEvent extends \FilterIterator
{
    /**
     * @var string
     */
    private $eventName;

    /**
     * @param string $eventName
     */
    public function __construct(\Traversable $states, $eventName)
    {
        parent::__construct(new \IteratorIterator($states));
        $this->eventName = $eventName;
    }

    /**
     * @see FilterIterator::accept()
     */
    public function accept(): bool
    {
        /* @var $state StateInterface */
        $state = $this->current();

        return $state->hasEvent($this->eventName);
    }
}
