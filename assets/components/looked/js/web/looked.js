var Looked = {
    initialize: function(config) {
        actionPath = config.actionUrl;
        resId = config.id;
        selectorRemove = '.looked-remove';
        selectorRemoveParent = '.looked-';
        selectorBlock = '.looked-wrap';
        selectorCount = '.looked-count';

        $(document).on('click', selectorRemove, function() {
            var act = $(this).data('looked');

            if (act == 'looked/remove') {
                var id = $(this).data('id');
            } else if (act == 'looked/remove/all') {
                var id = 0;
            }

            var sendData = {
                action: $(this).data('looked'),
                resource: id,
                id: resId
            };

            Looked.send(sendData);
        });
    },

    send: function(sendData) {
        $.ajax({
            type: 'POST',
            url: actionPath,
            data: sendData,
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['success'] == true) {
                    if (data.count > 0) {
                        $(selectorRemoveParent + sendData.resource).remove();
                        $(selectorCount).text(data.count);
                    }
                    if ($(selectorRemove).length == 0 || data.count == 0) {
                        $(selectorBlock).remove();
                    }
                } else {
                    console.log(data);
                }
            },
            error: function(data){
                console.log(data);
            }
        });
    }
};
