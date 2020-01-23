<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 22.01.2020
 * Time: 9:46
 */
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $gridColumns array */

?>

<div class="panel panel-primary panel-small m-b-0">
    <div class="panel-body panel-body-selected">
        <div class="pull-sm-right">
            <ul class="export-menu">
                <!--
                    I think there is no need in Export widget extended from original ExportMenu
                    Export menu can be configured so that reach the goal and force download
                        1. without confirmation popup 'showConfirmAlert' => false,
                        2. just csv no extra options (but they can be added if needed)
                           using exportConfig && asDropdown false
                        3. 'clearBuffers' => true solves problem with odd html in csv file
                -->
                <?= ExportMenu::widget([
                    'pjaxContainerId' => false,
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'showConfirmAlert' => false,
                    'exportType' => ExportMenu::FORMAT_CSV,
                    'exportConfig' => [
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_EXCEL => false,
                        ExportMenu::FORMAT_EXCEL_X => false,
                        ExportMenu::FORMAT_PDF => false,
                        ExportMenu::FORMAT_CSV => [
                            'icon' => false,
                            'linkOptions' => ['class' => 'btn btn-success'],
                        ],
                    ],
                    'asDropdown' => false,
                    'batchSize' => 2000,
                    'filename' => 'history-' . time(),
                    'clearBuffers' => true,
                ]); ?>
            <ul>
        </div>
    </div>
</div>
