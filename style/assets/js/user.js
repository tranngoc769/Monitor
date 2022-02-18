const every = 5000;
toHHMMSS = function(string) {
    var sec_num = parseInt(string, 10);
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours < 10) { hours = "0" + hours; }
    if (minutes < 10) { minutes = "0" + minutes; }
    if (seconds < 10) { seconds = "0" + seconds; }
    return hours + ':' + minutes + ':' + seconds;
}
$(document).ready(function() {
    function get_data() {
        var settings = {
            "url": "/admin/get_user?id=" + userid,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function(response) {
            try {
                response = JSON.parse(response)
            } catch (error) {

            }
            let data = response.msg;

            if (data.length == 0) {
                alert("Không có dữ liệu");
                return;
            }
            let history = data[0].data;
            try { history = JSON.parse(history) } catch (error) {}
            var innerHTML = ``
            for (var [key, val] of Object.entries(history)) {
                console.log(val)
                let is_online = val.is_online;
                if (is_online == true) {
                    is_online = "Đang hoạt động";
                } else {
                    is_online = "Ngừng hoạt động";
                }
                innerHTML += `
                    <tr>
                        <td class="text-success">${key}</td>
                        <td>${val.detail}</td>
                        <td class="text-success">${is_online}</td>
                        <td class=""><span class=" shadow-none badge outline-badge-primary">${toHHMMSS(parseInt(val.time_online))}</span></td>
                    </tr>
                `
            }
            var watch_tbody = $("#watch")[0];
            watch_tbody.innerHTML = innerHTML;

        }).fail(function(response) {
            console.log(response);
        });
    }
    var watch = $("#watch")[0];
    var userid = watch.getAttribute("userid")
    get_data()
    setInterval(get_data, every)
});