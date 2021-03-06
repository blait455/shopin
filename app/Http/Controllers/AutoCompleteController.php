<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    public function index(){
        return view('autocomplete.index');
    }

    public function autoComplete(Request $request) {
        $query = $request->get('term','');
        
        $users=User::where('name','LIKE','%'.$query.'%')->get();
        
        $data=array();
        foreach ($users as $user) {
                $data[]=array('value'=>$user->name,'id'=>$user->id);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'No Result Found','id'=>''];
    }
}
