<?php

namespace Catanchin\NovaNotesField\Traits;

use Catanchin\NovaNotesField\NotesFieldServiceProvider;

trait HasNotes
{
    /**
     * Creates a new note and attaches it to the model.
     *
     * @param string $note The note text which can contain raw HTML.
     * @param bool $user Enables or disables the use of `Auth::user()` to set as the creator.
     * @return \Catanchin\NovaNotesField\Models\Note
     **/
    public function addNote(string $note, $user = true)
    {
        $user = $user ? auth()->user() : null;

        return $this->notes()->create([
            'comment' => $note,
            'user_id' => isset($user) ? $user->id : null,
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
        $this->comments()->where('id', $noteId)->delete();
    }

    public function notes()
    {
        return $this->morphMany(NotesFieldServiceProvider::getNotesModel(), 'commentable');
    }
}
