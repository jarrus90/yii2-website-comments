(function ($) {
    var alert = $('#website-comment .reply-block');
    var commentIdInput = $('#comment-parent_id');
    $('.comment-reply').click(function () {
        var commentId = $(this).data('id');
        var comment = $(this).closest('.website-comment');
        commentIdInput.val(commentId);
        alert.find('.username').text(comment.find('.comment-from').first().text());
        alert.find('.message').text(comment.find('.comment-content').first().text());
        alert.addClass('active');
        $("html, body").animate({scrollTop: $('#website-comment').offset().top - 50}, "fast");
    });
    alert.find('.close').click(function(){
        $('#comment-parent_id').val(null);
        alert.removeClass('active');
    });
})(jQuery);