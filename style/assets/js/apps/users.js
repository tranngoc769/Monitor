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
        alert("Không hỗ trợ");
        return;
        $('#addContactModal #btn-add').show();
        $('#addContactModal #btn-edit').hide();
        $('#addContactModal').modal('show');
    })

    function deleteContact() {
        $(".delete").on('click', function(event) {
            event.preventDefault();
            /* Act on the event */
            $(this).parents('.items').remove();
        });
    }

    function addContact() {
        $("#btn-add").click(function() {

            var getParent = $(this).parents('.modal-content');

            var $_name = getParent.find('#c-name');
            var $_email = getParent.find('#c-email');
            var $_occupation = getParent.find('#c-occupation');
            var $_phone = getParent.find('#c-phone');
            var $_location = getParent.find('#c-location');

            var $_getValidationField = document.getElementsByClassName('validation-text');
            var reg = /^.+@[^\.].*\.[a-z]{2,}$/;
            var phoneReg = /^\d*\.?\d*$/;

            var $_nameValue = $_name.val();
            var $_emailValue = $_email.val();
            var $_occupationValue = $_occupation.val();
            var $_phoneValue = $_phone.val();
            var $_locationValue = $_location.val();

            if ($_nameValue == "") {
                $_getValidationField[0].innerHTML = 'Name must be filled out';
                $_getValidationField[0].style.display = 'block';
            } else {
                $_getValidationField[0].style.display = 'none';
            }

            if ($_emailValue == "") {
                $_getValidationField[1].innerHTML = 'Email Id must be filled out';
                $_getValidationField[1].style.display = 'block';
            } else if ((reg.test($_emailValue) == false)) {
                $_getValidationField[1].innerHTML = 'Invalid Email';
                $_getValidationField[1].style.display = 'block';
            } else {
                $_getValidationField[1].style.display = 'none';
            }

            if ($_phoneValue == "") {
                $_getValidationField[2].innerHTML = 'Invalid (Enter 10 Digits)';
                $_getValidationField[2].style.display = 'block';
            } else if ((phoneReg.test($_phoneValue) == false)) {
                $_getValidationField[2].innerHTML = 'Please Enter A numeric value';
                $_getValidationField[2].style.display = 'block';
            } else {
                $_getValidationField[2].style.display = 'none';
            }

            if ($_nameValue == "" || $_emailValue == "" || (reg.test($_emailValue) == false) || $_phoneValue == "" || (phoneReg.test($_phoneValue) == false)) {
                return false;
            }

            $html = '<div class="items">' +
                '<div class="item-content">' +
                '<div class="user-profile">' +

                '<div class="n-chk align-self-center text-center">' +
                '<label class="new-control new-checkbox checkbox-primary">' +
                '<input type="checkbox" class="new-control-input contact-chkbox">' +
                '<span class="new-control-indicator"></span>' +
                '</label>' +
                '</div>' +

                '<img src="assets/img/90x90.jpg">' +
                '<div class="user-meta-info">' +
                '<p class="user-name" data-name=' + $_nameValue + '>' + $_nameValue + '</p>' +
                '<p class="user-work" data-occupation=' + $_occupationValue + '>' + $_occupationValue + '</p>' +
                '</div>' +
                '</div>' +
                '<div class="user-email">' +
                '<p class="info-title">Email: </p>' +
                '<p class="usr-email-addr" data-email=' + $_emailValue + '>' + $_emailValue + '</p>' +
                '</div>' +
                '<div class="user-location">' +
                '<p class="info-title">Location: </p>' +
                '<p class="usr-location" data-location=' + $_locationValue + '>' + $_locationValue + '</p>' +
                '</div>' +
                '<div class="user-phone">' +
                '<p class="info-title">Phone: </p>' +
                '<p class="usr-ph-no" data-phone=' + $_phoneValue + '>' + $_phoneValue + '</p>' +
                '</div>' +
                '<div class="action-btn">' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 edit"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-minus delete"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="23" y1="11" x2="17" y2="11"></line></svg>'
            '</div>' +
            '</div>' +
            '</div>';

            $(".searchable-items > .items-header-section").after($html);
            $('#addContactModal').modal('hide');

            var $_setNameValueEmpty = $_name.val('');
            var $_setEmailValueEmpty = $_email.val('');
            var $_setOccupationValueEmpty = $_occupation.val('');
            var $_setPhoneValueEmpty = $_phone.val('');
            var $_setLocationValueEmpty = $_location.val('');

            deleteContact();
            editContact();
            checkall('contact-check-all', 'contact-chkbox');
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
                    // $_getInputName.text($_nameValue);
                    // $_getInputNocation.text($_locationValue);
                    // $_getInputName.attr('data-name', $_nameValue);
                    // $_getInputNocation.attr('data-location', $_locationValue);
                    $_name.text($_nameValue);
                    $_email.text($_locationValue);
                    // var $_nameValue = $_getInputName.val();
                    // var $_emailValue = $_getInputNmail.val();
                    // var $_occupationValue = $_getInputNccupation.val();
                    // var $_phoneValue = $_getInputNhone.val();
                    // var $_locationValue = $_getInputNocation.val();

                    // var setUpdatedNameValue = $_name.text($_nameValue);
                    // var setUpdatedEmailValue = $_email.text($_emailValue);
                    // var setUpdatedOccupationValue = $_occupation.text($_occupationValue);
                    // var setUpdatedPhoneValue = $_phone.text($_phoneValue);
                    // var setUpdatedLocationValue = $_location.text($_locationValue);

                    // var setUpdatedAttrNameValue = $_name.attr('data-name', $_nameValue);
                    // var setUpdatedAttrEmailValue = $_email.attr('data-email', $_emailValue);
                    // var setUpdatedAttrOccupationValue = $_occupation.attr('data-occupation', $_occupationValue);
                    // var setUpdatedAttrPhoneValue = $_phone.attr('data-phone', $_phoneValue);
                    // var setUpdatedAttrLocationValue = $_location.attr('data-location', $_locationValue);
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


// Validation Process

var $_getValidationField = document.getElementsByClassName('validation-text');
var reg = /^.+@[^\.].*\.[a-z]{2,}$/;
var phoneReg = /^\d{10}$/;

getNameInput = document.getElementById('c-name');

getNameInput.addEventListener('input', function() {

    getNameInputValue = this.value;

    if (getNameInputValue == "") {
        $_getValidationField[0].innerHTML = 'Name Required';
        $_getValidationField[0].style.display = 'block';
    } else {
        $_getValidationField[0].style.display = 'none';
    }

})


getEmailInput = document.getElementById('c-email');

getEmailInput.addEventListener('input', function() {

    getEmailInputValue = this.value;

    if (getEmailInputValue == "") {
        $_getValidationField[1].innerHTML = 'Email Required';
        $_getValidationField[1].style.display = 'block';
    } else if ((reg.test(getEmailInputValue) == false)) {
        $_getValidationField[1].innerHTML = 'Invalid Email';
        $_getValidationField[1].style.display = 'block';
    } else {
        $_getValidationField[1].style.display = 'none';
    }

})

getPhoneInput = document.getElementById('c-phone');

getPhoneInput.addEventListener('input', function() {

    getPhoneInputValue = this.value;

    if (getPhoneInputValue == "") {
        $_getValidationField[2].innerHTML = 'Phone Number Required';
        $_getValidationField[2].style.display = 'block';
    } else if ((phoneReg.test(getPhoneInputValue) == false)) {
        $_getValidationField[2].innerHTML = 'Invalid (Enter 10 Digits)';
        $_getValidationField[2].style.display = 'block';
    } else {
        $_getValidationField[2].style.display = 'none';
    }

})