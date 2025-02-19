<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TaskDashboard extends Component
{
    public $tasks = [];
    public $title;

    public $editMode = false;
    public $taskId;
    public $confirmingDelete = null;

    protected $rules = [
        'title' => 'required|string|max:255'
    ];

    public function mount()
    {
        $this->tasks = Task::where('user_id', Auth::id())->latest()->get();
    }

    public function createTask()
    {
        $this->validate();

        Task::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
        ]);
        
        $this->reset(['title']);

        $this->tasks = Task::where('user_id', Auth::id())->latest()->get();

        session()->flash('message', 'Task created successfully.');
    }

    public function toggleTask($taskId)
    {
        $task = Task::find($taskId);
        $task->status = !$task->status;
        $task->save();
        $this->tasks = Task::where('user_id', Auth::id())->latest()->get();
    }

    public function editTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $this->taskId = $taskId;
        $this->title = $task->title;
        $this->editMode = true;
    }

    public function updateTask()
    {
        $validated = $this->validate([
            'title' => 'required|min:3',
        ]);

        $task = Task::findOrFail($this->taskId);
        $task->update($validated);
        
        $this->cancelEdit();
        $this->tasks = Task::where('user_id', Auth::id())->latest()->get();
        session()->flash('message', 'Task updated successfully!');
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->reset(['title', 'taskId']);
    }

    public function confirmDelete($taskId)
    {
        $this->confirmingDelete = $taskId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteTask($taskId)
    {
        Task::findOrFail($taskId)->delete();
        $this->confirmingDelete = null;
        session()->flash('message', 'Task deleted successfully!');
        $this->tasks = Task::where('user_id', Auth::id())->latest()->get();
    }

    public function render()
    {
        return view('livewire.task-dashboard')->layout('layouts.app');
    }

}
