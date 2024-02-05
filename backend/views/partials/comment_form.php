<?php if (!empty($comments)): ?>
    <?php foreach($comments as $comment): ?>
        <div class="single-blog-item single-blog-item-txt">
            <h4>Author: <?= $comment->user->name; ?> Date: <?= $comment->getDate(); ?></h4>
            <p><?php echo $comment->text; ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!Yii::$app->user->isGuest): ?>
    <?php if(Yii::$app->session->getFlash('comment')): ?>
        <div class='alert alert-success' role='alert'>
            <?= Yii::$app->session->getFlash('comment'); ?>
        </div>
    <?php endif; ?>
    <?php $form = \yii\widgets\ActiveForm::begin([
        'action' => ['site/comment', 'id' => $article->id], 
        'options' => ['class' => 'contact-form', 'role' => 'form'] 
    ]); ?>
    <?= $form->field($commentForm, 'comment')
                ->textarea(['class'=>'form-control','placeholder'=>'Write message here.'])
                ->label(false); ?>
    <button type='submit' class='btn btn-success '>Send</button>
    <?php \yii\widgets\ActiveForm::end(); ?>
<?php endif; ?>