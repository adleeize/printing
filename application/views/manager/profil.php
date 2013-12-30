<?php $this->load->view('manager/templates/header'); ?>
    <div class="grid container">
        <div class="row">
            <div class="span8 bg-white">
                <div class="padding20 introduce bg-amber">
                    <h1 class="ntm fg-white">Manager Hartono</h1>
                    <p class="fg-white">No. Pegawai : 172.16.10.17</p>
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
                    <small class="on-right">Profil</small> Manager
                </h1>
                <div><p></p></div>
                <form method="post" action="<?php echo current_url(); ?>">
                    <!--<legend>Legend</legend>-->
                    <lable>Nama</lable>
                    <div class="input-control text<?php $error = form_error('nama'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Nama" name="nama" value="<?php echo set_value('nama', $manager->uacc_name); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Email</lable>
                    <div class="input-control text<?php $error = form_error('email'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Email" name="email" value="<?php echo set_value('email', $manager->uacc_email); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>No Pegawai</lable>
                    <div class="input-control text<?php $error = form_error('identitas'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="No Pegawai" name="identitas" value="<?php echo set_value('identitas', $manager->uacc_no_peg); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Nomor Telepon</lable>
                    <div class="input-control text<?php $error = form_error('no_telp'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Nomor Telepon" name="no_telp" value="<?php echo set_value('no_telp', $manager->uacc_phone); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Kota</lable>
                    <div class="input-control text<?php $error = form_error('kota'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Kota" name="kota" value="<?php echo set_value('kota', $manager->uacc_kota); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <input type="submit" value="Update" name="update_profil" class="bg-cyan fg-white" />
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