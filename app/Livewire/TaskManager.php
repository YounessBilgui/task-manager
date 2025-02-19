<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use App\Models\User;

class TaskManager extends Component
{
    use WithPagination;

    public $users;
    public $selectedUser = '';
    public $selectedStatus = '';
    public $selectedDate = '';
    public $confirmingDeleteTask = null;

    protected $queryString = [
        'selectedUser' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
        'selectedDate' => ['except' => ''],
    ];

    public function mount()
    {
        $this->users = User::all();
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tasks = Task::with('user')
            ->when($this->selectedUser, fn($q) => $q->where('user_id', $this->selectedUser))
            ->when($this->selectedStatus !== '', fn($q) => $q->where('status', $this->selectedStatus))
            ->when($this->selectedDate, fn($q) => $q->whereDate('created_at', $this->selectedDate))
            ->latest()
            ->paginate(10);

        return view('livewire.task-manager', compact('tasks'))
            ->layout('layouts.app');
    }
    public function updateStatus($taskId, $status)
    {
        Task::findOrFail($taskId)->update(['status' => (bool)$status]);
    }

    public function deleteTask($taskId)
    {
        Task::findOrFail($taskId)->delete();
        $this->confirmingDeleteTask = null;
        session()->flash('message', 'Task deleted successfully');
    }

    public function confirmDeleteTask($taskId)
    {
        $this->confirmingDeleteTask = $taskId;
    }
    public function cancelDeleteTask()
    {
        $this->confirmingDeleteTask = null;
    }
}
