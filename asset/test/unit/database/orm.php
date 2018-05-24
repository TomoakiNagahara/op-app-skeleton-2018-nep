<?php
/**
 * unit-test:/unit/database/orm.php
 *
 * @creation  2018-05-17
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
include('connect.php');

/* @var $orm \OP\UNIT\ORM */
if(!$orm = Unit::Instance('ORM') ){
	return;
}

//	...
$orm->DB($db);

/* @var $record \OP\UNIT\ORM\Record */
if( $ai = ifset($_GET['ai']) ){
	//	Find single record by QQL. (QQL is "Quick Query Language")
	$record = $orm->Find("t_orm.ai = $ai"); // 't_test.ai = MAX()'
}else{
	//	Generate Empty "Record" Object.
	$record = $orm->Create("t_orm");
}

//	Generate form object.
$form = $record->Form();

//	Save to database by Record object.
$result = $form->Validate() ? $orm->Save($record): null;

//	Debug
D('ai', $ai);
D('result', $result);
D('Found', $record->isFound());
D('Validate', $record->isValid(), $record->Validate(), $form->Validate());

?>
<section id="testcase">
	<p class="<?= $record->isFound() ? 'blue':'red' ?>">Found record</p>
	<p class="<?= $record->isValid() ? 'blue':'red' ?>">Validate</p>
	<p class="<?= $result !== false  ? 'blue':'red' ?>">Result</p>

	<?php $form->Start() ?>
	<table>
		<?php foreach( ['number','integer','positive','text'] as $name ): ?>
		<tr>
			<th><?= $form->Label($name) ?></th>
			<td><?= $form->Input($name) ?></td>
			<td><?= $form->Error($name) ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan=2 style="text-align: center;">
				<button>
					<?= !$ai ? 'Create':'Update' ?>
				</button>
			</td>
		</tr>
	</table>
	<?php $form->Finish() ?>
	<hr/>
	<?php
	//	...
	foreach( $db->Quick('t_orm','order=timestamp desc, limit=10') as $temp ){
		printf('<a href="?ai=%s">Edit of ai is %s</a>', $temp['ai'], $temp['ai']);
		D($temp);
	}
	?>
</section>
<style>

#testcase th,
#testcase td {
	padding: 0 0.5em;
}

#testcase td:nth-child(3) > span:nth-child(2) {
	display: none;
}

</style>
<?
//	...
if( $_GET['debug'] ?? null ){
	$orm->Debug();
	$form->Debug();
	$record->Debug();
}
