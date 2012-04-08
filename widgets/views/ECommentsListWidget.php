<div class="comment-widget" id="<?php echo $this->id?>">
<h3><?php echo Yii::t('CommentsModule.msg', 'Comments');?></h3>
<?php
    $this->widget('ext.bootstrap.widgets.BootListView', array(
        'id'=>'CommentsList-'.$this->id,
        'dataProvider'=>$comments,
        'itemView'=>'ECommentsWidgetComments',
    )); 
    
    if($this->registeredOnly === false || Yii::app()->user->isGuest === false)
    {   
        $this->beginWidget('bootstrap.widgets.BootModal', array(
            'id'=>'addCommentDialog-' . $this->id,
            'htmlOptions'=>array('class'=>'hide'),
            'events'=>array(
                'show'=>"js:function() { console.log('modal show.'); }",
                'shown'=>"js:function() { console.log('modal shown.'); }",
                'hide'=>"js:function() { console.log('modal hide.'); }",
                'hidden'=>"js:function() { console.log('modal hidden.'); }",
            ),
        )); ?>

            <?php
                $this->widget('comments.widgets.ECommentsFormWidget', array(
                    'model' => $this->model,
                ));
            ?>
        <?php $this->endWidget();
    }
    
    if($this->registeredOnly === false || Yii::app()->user->isGuest === false)
    {
        echo CHtml::link(Yii::t('CommentsModule.msg', 'Add comment'), '#addCommentDialog-' . $this->id, array('class'=>'btn btn-primary', 'data-toggle'=>'modal'));
    }
    else 
    {
        echo '<strong>'.Yii::t('CommentsModule.msg', 'You cannot add a new comment').'</strong>';
    }
?>
</div>
