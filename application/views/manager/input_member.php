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
                    <small class="on-right">Input</small> Member
                </h1>
                <div><p></p></div>
                <form method="post" action="<?php echo current_url(); ?>">
                    <!--<legend>Legend</legend>-->
                    <lable>Nama</lable>
                    <div class="input-control text<?php $error = form_error('nama'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Nama" name="nama" value="<?php echo set_value('nama', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>No Identitas</lable>
                    <div class="input-control text<?php $error = form_error('identitas'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="No Identitas" name="identitas" value="<?php echo set_value('identitas', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Pekerjaan</lable>
                    <div class="input-control text<?php $error = form_error('pekerjaan'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Pekerjaan" name="pekerjaan" value="<?php echo set_value('pekerjaan', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Nomor Telepon</lable>
                    <div class="input-control text<?php $error = form_error('no_telp'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Nomor Telepon" name="no_telp" value="<?php echo set_value('no_telp', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Kota</lable>
                    <div class="input-control text<?php $error = form_error('kota'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Kota" name="kota" value="<?php echo set_value('kota', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <input type="submit" value="Submit" name="insert_member" class="bg-cyan fg-white" />
                </form>
            </div>
        </div>
    </div>
    <?php if(!empty($message)) { ?>
    <script>$.Notify({style: {background: '#1ba1e2', color: 'white'}, caption: 'Success',  content: "<?php echo $message; ?>"});</script>
    <?php } ?>
<?php $this->load->view('manager/templates/footer'); ?>