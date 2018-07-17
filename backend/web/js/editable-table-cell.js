
    $('.status').on('change', function () {
        var newStatus = this.value;
        var fieldId = $(this).parent().parent().data('key');
        alert(newStatus);
        alert(fieldId);
        $.ajax({
            url : '/admin/admin/bid/update-bid-status',
            type : "POST",
            async: false,
            data: {'status':newStatus, 'id':fieldId},

            success : function (data) {
                // return true;
                console.log(data);
            },

            error : function (data) {
                console.log(data);
            }
        });


    });

    $(document).on({
        ajaxStart: function () {
            $('#loader').show();
        },

        ajaxStop: function () {
            $('#loader').hide();
        }
    });

