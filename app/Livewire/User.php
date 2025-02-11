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
    public $penggunaTerpilih;


    public function simpanEdit(){
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email', 'unique:users,email,'.$this->penggunaTerpilih->id],
            'peran' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format harus Email',
            'email.unique' => 'Email sudah digunakan',
            'peran.required' => 'Peran harus dipilih',
        ]);
        $simpan = $this->penggunaTerpilih;
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        if ($this->password){
            $simpan->password = bcrypt($this->password);
        }
        $simpan->peran = $this->peran;
        $simpan->save();

        $this->reset(['nama', 'email', 'peran', 'password', 'penggunaTerpilih']);
        $this->pilihanMenu = 'lihat';
    }
    public  function pilihEdit($id){
        $this->penggunaTerpilih = ModelUser::findOrFail($id);
        $this->nama = $this->penggunaTerpilih->name;
        $this->email = $this->penggunaTerpilih->email;
        $this->peran = $this->penggunaTerpilih->peran;
        $this->pilihanMenu = 'edit';
    }
    public  function pilihHapus($id){
        $this->penggunaTerpilih = ModelUser::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus(){
        $this->penggunaTerpilih->delete();
        $this->reset();
    }

    public function batal(){
        $this->reset();
    }


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
