<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 20.01.2020
 * Time: 23:35
 */

return [
    '<controller:[\w\-]+>' => '<controller>',
    '<controller:[\w\-]+>/<action:[\w\-]+>/<page:\d+>/<per-page:\d+>' => '/<controller>/<action>',
    '<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<controller>/<action>',
    '<controller:[\w\-]+>/<action:[\w\-]+>' => '<controller>/<action>',
];
