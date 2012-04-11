<?php $comment = $data; ?>
<div id="comment-<?php echo $comment->comment_id; ?>" class="comment">
    <div class="row comment-header">
        <div class="span2 name-panel">
            <?php echo CHtml::link($comment->userName, array("/profile/view","id"=>$comment->creator_id)).' '.CHtml::link('<i class="icon-envelope"></i>',
                            array('message/compose', 'id'=>$comment->creator_id),
                            array('class'=>'btn btn-mini', 'rel'=>"tooltip", 'title'=>"Отправить сообщение")); ?>
        </div>
        <div class="span6 admin-panel">
            <?php echo Yii::t('CommentsModule.msg', 'Created:'); ?>
            <?php echo Yii::app()->dateFormatter->formatDateTime($comment->create_time);?>
            <?php
            if($this->adminMode === true || $comment->creator_id == Yii::app()->user->id){
                echo CHtml::link(Yii::t('CommentsModule.msg', 'delete'), Yii::app()->urlManager->createUrl(
                    CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                ), array('class'=>'delete btn btn-mini btn-danger'));
            }?>
            <?php
            if($this->adminMode === true || $comment->creator_id == Yii::app()->user->id){
                echo CHtml::link(Yii::t('CommentsModule.msg', 'edit'), Yii::app()->urlManager->createUrl(
                    $this->postCommentAction, array('id'=>$comment->comment_id)
                ), array('class'=>'edit-comment btn btn-mini btn-success'));
            }?>
        </div>
    </div>
    <hr>
    
    <div class="row comment-body">
        <div class="span2 photo-panel">         
            <ul class="thumbnails">
                <li class="span2">
                    <?php 
                        $thumbnail_id = $comment->user->profile->thumbnail_id ? $comment->user->profile->thumbnail_id : 1;
                        echo CHtml::link(CHtml::image(Yii::app()->image->getURL($thumbnail_id,"span2")) ,
                            array("/profile/view","id"=>$comment->creator_id), array('class'=>'thumbnail')
                        );
                    ?> 
                </li>
            </ul>
            
        </div>
        <div class="span6 text-panel">
            <?php echo CHtml::encode($comment->comment_text);?>
        </div>
    </div>
</div>
       

