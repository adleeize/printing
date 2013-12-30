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
                    <small class="on-right">Input</small> Barang
                </h1>
                <div><p></p></div>
                <form method="post" action="<?php echo current_url(); ?>">
                    <!--<legend>Legend</legend>-->
                    <lable>Nama Barang</lable>
                    <div class="input-control text<?php $error = form_error('nama_barang'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Nama Barang" name="nama_barang" value="<?php echo set_value('nama_barang', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Satuan</lable>
                    <div class="input-control text<?php $error = form_error('satuan'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Satuan" name="satuan" value="<?php echo set_value('satuan', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Harga Beli</lable>
                    <div class="input-control text<?php $error = form_error('harga_beli'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Harga Beli" name="harga_beli" value="<?php echo set_value('harga_beli', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Harga Jual Non-member</lable>
                    <div class="input-control text<?php $error = form_error('harga_jual_biasa'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Harga Jual Non-member" name="harga_jual_biasa" value="<?php echo set_value('harga_jual_biasa', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <lable>Harga Jual Member</lable>
                    <div class="input-control text<?php $error = form_error('harga_jual_member'); echo!empty($error) ? ' error-state' : ''; ?>" data-role="input-control">
                        <input type="text" placeholder="Harga Jual Member" name="harga_jual_member" value="<?php echo set_value('harga_jual_member', ''); ?>">
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                        <?php echo $error; ?>
                    </div>
                    <input type="submit" value="Submit" name="insert_barang" class="bg-cyan fg-white" />
                </form>
            </div>
        </div>
    </div>
    <?php if(!empty($message)) { ?>
    <script>$.Notify({style: {background: '#1ba1e2', color: 'white'}, caption: 'Success',  content: "<?php echo $message; ?>"});</script>
    <?php } ?>
<?php $this->load->view('manager/templates/footer'); ?>