<?php

namespace App\Tests\data;

class first
{

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
