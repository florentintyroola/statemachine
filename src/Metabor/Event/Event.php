<?php

namespace Metabor\Event;

use Metabor\KeyValue\Nullable;
use Metabor\Observer\Subject;
use Metabor\Statemachine\Util\ArrayAccessToArrayConverter;
use MetaborStd\Event\EventInterface;
use MetaborStd\MetadataInterface;

/**
 * @author Oliver Tischlinger
 */
class Event extends Subject implements EventInterface, \ArrayAccess, MetadataInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $invokeArgs = array();

    /**
     * @var \ArrayAccess
     */
    private $metadata;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct();
        $this->name = $name;
        $this->metadata = new Nullable();
    }

    /**
     * @see MetaborStd\Event.EventInterface::getInvokeArgs()
     */
    public function getInvokeArgs()
    {
        return $this->invokeArgs;
    }

    /**
     * @see \MetaborStd\CallbackInterface::__invoke()
     */
    public function __invoke()
    {
        $this->invokeArgs = func_get_args();
        $this->notify();
        $this->invokeArgs = array();
    }

    /**
     * @see \MetaborStd\NamedInterface::getName()
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @see \ArrayAccess::offsetExists()
     */
    public function offsetExists($offset): bool
    {
        return $this->metadata->offsetExists($offset);
    }

    /**
     * @see \ArrayAccess::offsetGet()
     */
    public function offsetGet($offset): mixed
    {
        return $this->metadata->offsetGet($offset);
    }

    /**
     * @see \ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value): void
    {
        $this->metadata->offsetSet($offset, $value);
    }

    /**
     * @see \ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset): void
    {
        $this->metadata->offsetUnset($offset);
    }

    /**
     * @see \MetaborStd\MetadataInterface::getMetadata()
     */
    public function getMetadata()
    {
        $converter = new ArrayAccessToArrayConverter($this->metadata);

        return $converter->toArray();
    }
}
