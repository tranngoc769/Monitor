<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-chart-three">
                            <div class="widget-heading">
                                <div class="">
                                    <h5 class="">Theo dõi : <?= $userdata->name ?></h5>
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
                                                <th>Trạng thái</th>
                                                <th class="">Thời gian chạy</th>
                                                <!-- <th>Đang chạy</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="watch" userid="<?= $userdata->id ?>">
                                            <tr>
                                                <td class="text-success"></td>
                                                <td></td>
                                                <td class=""><span class=" shadow-none badge outline-badge-primary"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
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