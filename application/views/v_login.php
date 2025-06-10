<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en" class="body-full-height">

<head>
    <!-- META SECTION -->
    <title><?php echo $this->config->item('site_name'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="author" content="bphtbkotamalang" />
    <meta name="keywords" content="<?php echo $this->config->item('header'); ?>" />
    <meta name="description" content="" />

    <link rel="icon" href="<?= base_url() . 'assets/template/assets/images/users/logo.png'; ?>" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/theme-default.css" />
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/mystyle.css" />
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/style_27012015.css" />
    <!-- EOF CSS INCLUDE -->
</head>

<body>

    <div class="login-container">

        <div class="login-box animated fadeInDown">

            <div id="formlogin">
                <div class="login-logo"><span class="logo-text">SAM-BPHTB</span></div>
                <div class="login-body">
                    <div class="login-title text-center" style="color:#337AB7; font-size:10; font-wight:bolder;"><?php echo $info ?></div>
                    <form name="frm_login" method="post" action="" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-3 ">
                                <img class="" width="100px" height="110px" style="padding-right: 15px" src="<?php echo base_url() ?>assets/template/assets/images/users/<?= $this->config->item('LOGO_KOTA') ?>" alt="Logo Daerah" />
                            </div>
                            <div class="col-md-offset-1 col-md-8">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" name="txt_username" class="form-control" placeholder="Username" style="background-color:white; color: #555; border: 1px solid #D5D5D5" maxlength="15" />
                                        <?php if (!empty($username_error)) {
                                            echo '<div class="warn_text">' . $username_error . '</div>';
                                        } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="password" name="txt_password" class="form-control" placeholder="Password" style="background-color:white; color: #555; border: 1px solid #D5D5D5" maxlength="15" />
                                        <?php if (!empty($password_error)) {
                                            echo '<div class="warn_text">' . $password_error . '</div>';
                                        } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6" style="margin-left: -15px;">
                                        <input type="text" name="captcha" class="form-control" placeholder="Captcha" style="background-color:white; color: #555; border: 1px solid #D5D5D5" maxlength="6" />
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $cap; ?> </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        <a class="btn btn-warning btn-block btn-lg" style="background-color:#1B4F74; border:1px solid #1B4F74" href="<?php echo site_url() ?>/register">Daftar</a>
                    </div>
                    <div class="pull-right">

                        <input class="btn btn-warning btn-block btn-lg" type="submit" name="submit_login" value="Login" class="bt" style="background-color:#1B4F74; border:1px solid #1B4F74" />
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!--b>AAAACCCC</b-->

    <!-- <a id="wa-widget-send-button" href="https://wa.me/6281132000194?text=Permisi%20nama%20saya%20%3A%0ASaya%20mau%20bertanya%20perihal%20BPHTB" target="_blank">
        <img src="<?= base_url() . "assets/images/wa.png"; ?>" />
    </a> -->

    <div id="wa-widget-send-button">
        <a href="https://wa.me/6281132000194?text=Permisi%20nama%20saya%20%3A%0ASaya%20mau%20bertanya%20perihal%20BPHTB%20..." target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" class="wa-messenger-svg-whatsapp wh-svg-icon">
                <path d=" M19.11 17.205c-.372 0-1.088 1.39-1.518 1.39a.63.63 0 0 1-.315-.1c-.802-.402-1.504-.817-2.163-1.447-.545-.516-1.146-1.29-1.46-1.963a.426.426 0 0 1-.073-.215c0-.33.99-.945.99-1.49 0-.143-.73-2.09-.832-2.335-.143-.372-.214-.487-.6-.487-.187 0-.36-.043-.53-.043-.302 0-.53.115-.746.315-.688.645-1.032 1.318-1.06 2.264v.114c-.015.99.472 1.977 1.017 2.78 1.23 1.82 2.506 3.41 4.554 4.34.616.287 2.035.888 2.722.888.817 0 2.15-.515 2.478-1.318.13-.33.244-.73.244-1.088 0-.058 0-.144-.03-.215-.1-.172-2.434-1.39-2.678-1.39zm-2.908 7.593c-1.747 0-3.48-.53-4.942-1.49L7.793 24.41l1.132-3.337a8.955 8.955 0 0 1-1.72-5.272c0-4.955 4.04-8.995 8.997-8.995S25.2 10.845 25.2 15.8c0 4.958-4.04 8.998-8.998 8.998zm0-19.798c-5.96 0-10.8 4.842-10.8 10.8 0 1.964.53 3.898 1.546 5.574L5 27.176l5.974-1.92a10.807 10.807 0 0 0 16.03-9.455c0-5.958-4.842-10.8-10.802-10.8z" fill-rule="evenodd"></path>
            </svg>
            <div style="color: white; font-size: 18px">Customer Service</div>
        </a>
    </div>
</body>

</html>