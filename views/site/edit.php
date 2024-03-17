<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin();?>
<?= $form->field($model, 'fio')?>
<?= $form->field($model, 'phone')?>

<div class="form-group">
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>


<?php ActiveForm::end();?>

