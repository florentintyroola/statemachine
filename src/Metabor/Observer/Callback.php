<?php

namespace Metabor\Observer;

use MetaborStd\CallbackInterface;

/**
 * @author Oliver Tischlinger
 */
class Callback implements \SplObserver
{
    /**
     * @var CallbackInterface
     */
    private $callback;

    /**
     * @param CallbackInterface $callback
     */
    public function __construct(CallbackInterface $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @see \SplObserver::update()
     */
    public function update(\SplSubject $subject): void
    {
        $this->callback->__invoke($subject);
    }
}
