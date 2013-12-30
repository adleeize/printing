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
                <nav class="breadcrumbs">
                    <ul>
                        <li<?php if($this->uri->segment(3) === "all") echo ' class="active"'; ?>><a href="<?php echo site_url('kasir/pesanan/all');?>">Semua Pesanan</a></li>
                        <li<?php if($this->uri->segment(3) === "ambil") echo ' class="active"'; ?>><a href="<?php echo site_url('kasir/pesanan/ambil');?>">Pesanan Oke</a></li>
                        <li<?php if($this->uri->segment(3) === "") echo ' class="active"'; ?>><a href="<?php echo site_url('kasir/pesanan');?>">Pesanan Belum Di Ambil</a></li>
                    </ul>
                </nav>
                <h1>
                    <i class="icon-cart fg-darker smaller"></i>
                <?php
                    if($this->uri->segment(3) == "all")
                    {
                        echo '<small class="on-right">Daftar</small>Semua Pesanan';
                        $ambil = "all";
                    }
                    else if($this->uri->segment(3) == "ambil")
                    {
                        echo '<small class="on-right">Daftar</small>Pesanan Oke';
                        $ambil = "sudah";
                    }
                    else
                    {
                        echo '<small class="on-right">Daftar</small>Pesanan Belum Di Ambil';
                        $ambil = "belum";
                    }
                ?>
                </h1>
                <div><p></p></div>
                <table class="table hovered">
                    <thead>
                        <tr><th>#</th><th>No Order</th><th>Tgl Pesan</th><th>Tgl Ambil</th><th>DP</th><th>Total Harga</th><th>Pembayaran</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody class="data-pesanan">
                    <?php if(!empty($list_orders)) { $i=1;
                    foreach ($list_orders as $list_order):
                    ?>
                        <tr class="list-pesanan">
                            <td><?php echo $i;?><input type="hidden" class="id_transaksi" value="<?php echo $list_order->id_pembelian;?>"></td>
                            <td align="center"><?php echo $list_order->id_pembelian;?></td>
                            <td align="center"><?php echo $list_order->order_date;?></td>
                            <td align="center"><?php $pick = $list_order->pick_date == "" ? "<b class='icon-alarm-clock'></b>" : $list_order->pick_date;echo $pick;?></td>
                            <td align="center"><?php echo $list_order->dp;?></td>
                            <td align="center"><?php echo $list_order->total_harga;?></td>
                            <td align="center"><?php $pembayaran = $list_order->status_pembayaran == 1 ? "<b style='color:green;'>L</b>" : "<b style='color:red;'>BL</b>";echo $pembayaran;?></td>
                            <td>
                                <?php $status = $list_order->status_pengambilan == 1 ? "<b style='color:green;' class='icon-checkmark'></b>" : "<b style='color:red;' class='icon-cancel-2'></b>";echo $status;?>
                            </td>
                            <td>
                                <?php if($list_order->status_pengambilan==1){?>
                                    <button class="primary ambilkan" disabled="true">Proses</button>
                                <?php }else{?>
                                    <button class="primary ambilkan">Proses</button>
                                <?php }?>
                                <button class="warning hapuskan"><i class="icon-remove"></i></button>
                            </td>
                        </tr>
                    <?php $i++;
                    endforeach;
                    } else {
                    ?>
                        <tr>
                            <td colspan="9" class="bg-lightBlue fg-white text-center">Tidak ada pesanan</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <center>
                    <!-- <button class="shortcut danger">
                        <i class="icon-cancel"></i>
                        Batalkan
                    </button>
                    <button class="shortcut primary">
                        <i class="icon-printer"></i>
                        Cetak Nota
                    </button> -->
                </center>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){
        $(".ambilkan").click(function(e){
            e.preventDefault();
            var id = $(this).parent().parent().find(".id_transaksi").val();;
            // alert(id);
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-rocket"></span>',
                title: 'Proses Transaksi',
                width: 430,
                padding: 15,
                content: 'Apakah anda yakin mau memproses Transaksi ini?' +
                         '<br/><br/><br/><span style="padding-left:150px;"><button class="primary" id="proses-yes">Yess</button></span>'
            });
            $("#proses-yes").click(function(e){
                e.preventDefault();
                $.get('<?php echo site_url("kasir/proses_transaksi");?>',{id : id}, function(data) {
                    location.reload();
                });
            });
        });

        $(".hapuskan").click(function(e){
            e.preventDefault();
            var id = $(this).parent().parent().find(".id_transaksi").val();;
            // alert(id);
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-remove"></span>',
                title: 'Delete Transaksi',
                width: 430,
                padding: 15,
                content: 'Apakah anda yakin mau menghapus Transaksi ini?' +
                         '<br/><br/><br/><span style="padding-left:150px;"><button class="primary" id="proses-yes">Yes</button></span>'
            });
            $("#proses-yes").click(function(e){
                e.preventDefault();
                $.get('<?php echo site_url("kasir/delete_transaksi");?>',{id : id}, function(data) {
                    location.reload();
                });
            });
        });
    });
    </script>