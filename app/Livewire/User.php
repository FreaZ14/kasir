<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as modelUser;
class User extends Component
{
    public $pilihanMenu = 'lihat';
    public $nama;
    public $email;
    public $peran;
    public $password;

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'peran' => 'required',
            'password' => 'required'
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format harus Email',
            'email.unique' => 'Email sudah digunakan',
            'peran.required' => 'Peran harus dipilih',
            'password.required' => 'Password harus diisi'
        ]);
        $simpan = new ModelUser();
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        $simpan->peran = $this->peran;
        $simpan->password = bcrypt($this->password);
        $simpan->save();
        $this->reset(['nama', 'email', 'peran', 'password']);
        $this->pilihanMenu = 'lihat';
    }
    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }
    public function render()
    {
        return view('livewire.user')->with([
            'semuaPengguna' => ModelUser::all()
        ]);
    }
}
