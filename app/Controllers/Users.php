<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $data['users'] = $userModel->findAll();

        return view('users/index', $data);
    }
    public function new()
{
    return view('users/form', [
        'title' => 'Add User',
        'user'  => null,
    ]);
}

public function create()
{
    $rules = [
        'username'  => 'required|max_length[50]|is_unique[users.username]',
        'full_name' => 'required|max_length[100]',
        'password'  => 'required|min_length[8]|max_length[255]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $model = new \App\Models\UserModel();

    $model->insert([
        'username'  => trim((string) $this->request->getPost('username')),
        'full_name' => trim((string) $this->request->getPost('full_name')),

        // Never save the plain password.
        'password' => password_hash(
            (string) $this->request->getPost('password'),
            PASSWORD_DEFAULT
        ),
    ]);

    return redirect()->to('/users')
        ->with('success', 'User added successfully.');
}

public function edit(int $id)
{
    $model = new \App\Models\UserModel();
    $user  = $model->find($id);

    if (! $user) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    return view('users/form', [
        'title' => 'Edit User',
        'user'  => $user,
    ]);
}

public function update(int $id)
{
    $model = new \App\Models\UserModel();
    $user  = $model->find($id);

    if (! $user) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $rules = [
        'username' => "required|max_length[50]|is_unique[users.username,id,{$id}]",
        'full_name' => 'required|max_length[100]',
        'password'  => 'permit_empty|min_length[8]|max_length[255]',
    ];

    $avatar = $this->request->getFile('avatar');

    if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
        $rules['avatar'] =
            'uploaded[avatar]|max_size[avatar,2048]|'
            . 'is_image[avatar]|'
            . 'mime_in[avatar,image/jpg,image/jpeg,image/png]|'
            . 'ext_in[avatar,jpg,jpeg,png]';
    }

    if (! $this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $data = [
        'username'  => trim((string) $this->request->getPost('username')),
        'full_name' => trim((string) $this->request->getPost('full_name')),
    ];

    $password = (string) $this->request->getPost('password');

if ($password !== '') {
    $data['password'] = password_hash(
        $password,
        PASSWORD_DEFAULT
    );
}

    if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
        $uploadPath = FCPATH . 'uploads/avatars';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $filename = $avatar->getRandomName();
        $avatar->move($uploadPath, $filename);

        service('image')
            ->withFile($uploadPath . DIRECTORY_SEPARATOR . $filename)
            ->fit(200, 200, 'center')
            ->save($uploadPath . DIRECTORY_SEPARATOR . $filename, 85);

        $data['avatar'] = $filename;
    }

    $model->update($id, $data);

    return redirect()->to('/users')
        ->with('success', 'User updated successfully.');
}
}