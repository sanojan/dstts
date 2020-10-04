<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Letter;

class LettersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $letters = Letter::all();
        return view('letters.index')->with('letters', $letters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('letters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Create letters
        $this->validate($request, [
            'letter_no' => 'bail|required|regex:/^[a-z .\'\/ - 0-9]+$/i',
            'letter_date' => 'before:tomorrow',
            'letter_sender' => 'required|regex:/^[a-z .\'\/ - 0-9]+$/i|max:150',
            'letter_title' => 'required|max:150',
            'letter_content' => 'nullable|max:250',
            'letter_scanned_copy' => 'max:1999|nullable|mimes:jpeg,jpg,pdf'

        ],
        ['letter_no.regex' => 'letter number cannot contain special characters',
        'letter_sender.regex' => 'letter sender name cannot contain special characters',
        'letter_scanned_copy.max' => 'Document file size should be less than 2 MB',
        'letter_scanned_copy.mimes' => 'Only PDF, JPEG & JPG formats are allowed']);

         //Handle File Upload
         if($request->hasFile('letter_scanned_copy')){
            // Get file name with extension
            //$filenameWithExt = $request->letter_scanned_copy->path();
            // Get filename only
            //$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get extension only
            $extension = $request->letter_scanned_copy->extension();
            //Filename to store
            $fileNameToStore = date('Y-m-d') . '.' . $extension;
            //UploadFile
            $path = $request->letter_scanned_copy->storeAs('public/scanned_letters', $fileNameToStore);
        }else{
            $fileNameToStore = NULL;
        }

        //Create an instance of letter model
        $letter = new Letter;
        $letter->letter_no = $request->letter_no;
        $letter->letter_date = $request->letter_date;
        $letter->letter_from = $request->letter_sender;
        $letter->letter_title = $request->letter_title;
        $letter->letter_content = $request->letter_content;
        $letter->letter_scanned_copy = $fileNameToStore;
        
        $letter->save();

        //session()->put('success','Letter has been created successfully.');

        $notification = array(
            'message' => 'Letter has been created successfully!', 
            'alert-type' => 'success'
        );

        return redirect('/letters')->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $letter = Letter::find($id);
        //Return letters show page
        return view('letters.show')->with('letter', $letter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
