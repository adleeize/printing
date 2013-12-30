    <div class="grid container">
        <div class="row">
            <div class="span8 bg-white">
                <div class="padding20 introduce bg-amber">
                    <h1 class="ntm fg-white">Kasir Hartono</h1>
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
                <div class="place-right subheader-secondary clearfix" style="height: 90px">
                    <button class="primary" id="reg_member">Register Anggota <span class="icon-plus"></span></button>
                </div>
                <h1>
                    <i class="icon-user fg-darker smaller"></i>
                    <small class="on-right">Daftar</small>Member
                </h1>
                <div><p></p></div>
                <table class="table hovered">
                    <thead>
                        <tr><th>#</th><th>No KTP</th><th>Nama</th><th>Pekerjaan</th><th>Kota</th><th>Telepon</th><th>Waktu Regist.</th><th>Aksi</th></tr>
                    </thead>
                    <tbody class="data-pesanan">
                    <?php
                        $i = 0;
                        foreach ($list_members as $list_member):
                            $i++;
                    ?>
                        <tr>
                            <td><?php echo $i;?><input type="hidden" class="id_member" value="<?php echo $list_member->id;?>"></td>
                            <td class="nomer_ktp_member"><?php echo $list_member->no_identitas;?></td>
                            <td class="nama_member"><?php echo $list_member->nama;?></td>
                            <td class="pekerjaan_member"><?php echo $list_member->pekerjaan;?></td>
                            <td class="telp_member"><?php echo $list_member->no_telp;?></td>
                            <td class="kota_member"><?php echo $list_member->kota;?></td>
                            <td class="waktu_daftar_member"><?php echo $list_member->waktu_daftar;?></td>
                            <td><button id="action-edit<?php echo $i;?>" class="warning edit_member">Edit</button>&nbsp;
                                <button id="action-hapus<?php echo $i;?>" class="danger delete_member">Delete</button>
                            </td>
                        </tr>
                    <?php
                        endforeach;
                    ?>
                    </tbody>
                </table>
                <!-- <center>
                    <button class="shortcut danger">
                        <i class="icon-cancel"></i>
                        Batalkan
                    </button>
                    <button class="shortcut primary">
                        <i class="icon-printer"></i>
                        Cetak Nota
                    </button>
                </center> -->
            </div>
        </div>
    </div>

<script>
    $(document).ready(function(){
        $("#reg_member").on('click', function(e){
            e.preventDefault();
            $.Dialog({
                overlay: false,
                shadow: true,
                flat: false,
                icon: '<span class="icon-user"></span>',
                title: 'Register Member',
                content: '',
                width : 400,
                padding: 25,
                onShow: function(_dialog){
                    var content = '<table><form action="<?php echo site_url()?>kasir/register_member">' +
                            '<tr>' +
                            '<td><label>No KTP</label></td>' +
                            '<td><div class="input-control text"><input type="text" placeholder="Nomer Identitas" name="no_ktp" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<td><label>Nama</label></td>' +
                            '<td><div class="input-control text"><input type="text" placeholder="Nama" name="nama" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<td><label>Pekerjaan</label></td>' +
                            '<td><div class="input-control text"><input type="text" placeholder="Pekerjaan" name="pekerjaan" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<tr>' +
                            '<td><label>No Telp.</label></td>' +
                            '<td><div class="input-control text"><input type="text" placeholder="No Telepon" name="telp" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<tr>' +
                            '<td><label>Kota</label></td>' +
                            '<td><div class="input-control text"><input type="text" placeholder="Kota" name="kota" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<td>&nbsp;</td>' +
                            '<td><div class="form-actions">' +
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="button primary" value="Register">&nbsp;&nbsp;'+
                            '<button class="button" type="button">Cancel</button> '+
                            '</div></td>'+
                            '</tr>' +
                            '</form></table>';

                    $.Dialog.title("Register Member");
                    $.Dialog.content(content);
                    reinitInputs();
                }
            });
        });

    $(".edit_member").on('click', function(e){
            e.preventDefault();
            var id          = $(this).parent().parent().find(".id_member").val();
            var no_ktp      = $(this).parent().parent().find(".nomer_ktp_member").html();
            var nama        = $(this).parent().parent().find(".nama_member").html();
            var pekerjaan   = $(this).parent().parent().find(".pekerjaan_member").html();
            var kota        = $(this).parent().parent().find(".kota_member").html();
            var telepon     = $(this).parent().parent().find(".telp_member").html();
            $.Dialog({
                overlay: false,
                shadow: true,
                flat: false,
                icon: '<span class="icon-user"></span>',
                title: 'Register Member',
                content: '',
                width : 400,
                padding: 25,
                onShow: function(_dialog){
                    var content = '<table><form action="<?php echo site_url()?>kasir/edit_member">' +
                            '<tr>' +
                            '<td><label>No KTP</label><input type="hidden" name="edit-id" value="'+id+'"></td>' +
                            '<td><div class="input-control text"><input type="text" value="'+no_ktp+'" placeholder="Nomer Identitas" name="no_ktp" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<td><label>Nama</label></td>' +
                            '<td><div class="input-control text"><input type="text" value="'+nama+'" placeholder="Nama" name="nama" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<td><label>Pekerjaan</label></td>' +
                            '<td><div class="input-control text"><input type="text" value="'+pekerjaan+'" placeholder="Pekerjaan" name="pekerjaan" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<tr>' +
                            '<td><label>No Telp.</label></td>' +
                            '<td><div class="input-control text"><input type="text" value="'+telepon+'" placeholder="No Telepon" name="telp" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<tr>' +
                            '<td><label>Kota</label></td>' +
                            '<td><div class="input-control text"><input type="text" value="'+kota+'" placeholder="Kota" name="kota" required><button class="btn-clear"></button></div> ' +
                            '</tr><tr>' +
                            '<td>&nbsp;</td>' +
                            '<td><div class="form-actions">' +
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="button primary" value="Register">&nbsp;&nbsp;'+
                            '<button class="button" type="button">Cancel</button> '+
                            '</div></td>'+
                            '</tr>' +
                            '</form></table>';

                    $.Dialog.title("Edit Member");
                    $.Dialog.content(content);
                    // $.Dialog.content(console.log($(this).html()));
                    reinitInputs();
                }
            });
        });

        $(".delete_member").on('click', function(e){
            e.preventDefault();
            var id = $(this).parent().parent().find(".id_member").val();
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-user"></span>',
                title: 'Hapus Member',
                width: 400,
                padding: 20,
                content: 'Anda yakin mau menghapus Member ini?' +
                         '<form action="<?php echo site_url();?>kasir/hapus_member">' +
                         '<input type="hidden" name="id" value="'+id+'"><br/><br/><br/>' +
                         '<span style="padding-left:130px;"><input type="submit" class="danger" value="Hapus"></span>' +
                         '</form>'
            });
        });
    });
</script>