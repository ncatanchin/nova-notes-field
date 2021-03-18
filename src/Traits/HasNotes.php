<?php

namespace Spatialmedia\NovaNotesField\Traits;

use Spatialmedia\NovaNotesField\FieldServiceProvider;

trait HasNotes
{
    /**
     * Creates a new note and attaches it to the model.
     *
     * @param string $note The note text which can contain raw HTML.
     * @param bool $user Enables or disables the use of `Auth::user()` to set as the creator.
     * @param bool $system Defines whether the note is system created and can be deleted or not.
     * @return \Spatialmedia\NovaNotesField\Models\Note
     **/
    public function addNote($note, $user = true, $system = true)
    {
        $user = $user ? auth()->user() : null;

        /*
        return $this->notes()->create([
            'text' => $note,
            'created_by' => isset($user) ? $user->id : null,
            'system' => $system,
        ]);
        */

        return $this->notes()->create([
            'comment' => $note,
            'user_id' => isset($user) ? $user->id : null,
            // 'system' => $system,
        ]);

    }

    /**
     * Deletes a note with given ID and dissociates it from the model.
     *
     * @param int|string $noteId The ID of the note to delete.
     * @return void
     **/
    public function deleteNote($noteId)
    {
        $this->comments()->where('id', '=', $noteId)->delete();
    }

    public function notes()
    {
        return $this->morphMany(FieldServiceProvider::getNotesModel(), 'commentable');
    }
}
