<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <meta name="product" content="Metro UI CSS Framework">
    <meta name="author" content="Sergey S. Pimenov, Ukraine, Kiev">
    <meta name="description" content="Simple responsive css framework">
    <meta name="keywords" content="Metro, ui, responsive, css, framework, library">

    <link rel="stylesheet" href="<?php echo base_url('assets/metro/css/metro-bootstrap.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/metro/css/metro-bootstrap-responsive.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/metro/css/docs.css');?>">
    <link href="<?php echo base_url('assets/metro/js/prettify/prettify.css');?>" rel="stylesheet">

    <script src="<?php echo base_url('assets/metro/js/jquery/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/metro/js/jquery/jquery.widget.min.js');?>"></script>
    <script src="<?php echo base_url('assets/metro/js/prettify/prettify.js');?>"></script>

    <script src="<?php echo base_url('assets/metro/js/metro/metro-loader.js');?>"></script>
    <script src="<?php echo base_url('assets/metro/js/docs.js');?>"></script>
    <script src="<?php echo base_url('assets/metro/js/github.info.js');?>"></script>
    <title>Login User</title>
</head>
<body class="metro">
    <div class="grid fluid">
        <div class="row">
            <div class="span4 offset4">
                <div class="description padding20 bg-grayLighter">
                    <form method="post" action="<?php echo site_url('login/verifikasi');?>">
                        <fieldset>
                            <legend><center><h1><i class="icon-user-3">&nbsp;</i>Login</h1></center></legend>
                            <lable>Username</lable>
                            <div class="input-control text" data-role="input-control">
                                <input type="text" name="email" placeholder="email">
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                            <lable>Password</lable>
                            <div class="input-control password" data-role="input-control">
                                <input type="password" name="password" placeholder="type password" autofocus="">
                                <button class="btn-reveal" tabindex="-1" type="button"></button>
                            </div>
                            <div class="input-control select" data-role="input-control">
                                <select name="role">
                                    <option value="-99">--Login sebagai--</option>
                            <?php
                                foreach ($list_roles as $list_role) {
                                    echo "<option value='".$list_role->ugrp_id."'>".$list_role->ugrp_name."</option>";
                                }
                            ?>
                                </select>
                            </div>
                            <div id="erore" style="color:red;">
                            <?php if(validation_errors()){
                                    echo "<span style='font-color:red;'>".validation_errors()."</span>";
                              }?>
                            </div>

                            <center><input class="primary" id="cek" type="submit" value="Submit">&nbsp;&nbsp;<input class="warning" type="reset" value="Reset"></center>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
      $(document).ready(function(){
          $("#username").focus();
          $('#cek').click(function(){
              if($('input[name="email"]').val()=='' || $('input[name="password"]').val()=='' || $('input[name="role"]').val()=='-99'){
                  $('#erore').html('<p style="color:red;">Lengkapi form dengan benar</p>');
                  return false;
              }
              return true;
          });
      });
  </script>
</body>
</html>