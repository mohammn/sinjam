<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Transaksi Tabungan</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group row">
                    <label for="id" class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-10">
                        <input oninput="cekData()" onchange="cekData()" type="text" class="form-control" id="nik" autocomplete="TRUE" list="daftarNasabah" placeholder="">
                        <datalist onchange="cekData()" id="daftarNasabah">

                        </datalist>
                        <div id="errorNasabah"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <button class="btn btn-info" onclick="tampilkan()" id="tombolTampilkan">Tampilkan</button>
                <button class="btn btn-info" data-toggle="modal" data-target="#modalTambah" id="tombolTambah" disabled>Tambah Transaksi</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tempatTabel">

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulForm">Tambah Transaksi</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nikTambah" name="nikTambah" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Nominal</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="tambah()" id="simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
    var nasabah = ""
    muatNasabah()
    var barangKosong = true
    kosongkanTabel("Silahkan cari Nasabah ya :)")

    function muatNasabah() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>/nasabah/dataAktif',
            dataType: 'json',
            success: function(data) {
                nasabah = data;
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].nik + '">' + data[i].nama + '</option>';;
                }
                $("#daftarNasabah").html(html);
            }
        });
    }

    function cekData() {
        $("#errorNasabah").html("")
        barangKosong = true;
        for (var i = 0; i < nasabah.length; i++) {
            if ($('#nik').val() == nasabah[i].nik) {
                $("#errorNasabah").html("<small class='text-success'>NIK ditemukan. atas Nama : '" + nasabah[i].nama + "'</small>")
                barangKosong = false;
                kosongkanTabel("Silahkan Tekan Tombol 'Tampilkan' ya :)")
                $("#nama").val(nasabah[i].nama)
                $("#nikTambah").val(nasabah[i].nik)
                break
            }
        }

        if (barangKosong) {
            $("#errorNasabah").html("<small class='text-danger'>NIK tidak ditemukan.</small>")
            $('#nama').val("");
            $('#netto').val("");
            kosongkanTabel("Data Nasabah Tidak Ditemukan :(")
        }
    }

    function kosongkanTabel(pesan) {
        var baris = '<table class="table table-bordered" id="tabelNasabah" width="100%" cellspacing="0"><thead><tr><th>NO</th><th>TANGGAL</th><th>KETERANGAN</th><th>NOMINAL</th><th>PETUGAS</th><th>SALDO</th></tr></thead><tbody>'
        baris += "<td colspan='6' class='text-center'>" + pesan + "</td></tbody></table>"
        $("#tempatTabel").html(baris)
    }

    function tampilkan() {
        cekData()
        var nik = $("#nik").val()
        $.ajax({
            url: '<?= base_url() ?>/transaksi/getData',
            method: 'post',
            data: "nik=" + nik,
            dataType: 'json',
            success: function(data) {
                if (data.length || barangKosong == false) {
                    $("#nik").prop("disabled", true)
                    $("#tombolTambah").prop("disabled", false)
                    $("#tombolTampilkan").html("Edit NIK")
                    $("#tombolTampilkan").removeClass("btn-info")
                    $("#tombolTampilkan").addClass("btn-success")
                    $("#tombolTampilkan").attr("onclick", "edit()")

                    var baris = '<table class="table table-bordered" id="tabelNasabah" width="100%" cellspacing="0"><thead><tr><th>NO</th><th>TANGGAL</th><th>KETERANGAN</th><th>NOMINAL</th><th>PETUGAS</th><th>SALDO</th></tr></thead><tbody>'
                    for (let i = data.length - 1; i >= 0; i--) {
                        baris += "<tr><td>" + (data.length - i) + "</td><td>" + data[i].tanggal + "</td><td>" + data[i].keterangan + "</td><td>" + data[i].nominal + "</td><td>" + data[i].petugas + "</td><td>" + data[i].saldo + "</td>"
                    }

                    baris += "</tbody></table>"
                    $("#tempatTabel").html(baris)

                    $('#tabelNasabah').DataTable({
                        "pageLength": 10,
                    });
                } else {
                    if (nik) {
                        kosongkanTabel("Transaksi Nasabah Masih Kosong :(")
                    } else {
                        kosongkanTabel("Silahkan cari Nasabah ya :)")
                    }
                }
            }
        });
    }

    function edit() {
        $("#nik").prop("disabled", false)
        $("#tombolTambah").prop("disabled", true)
        $("#tombolTampilkan").removeClass("btn-success")
        $("#tombolTampilkan").addClass("btn-info")
        $("#tombolTampilkan").html("Tampilkan")
        $("#tombolTampilkan").attr("onclick", "tampilkan()")
    }


    function tambah() {
        if ($("#nominal").val() == "" || $("#nominal").val() == 0) {
            $("#nominal").focus();
        } else if ($("#keterangan").val() == "") {
            $("#keterangan").focus();
        } else {
            $.ajax({
                type: 'POST',
                data: 'nik=' + $("#nikTambah").val() + '&nominal=' + $("#nominal").val() + '&keterangan=' + $("#keterangan").val(),
                url: '<?= base_url() ?>/transaksi/tambah',
                dataType: 'json',
                success: function(data) {
                    $("#nikTambah").val("");
                    $("#nama").val("");
                    $("#nominal").val("");
                    $("#keterangan").val("");

                    $('#modalTambah').modal('hide');
                    tampilkan();
                }
            });
        }
    }
</script>
<?php $this->endSection() ?>