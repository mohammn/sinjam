<?php

namespace App\Controllers;

use App\Models\NasabahModel;
use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    public function __construct()
    {
        $this->nasabahModel = new NasabahModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        if (!session()->get('nama')) {
            return redirect()->to(base_url() . "/login");
        }
        return view('transaksi');
    }

    public function data()
    {
        echo json_encode($this->nasabahModel->findAll());
    }

    public function getData()
    {
        echo json_encode($this->transaksiModel->where("nik", $this->request->getPost("nik"))->findAll());
    }

    public function tambah()
    {
        $saldoAwal = $this->nasabahModel->where("nik", $this->request->getPost("nik"))->first()["saldo"];

        $saldoAkhir = $saldoAwal + $this->request->getPost("nominal");

        $data = [
            "nik" => $this->request->getPost("nik"),
            "nominal" => $this->request->getPost("nominal"),
            "keterangan" => $this->request->getPost("keterangan"),
            "petugas" => "moham",
            "saldo" => $saldoAkhir
        ];

        $this->transaksiModel->insert($data);

        if ($this->transaksiModel->getInsertID()) {
            $this->nasabahModel->update($this->request->getPost("nik"), ["saldo" => $saldoAkhir]);
        }

        echo json_encode("");
    }
}
