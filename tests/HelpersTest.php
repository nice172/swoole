<?php

/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
class HelpersTest extends PHPUnit_Framework_TestCase
{
    public function testParseUri()
    {
        $info = parse_address('http://examples.com:9527');

        print_r($info);
    }
}
