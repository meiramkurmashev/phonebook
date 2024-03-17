<?php
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\helpers\Html;
?>
<script>
	function tableSearch() {
    var phrase = document.getElementById('search-text');
    var table = document.getElementById('info-table');
    var regPhrase = new RegExp(phrase.value, 'i');
    var flag = false;
    for (var i = 1; i < table.rows.length; i++) {
        flag = false;
        for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
            flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
            if (flag) break;
        }
        if (flag) {
            table.rows[i].style.display = "";
        } else {
            table.rows[i].style.display = "none";
        }

    }
}
</script>
<h1>Телефоны:</h1>
<?= Html::a("Добавить",["add"],['class'=>'btn btn-info'])?>
<ul>


<table  class="table table-striped" id="info-table">
	<input class="form-control" type="text" placeholder="Фамилия или телефон" id="search-text" onkeyup="tableSearch()">
	<?php echo  $sort->link('fio') ; foreach ($records as $record){ ?>
	<tr>
		<td><a href="<?=Yii::$app->urlManager->createUrl(['site/edit', 'id' => $record->id] )?>"><?=$record->fio?>: </b></a></td>
		<td><?=$record->phone?></td>
		<td><?= Html::a("удалить",['site/delete', 'id' => $record->id ],['class'=>'btn btn-outline-danger btn-sm'])?></td>
	</tr>
	<?php } ?>
</table>


</ul>
<?= LinkPager::widget(['pagination' => $pagination]) ?>