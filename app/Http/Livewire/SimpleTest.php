<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SimpleTest extends Component
{
    public $answers = [];
    public $model;

    public function mount()
    {
        $this->answers = $this->model->data['answers'] ?? [
                [],
                [],
                []
            ];
    }

    public function render()
    {
        return view('livewire.simple-test');
    }

    public function addAnswer()
    {
        $this->answers[] = ['answer' => '', 'x' => ''];
    }

    public function removeAnswer($index)
    {
        unset($this->answers[$index]);
        $this->answers = array_values($this->answers);
    }

}
