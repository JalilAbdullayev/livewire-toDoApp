<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ToDoList extends Component {
    #[Rule('required|min:3|max:50')]
    public string $name;
    public string $search;

    public function create() {
        $validated = $this->validateOnly('name');
        Todo::create($validated);
        $this->reset('name');
        request()->session()->flash('success', 'Task created successfully!');
    }

    public function render() {
        return view('livewire.to-do-list');
    }
}
