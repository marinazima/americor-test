<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 20.01.2020
 * Time: 22:28
 */

namespace app\dto;


class HistoryDto
{
    /**
     * @var string
     */
    protected $old;

    /**
     * @var array
     */
    protected $new;

    /**
     * UserDto constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->old = $params['old'] ?? null;
        $this->new = $params['new'] ?? null;
    }

    /**
     * @return string
     */
    public function getOld()
    {
        return $this->old;
    }

    /**
     * @return array
     */
    public function getNew()
    {
        return $this->new;
    }
}