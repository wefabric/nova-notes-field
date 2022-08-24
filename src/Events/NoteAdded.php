<?php

namespace OptimistDigital\NovaNotesField\Events;

use Illuminate\Database\Eloquent\Model;
use OptimistDigital\NovaNotesField\Models\Note;

class NoteAdded
{
    /**
     * @var Note
     */
    public Note $note;

    /**
     * @var Model
     */
    public Model $model;

    /**
     * @param Note $note
     * @param Model $model
     */
    public function __construct(Note $note, Model $model)
    {
        $this->note = $note;
        $this->model = $model;
    }
}
