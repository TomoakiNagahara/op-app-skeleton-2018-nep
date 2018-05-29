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

//	Join database object.
$orm->DB($db);

/* @var $record \OP\UNIT\ORM\Record */
if( $ai = ifset($_GET['ai']) ){
	//	Find single record by QQL. (QQL is "Quick Query Language")
	$record = $orm->Find("t_orm.ai = $ai"); // 't_test.ai = MAX()'
}else{
	//	Generate Empty "Record" Object.
	$record = $orm->Create("t_orm");
}

//	...
if(!$record->isReady() ){
	D(false);
	return;
}

//	In case of new record, Set create datetime.
if( $record->isFound() ){
	$record->Set('updated', Time::Datetime());
}else{
	$record->Set('created', Time::Datetime());
}

//	Generate form object.
$form = $record->Form();

//	Save to database by Record object.
$result = $form->Validate() ? $orm->Save($record): null;

//	Debug
/*
D('ai', $ai);
D('result', $result);
D('Found', $record->isFound());
D('Validate', $record->isValid(), $record->Validate(), $form->Validate());
*/

?>

<p class="<?= $record->isFound() ? 'blue':'red' ?>">Found record</p>
<p class="<?= $record->isValid() ? 'blue':'red' ?>">Validate</p>
<p class="<?= $result !== false  ? 'blue':'red' ?>">Result</p>

<?php $form->Start() ?>
<table class="testcase">
	<?php foreach( ['number','integer','positive','ascii','multibyte'] as $name ): ?>
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

<style>

table.testcase th,
table.testcase td {
	padding: 0 0.5em;
}

table.testcase td:nth-child(3) > span:nth-child(2) {
	display: none;
}

</style>

<?php
//	...
if( ifset($_GET['debug']) ){
	$orm->Debug();
	$form->Debug();
	$record->Debug();
}else{
	if(!$record->isValid() ){
		$form->Debug();
	}
}

//	...
foreach( $db->Quick('t_orm','order=timestamp desc, limit=10') as $temp ){
	printf('<a href="?ai=%s">Edit of ai is %s</a>', $temp['ai'], $temp['ai']);
	Json($temp, 'OP_DUMP');
}
