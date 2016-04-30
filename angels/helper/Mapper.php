<?php
namespace angels\helper;

class Mapper
{
    private $names = [

    ];

    public function getName($alias)
    {
        if (array_key_exists($alias, $this->names))
            return $this->names[$alias];
    }

    public function getAlias($name)
    {
        return array_search($name, $this->names);
    }
}