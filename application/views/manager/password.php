<?php $this->load->view('manager/templates/header'); ?>
    <div class="grid container">
        <div class="row">
            <div class="span8 bg-white">
                <div class="padding20 introduce bg-amber">
                    <h2 class="ntm fg-white">Manager <?php echo ucwords($this->session->userdata('name')); ?></h2>
                    <p class="fg-white">No. Pegawai : <?php echo $this->session->userdata('no_pegawai'); ?></p>
                    <p class="fg-white item-title">Adukan karyawan kami jika anda merasa ada sesuatu yang kurang beres.</p>
                </div>
                <div class="row">
                    <div class="span4 offset3 pos-rel">
                        <div class="times" data-role="times"></div>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="row no-margin">
                    <div class="span4">
                        <div class="calendar" data-role="calendar"></div>
                    </div>
                </div>  
            </div>
        </div>
        <div class="row border-top">
            <div class="span12 padding10 bg-grayLighter">
                <h1>
                    <i class="icon-list fg-darker smaller"></i>
                    <small class="on-right">Ganti</small> Password
                </h1>
                <div><p></p></div>
                <form method="post" action="<?php echo current_url(); ?>">
                    <!--<legend>Legend</legend>-->
                    <lable>Password Lama</lable>
                    <div class="input-control text<?php $error = form_error('current_password'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="password" placeholder="Password lama" name="current_password" value="<?php echo set_value('current_password', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Password Baru</lable>
                    <div class="input-control text<?php $error = form_error('new_password'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="password" placeholder="Password Baru" name="new_password" value="<?php echo set_value('new_password', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <input type="submit" value="Update" name="update_password" class="bg-cyan fg-white" />
                </form>
            </div>
        </div>
    </div>
    <?php if(!empty($response) && $response === 'success') { ?>
    <script>$.Notify({style: {background: '#1ba1e2', color: 'white'}, caption: 'Success',  content: "<?php echo $message; ?>"});</script>
    <?php } ?>
    <?php if(!empty($response) && $response === 'error') { ?>
    <script>$.Notify({style: {background: 'red', color: 'white'}, caption: 'Failed',  content: "<?php echo $message; ?>"});</script>
    <?php } ?>
<?php $this->load->view('manager/templates/footer'); ?>