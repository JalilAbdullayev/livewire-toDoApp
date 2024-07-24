<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ToDoList extends Component {
    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public string $name;
    public string $search = '';

    public function create() {
        $validated = $this->validateOnly('name');
        Todo::create($validated);
        $this->reset('name');
        request()->session()->flash('success', 'Task created successfully!');
    }

    public function delete(Todo $todo) {
        $todo->delete();
    }

    public function toggle(Todo $todo) {
        $todo->update(['completed' => !$todo->completed]);
    }

    public function render() {
        return view('livewire.to-do-list', ['todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)]);
    }
}
