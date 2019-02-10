<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use App\Services\FileSaveService;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestQuery = request()->query();
        $condition = array_key_exists('type', $requestQuery) && $requestQuery['type'] === 'favourite';
        $allNotes = $condition ? Note::where('is_favourite', true)->latest()->get() : Note::latest()->get();

        return response()->json($allNotes);
    }

    public function email_index()
    {
        $allMails =  Note::all('email');

        return response()->json($allMails);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedNoteData = $request->validate([
            'title' => 'required',
            //'is_favourite' => 'required',
            'email' => 'required|unique:notes,email',
        ]);

        $note = Note::create($validatedNoteData);
        $lastId = $note->id;

        return response()->json($note);
        //return response()->json($lastId);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {



        $note = Note::find($id);

        $imagePath = with(new FileSaveService)->handleUpload($request->file('photo'));

        //$note = Note::find($id)->update(['position' => $request->get('position'), 'photo' => $imagePath]);
        //$note = Note::find($id)->update(['position' => $request->get('position')]);
        //$note = Note::find($id)->update(['photo' => $imagePath]);

        $note->position = $request->position;
        $note->about = $request->about;
        $note->company = $request->company;
        $note->photo = $imagePath;

        $note->save();


        return response()->json($note);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $note = Note::find($id)->update(['title' => $request->get('title')]);

        return response()->json($note);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);

        return response()->json($note->delete());

    }




    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleFavourite($id)
    {
        $note = Note::find($id);
        $note = $note->update(['is_favourite' => !$note->is_favourite]);

        return response()->json($note);
    }
}
