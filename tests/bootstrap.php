<?php

if (class_exists('PHPUnit_Framework_Constraint')) {
    class_alias('PHPUnit_Framework_Constraint', '\PHPUnit\Framework\Constraint\Constraint');
}
