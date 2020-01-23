<?php

namespace app\types\history\event;

use app\models\History;

use ReflectionClass;
use Yii;
use yii\base\ViewContextInterface;
use yii\web\View;

/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 20:48
 */

abstract class Type implements TypeInterface, ViewContextInterface
{
    /**
     * @var History
     */
    protected $history;

    /**
     * @var View
     */
    private $view;

    /**
     * Type constructor.
     *
     * @param History $history
     */
    public function __construct(History $history)
    {
        $this->history = $history;
    }

    /**
     * @param string $view
     * @param array $params
     *
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        return $this->getView()->render($view, $params, $this);
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        if ($this->view === null) {
            $this->view = Yii::$app->getView();
        }

        return $this->view;
    }

    /**
     * @return string
     */
    public function getViewPath(): string
    {
        $class = new ReflectionClass($this);

        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views';
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->render('default', [
            'model' => $this->history,
            'body' => $this->getBody(),
            'iconClass' => 'glyphicon glyphicon-cog bg-secondary',
        ]);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->history->eventText ?: '';
    }

    /**
     * @return string
     */
    protected function getIconClass(): string
    {
        return 'fa-gear bg-purple-light';
    }
}
