<?php

namespace OptimistDigital\NovaNotesField\Traits;

use Illuminate\Support\Facades\Auth;
use OptimistDigital\NovaNotesField\Events\NoteAdded;
use OptimistDigital\NovaNotesField\Exceptions\UndefinedTypeException;
use OptimistDigital\NovaNotesField\NotesFieldServiceProvider;
use OptimistDigital\NovaNotesField\Types;

trait HasNotes
{
    /**
     * @param string $note The note text which can contain raw HTML.
     * @param bool $user Enables or disables the use of `Auth::user()` to set as the creator.
     * @param bool $system Defines whether the note is system created and can be deleted or not.
     * @param string|null $type optional not type.
     * @return \Illuminate\Database\Eloquent\Model
     * @throws UndefinedTypeException
     */
    public function addNote($note, $user = true, $system = true, ?string $type = null)
    {
        $user = $user ? Auth::user() : null;

        if(!$type) {
            $type = Types::default();
        }

        if(!Types::get()->get($type)) {
            throw new UndefinedTypeException(__(':type is undefined', ['type' => $type]));
        }

        $createdNote = $this->notes()->create([
            'text' => $note,
            'created_by' => isset($user) ? $user->id : null,
            'system' => $system,
            'type' => $type,
        ]);

        event(new NoteAdded($createdNote, $this));

        return $createdNote;
    }

    /**
     * Deletes a note with given ID and dissociates it from the model.
     *
     * @param int|string $noteId The ID of the note to delete.
     * @return void
     **/
    public function deleteNote($noteId)
    {
        $this->notes()->where('id', '=', $noteId)->delete();
    }

    public function notes()
    {
        return $this->morphMany(NotesFieldServiceProvider::getNotesModel(), 'notable');
    }
}
