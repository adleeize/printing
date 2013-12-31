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
                    <small class="on-right">Daftar</small> Member
                </h1>
                <div><p></p></div>
                <form method="post" action="<?php echo current_url(); ?>">
                    <a href="<?php echo site_url('manager/input_member'); ?>" class="button bg-lightBlue fg-white large"><i class="icon-plus fg-white"></i> Input</a> 
                <input type="submit" name="update_member" class="button bg-red fg-white large" value="Delete" />
<!--                    <div class="span4 offset4 input-control text">
                        <input type="text"placeholder="Nama Barang" />
                        <button class="btn-search"></button>
                    </div>-->
                <div><p></p></div>
                <table class="table hovered">
                    <thead>
                        <tr>
                            <th class="text-left">No</th>
                            <th class="text-left">Nama</th>
                            <th class="text-center">Pekerjaan</th>
                            <th class="text-center">Nomor Telepon</th>
                            <th class="text-center">Kota</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($list_member)) {
                                foreach($list_member as $member) { ?>
                        <tr>
                            <td><?php echo $number++; ?></td>
                            <td class="text-left"><a href="<?php echo site_url('manager/edit_member/'.$member->id); ?>" title="Edit"><?php echo ucwords($member->nama); ?></a></td>
                            <td class="text-center"><?php echo ucwords($member->pekerjaan); ?></td>
                            <td class="text-center"><?php echo $member->no_telp; ?></td>
                            <td class="text-center"><?php echo ucwords($member->kota); ?></td>
                            <td class="text-center"><input type="checkbox" name="delete_member[<?php echo $member->id; ?>]" value="1" /></td>
                        </tr>
                        <?php }} else { ?>
                        <tr>
                            <td colspan="6" class="text-center bg-lighterBlue">Tidak ada data member</td>
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