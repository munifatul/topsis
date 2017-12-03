 <?php
    $kriteria=("SELECT b.id_bobot,a.nama_kriteria FROM kriteria A
                INNER JOIN bobot_penilaian B ON a.id_kriteria=b.id_kriteria");
    $kriteria_query = mysqli_query($db_link,$kriteria);

   
    $sql_pegawai="SELECT B.id_jabatan,A.nama FROM pegawai A
                INNER JOIN jabatan_pegawai B ON A.no_pegawai=B.id_pegawai
                LEFT JOIN Penilaian C ON B.id_jabatan=C.id_jabatan 
                WHERE C.id_jabatan IS NULL
                ORDER BY A.no_pegawai";
$hasil_pegawai=mysqli_query($db_link,$sql_pegawai);        
?>


<div class="col-sm-6 col-sm-offset-4">  
	<div class="panel-group">
		<div class="panel panel-primary">
            <div class="panel-heading"><h2 class="text-center">TAMBAH PENILAIAN PEGAWAI</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="jabatan">Nama Pegawai : </label>
                        <div class="col-sm-6">
                            <select  class="form-control" name="jabatan">  
                            <?php
                                while ($pegawai_tampil=mysqli_fetch_assoc($hasil_pegawai)){
                                    echo "<option value='".$pegawai_tampil['id_jabatan']."'>".$pegawai_tampil['nama']."</option>";
                                }
                            ?>
                        </select> 
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="control-label col-sm-4" for="penilaian">Kriteria Penilaian :</label>
                    </div>
                    <?php
                        $b=1;

                        while ($kriteria_tampil=mysqli_fetch_assoc($kriteria_query)){
                            echo '
                             <div class="form-group">
                            <label class="control-label col-sm-4 col-sm-offset-1" for="bobot">'.$kriteria_tampil["nama_kriteria"].' : </label>
                            <div class="col-sm-3">
                                    <input type="hidden" class="form-control" id="bobot" name="bobot'.$b.'" value="'.$kriteria_tampil["id_bobot"].'" >
                                    <input type="text" class="form-control" id="bobot" name="penilaian'.$b.'" placeholder="PENILAIAN" >
                            </div>
                            </div>   ';
                        $b++;
                        }
                        
                       
                    ?>
                     <div class="form-group">
                            <label class="control-label col-sm-4" for="tgl_penilaian">Tanggal Penilaian :</label>
                            <div class="col-sm-6">
                                <div class='input-group date datetimepicker1'>
                                    <input type="text" class="form-control" id="tgl_penilaian" name="tgl_penilaian" placeholder="Tanggal Penilaian" >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                   </form>   
                </div>
			<hr style="height:1px; border:none;margin:0; color:#000; background-color:#428bca;">
			<div class="panel-footer">
				<div class="text-center">	
					<button type="sumbit" id="tambah" class="btn btn-success">SIMPAN</button>
                    <button type="button" id="cancel" onclick="window.location ='index.php?navigasi=penilaian&crud=view';" class="btn btn-danger">CANCEL</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>
<script>
 
 $(document).ready(function () {
        var penilaiancount=<?php echo $b; ?>;
            penilaiancount=penilaiancount-1;
          $("#tambah").click(function () {
            var jabatan= $('select[name=jabatan]').val();
            var tgl_penilaian=$('input[name=tgl_penilaian]').val();
            var count=1;
            var penilaian=[];
            var penilaianstring='';
            var bobot=[];
            var bobotstring='';
        while (count<=penilaiancount){
            bobot[count]=$('input[name=bobot'+count+']').val();
            bobotstring=bobotstring+'&bobot'+count+'='+bobot[count];

            penilaian[count]=$('input[name=penilaian'+count+']').val();
            penilaianstring=penilaianstring+'&nilai'+count+'='+penilaian[count];
            count++;
        }
            $.ajax({
              type: "POST",
              url: "../include/kontrol/kontrol_penilaian.php",
              data: 'crud=tambah&count='+penilaiancount+
                    '&tgl_nilai=' +tgl_penilaian+
                    '&jabatan='+jabatan+
                    bobotstring+penilaianstring,
              success: function (respons) {
                  if (respons=='berhasil'){
                         $('#pesan_berhasil').text("Penilaian Pegawai Berhasil Ditambah");
                        $("#hasil").show();
                        setTimeout(function(){
                            $("#hasil").hide(); 
                        }, 2000);
                  }
                  else {
                        $('#pesan_gagal').text("Penilaian Pegawai Gagal Ditambah");
                        $("#gagal").show();
                        setTimeout(function(){
                            $("#gagal").hide(); 
                        }, 2000);

                  }
              }
              
            });
          });
          $(function () {
                $('.datetimepicker1').datetimepicker({
                viewMode: 'years',
                format: 'DD/MM/YYYY'
            }
                );
            });
      });
      
</script>