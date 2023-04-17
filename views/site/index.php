<?php

/** @var yii\web\View $this */

/**
 * @var $courses - массив курсов
 */

use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Курсы';
$finishArr = array_filter($courses, function ($item) {
    return !($item['finished'] ?? false);
});
unset($item);

?>
<div class="site-index">
	<?php if (!Yii::$app->user->isGuest && !$finishArr): ?>
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">Курсы пройдены!!!!</p>
    </div>
	<?php endif; ?>
    <div class="body-content">
		<h2>Курсы</h2>
        <div class="row">
			<?php if (Yii::$app->user->isGuest): ?>
			<p>Зарегистрируйтесь или войдите в свой аккаунт</p>
			<?php else: ?>
			<div class="col">
                <?php foreach ($courses as $cours): ?>
					<div class="col-lg-6 custom_course_list">
						<h2><?php echo $cours['name'] ?></h2>
						<span class="double_check"><?php echo (($cours['finished'] ?? false)) ? 'Пройден ✔</i>' : 'Не пройден'; ?></span>
                        <?php if(!($cours['finished'] ?? false)): ?>
							<p><a class="btn btn-outline-secondary" href="<?php echo Url::to(['site/view', 'id' => $cours['id']]); ?>">Пройти курс</a></p>
                        <?php endif; ?>
					</div>
                <?php endforeach; ?>
			</div>
			<?php endif; ?>
        </div>

    </div>
</div>
<div>
    <?php $form = ActiveForm::begin([
		'id' => 'addcourse-form',
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n{input}\n{error}",
			'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
			'inputOptions' => ['class' => 'col-lg-3 form-control'],
			'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
		],
	]); ?>

	<div class="form-group row required">
		<label class="col-lg-1 col-form-label mr-lg-3" for="course_name">Название курса</label>
		<input type="text" id="course_name" class="col-lg-3 form-control is-invalid" name="CoursesHelper[name]" autofocus="" aria-required="true" aria-invalid="true">
		<div class="col-lg-7 invalid-feedback">Заполните поле</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-1 col-form-label mr-lg-3" for="url_attach_video">Ссылка на видео</label>
		<input type="text" id="url_attach_video" class="col-lg-3 form-control" name="CoursesHelper[url]" autofocus="" aria-required="true" aria-invalid="true">

	</div>
	<div class="form-group row">
		<label class="col-lg-1 col-form-label mr-lg-3" for="description">Описание</label>
		<textarea type="text" id="description" class="col-lg-3 form-control" name="CoursesHelper[description]" autofocus="" aria-required="true" aria-invalid="true"></textarea>
	</div>


	<div class="form-group">
		<div class="offset-lg-1 col-lg-11">
            <?php echo Html::a('Добавить курс',null, ['class' => 'btn btn-primary add_course', 'type' => 'button']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>
</div>