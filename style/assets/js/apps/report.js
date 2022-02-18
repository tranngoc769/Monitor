var from_date = flatpickr(document.getElementById('fromPicker'));
var to_date = flatpickr(document.getElementById('toPicker'));
$(document).ready(function() {
    $("#filter").on('click', function() {
        let from = $("#fromPicker").val();
        let to = $("#toPicker").val();
        let userid = $("#username").val();
        let url = `/admin/report?id=${userid}&from=${from}&to=${to}`
        window.location.replace(url);
    })
})