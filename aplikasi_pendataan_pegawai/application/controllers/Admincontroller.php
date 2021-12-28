<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admincontroller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pegawai_model', 'Pegawai_model');
        $this->load->model('gaji_model', 'Gaji_model');
        $this->load->model('jabatan_model', 'Jabatan_model');
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['judul'] = "Admin Page";
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['menu'] = $this->db->get_where('user_sub_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();
        $this->load->view('komponen/header', $data);
        $this->load->view('komponen/sidebar', $data);
        // $this->load->view('komponen/topnav', $data);
        $this->load->view('admin/index', $data);
        // $this->load->view('komponen/footer', $data);
    }

    // START PROCESS PEGAWAI

    public function data_pegawai()
    {
        // mengambil data seluruh pegawai
        $data['getAllPegawai'] = $this->Pegawai_model->allData();
        // mengambil seluruh dara jabatan
        $data['jabatan'] = $this->db->get('jabatan')->result_array();
        // membuat judul halaman
        $data['title'] = "Data Pegawai";
        $data['judul'] = "Data Pegawai";
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['menu'] = $this->db->get_where('user_sub_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();
        // memanggil header halaman
        $this->load->view('komponen/header', $data);
        // memanggil sidebar halaman
        $this->load->view('komponen/sidebar', $data);
        // $this->load->view('komponen/topnav', $data);
        $this->load->view('admin/data_pegawai', $data);
        // $this->load->view('komponen/footer', $data);
    }

    public function tambahDataPegawai()
    {
        // pembuatan aturan inputan
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('nip', 'Nip', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tgl_lahir', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat_lahir', 'required|trim');
        $this->form_validation->set_rules('jenkel', 'Jenkel', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('status_nikah', 'Status_nikah', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('jml_anak', 'Jumlah_anak', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim');
        $this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan_terakhir', 'required|trim');
        $this->form_validation->set_rules('gaji_pokok', 'Gaji_pokok', 'required|trim');

        // cek apakah aturan berjalan dengan seharusnya

        // jika tidak
        if ($this->form_validation->run() == false) {
            // tempilkan pesan kegagalan
            echo 'validation failed';
        } else {
            // jika berhasil panggil model pegawai dan jalankan fungsi untuk menambah atau mengirim data
            $this->Pegawai_model->addNewPegawai();
            redirect('admincontroller/data_pegawai');
        }
    }

    public function updateDataPegawai($id)
    {
        // pembuatan aturan inputan
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('nip', 'Nip', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tgl_lahir', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat_lahir', 'required|trim');
        $this->form_validation->set_rules('jenkel', 'Jenkel', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('status_nikah', 'Status_nikah', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('jml_anak', 'Jumlah_anak', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No_hp', 'required|trim');
        $this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan_terakhir', 'required|trim');
        $this->form_validation->set_rules('gaji_pokok', 'Gaji_pokok', 'required|trim');
        // cek apakah aturan berjalan dengan seharusnya
        if ($this->form_validation->run() == false) {
            echo 'validation failed';
        } else {
            // jika aturan berjalan dengan seharusnya maka jalan kan model pegawai dan jalan kan fungsi ubah data
            $this->Pegawai_model->UbahPegawai($id);
            redirect('admincontroller/data_pegawai');
        }
    }

    public function deleteDataPegawai($id)
    {
        $this->Pegawai_model->hapusData($id);
        redirect('admincontroller/data_pegawai');
    }

    public function laporanPegawaiPdf()
    {
        // ambil semua data pegawai
        $data['allPegawai'] = $this->Pegawai_model->allData();
        $this->load->library('pdf');
        // mengatur jenis kertas dan layout
        $this->pdf->setPaper('A4', 'potrait');
        // menentukan nama file
        $this->pdf->filename = "Laporan_Data_Gaji.pdf";
        // memanggil file yang akan digenerate menjadi pdf
        $this->pdf->load_view('laporan/laporan_pegawai_pdf', $data);
    }

    public function laporanPegawaiExcel()
    {
        $data['allDataGaji'] = $this->Gaji_model->getAllGajiJoinPegawai();
        $this->load->view('laporan/laporan_gaji_excel', $data);
    }

    // END PROCESS PEGAWAI

    // START PROCESS GAJI

    public function data_gaji()
    {
        $data['getAllGaji'] = $this->Gaji_model->getAllDataGaji();
        $data['dataPegawai'] = $this->db->get('data_pegawai')->result_array();

        $data['title'] = "Data Gaji";
        $data['judul'] = "Data Gaji";
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['menu'] = $this->db->get_where('user_sub_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();
        $this->load->view('komponen/header', $data);
        $this->load->view('komponen/sidebar', $data);
        // $this->load->view('komponen/topnav', $data);
        $this->load->view('admin/data_gaji', $data);
        // $this->load->view('komponen/footer', $data);
    }

    public function tambahdataGaji()
    {
        $this->form_validation->set_rules('kode_pegawai', 'Kode_pegawai', 'required|trim');
        $this->form_validation->set_rules('tunjangan', 'Tunjangan', 'required|trim');
        $this->form_validation->set_rules('jml_lembur', 'Jml_lembur', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata("message", "<script>alert('validasi gagal');</script>");
            redirect("admincontroller/data_gaji");
        } else {
            $jml_lembur = $this->input->post('jml_lembur');
            $tunjangan = $this->input->post('tunjangan');
            $total = (150000 * $jml_lembur) + $tunjangan;
            $data = [
                'id_pegawai' => $this->input->post('kode_pegawai'),
                'tunjangan' => $this->input->post('tunjangan'),
                'jumlah_lembur' => $this->input->post('jml_lembur'),
                'total' => $total
            ];

            $this->Gaji_model->addNewGaji($data);
            redirect('admincontroller/data_gaji');
        }
    }


    public function updateDataGaji($id)
    {
        $this->form_validation->set_rules('id', 'Id', 'required|trim');
        $this->form_validation->set_rules('kode', 'Kode', 'required|trim');
        $this->form_validation->set_rules('tunjangan', 'Tunjangan', 'required|trim');
        $this->form_validation->set_rules('jml_lembur', 'jml_lembur', 'required|trim');

        if ($this->form_validation->run() == false) {
            echo 'validation failed';
        } else {
            $jml_lembur = $this->input->post('jml_lembur');
            $tunjangan = $this->input->post('tunjangan');
            $total = (150000 * $jml_lembur) + $tunjangan;
            $data = [
                'id_pegawai' => $this->input->post('kode'),
                'tunjangan' => $this->input->post('tunjangan'),
                'jumlah_lembur' => $this->input->post('jml_lembur'),
                'total' => $total
            ];

            $this->Gaji_model->updateDataGaji($id, $data);
            redirect('admincontroller/data_gaji');
        }
    }

    public function hapusDataGaji($id)
    {
        $this->Gaji_model->deleteDataGaji($id);
        redirect('admincontroller/data_gaji');
    }

    public function laporanGajiPegawai()
    {
        $data['allDataGaji'] = $this->Gaji_model->getAllGajiJoinPegawai();
        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "Laporan_Data_Gaji.pdf";
        $this->pdf->load_view('laporan/laporan_Gaji_pdf', $data);
    }

    public function laporanGajiExcel()
    {
        $data['allDataGaji'] = $this->Gaji_model->getAllGajiJoinPegawai();
        $this->load->view('laporan/laporan_gaji_excel', $data);
    }

    public function importGajiFromExcel()
    {
        if (isset($_POST['import'])) {

            $file = $_FILES['data_gaji']['tmp_name'];

            // Medapatkan ekstensi file csv yang akan diimport.
            $ekstensi  = explode('.', $_FILES['data_gaji']['name']);

            // Tampilkan peringatan jika submit tanpa memilih menambahkan file.
            if (empty($file)) {
                echo 'File tidak boleh kosong!';
            } else {
                // Validasi apakah file yang diupload benar-benar file csv.
                if (strtolower(end($ekstensi)) === 'csv' || strtolower(end($ekstensi)) == 'xlx') {
                    if ($_FILES["data_gaji"]["size"] > 0) {
                        # code...
                        $i = 0;
                        $handle = fopen($file, "r");
                        while (($row = fgetcsv($handle, 2048, ";"))) {
                            // var_dump($row);
                            // die;
                            $i++;

                            if ($i == 1) continue;

                            // var_dump($row[$i][1]);
                            // die;
                            // Data yang akan disimpan ke dalam databse

                            $data = [
                                'nama' => $row[1],
                                'nip' => $row[2],
                                'id_jabatan' => $row[3],
                                'tanggal_lahir' => $row[4],
                                'tempat_lahir' => $row[5],
                                'jenis_kelamin' => $row[6],
                                'agama' => $row[7],
                                'status_pernikahan' => $row[8],
                                'jumlah_anak' => $row[9],
                                'alamat' => $row[10],
                                'nomor_telpon' => $row[11],
                                'pendidikan_terakhir' => $row[12],
                                'gaji_pokok' => $row[13],
                            ];
                            // var_dump($data);
                            // die;
                            // Simpan data ke database.
                            // $this->Jabatan_model->addNewJabatan($data);
                            $this->Gaji_model->addNewGaji($data);
                        }

                        fclose($handle);
                        redirect('admincontroller/jabatan');
                    }
                } else {
                    echo 'Format file tidak valid!';
                }
            }
        }
    }
    // END PROCESS GAJI

    // START PROSES JABATAN
    public function jabatan()
    {
        $data['getAllJabatan'] = $this->Jabatan_model->getAllDataJabatan();
        $data['title'] = "Jabatan";
        $data['judul'] = "Jabatan";
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['menu'] = $this->db->get_where('user_sub_menu', ['role_id' => $this->session->userdata('role_id')])->row_array();
        $this->load->view('komponen/header', $data);
        $this->load->view('komponen/sidebar', $data);
        // $this->load->view('komponen/topnav', $data);
        $this->load->view('admin/data_jabatan', $data);
        // $this->load->view('komponen/footer', $data);
    }

    public function tambahdatajabatan()
    {
        $this->form_validation->set_rules('nip', 'Nip', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('tunjangan', 'Tunjangan', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata("message", "<script>alert('Data gagal disimpan');</script>");
            redirect("admincontroller/jabatan");
        } else {
            $data = [
                'kode_jabatan' => $this->input->post('nip'),
                'nama_jabatan' => $this->input->post('nama'),
                'tunjangan' => $this->input->post('tunjangan'),
            ];

            $this->Jabatan_model->addNewJabatan($data);
            redirect('admincontroller/jabatan');
        }
    }

    public function ubahDataJabatan($id)
    {
        $this->form_validation->set_rules('id', 'Id', 'required');
        $this->form_validation->set_rules('kode', 'Kode', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('tunjangan', 'Tunjangan', 'required');

        $id = $this->input->post('id');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata("message", "<script>alert('Data gagal disimpan');</script>");
            redirect("admincontroller/jabatan");
        } else {
            $data = [
                'kode_jabatan' => $this->input->post('kode'),
                'nama_jabatan' => $this->input->post('nama'),
                'tunjangan' => $this->input->post('tunjangan'),
            ];
            $this->Jabatan_model->updateDataJabatan($data, $id);
            redirect('admincontroller/jabatan');
        }
    }

    public function hapusDataJabatan($id)
    {
        $dataUser = $this->Pegawai_model->oneData($id);
        if ($id == $dataUser["id"]) {
            // $this->session->set_flashdata("message", "maaf anda tidak bisa menghapus data tersebut, karena data tersebut terhubung dengan data dari pegawai tertentu, silahkan hapus data yang ada pada data pegawai sebelum menghapus data jabatan");
            $this->session->set_flashdata("message", "<script>alert('maaf anda tidak bisa menghapus data tersebut, karena data tersebut terhubung dengan data dari pegawai tertentu, silahkan hapus data yang ada pada data pegawai sebelum menghapus data jabatan');</script>");
            redirect("admincontroller/jabatan");
            // echo "<script>alert('maaf anda tidak bisa menghapus data tersebut, karena data tersebut terhubung dengan data dari pegawai tertentu, silahkan hapus data yang ada pada data pegawai sebelum menghapus data jabatan');</script>";
        } else {
            $this->Jabatan_model->deleteDataJabatan($id);
            redirect('admincontroller/jabatan');
        }
    }

    public function cetakLaporanJabatan()
    {
        $data['getAllData'] = $this->Jabatan_model->getAllDataJabatan();

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "Laporan_Data_Jabatan.pdf";
        $this->pdf->load_view('laporan/laporan_data_jabatan', $data);
    }

    public function importFromExcel()
    {
        if (isset($_POST['import'])) {

            $file = $_FILES['jabatan']['tmp_name'];

            // Medapatkan ekstensi file csv yang akan diimport.
            $ekstensi  = explode('.', $_FILES['jabatan']['name']);

            // Tampilkan peringatan jika submit tanpa memilih menambahkan file.
            if (empty($file)) {
                echo 'File tidak boleh kosong!';
            } else {
                // Validasi apakah file yang diupload benar-benar file csv.
                if (strtolower(end($ekstensi)) === 'csv' || strtolower(end($ekstensi)) == 'xlx') {
                    if ($_FILES["jabatan"]["size"] > 0) {
                        # code...
                        $i = 0;
                        $handle = fopen($file, "r");
                        while (($row = fgetcsv($handle, 2048, ";"))) {
                            // var_dump($row);
                            // die;
                            $i++;

                            if ($i == 1) continue;

                            // var_dump($row[$i][1]);
                            // die;
                            // Data yang akan disimpan ke dalam databse

                            $data = [
                                'kode_jabatan' => $row[1],
                                'nama_jabatan' => $row[2],
                                'tunjangan' => $row[3],
                            ];
                            // var_dump($data);
                            // die;
                            // Simpan data ke database.
                            $this->Jabatan_model->addNewJabatan($data);
                        }

                        fclose($handle);
                        redirect('admincontroller/jabatan');
                    }
                } else {
                    echo 'Format file tidak valid!';
                }
            }
        }
    }
    // END PROSES JABATAN
}
