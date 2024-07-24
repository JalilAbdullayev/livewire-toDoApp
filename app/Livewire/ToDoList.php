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
    public int $todoId;

    #[Rule('required|min:3|max:50')]
    public string $newName;

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

    public function edit(Todo $todo) {
        $this->todoId = $todo->id;
        $this->newName = $todo->name;
    }

    public function cancel() {
        $this->reset('todoId', 'newName');
    }

    public function update() {
        $this->validateOnly('newName');
        Todo::find($this->todoId)->update(['name' => $this->newName]);
        $this->cancel();
    }

    public function render() {
        return view('livewire.to-do-list', ['todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)]);
    }
}
