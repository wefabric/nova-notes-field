<?php

Route::get('/notes', 'NotesController@getNotes');
Route::get('/notes-types', 'NotesController@getTypes');
Route::post('/notes', 'NotesController@addNote');
Route::delete('/notes', 'NotesController@deleteNote');
