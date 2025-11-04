<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class User extends Component
{
    public  $name, $email, $no_hp, $password, $selected_id;
    public $isOpen = false; // Variabel untuk kontrol modal

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'no_hp' => 'required',
        'password' => 'required',
    ];

    public function render()
    {
        // Menampilkan semua pengguna dengan role 'admin'
        $users = UserModel::where('role', 'admin')->get();

        return view('livewire.user', [
            'users' => $users,
        ]);
    }

    public function create()
    {

        $this->resetInputFields();
        $this->isOpen = true; // Membuka modal
    }

    public function store()
    {

        // Define the base validation rules
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'no_hp' => 'required',
        ];

        // Add password validation only if creating a new user
        if (!$this->selected_id) {
            $rules['password'] = 'required|string|min:6'; // Assuming you want at least 6 characters
        }

        // Validate the input based on the defined rules
        $validatedData = $this->validate($rules);

        if ($this->selected_id) {
            // Update existing user
            $user = UserModel::findOrFail($this->selected_id);
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'no_hp' => $validatedData['no_hp'],
            ]);
        } else {
            // Create new user
            UserModel::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'no_hp' => $validatedData['no_hp'],
                'password' => Hash::make($validatedData['password']), // Hash password here
                'role' => 'admin',
                'is_first_login' => false,
            ]);
        }

        // Flash message after operation
        session()->flash('message', $this->selected_id ? 'User updated successfully.' : 'User created successfully.');

        $this->closeModal(); // Close modal after operation
        $this->resetInputFields(); // Reset input fields
    }



    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->no_hp = $user->no_hp;
        $this->isOpen = true; // Membuka modal untuk edit
    }

    public function delete($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        // Flash message setelah delete
        session()->flash('message', 'User deleted successfully.');

        $this->render(); // Refresh data setelah penghapusan
    }

    public function closeModal()
    {
        $this->isOpen = false; // Menutup modal
    }

    private function resetInputFields()
    {
        // Reset semua input
        $this->selected_id = null;
        $this->name = '';
        $this->email = '';
        $this->no_hp = '';
        $this->password = '';
    }
}
