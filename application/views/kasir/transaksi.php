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
                                <input type="text" placeholder="Nama Barang" id="barang" required>
                                <button class="btn-clear" tabindex="-1" type="button"></button>
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
                <table class="table hovered">
                    <thead>
                        <tr><th>#</th><th>Nama Barang</th><th>Jumlah</th><th>Ukuran(pxl)</th><th>Ukuran</th><th>Harga Satuan</th><th>Harga</th><th>&nbsp;</th></tr>
                    </thead>
                    <tbody class="data-barang">
                    </tbody>
                </table>
                <center>
                    <button class="shortcut danger">
                        <i class="icon-cancel"></i>
                        Batalkan
                    </button>
                    <button class="shortcut primary">
                        <i class="icon-printer"></i>
                        Cetak Nota
                    </button>
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
                z += "&nbsp;<button class='primary'>Cek</button></td>";
                z += "<td>&nbsp;</td>";
                $("#member_area").append(z);
            }
            else{
                $("#member_area").empty();   
            }
        });

        $("#barang").autocomplete({
            source : function(request,response){
                $.ajax({
                    url : "<?php echo base_url('kasir/autocomplete_barang');?>",
                    dataType : "json",
                    data : {q : $("#barang").val()},
                    success : function(hasil){
                        response(hasil[0]);
                    }
                });
            }
        });

        $("#barang-masuk").click(function(e) {
            e.preventDefault();
            var member = $("#member").prop("checked");
            var a = "";
            $.ajax({
                url : "<?php echo base_url('kasir/barang_masuk');?>",
                data : {name : $("#barang").val()},
                dataType : "json",
                success : function(data){
                    // console.log(data[0]);
                    a += "<tr>";
                    a += "<td>~><input type='hidden' class='id_barang' value='"+data[0].id_barang+"'></td>";
                    a += "<td>"+data[0].nama_barang+"</td>";
                    a += "<td>";
                    a += "<div class='input-control span1 text' data-role='input-control'>";
                    a += "<input type='text' placeholder='jumlah' value='1'>";
                    a += "</div>";
                    a += "</td>";    
                    a += "<td>";
                    if(data[0].satuan=="paket"){
                        a += "Paket";
                    }
                    else{
                        a += "<div class='input-control span1 text' data-role='input-control'>";
                        a += "<input type='text' placeholder='p' class='span1' value='1.0'>";
                        a += "</div>";
                        a += "<div class='input-control span1 text' data-role='input-control'>";
                        a += "<input type='text' placeholder='p' class='span1' value='1.0'>";
                        a += "</div>";
                    }          
                    a += "</td>";
                    a += "<td>";
                    if(data[0].satuan=="paket"){
                        a += "Paket";
                    }
                    else{
                        a += "<div class='input-control span1 text'>";
                        a += "<input type='text' placeholder='m2' disabled/>";
                        a += "</div>";
                    }
                    a += "<td>";
                    a += "<div class='input-control span2 text'>";
                    if(member === true){
                        a += "<input type='text' value='"+data[0].harga_jual_member+"' placeholder='harga satuan' disabled/>";
                    }
                    else{
                        a += "<input type='text' value='"+data[0].harga_jual_biasa+"' placeholder='harga satuan' disabled/>";
                    }
                    a += "</div>";       
                    a += "</td>";        
                    a += "<td>";
                    a += "<div class='input-control span2 text'>";
                    a += "<input type='text' value='' placeholder='harga' disabled/>";
                    a += "</div>";            
                    a += "</td>";
                    a += "<td>";
                    a += "<i class='icon-cancel fg-red on-right on-left'></i>";
                    a += "</td>";
                    a += "</tr>";

                    $(".data-barang").append(a);
                }
            });
        });
    });
</script>