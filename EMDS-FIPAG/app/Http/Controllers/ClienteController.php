<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Document;
use App\Cliente;
use Illuminate\Support\Facades\Storage;
use DB;
use Mail;

class ClienteController extends Controller
{
     // Create Cliente Form
     public function index(Request $request) {
        $categories = Category::pluck('name','id')->all();
        return view('pages.cliente',compact('categories'));
      }


       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

      public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8',
            'description' => 'required|string|max:255',
            
          ]);
  
          // get the data of uploaded user
         // $user_id = auth()->user()->id;
         // $department_id = auth()->user()->department_id;
         $cliente = new Cliente;
         $cliente->name = $request->input('name');
         $cliente->email = $request->input('email');
         $cliente->telefone = $request->input('phone');
         $cliente->save();
         
          
  
          $doc = new Document;
          $doc->description = $request->input('description');
          $doc->cliente_name = $request->input('name');
          $doc->cliente_id = $cliente->id;
        //  $doc->user_id = $user_id;
        //  $doc->department_id = $department_id;
        // handle file upload
        if ($request->hasFile('file')) {
            // filename with extension
            $fileNameWithExt = $request->file('file')->getClientOriginalName();
            // filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // extension
            $extension = $request->file('file')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // upload file
            $path = $request->file('file')->storeAs('public/files/', $fileNameToStore);

            $doc->file = $path;
          $doc->mimetype = Storage::mimeType($path);
          $size = Storage::size($path);
          if ($size >= 1000000) {
            $doc->filesize = round($size/1000000) . 'MB';
          }elseif ($size >= 1000) {
            $doc->filesize = round($size/1000) . 'KB';
          }else {
            $doc->filesize = $size;
          }
        }
          
          // determine whether it expires
          /*
          if ($request->input('isExpire') == true) {
              $doc->isExpire = false;
          }else {
              $doc->isExpire = true;
              $doc->expires_at = $request->input('expires_at');
          }*/
          // save to db
           // add Category
          $doc->category_id = $request->input('category');
          $doc->save();
         
          $cat = Category::where('id','=',$request->input('category'))->first();
         //  Send mail to admin
        \Mail::send('inc.mail', array(
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'phone' => $request->get('phone'),
          'subject' => $cat->name,
          'user_query' => $request->get('description')
      ), function($message) use ($request){
          $message->from($request->get('email'));
          $message->to('vergil99966@gmail.com', 'FIPAG')->subject($request->input('category'));
      });
          //$doc->categories()->sync($request->category_id);
  
          \Log::addToLog('Nova Carta, O cliente '.$request->get('name').' enviou uma nova carta',
        $cliente->name,$cliente->id);
  
          return redirect('/cliente')->with('success','A sua carta foi enviada');
      }
}
