<?php 
/**
 * @var Comment model
 */
?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3><?php echo Yii::t('CommentsModule.msg', 'Add comment'); ?></h3>
</div>
<div class="modal-body">

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action'=>Yii::app()->urlManager->createUrl($this->postCommentAction),
        'id'=>$this->id,
)); ?>
    <?php echo $form->errorSummary($newComment); ?>
    <?php 
        echo $form->hiddenField($newComment, 'owner_name'); 
        echo $form->hiddenField($newComment, 'owner_id'); 
        echo $form->hiddenField($newComment, 'parent_comment_id', array('class'=>'parent_comment_id'));
        if(!$newComment->isNewRecord){
            echo $form->hiddenField($newComment, 'comment_id');
        }
    ?>
    <?php if(Yii::app()->user->isGuest == true):?>
        <?php echo $form->textFieldRow($newComment,'user_name', array('size'=>40)); ?>
        <?php echo $form->textFieldRow($newComment,'user_email', array('size'=>40)); ?>
    <?php endif; ?>
        
    <?php echo $form->textAreaRow($newComment, 'comment_text', array('cols' => 150, 'rows' => 7, 'class'=>'span5')); ?>

    <?php if($this->useCaptcha === true && extension_loaded('gd')): ?>
        <?php $form->captchaRow($newComment, 'verifyCode', array(), array('captchaAction'=>Yii::app()->urlManager->createUrl(CommentsModule::CAPTCHA_ACTION_ROUTE),)) ?>
    <?php endif; ?>
<?php $this->endWidget(); ?>

</div>

<div class="modal-footer">
    <?php echo CHtml::button(Yii::t('CommentsModule.msg', 'Add comment'), array('class'=>'btn btn-primary post-comment',)); ?>
    <?php echo CHtml::button(Yii::t('CommentsModule.msg', 'Cancel'), array('class'=>'btn', 'data-dismiss'=>'modal')); ?>
</div>
