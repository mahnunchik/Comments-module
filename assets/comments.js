/**
 * jQuery Comments list plugin
 * @author Zasjadko Dmitry <segoddnja@gmail.com>
 */

;
(function($) {
    /**
	 * commentsList set function.
	 * @param options map settings for the comments list. Availablel options are as follows:
	 * - deleteConfirmString
         * - approveConfirmString
	 */
    $.fn.commentsList = function(options) {
        return this.each(function(){
            var settings = $.extend({}, $.fn.commentsList.defaults, options || {});
            var $this = $(this);
            var id = $this.attr('id');
            $.fn.commentsList.settings[id] = settings;
            $.fn.commentsList.initDialog(id);
            $this
            .delegate('.delete', 'click', function(){
                var id = $($(this).parents('.comment-widget')[0]).attr("id");
                if(confirm($.fn.commentsList.settings[id]['deleteConfirmString']))
                {
                    $.post($(this).attr('href'))
                    .success(function(data){
                        data = $.parseJSON(data);
                        if(data["code"] === "success")
                        {
                            $.fn.yiiListView.update('CommentsList-'+id);
                        }
                    });
                }
                return false;
            })
            
            .delegate('.edit-comment', 'click', function(){
                var id = $($(this).parents('.comment-widget')[0]).attr("id");
                $dialog = $("#addCommentDialog-"+id);
                
                $.post($(this).attr('href'))
                .success(function(data){
                    data = $.parseJSON(data);
                    $dialog.html(data["form"]);
                    $($dialog).modal('show');               
                });
                
                return false;
            })
            .delegate('.post-comment', 'click', function(){
                var id = $($(this).parents('.comment-widget')[0]).attr("id");
                $dialog = $("#addCommentDialog-"+id);
                $.fn.commentsList.postComment($dialog);
                return false;
            });
        });
    };
        
    $.fn.commentsList.defaults = {
        deleteConfirmString: 'Delete this comment?',
        approveConfirmString: 'Approve this comment?'
    };
        
    $.fn.commentsList.settings = {};
        
    $.fn.commentsList.initDialog = function(id){
        var $dialog = $('#addCommentDialog-'+id);
        
        $dialog.find('form').submit(function(){
            $.fn.commentsList.postComment($dialog);
            return false;
        });
            
        $dialog.data('widgetID', id);
    }
        
    $.fn.commentsList.postComment = function($dialog){
        var $form = $("form", $dialog);
        $.post(
            $form.attr("action"),
            $form.serialize()
        ).success(function(data){
            data = $.parseJSON(data);
            $dialog.html(data["form"]);
            if(data["code"] == "success")
            {
                $($dialog).modal('hide');
                var id = $dialog.data('widgetID');
                $.fn.yiiListView.update('CommentsList-'+id);
            }
        });
    }

})(jQuery);