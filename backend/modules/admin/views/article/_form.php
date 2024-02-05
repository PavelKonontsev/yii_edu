<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'id' => 'editor1']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'id' => 'editor2']) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

<!--    <?= $form->field($model, 'viewed')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?> -->

    <?= $form->field($model, 'category_id')->dropDownList(
            $categories,
           ['class' => 'form-control',],
        ) ?> 

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
