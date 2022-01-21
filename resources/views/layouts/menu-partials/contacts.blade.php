@include('layouts.menu-partials.social')
<div class="contacts">
    <?php
    $data = json_decode($restaurant->contacts);
    $IS__LOCATION_FOUND = false;
    if ($data) {
    ?>
        <!-- location links part started -->
        <div class=" col-lg-6 col-md-12 col-sm-12 offset-lg-3" >
            <br>
            <?php
            foreach ($data as $name => $value) {

                if ($value[3] == "location") {
                    $IS__LOCATION_FOUND = true;
                    break;
                }
            }

            if ($IS__LOCATION_FOUND) {
            ?>
                <button id="location" class="btn btn-default border btn-sm bg-white" style="font-size: 1.3rem;text-align:center;box-shadow: rgb(0 0 0 / 18%) 0px 6px 15px;border-radius: 10px;display:inline-block">
                    <b>
                    الموقع
                    </b>
                    <i class="fa fa-angle-down"></i>
                </button>

            <?php
            }
            ?>

            <div class="location my-2" style="display:flex;justify-content: center;overflow: auto;">

                <?php
                foreach ($data as $name => $value) {

                    if ($value[3] == "location") {
                        $IS__LOCATION_FOUND = true;
                ?>
                        <div class="mx-2">
                            <a href="<?php echo $value[1] ?>" class="mr-1" style="text-decoration:none" style="font-size:20px;">
                                <div>
                                    <img width="30" height="40" style="border-radius:40px" src="/public/images/ourlocation.png" />
                                    <br>
                                    <b class="phone"> <?php echo $value[2]; ?></b>
                                </div>

                            </a>
                        </div>
                <?php
                    }
                }
                ?>

            </div>
        </div>
        <!-- location links part ended -->
    <?php
    }
    ?>
    <?php
    $data = json_decode($restaurant->contacts);
    $IS__SOCIAL_FOUND = false;
    if ($data) {
    ?>
        <!-- social links part started -->
        <div class="  col-lg-6 col-md-12 col-sm-12 offset-lg-3" >

            <br>
            <?php

            foreach ($data as $name => $value) {

                if ($value[3] == "social") {
                    $IS__SOCIAL_FOUND = true;
                    break;
                }
            }

            if ($IS__SOCIAL_FOUND) {
            ?>
                <button id="social" class="btn btn-default border btn-sm bg-white" style="font-size: 1.3rem;text-align:center;box-shadow: rgb(0 0 0 / 18%) 0px 6px 15px;border-radius: 10px;display:inline-block">
                    <b>
                            الطلبات                   
                     </b>
                    <i class="fa fa-angle-down"></i>
                </button>

            <?php
            }
            ?>

            <div class="social my-2" style="display:flex;justify-content: center;overflow: auto;">

                <?php
                foreach ($data as $name => $value) {

                    if ($value[3] == "social") {
                        $IS__SOCIAL_FOUND = true;
                ?>
                        <div class="mx-2">
                            <a class="mr-1" style="text-decoration:none" rel="external" href="<?php echo $value[1]; ?>" style="font-size:20px;">
                                <div>

                                    <i style="display:block;font-size: 25px;" class="phone <?php echo $value[0]; ?>"></i>
                                    <b class="phone"> <?php echo $value[2]; ?></b>
                                </div>

                            </a>
                        </div>
                <?php
                    }
                }
                ?>

            </div>
        </div>
        <!-- social links part ended -->

        <br>
    <?php
    }
    ?>




    <?php
    $data = json_decode($restaurant->contacts);
    $IS__APPS_FOUND = false;

    if ($data != "") {
    ?>

        <!-- app links part started -->
        <div>


            <?php

            foreach ($data as $name => $value) {

                if ($value[3] == "app") {
                    $IS__APPS_FOUND = true;
                    break;
                }
            }

            if ($IS__APPS_FOUND) {
            ?>

                <button id="apps" class="btn btn-default border btn-sm bg-white" style="font-size: 1.3rem;text-align:center;box-shadow: rgb(0 0 0 / 18%) 0px 6px 15px;border-radius: 10px;display:inline-block">
                    <b>
                        تطبيقات التوصيل
                    </b>
                    <i class="fa fa-angle-down"></i>
                </button>

                <div class="apps my-2 " style="display:flex;justify-content: center;">

                    <?php

                    foreach ($data as $name => $value) {

                        if ($value[3] == "app") {
                    ?>
                            <div class="mx-2">
                                <a class="mr-1" href="<?php echo $value[1]; ?>" style="font-size:20px;">
                                    <img width="100" height="100" style="border-radius:40px" src="/public/images/<?php echo $value[0]; ?>" />
                                </a>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

            <?php
            }
            ?>

        </div>
        <!-- app links part ended -->
    <?php

    }
    ?>





</div>


<script>
    $(document).ready(function() {
        $('.contacts button').on('click', function() {
            var id = $(this).attr('id');
            $('.' + id).slideToggle();
        });
    });
</script>

<style>
    .mr-1 {
        font-size: 20px;
    }
</style>