<?php

namespace Outside\Project;

class first
{
    public function simpleMethod(): bool
    {
        return true;
    }
}

class Second
{

}

abstract class abstractMain implements plainInterface
{

}

abstract class simpleAbstract
{

}

interface plainInterface
{

}


class inherited extends abstractMain
{

}

interface FancyInterface extends plainInterface
{

}

class Third extends abstractMain implements FancyInterface
{

}
