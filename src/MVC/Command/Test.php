<?php

namespace MVC\Command;

/**
 * Functions of Test
 *
 * @author Ramón Serrano
 */
interface Test {

    function buildUnitTest();
    
    function makeUnitTest( $name_file, $path_file);

}