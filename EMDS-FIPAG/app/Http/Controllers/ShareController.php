<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shared;
use App\Document;
use App\Category;
use App\Department;

class ShareController extends Controller
{
    public function __construct() {
        return $this->middleware(['auth','permission:shared']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $user_dept = auth()->user()->department_id;
        $shared = Document::where('depart_id','=',$user_dept)->get();
        $dept = Department::all();
        $cat = Category::all();
        return view('pages.shared',compact('shared','cat','dept'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $doc = Document::findOrFail($id);

        $shared = new Shared;
        $shared->name = $doc->name;
        $shared->description = $doc->description;
        $shared->document_id = $doc->id;
        $shared->user_id = $doc->user_id;
        $shared->department_id = $doc->department_id;
        $shared->file = $doc->file;
        $shared->mimetype = $doc->mimetype;
        $shared->filesize = $doc->filesize;
        $shared->isExpire = $doc->isExpire;
        $shared->expires_at = $doc->expires_at;
        $shared->save();

        \Log::addToLog('Document ID '.$id.' was shared');

        return redirect('/documents')->with('success','File Shared!');
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
