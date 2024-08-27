<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StockController extends Controller
{
    public function create(Request $req){
        $insert = DB::connection('mysql')
        ->table('stocks')
        ->insert([
            'name' => $req->name,
            'amount' => $req->amount,
            'serial_number' => $req->serial_number,
            'add_info' => $req->add_info,
            'image' => $req->image,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'created_by' => $req->user,
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_by' => $req->user,
        ]);
        
        return response()->json(['info' => 'success']);
    }
    
    public function list(){
        $data['data'] = DB::connection('mysql')
        ->table('stocks')
        ->select('id', 'name')
        ->get()
        ;
        return response()->json($data);
    }
    
    public function detail($id){
        $data['data'] = DB::connection('mysql')
        ->table('stocks')
        ->select('*')
        ->where('id', $id)
        ->get()
        ;
        return response()->json($data);
    }
    
    public function update(Request $req){
        $insert = DB::connection('mysql')
        ->table('stocks')
        ->where('id', $req->id)
        ->update([
            'name' => $req->name,
            'amount' => $req->amount,
            'serial_number' => $req->serial_number,
            'add_info' => $req->add_info,
            'image' => $req->image,
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_by' => $req->user,
        ]);
        
        return response()->json(['info' => 'success']);
    }
    
    public function delete($id){
        $data['data'] = DB::connection('mysql')
        ->table('stocks')
        ->where('id', $id)
        ->delete()
        ;
        return response()->json(['info' => 'success']);
    }
}
