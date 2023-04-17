<?php

/**
 * @var $model
 */
use yii\bootstrap4\Html;

?>
<div class="body-content">

	<div class="row" style="flex-direction:column;">
		<h1><?php echo $model->name; ?></h1>
		<div>
			<p><?php echo $model->description; ?></p>
		</div>
		<iframe width="560" height="315" src="<?php echo $model->url; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
		<div style="margin-top:25px">
            <?php echo Html::a('Завершить курс', null,['type' => 'button', 'class' => 'btn btn-outline-secondary finish_course']) ?>
		</div>
	</div>

</div>
