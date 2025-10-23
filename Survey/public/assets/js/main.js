$(document).ready(function(){
    $(document).on('change', '#step',function () {
        let stepValue = $(this).val(),
            url = $(location).attr('origin') + '/dashboard/groups/step/' + stepValue,
            groupSelect = $('#groups');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: "json",
            contentType: "application/json",
            success: function (data, url) {
                groupSelect.empty();
                groupSelect.append(`<option selected disabled> اختار ......</option>`);
                $.each(data, function (index, groups) {
                    groupSelect.append(`<option value='${groups.id}'> ${groups.number}</option>`);
                });
            },

        });
    })// End Get Groups



})
