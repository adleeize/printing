    <div class="grid container">
        <div class="row">
            <div class="span8 bg-white">
                <div class="padding20 introduce bg-amber">
                    <h1 class="ntm fg-white">Kasir <?php echo ucwords($this->session->userdata('name')); ?></h1>
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
                    <i class="icon-cart fg-darker smaller"></i>
                    Transaksi<small class="on-right">barang</small>
                </h1>
                <table>
                    <tr>
                        <td>Member</td>
                        <td>
                            <div class="input-control switch">
                                <label>
                                    off&nbsp;<input type="checkbox" id="member" />
                                    <span class="check"></span>&nbsp;on
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr id='member_area'>
                    </tr>
                    <tr>
                        <form>
                        <td>Nama Barang&nbsp;&nbsp;</td>
                        <td>
                            <div class="input-control span4 text ui-widget" data-role="input-control">
                                <input type="text" placeholder="Nama Barang" id="barang" list="searchresults" autocomplete="off" required>
                                <datalist id="searchresults"></datalist>
                            </div>    
                            &nbsp;&nbsp;
                        </td>
                        <td>
                            <input type="submit" id="barang-masuk" class="button primary" value="Masukan">
                        </td>
                        </form>
                    </tr>
                </table>
                <div><p></p></div>
                <form id="transaksi_barang_toko">
                <table class="table hovered">
                    <thead>
                        <tr><th>#</th><th>Nama Barang</th><th>Jumlah</th><th>Ukuran(pxl)</th><th>Ukuran</th><th>Harga Satuan</th><th>Harga</th><th>&nbsp;</th></tr>
                    </thead>
                    <tbody class="data-barang">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <th colspan="6">Total Harga</th>
                            <th>
                                <div class="input-control span2 text ui-widget" data-role="input-control">
                                    <input type="text" placeholder="Total Harga" value="0" id="tot_harga" disabled="true">
                                </div>
                            </th>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <th colspan="6">DP</th>
                            <th>
                                <div class="input-control span2 text ui-widget" data-role="input-control">
                                    <input type="text" placeholder="Dp nya" value="0" id="dp">
                                </div>
                            </th>
                            <td><div id="tempat_member_pemesan"></div></td>
                        </tr>
                        <!-- <tr>
                            <th colspan="6">
                                Tanggal Ambil
                            </th>
                            <td colspan="2">
                                <div class="span2">
                                    <div class="input-control text" data-format="yyyy-mm-dd"  data-role="datepicker">
                                        <input type="text" id="pick_dt" readonly="readonly">
                                        <button class="btn-date"></button>
                                    </div>
                                </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr> -->
                    </tfoot>
                </table>
                </form>
                <center>
                    <button class="shortcut danger" id="batal_transaksi" disabled="true">
                        <i class="icon-cancel"></i>
                        Batalkan
                    </button>
                    <button class="shortcut primary" id="proses_transaksi" disabled="true">
                        <i class="icon-printer"></i>
                        Cetak Nota
                    </button> 
                    <span id="loading-transaksi" style="display:none;">
                        <img src="<?php echo base_url('assets/metro/images/metro-loading.gif');?>">
                    </span>
                    <span id="status_transaksi" style="display:none;">
                        <i class="icon-checkmark on-left" style="background: green; color: white; padding: 5px; border-radius: 50%"></i><i style="color:green">Transaksi berhasil</i>
                    </span>
                </center>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function(){
        $("#member").change(function(e){
            e.preventDefault();
            var member = $("#member").prop("checked");
            // console.log(member);
            if(member === true){
                var z = "<td>No Member</td>";
                z += "<td>";
                z += "<div class='input-control span2 text ui-widget' data-role='input-control'>";
                z += "<input type='text' placeholder='xxxxx' id='id_member'>";
                z += "</div>";
                z += "&nbsp;<button class='primary' id='cek_member'>Cek</button>";
                z += '<span id="respon_cek"></span>';
                z += "</td>";
                z += "<td>&nbsp;</td>";
                $("#member_area").append(z);
                ada_member_tidak();
            }
            else{
                $("#member_area").empty();   
            }
        });

        function ada_member_tidak(){
            $("#cek_member").click(function(e){
                e.preventDefault();
                var y;
                $.get(BASE_URL+"kasir/cek_member",{id : $("#id_member").val()}, function(data) {
                    if(data!==false){
                        console.log(data);
                        $("#respon_cek").html("");
                        y = '<span id="adagan"><i class="icon-checkmark fg-green on-right on-left"></i>Tersedia</span>';
                        $("#respon_cek").append(y);
                        $("#id_member_pemesan").html("");
                        $("#tempat_member_pemesan").append("<input id='id_member_pemesan' type='hidden' value='"+data[0].id+"'>");
                    }
                    else{
                        console.log(0);
                        $("#respon_cek").html("");
                        y = '<span id="adagan"><i class="icon-cancel-2 fg-red on-right on-left"></i>Tak ada</span>';
                        $("#respon_cek").append(y);
                    }
                },"json");
            });
        }

        $("#barang-masuk").click(function(e) {
            e.preventDefault();
            var member = $("#member").prop("checked");
            var a = "";
            $.ajax({
                url : BASE_URL+'kasir/barang_masuk',
                data : {name : $("#barang").val()},
                dataType : "json",
                success : function(data){
                    // console.log(data[0]);
                    if(data){
                    a += "<tr class='baris'>";
                    a += "<td>~><input type='hidden' class='id_barang' value='"+data[0].id_barang+"'></td>";
                    a += "<td>"+data[0].nama_barang+"</td>";
                    a += "<td>";
                    a += "<div class='input-control span1 text' data-role='input-control'>";
                    a += "<input type='text' class='jum_brg' placeholder='jumlah' value='1'>";
                    a += "</div>";
                    a += "</td>";    
                    a += "<td>";
                    if(data[0].satuan=="paket"){
                        a += "Paket";
                    }
                    else{
                        a += "<div class='input-control span1 text' data-role='input-control'>";
                        a += "<input type='text' placeholder='p' class='span1 pjg' value='1.0'>";
                        a += "</div>";
                        a += "<div class='input-control span1 text' data-role='input-control'>";
                        a += "<input type='text' placeholder='p' class='span1 lbr' value='1.0'>";
                        a += "</div>";
                    }          
                    a += "</td>";
                    a += "<td>";
                    if(data[0].satuan=="paket"){
                        a += "<div class='input-control span1 text'>";
                        a += "<input type='hidden' class='luas' value='1.0'/>Paket";
                        a += "</div>";
                    }
                    else{
                        a += "<div class='input-control span1 text'>";
                        a += "<input type='text' class='luas' value='1.0' placeholder='m2' disabled/>";
                        a += "</div>";
                    }
                    a += "<td>";
                    a += "<div class='input-control span2 text'>";
                    if((member === true) && $("#id_member_pemesan").val()){
                        a += "<input type='text' class='h_jual' value='"+data[0].harga_jual_member+"' placeholder='harga satuan' disabled/>";
                    }
                    else{
                        a += "<input type='text' class='h_jual' value='"+data[0].harga_jual_biasa+"' placeholder='harga satuan' disabled/>";
                    }
                    a += "</div>";       
                    a += "</td>";        
                    a += "<td>";
                    a += "<div class='input-control span2 text'>";
                    if(member === true && $("#id_member_pemesan").val()){
                        a += "<input type='text' class='h_barang' value='"+data[0].harga_jual_member+"' placeholder='harga' disabled/>";
                    }
                    else{
                        a += "<input type='text' class='h_barang' value='"+data[0].harga_jual_biasa+"' placeholder='harga' disabled/>";
                    }
                    a += "</div>";            
                    a += "</td>";
                    a += "<td>";
                    a += "<a href='#' class='delete' title='hapus barang'><i class='icon-cancel fg-red on-right on-left'></i></a>";
                    // a += "<button class='delete danger' title='hapus barang' id='hapus"+data[0].id_barang+"'>Hapus</button>";
                    a += "</td>";
                    a += "</tr>";

                    $(".data-barang").append(a);
                    trans();
                    }
                    else{
                        console.log(0);
                    }
                }
            });
        });

        function trans(){
            hapus_baris();
            ubah_ukuran();
        }

        function hapus_baris(){
            $(".delete").click(function(e){
                e.preventDefault();
                // var ans = confirm("Yakin mau menghapus data barang ini dari transaksi?");
                // if(ans === true){
                    // $(this).parent("tr:first").remove();
                    $(this).parent().parent().parent().find("tr:first").remove();
                    $(".h_barang").blur();
                // }
                if(!$(".h_barang").val()){
                    $("#tot_harga").val(0);
                    $("#proses_transaksi").attr('disabled', 'true');
                } 
            });
        }

        function ubah_ukuran(){
            $(".pjg").keyup(function(){
                var p = parseFloat($(this).val());
                var l = parseFloat($(this).parent().next().find('.lbr').val());
                var luas = p*l;
                $(this).parent().parent().next().find('.luas').val(luas);
                $(this).parent().parent().next().find('.luas').blur();
            });

            $(".lbr").keyup(function(){
                var l = parseFloat($(this).val());
                var p = $(this).parent().parent().find('.pjg').val();
                var luas = p*l;
                $(this).parent().parent().next().find('.luas').val(luas);
                $(this).parent().parent().next().find('.luas').blur();
            });

            $(".jum_brg").keyup(function(){
                var jumlah = parseFloat($(this).val());
                var ukuran = parseFloat($(this).parent().parent().next().next().find(".luas").val());
                var h_jual = parseFloat($(this).parent().parent().next().next().next().find(".h_jual").val());
                harga = (ukuran*h_jual)*jumlah;
                $(this).parent().parent().next().next().next().next().find(".h_barang").val(harga);
                $(this).parent().parent().next().next().next().next().find(".h_barang").blur();
            });

            $(".luas").on('change, blur',function(){
                var ukuran = parseFloat($(this).val());
                var jumlah = parseFloat($(this).parent().parent().parent().find(".luas").val());
                var h_jual = parseFloat($(this).parent().parent().next().find(".h_jual").val());
                harga = (ukuran*h_jual)*jumlah;
                $(this).parent().parent().next().next().find(".h_barang").val(harga);
                $(this).parent().parent().next().next().find(".h_barang").blur();
            });

            $(".h_barang").on('blur',function(){
                var z=0;
                $(".baris").parent().find('.h_barang').each(function(){
                    z = z+parseFloat($(this).val());
                });
                $("#tot_harga").val(z);
                $("#tot_harga").blur();
            });

            $("#tot_harga").on('blur',function(){
                if($("#tot_harga").val() == "0"){
                    $("#batal_transaksi").attr("disabled");
                    $("#proses_transaksi").attr("disabled");
                }
                else{
                    $("#batal_transaksi").removeAttr('disabled');
                    $("#proses_transaksi").removeAttr('disabled'); 
                }
            });
        }

        $("#batal_transaksi").click(function(e) {
            e.preventDefault();
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-cart"></span>',
                title: 'Proses Transaksi',
                width: 400,
                padding: 20,
                content: "Anda yakin mau membatalkan Transaksi ini?<br/><br/><br/><span style='padding-left:130px;'><button class='warning' id='btl_trans'>Batalkan!</button></span>"
            });
            $("#btl_trans").click(function(e){
                $("tr.baris").remove();
                $("input").val("");
                $("#tot_harga").val(0);
                $("#tot_harga").blur();
                $(".btn-close").click();
                $("#member").prop("checked",false);
                $("#member_area").empty();
                $("#barang-masuk").attr("value","Masukan");
                $("#batal_transaksi").attr("disabled","true");
                $("#proses_transaksi").attr("disabled","true");
            });
        });

        // window proses transaksi
        $("#proses_transaksi").on('click', function(e){
            e.preventDefault();
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<span class="icon-cart"></span>',
                title: 'Proses Transaksi',
                width: 400,
                padding: 20,
                content: "Anda yakin mau memproses Transaksi ini?<br/><br/><br/><span style='padding-left:130px;'><button class='primary' id='proses_trans'>Proses</button></span>"
            });
            $("#proses_trans").click(function(e){
                $(".btn-close").click();
                var harga_msg_barang = new Array(),jumlah_msg_barang = new Array(),id_msg_barang = new Array(),luas_msg_barang = new Array();
                var total_harga = $("#tot_harga").val();
                var dp = $("#dp").val();
                // var pick_date = $("#pick_dt").val();
                var id_member = $("#id_member_pemesan").val();
                var i;
                i=0;
                $(".h_barang").each(function(){
                    harga_msg_barang[i] = $(this).val();
                    i++;
                });
                i=0;
                $(".jum_brg").each(function(){
                    jumlah_msg_barang[i] = $(this).val();
                    i++;
                });
                i=0;
                $(".id_barang").each(function(){
                    id_msg_barang[i] = $(this).val();
                    i++;
                });
                i=0;
                $(".luas").each(function(){
                    luas_msg_barang[i] = $(this).val();
                    i++;
                });

                if(parseFloat(dp)>=parseFloat(total_harga)){
                    var status = 1;
                }
                else var status = 0;
                if(id_member) var member = id_member;
                else var member = '';
                // ajax pembelian
                $.post(BASE_URL+"kasir/transaksi_pembelian", {dp:dp,tot_harga:total_harga,status:status,member:member}, function(data) {
                    if(data>0){
                        $.ajax({
                            url: BASE_URL+"kasir/detail_transaksi_pembelian",
                            type: 'POST',
                            data: {id_trans : data,id_barang: id_msg_barang,jumlah_brg: jumlah_msg_barang,luas_barang: luas_msg_barang,harga_barang: harga_msg_barang},
                            beforeSend : function(){
                                $("#status_transaksi").hide();
                                $("#loading-transaksi").show();
                            },
                            success : function(data){
                                $("#status_transaksi").show();
                                $("#loading-transaksi").hide();
                                $(".baris").remove();
                                $("input").val("");
                                $("#tot_harga").val(0);
                                $("#tot_harga").blur();
                                $("#member").prop("checked",false);
                                $("#member_area").empty();
                                $("#barang-masuk").attr("value","Masukan");
                                $("#batal_transaksi").attr("disabled","true");
                                $("#proses_transaksi").attr("disabled","true");
                            }
                        });
                    }
                });
            });
        });

        if(document.createElement("datalist").options) {
            $("#barang").keyup(function(e) {
                var val = $(this).val();
                if(val === "") return;
                //You could use this to limit results
                //if(val.length < 3) return;
                console.log(val);
                $.get(BASE_URL+'kasir/autocomplete_barang', {q:val}, function(res) {
                    var dataList = $("#searchresults");
                    dataList.empty();
                    console.log(res);
                    if(res.length) {
                        for(var i in res){
                            var opt = $("<option></option>").attr("value", res[i].nama_barang);
                            dataList.append(opt);
                        }   

                    }
                },"json");
            });

        }

    });
</script>