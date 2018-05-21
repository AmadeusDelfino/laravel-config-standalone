<?php

namespace Adelf\Config;


class Config extends Singletonable
{
    private $repository;

    protected function configure($instance)
    {
        $this->repository = new ConfigBag();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repository, $name], $arguments);
    }
}