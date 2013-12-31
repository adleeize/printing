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
                    <small class="on-right">Daftar</small> Barang
                </h1>
                <div><p></p></div>
                <form method="post" action="<?php echo current_url(); ?>">
                    <a href="<?php echo site_url('manager/input_barang'); ?>" class="button bg-lightBlue fg-white large"><i class="icon-plus fg-white"></i> Input</a> 
                <input type="submit" name="update_barang" class="button bg-red fg-white large" value="Delete" />
<!--                    <div class="span4 offset4 input-control text">
                        <input type="text"placeholder="Nama Barang" />
                        <button class="btn-search"></button>
                    </div>-->
                <div><p></p></div>
                <table class="table hovered">
                    <thead>
                        <tr>
                            <th class="text-left">No</th>
                            <th class="text-left">Nama Barang</th>
                            <th class="text-left">Satuan</th>
                            <th class="text-right">Harga Beli</th>
                            <th class="text-right">Harga Jual Non-Member</th>
                            <th class="text-right">Harga Jual Member</th>
                            <th class="text-right">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($list_barang)) {
                                foreach($list_barang as $barang) { ?>
                        <tr>
                            <td><?php echo $number++; ?></td>
                            <td class="right"><a href="<?php echo site_url('manager/edit_barang/'.$barang->id_barang); ?>" title="Edit"><?php echo $barang->nama_barang; ?></a></td>
                            <td class="right"><?php echo $barang->satuan; ?></td>
                            <td class="text-right"><?php echo number_format($barang->harga_beli, 0, '', '.'); ?></td>
                            <td class="text-right"><?php echo number_format($barang->harga_jual_biasa, 0, '', '.'); ?></td>
                            <td class="text-right"><?php echo number_format($barang->harga_jual_member, 0, '', '.'); ?></td>
                            <td class="text-center"><input type="checkbox" name="delete_barang[<?php echo $barang->id_barang; ?>]" value="1" /></td>
                        </tr>
                        <?php }} else { ?>
                        <tr>
                            <td colspan="6" class="text-center bg-lighterBlue">Tidak ada data barang</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </form>
                <?php echo $pagination['links']; ?>
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