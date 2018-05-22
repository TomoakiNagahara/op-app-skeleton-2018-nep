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

//	Save to database by Record object.
$result = $record->Validate() ? $orm->Save($record): null;

//	...


//	...
D('ai', $ai);
D('result', $result);
D('Found', $record->isFound());
D('Validate', $record->isValid(), $record->Validate());

//	Generate form object.
$form = $record->Form();
?>

<?php $form->Start() ?>
<table>
	<?php foreach( ['number','text'] as $name ): ?>
	<tr>
		<th><?= $form->Label($name) ?></th>
		<td><?= $form->Input($name) ?></td>
		<td><?= $form->Error($name) ?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<td colspan=3 style="text-align: center;">
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
foreach( $db->Quick('t_orm','order=timestamp desc, limit=10') as $record ){
	printf('<a href="?ai=%s">Edit of ai is %s</a>', $record['ai'], $record['ai']);
	D($record);
}

//	...
$orm->Debug();
//$record->Debug();
