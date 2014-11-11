<?php namespace Conductor\Laravel\Commands;

class InputParser
{

    /**
     * Parse the command input.
     *
     * @param $name
     * @param $properties
     * @return CliInput
     */
    public function parse($name, $properties)
    {

        $segments   = explode('\\', str_replace('/', '\\', $name));
        $name       = array_pop($segments);
        $namespace  = implode('\\', $segments);
        $properties = $this->parseProperties($properties);

        return new CliInput($name, $namespace, $properties);
    }

    /**
     * Parse the properties for a command.
     *
     * @param $properties
     * @return array
     */
    private function parseProperties($properties)
    {

        return preg_split('/ ?, ?/', $properties, null, PREG_SPLIT_NO_EMPTY);
    }
}
