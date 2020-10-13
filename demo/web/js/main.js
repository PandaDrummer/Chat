function hidemessage(id){
    $.ajax({
            url: '/site/hide-message',
            type: 'GET',
            data: {id: id },
            success:function(res){
                console.log(res);
            }
        }
    );
    $.pjax.reload({container: '#pjaxContent'});
}


function showmessage(id){
    $.ajax({
            url: '/site/show-message',
            type: 'GET',
            data: {id: id },
            success:function(res){
                console.log(res);
            }
        }
    );
    $.pjax.reload({container: '#pjaxContent'});
}