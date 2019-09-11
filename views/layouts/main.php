<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\sidenav\SideNav;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode('') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" dir="rtl">
    <?php
    $languageItem = new cetver\LanguageSelector\items\DropDownLanguageItem([
        "languages" => [
            "en" => "<span class='flag-icon flag-icon-us'></span> English",
            "ar" => "<span class='flag-icon flag-icon-ar'></span> Arabic",
        ],
        "options" => ["encode" => false],
    ]);
    NavBar::begin([
        "brandLabel" => Yii::t("app","Doctor"),
        "brandUrl" => Yii::$app->homeUrl,
        "options" => [
            "class" => "navbar-inverse navbar-fixed-top",
        ],
    ]);
    echo Nav::widget([
        "options" => ["class" => "navbar-nav navbar-right"],
        "items" => [
            ["label" => Yii::t("app","Home"), "url" => ["/site/index"]],
            ["label" => Yii::t("app","Medicine"), "url" => ["/medicine/index"]],
            ["label" => Yii::t("app","Receipt"), "url" => ["/receipt/create"]],
            ["label" => Yii::t("app","Patients"), "url" => ["/receipt/index"]],
            ["label" => Yii::t("app","Setting"), "url" => ["/information/index"]],
        ],
    ]);
    NavBar::end();
    ?>



    <div class="container col-sm-9" dir="rtl">
        <?= Breadcrumbs::widget([
            "links" => isset($this->params["breadcrumbs"]) ? $this->params["breadcrumbs"] : [],
        ]) ?>
        <?= Alert::widget() ?>

        <?= $content ?>

    </div>

    <div class="container col-sm-3">
        <?= SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => '',
            'items' => [
                [
                    'url' => ["/site/index"]    ,
                    'label' => Yii::t("app","Home"),
                    'icon' => 'home'
                ],
                [
                    'label' => Yii::t("app","Patients"),
                    'icon' => 'question-sign',
                    'items' => [
                        ['label' => Yii::t("app","Patients"), 'icon'=>'info-sign', 'url'=>["/receipt/index"]],
                        ['label' => Yii::t("app","Receipt"), 'icon'=>'plus', 'url'=>["/receipt/create"]],
                    ],
                ],
            ],
        ]);

        ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
