<?php

declare(strict_types=1);

namespace Framework;

/**
 * Class Component
 * @package Framework
 */
class Component
{
    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        $getter = 'get' . $name;

        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        throw new \Exception('Getting unknown property');
    }
}