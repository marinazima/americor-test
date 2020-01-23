<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 20:49
 */

namespace app\types\history\event;


interface TypeInterface
{
    /**
     * @return string
     */
    public function getTemplate(): string;

    /**
     * @return string
     */
    public function getBody(): string;
}