<?php namespace Portico\SessionUser\Test;

class App
{
    protected $stored = [];

    public function bind($name, $value)
    {
        $this->stored[$name] = $value;
    }

    public function make($name)
    {
        return $this->stored[$name]();
    }

    public function has($name)
    {
        return isset($this->stored[$name]);
    }

} 