<div class="col-sm-8 col-sm-offset-4">  
<?php 
//$tanggal=mysqli_query($db_link,"SELECT DISTINCT tgl_penilaian FROM penilaian"); 
$toko=mysqli_query($db_link,"SELECT id_toko,nama_toko FROM toko"); 
$bag=mysqli_query($db_link,"SELECT id_bagian,bagian FROM bagian");  
?>

<h2 class="text-center">LAPORAN USULAN PEGAWAI TERBAIK</h2> 
	<div class="panel-group" >
		<div class="panel panel-default" style="padding:10px" >
            <br/>
            <form class="form-horizontal">
          <div class="form-group">
              <label class="control-label col-sm-3" for="month">Bulan : </label>
                <div class="col-sm-5">
                    <select  class="form-control" name="month">
						<option>- Pilih Bulan -</option>
						<option value="01">Januari</option>
						<option value="02">Februari</option>
						<option value="03">Maret</option>
						<option value="04">April</option>
						<option value="05">Mei</option>
						<option value="06">Juni</option>
						<option value="07">Juli</option>
						<option value="08">Agustus</option>
						<option value="09">September</option>
						<option value="10">Oktober</option>
						<option value="11">November</option>
						<option value="12">Desember</option>
						</select>
                </div>
            </div>
			
			 <div class="form-group">
              <label class="control-label col-sm-3" for="year">Tahun : </label>
                <div class="col-sm-5">
                    <select  class="form-control" name="year">
						<?php
							$mulai= date('Y') - 50;
							for($i = $mulai;$i<$mulai + 100;$i++){
    						$sel = $i == date('Y') ? ' selected="selected"' : '';
    						echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
							}
						?>
					</select>
                </div>
            </div>
			
             <div class="form-group">
                <label class="control-label col-sm-3" for="toko">Toko : </label>
                <div class="col-sm-5">
                    <select  class="form-control" name="toko">  
                        <option value='0'>All</option>
                    <?php
                        while ($data_toko=mysqli_fetch_assoc($toko)){
                            echo "<option value='".$data_toko['id_toko']."'>".$data_toko['nama_toko']."</option>";
                        }
                    ?>
                </select> 
                </div>
            </div>
             <div class="form-group">
                <label class="control-label col-sm-3" for="jabatan">Jabatan : </label>
                <div class="col-sm-5">
                        <select  class="form-control" name="jabatan" id="jabatan">  
                        <option value="none">All</option>
                        <option value="koordinator">Koordinator</option>
                        <option value="karyawan">Karyawan</option>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="bagian">Bagian : </label>
                <div class="col-sm-5">
                    <select  class="form-control" name="bagian">  
                        <option value='none' >All</option>
                    <?php
                        while ($data_bag=mysqli_fetch_assoc($bag)){
                            echo "<option value='".$data_bag['id_bagian']."'>".$data_bag['bagian']."</option>";
                        }
                    ?>
                </select> 
                </div>
           </div>
           <div class="form-group">
                <label class="control-label col-sm-3" for="toko">Jumlah Terbaik : </label>
                <div class="col-sm-5">
                   <input type="number" name='jumlah_terbaik' class="form-control" >
                </div>
           </div>
           <div class="text-center">	
					<button type="button" id="tampil" class="btn btn-success">TAMPIL</button>
				</div>
                    
            </form>
            </div>
            <br/>
        <div class="point">
        </div>
    </tbody>
    </table>

		</div>
	</div>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>

<script>
	 $(document).ready(function () {

        $("#tampil").click(function () {
            var month= $('select[name=month]').val();
            var year= $('select[name=year]').val();
			var id_toko= $('select[name=toko]').val();
			var jabatan= $('select[name=jabatan]').val();
            var id_bagian= $('select[name=bagian]').val();
            var jum_terbaik= $('input[name=jumlah_terbaik]').val();
           	$.ajax({
					type: "POST",
					url: "../include/view/read/usulan_terbaik2.php",
					data: 'month='+month+'&year='+year+'&id_toko='+id_toko+'&jabatan='+jabatan+'&id_bagian='+id_bagian+'&jum_terbaik='+jum_terbaik,
					success: function (respons) {
                        $('.point').html(respons);
                        
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