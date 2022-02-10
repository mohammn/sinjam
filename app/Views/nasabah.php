<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Barang</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-info" onclick="modalForm(0)">Tambah</button>
                <b class="ml-5">Menampilkan Nasabah :</b>
                <select name="aktifTidak" id="aktifTidak" class="btn btn-outline-info" onchange="tampilkan()">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tempatTabel">

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulForm">Tambah Nasabah</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="nikLama" name="nikLama" placeholder="">
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">No. Telpon</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="telp" name="telp" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="tambahAtauEdit()" id="simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat / Upload Foto <b id="namaUploadFoto"></b></h5>
            </div>
            <div class="modal-body text-center">
                <form enctype="multipart/form-data">
                    <input type="hidden" value="" id="nikUploadFoto" name="idUpload">
                    <img src="" id="fotoNasabah" style="width:50%">
                    <br>
                    <br>
                    <div class='alert alert-danger mt-2 d-none' id="err_file"></div>
                    <div class="alert displaynone" id="responseMsg"></div>
                    <input type="file" id="uploadFotoNasabah" class="form-control" name="uploadFotoNasabah" value="Pilih foto" accept="image/*" onchange="ubahFoto(event)">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="upload()" class="btn btn-info">Upload</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>


<script>
    tampilkan()

    function tampilkan() {
        var baris = '<table class="table table-bordered" id="tabelNasabah" width="100%" cellspacing="0"><thead><tr><th>NO</th><th>NIK</th><th>NAMA</th><th>TELP</th><th>ALAMAT</th><th>SALDO</th><th>STATUS</th><th>KELOLA</th></tr></thead><tbody>'
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>/nasabah/data',
            data: "aktifTidak=" + $("#aktifTidak").val(),
            dataType: 'json',
            success: function(data) {
                if (data.length) {
                    for (let i = data.length - 1; i >= 0; i--) {
                        baris += "<tr><td>" + (data.length - i) + "</td><td>" + data[i].nik + "</td><td>" + data[i].nama + "</td><td>" + data[i].telp + "</td><td>" + data[i].alamat + "</td><td>" + data[i].saldo + "</td><td>"
                        if (data[i].status == 1) {
                            baris += "Aktif"
                        } else {
                            baris += "Tidak Aktif"
                        }
                        baris += "</td><td><button href='#' class='btn btn-info btn-sm' onClick='modalForm(1, \"" + data[i].nik + "\", \"" + data[i].nama + "\", \"" + data[i].telp + "\", \"" + data[i].alamat + "\", " + data[i].status + ")'><i class='fa fa-edit'></i><i class='mdi mdi-food'></i></button><button href='#' class='btn btn-info btn-sm ml-2' onClick='tryUpload(\"" + data[i].nik + "\", \"" + data[i].nama + "\" ,\"" + data[i].foto + "\")'><i class='fa fa-image'></button></td></tr>"
                    }
                } else {
                    baris = "<td colspan='4' class='text-center'>Data Masih Kosong :)</td>"
                }
                baris += "</tbody></table>"
                $("#tempatTabel").html(baris)

                $('#tabelNasabah').DataTable({
                    "pageLength": 10,
                });
            }
        });
    }


    function tambahAtauEdit() {
        if ($("#nik").val() == "") {
            $("#nik").focus();
        } else if ($("#nama").val() == "") {
            $("#nama").focus();
        } else if ($("#telp").val() == "") {
            $("#telp").focus();
        } else if ($("#alamat").val() == "") {
            $("#alamat").focus();
        } else {
            $.ajax({
                type: 'POST',
                data: 'nik=' + $("#nik").val() + '&nama=' + $("#nama").val() + '&telp=' + $("#telp").val() + '&alamat=' + $("#alamat").val() + '&status=' + $("#status").val() + '&nikLama=' + $("#nikLama").val(),
                url: '<?= base_url() ?>/nasabah/tambah',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $("#nik").val("");
                    $("#nama").val("");
                    $("#telp").val("");
                    $("#alamat").val("");
                    $("#status").val(1);

                    $('#modalForm').modal('hide');
                    tampilkan();
                }
            });
        }
    }

    function modalForm(jenis, nik = "", nama = "", telp = "", alamat = "", status = 0) {
        if (jenis) {
            $("#nik").prop("disabled", true)
            $("#judulForm").html("Edit Nasabah")
            $("#nikLama").val(nik)
            $("#nik").val(nik)
            $("#nama").val(nama)
            $("#telp").val(telp)
            $("#alamat").val(alamat)
            $("#status").val(status)
        } else {
            $("#nik").prop("disabled", false)
            $("#judulForm").html("Tambah Nasabah")
            $("#nikLama").val(false)
            $("#nik").val("")
            $("#nama").val("")
            $("#telp").val("")
            $("#alamat").val("")
            $("#status").val(1)
        }

        $("#modalForm").modal('show')
    }

    function tryUpload(nik, nama, foto) {
        $("#nikUploadFoto").val(nik)
        $.ajax({
            url: '<?= base_url() ?>/nasabah/getData',
            method: 'post',
            data: "nik=" + nik,
            dataType: 'json',
            success: function(data) {
                $("#fotoNasabah").attr('src', '<?= base_url() . "/public/upload/" ?>' + data.foto + "?=" + new Date().getTime())
                $("#namaUploadFoto").html(data.nama)
                $("#modalUpload").modal("show")
            }
        });
    }

    function upload() {
        var files = $('#uploadFotoNasabah')[0].files;

        if (files.length > 0) {
            var fd = new FormData();
            fd.append('file', files[0]);
            fd.append('nik', $("#nikUploadFoto").val());

            $('#responseMsg').hide();

            $.ajax({
                url: '<?= base_url() ?>/nasabah/upload',
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    $('#err_file').removeClass('d-block');
                    $('#err_file').addClass('d-none');

                    if (response.success == 1) {
                        $('#responseMsg').removeClass("alert-danger");
                        $('#responseMsg').addClass("alert-success");
                        $('#responseMsg').html(response.message);
                        $('#responseMsg').show();

                        $('#responseMsg').hide();
                        $('#uploadFotoNasabah').val("")

                        $("#modalUpload").modal("hide")
                    } else if (response.success == 2) {
                        $('#responseMsg').removeClass("alert-success");
                        $('#responseMsg').addClass("alert-danger");
                        $('#responseMsg').html(response.message);
                        $('#responseMsg').show();
                    } else {
                        $('#err_file').text(response.message);
                        $('#err_file').removeClass('d-none');
                        $('#err_file').addClass('d-block');
                    }
                },
                error: function(response) {
                    console.log("error : " + JSON.stringify(response));
                }
            });
        } else {
            $('#responseMsg').removeClass("alert-success");
            $('#responseMsg').addClass("alert-danger");
            $('#responseMsg').html("Pilih foto dulu ya.");
            $('#responseMsg').show();
        }
    }

    function ubahFoto(event) {
        $("#fotoNasabah").attr("src", URL.createObjectURL(event.target.files[0]))
    }
</script>
<?php $this->endSection() ?>