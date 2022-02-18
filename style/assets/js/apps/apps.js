$(document).ready(function() {


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
        $('#addContactModal #btn-add').show();
        $('#addContactModal #btn-edit').hide();
        $('#addContactModal').modal('show');
    })

    function deleteContact() {
        $(".delete").on('click', function(event) {
            event.preventDefault();
            /* Act on the event */
            var getParentItem = $(this).parents('.items');
            var getModal = $('#addContactModal');
            // Get List Item Fields
            var $_name = getParentItem.find('.usr-email-addr');
            // Get Attributes
            var $_nameAttrValue = $_name.attr('data-email');
            console.log($_nameAttrValue);
            var form = new FormData();
            form.append("name", $_nameAttrValue);
            var settings = {
                "url": "delete_app",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };

            var parent = $(this).parents('.items');
            $.ajax(settings).done(function(response) {
                try {
                    response = JSON.parse(response);
                } catch (error) {

                }
                if (response.code != 200) {
                    alert("Không thành công");
                    return;
                }
                parent.remove();
            }).fail(function(response) {
                alert("Lỗi")
                console.log(response);
            });
        });
    }

    function addContact() {
        $("#btn-add").click(function() {
            var $_getValidationField = document.getElementsByClassName('validation-text');
            var getParent = $(this).parents('.modal-content');
            var $_name = getParent.find('#c-name');
            var $_location = getParent.find('#c-location');
            var $_nameValue = $_name.val();
            var $_locationValue = $_location.val();

            if ($_nameValue == "") {
                $_getValidationField[0].innerHTML = 'Tên dịch vụ không được trống';
                $_getValidationField[0].style.display = 'block';
                return;
            } else {
                $_getValidationField[0].style.display = 'none';
            }
            if ($_locationValue == "") {
                $_getValidationField[0].innerHTML = 'Tên ứng dụng không được để trống';
                $_getValidationField[0].style.display = 'block';
                return;
            } else {
                $_getValidationField[0].style.display = 'none';
            }

            if ($_nameValue == "" || $_locationValue == "") {
                alert("Nhập đủ thông tin")
                return false;
            }
            var form = new FormData();
            form.append("name", $_nameValue);
            form.append("detail", $_locationValue);
            var settings = {
                "url": "add_app",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };
            $.ajax(settings).done(function(response) {
                try {
                    response = JSON.parse(response);
                } catch (error) {

                }
                console.log(response);
                if (response.code != 200) {
                    alert("Không thành công");
                    return;
                }
                $html = `<div class="items">
                <div class="item-content">
                    <div class="user-email">
                        <p class="info-title">Tên dịch vụ: </p>
                        <p class="usr-email-addr" data-email="${$_nameValue}">${$_nameValue}</p>
                    </div>
                    <div class="user-location">
                        <p class="info-title">Tên ứng dụng: </p>
                        <p class="usr-location" data-email="${$_nameValue}">${$_nameValue}</p>
                    </div>
                    <div class="action-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 edit">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-minus delete">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                    </div>
                </div>
            </div>`;
                $(".searchable-items > .items-header-section").after($html);
                $('#addContactModal').modal('hide');

                $_name.val('');
                $_location.val('');
            }).fail(function(response) {
                alert("Lỗi")
                console.log(response);
            });
            // deleteContact();
            // editContact();
        });
    }
    // $('#addContactModal').on('hidden.bs.modal', function(e) {
    //     var $_name = document.getElementById('c-name');
    //     var $_email = document.getElementById('c-email');
    //     var $_occupation = document.getElementById('c-occupation');
    //     var $_phone = document.getElementById('c-phone');
    //     var $_location = document.getElementById('c-location');
    //     var $_getValidationField = document.getElementsByClassName('validation-text');

    //     var $_setNameValueEmpty = $_name.value = '';
    //     var $_setEmailValueEmpty = $_email.value = '';
    //     var $_setOccupationValueEmpty = $_occupation.value = '';
    //     var $_setPhoneValueEmpty = $_phone.value = '';
    //     var $_setLocationValueEmpty = $_location.value = '';

    //     for (var i = 0; i < $_getValidationField.length; i++) {
    //         e.preventDefault();
    //         $_getValidationField[i].style.display = 'none';
    //     }
    // })
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
                form.append("detail", $_locationValue);
                var settings = {
                    "url": "update_app",
                    "method": "POST",
                    "timeout": 0,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": form
                };
                $.ajax(settings).done(function(response) {
                    try {
                        response = JSON.parse(response);
                    } catch (error) {

                    }
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

    deleteContact();
    addContact();
    editContact();

})