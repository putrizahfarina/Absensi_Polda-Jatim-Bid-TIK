<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PetugasModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Libraries\enums\UserRole;

class DataPetugas extends BaseController
{
    protected PetugasModel $petugasModel;
    protected \App\Models\GuruModel $guruModel;
    protected \App\Models\UploadModel $uploadModel;

    protected $petugasValidationRules = [
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Email harus diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email ini telah terdaftar.'
            ]
        ],

        'username' => [
            'rules' => 'required|min_length[6]',
            'errors' => [
                'required' => 'Username harus diisi.',
                'min_length' => 'Username minimal 6 karakter.',
                'is_unique' => 'Username ini telah terdaftar.'
            ]
        ],

        'password' => [
            'rules' => 'permit_empty|min_length[6]',
            'errors' => [
                'min_length' => 'Password minimal 6 karakter.'
            ]
        ]
    ];

    public function __construct()
    {
        $this->petugasModel = new PetugasModel();
        $this->guruModel = new \App\Models\GuruModel();
        $this->uploadModel = new \App\Models\UploadModel();
    }

    /**
     * Mengambil role Super Admin.
     */
    private function getSuperAdminRole()
    {
        foreach (UserRole::ALL_ROLES as $role) {
            if (strtolower(trim($role->label())) === 'super admin') {
                return $role;
            }
        }

        return null;
    }

    /**
     * Halaman utama data petugas.
     */
    public function index()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $data = [
            'title' => 'Data Petugas',
            'ctx' => 'petugas'
        ];

        return view('admin/petugas/data-petugas', $data);
    }

    /**
     * Mengambil data petugas melalui AJAX.
     */
    public function ambilDataPetugas()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $petugas = $this->petugasModel->getAllPetugas();

        $data = [
            'data' => $petugas,
            'empty' => empty($petugas)
        ];

        return view('admin/petugas/list-data-petugas', $data);
    }

    /**
     * Form registrasi petugas.
     * Role otomatis Super Admin.
     */
    public function registerPetugas()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $superAdminRole = $this->getSuperAdminRole();

        if ($superAdminRole === null) {
            throw new \RuntimeException(
                'Role Super Admin tidak ditemukan.'
            );
        }

        $data = [
            'title' => 'Register Petugas',
            'ctx' => 'petugas',
            'roles' => [$superAdminRole]
        ];

        return view('admin/petugas/register', $data);
    }

    /**
     * Proses registrasi petugas.
     * Role ditentukan langsung oleh server.
     */
    public function registerPetugasPost()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $superAdminRole = $this->getSuperAdminRole();

        if ($superAdminRole === null) {
            throw new \RuntimeException(
                'Role Super Admin tidak ditemukan.'
            );
        }

        // Validasi email dan username.
        $rules = $this->petugasValidationRules;

        $rules['email']['rules'] .=
            '|is_unique[auth_identities.secret]';

        $rules['username']['rules'] .=
            '|is_unique[users.username]';

        $rules['password']['rules'] =
            'required|min_length[6]';

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Role otomatis Super Admin.
        $role = $superAdminRole->value;

        // Tidak menghubungkan akun dengan Guru.
        $id_guru = null;

        $result = $this->petugasModel->savePetugas(
            null,
            $email,
            $username,
            $password,
            $role,
            $id_guru,
            1
        );

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Registrasi Super Admin berhasil.',
                'error' => false
            ]);

            return redirect()->to('/admin/petugas');
        }

        session()->setFlashdata([
            'msg' => 'Gagal registrasi Super Admin.',
            'error' => true
        ]);

        return redirect()->back()->withInput();
    }

    /**
     * Form edit petugas.
     */
    public function formEditPetugas($id)
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $petugas = $this->petugasModel->getPetugasById($id);

        if (empty($petugas)) {
            throw new PageNotFoundException(
                'Data petugas dengan id ' . $id . ' tidak ditemukan'
            );
        }

        $superAdminRole = $this->getSuperAdminRole();

        if ($superAdminRole === null) {
            throw new \RuntimeException(
                'Role Super Admin tidak ditemukan.'
            );
        }

        $data = [
            'data' => $petugas,
            'ctx' => 'petugas',
            'title' => 'Edit Data Petugas',

            // Hanya Super Admin yang tersedia.
            'roles' => [$superAdminRole],

            // Tidak ada pilihan Guru.
            'guru' => []
        ];

        return view('admin/petugas/edit-data-petugas', $data);
    }

    /**
     * Proses update data petugas.
     */
    public function updatePetugas()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $idPetugas = $this->request->getVar('id');

        $petugasLama = $this->petugasModel->getPetugasById(
            $idPetugas
        );

        if (empty($petugasLama)) {
            throw new PageNotFoundException(
                'Data petugas tidak ditemukan.'
            );
        }

        $rules = $this->petugasValidationRules;

        // Password boleh kosong ketika edit.
        $rules['password']['rules'] =
            'permit_empty|min_length[6]';

        // Validasi username jika berubah.
        if (
            $petugasLama['username'] !=
            $this->request->getVar('username')
        ) {
            $rules['username']['rules'] =
                'required|min_length[6]|is_unique[users.username]';
        }

        // Validasi email jika berubah.
        if (
            $petugasLama['email'] !=
            $this->request->getVar('email')
        ) {
            $rules['email']['rules'] =
                'required|valid_email|is_unique[auth_identities.secret]';
        }

        if (!$this->validate($rules)) {

            $superAdminRole = $this->getSuperAdminRole();

            $data = [
                'data' => $this->petugasModel->getPetugasById(
                    $idPetugas
                ),
                'ctx' => 'petugas',
                'title' => 'Edit Data Petugas',
                'validation' => $this->validator,
                'oldInput' => $this->request->getVar(),
                'roles' => $superAdminRole ? [$superAdminRole] : [],
                'guru' => []
            ];

            return view(
                'admin/petugas/edit-data-petugas',
                $data
            );
        }

        $superAdminRole = $this->getSuperAdminRole();

        if ($superAdminRole === null) {
            throw new \RuntimeException(
                'Role Super Admin tidak ditemukan.'
            );
        }

        $password = $this->request->getVar('password') ?: false;

        $email = $this->request->getVar('email');
        $username = $this->request->getVar('username');

        // Role tidak diambil dari input browser.
        $role = $superAdminRole->value;

        // Hapus hubungan Guru.
        $id_guru = null;

        $result = $this->petugasModel->savePetugas(
            $idPetugas,
            $email,
            $username,
            $password,
            $role,
            $id_guru,
            $petugasLama['active']
        );

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Edit data petugas berhasil.',
                'error' => false
            ]);

            return redirect()->to('/admin/petugas');
        }

        session()->setFlashdata([
            'msg' => 'Gagal mengubah data petugas.',
            'error' => true
        ]);

        return redirect()->to(
            '/admin/petugas/edit/' . $idPetugas
        );
    }

    /**
     * Hapus data petugas.
     */
    public function delete($id)
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $result = $this->petugasModel->delete($id);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Data berhasil dihapus.',
                'error' => false
            ]);

            return redirect()->to('/admin/petugas');
        }

        session()->setFlashdata([
            'msg' => 'Gagal menghapus data.',
            'error' => true
        ]);

        return redirect()->to('/admin/petugas');
    }

    /**
     * Mengaktifkan atau menonaktifkan akun petugas.
     */
    public function toggleActivation($id)
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $petugas = $this->petugasModel->getPetugasById($id);

        if (empty($petugas)) {
            throw new PageNotFoundException(
                'Data petugas dengan id ' . $id . ' tidak ditemukan'
            );
        }

        $newStatus = ($petugas['active'] ?? 0) == 1 ? 0 : 1;

        $this->petugasModel->update(
            $id,
            ['active' => $newStatus]
        );

        session()->setFlashdata([
            'msg' => 'Status akun berhasil diubah.',
            'error' => false
        ]);

        return redirect()->to('/admin/petugas');
    }

    /*
     * ---------------------------------------------------------
     * IMPORT PETUGAS
     * ---------------------------------------------------------
     */

    /**
     * Halaman bulk import petugas.
     *
     * Data Guru tetap disediakan untuk menjaga kompatibilitas
     * dengan proses import yang lama.
     */
    public function bulkPost()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $data = [
            'title' => 'Import Petugas',
            'ctx' => 'petugas',
            'guru' => $this->guruModel->getAllGuru()
        ];

        return view('admin/petugas/import-petugas', $data);
    }

    /**
     * Generate CSV Object Post.
     */
    public function generateCSVObjectPost()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        // Hapus file TXT sementara yang lama.
        $files = glob(FCPATH . 'uploads/tmp/*.txt');

        if (!empty($files)) {
            foreach ($files as $item) {
                if (
                    file_exists($item) &&
                    !unlink($item)
                ) {
                    log_message(
                        'error',
                        'Failed to delete temporary file: {file}',
                        ['file' => $item]
                    );
                }
            }
        }

        $file = $this->uploadModel->uploadCSVFile('file');

        if (!empty($file) && !empty($file['path'])) {

            $obj = $this->petugasModel->generateCSVObject(
                $file['path']
            );

            if (!empty($obj)) {
                $data = [
                    'result' => 1,
                    'numberOfItems' => $obj->numberOfItems,
                    'txtFileName' => $obj->txtFileName
                ];

                return $this->response->setJSON($data);
            }
        }

        return $this->response->setJSON([
            'result' => 0
        ]);
    }

    /**
     * Import CSV Item Post.
     */
    public function importCSVItemPost()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $txtFileName = inputPost('txtFileName');
        $index = inputPost('index');

        if (!is_numeric($index) || (int) $index < 1) {
            return $this->response->setJSON([
                'result' => 0,
                'index' => $index,
                'message' => 'Invalid index'
            ]);
        }

        $index = (int) $index;

        try {
            $petugas = $this->petugasModel->importCSVItem(
                $txtFileName,
                $index
            );

            if (!empty($petugas)) {
                $data = [
                    'result' => 1,
                    'petugas' => $petugas,
                    'index' => $index
                ];

                return $this->response->setJSON($data);
            }

            return $this->response->setJSON([
                'result' => 0,
                'index' => $index,
                'message' => 'Duplicate or invalid data'
            ]);

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());

            return $this->response->setJSON([
                'result' => 0,
                'index' => $index,
                'message' => 'Terjadi kesalahan saat import data.'
            ]);
        }
    }

    /**
     * Download CSV File Post.
     */
    public function downloadCSVFilePost()
    {
        if (!is_superadmin()) {
            return redirect()->to('admin');
        }

        $file = FCPATH . 'assets/file/csv_petugas_template.csv';

        if (file_exists($file)) {
            return $this->response->download($file, null);
        }

        return redirect()
            ->back()
            ->with('error', 'Template file not found.');
    }
}
