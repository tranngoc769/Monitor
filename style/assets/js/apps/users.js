$(document).ready(function() {

    $("svg[name=report]").on('click', function() {

        var getParentItem = $(this).parents('.items');
        var $_name = getParentItem.find('.usr-email-id');
        $userid = $_name.attr('data-email');
        console.log($userid)
        window.open("/admin/report?id=" + $userid, '_blank').focus();
    })
    $('#input-search').on('keyup', function() {
        var rex = new RegExp($(this).val(), 'i');
        $('.searchable-items .items:not(.items-header-section)').hide();
        $('.searchable-items .items:not(.items-header-section)').filter(function() {
            return rex.test($(this).text());
        }).show();
    });

    $('.view-grid').on('click', function(event) {
        event.preventDefault();
        /* Act on the event */

        $(this).parents('.switch').find('.view-list').removeClass('active-view');
        $(this).addClass('active-view');

        $(this).parents('.searchable-container').removeClass('list');
        $(this).parents('.searchable-container').addClass('grid');

        $(this).parents('.searchable-container').find('.searchable-items').removeClass('list');
        $(this).parents('.searchable-container').find('.searchable-items').addClass('grid');

    });

    $('.view-list').on('click', function(event) {
        event.preventDefault();
        /* Act on the event */
        $(this).parents('.switch').find('.view-grid').removeClass('active-view');
        $(this).addClass('active-view');

        $(this).parents('.searchable-container').removeClass('grid');
        $(this).parents('.searchable-container').addClass('list');

        $(this).parents('.searchable-container').find('.searchable-items').removeClass('grid');
        $(this).parents('.searchable-container').find('.searchable-items').addClass('list');
    });

    $('#btn-add-contact').on('click', function(event) {
        alert("Không hỗ trợ");
        return;
        $('#addContactModal #btn-add').show();
        $('#addContactModal #btn-edit').hide();
        $('#addContactModal').modal('show');
    })

    function editContact() {
        $('.edit').on('click', function(event) {
            $('#addContactModal #btn-add').hide();
            $('#addContactModal #btn-edit').show();

            // Get Parents
            var getParentItem = $(this).parents('.items');
            var getModal = $('#addContactModal');
            // Get List Item Fields
            var $_name = getParentItem.find('.usr-email-addr');
            var $_email = getParentItem.find('.usr-location');
            // Get Attributes
            var $_nameAttrValue = $_name.attr('data-email');
            var $_emailAttrValue = $_email.attr('data-email');
            // Get Modal Attributes
            var $_getModalNameInput = getModal.find('#c-name');
            var $_getModalEmailInput = getModal.find('#c-location');

            // Set Modal Field's Value
            $_getModalNameInput.val($_nameAttrValue);
            $_getModalEmailInput.val($_emailAttrValue);
            $('#addContactModal').modal('show');

            $("#btn-edit").off('click').click(function() {
                var getParent = $(this).parents('.modal-content');
                var $_getInputName = getParent.find('#c-name');
                var $_getInputNocation = getParent.find('#c-location');
                var $_nameValue = $_getInputName.val();
                var $_locationValue = $_getInputNocation.val();
                console.log($_nameValue)
                console.log($_locationValue)
                var form = new FormData();
                form.append("name", $_nameValue);
                form.append("mac", $_locationValue);
                var settings = {
                    "url": "update_user",
                    "method": "POST",
                    "timeout": 0,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": form
                };
                $.ajax(settings).done(function(response) {
                    console.log(response);
                    try {
                        response = JSON.parse(response);
                    } catch (error) {}
                    if (response.code != 200) {
                        alert("Không thành công");
                        return;
                    }
                    $_name.text($_nameValue);
                    $_email.text($_locationValue);
                }).fail(function(response) {
                    alert("Lỗi")
                    console.log(response);
                });

                $('#addContactModal').modal('hide');
            });
        })
    }

    $(".delete-multiple").on("click", function() {
        var inboxCheckboxParents = $(".contact-chkbox:checked").parents('.items');
        inboxCheckboxParents.remove();
    });
    editContact();

})