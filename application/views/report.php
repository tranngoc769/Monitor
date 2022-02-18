<?php
function convert_time($seconds)
{
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t / 3600), ($t / 60 % 60), $t % 60);
}
?>
<link href="/style/plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
<link href="/style/plugins/noUiSlider/nouislider.min.css" rel="stylesheet" type="text/css">
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="row">
                    <div class="col-lg-4 col-12 layout-spacing">
                        <div class="form-group mb-0">
                            <input id="fromPicker" value="<?= $from ?>" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date.." readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 layout-spacing">
                        <div class="form-group mb-0">
                            <input id="toPicker" value="<?= $to ?>" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date.." readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 layout-spacing">
                        <div class="form-group mb-0">
                            <button id="filter" type="button" name="Lọc" class="btn-primary form-control flatpickr flatpickr-input active">Lọc</button>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-chart-three">
                            <div class="widget-heading">
                                <div class="">
                                <h5 class="">Theo dõi : <?= $userdata->name ?></h5>
                                <input id="username" value="<?= $userdata->id ?>" hidden>
                                    
                                </div>
                                <div class="dropdown  custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-condensed mb-4">
                                        <thead>
                                            <tr>
                                                <th>Process</th>
                                                <th>Tên ứng dụng</th>
                                                <th class="">Thời gian chạy</th>
                                                <!-- <th>Đang chạy</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="watch" userid="<?= $userdata->id ?>">
                                            <?php foreach ($reports as $key => $app) : ?>
                                                <tr>
                                                    <td class="text-success"><?= $key ?></td>
                                                    <td><?= $app["detail"] ?></td>
                                                    <td class=""><?= convert_time($app["online"]) ?><span class=" shadow-none badge outline-badge-primary"></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-activity-three">
                    <div class="widget-heading">
                        <h5 class="">Thông báo</h5>
                    </div>

                    <div class="widget-content">
                        <div class="mt-container mx-auto">
                            <div class="timeline-line">
                                <?php foreach ($logs as $i => $log) : ?>
                                    <div class="item-timeline timeline-new">
                                        <div class="t-dot">
                                            <div class="t-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                    <polyline points="22,6 12,13 2,6"></polyline>
                                                </svg></div>
                                        </div>
                                        <div class="t-content">
                                            <div class="t-uppercontent">
                                                <h5><?= $log->name ?></h5>
                                                <span class=""><?= $log->datetime ?></span>
                                            </div>
                                            <p><?= $log->message ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
</div>
<script src="/style/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="/style/bootstrap/js/popper.min.js"></script>
<script src="/style/bootstrap/js/bootstrap.min.js"></script>
<script src="/style/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/style/assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>