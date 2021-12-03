<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; //use tambahan
use Validator; // import library validasi
use App\Models\Pengantar; //import model Course

class PengantarController extends Controller
{
    //method untnuk menampilkan semua data (read)
    public function index(){
        $pengantar = Pengantar::all(); // mengambil semua data 

        if(count($pengantar)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pengantar
            ], 200);
        } //return data semua course dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //return message data  kosong
    }

    //method untuk menampilkan 1 data  (search)
    public function show($id){
        $pengantar = Pengantar::find($id); // mencari data  berdasarkan id

        if(!is_null($pengantar)){
            return response([
                'message' => 'Retrieve Pengantar Data Success',
                'data' => $pengantar
            ], 200);
        } //return data  yang ditemukan dalam bentuk json

        return response([
            'message' => 'Pengantar Data Not Found',
            'data' => null
        ], 400); //return message data tidak ditemukan
    }

    //method untuk menambah 1 data  baru (create)
    public function store(Request $request){
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'nama' => 'required',
            'noTelp' => 'required|numeric|regex:/^((08))/|digits_between:10,13',
        ]); //membuat rule validasi input delivery

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        $pengantar = Pengantar::create($storeData);
        return response([
            'message' => 'Add Pengantar Success',
            'data' => $pengantar
        ], 200); //return data baru dalam bentuk json
    }

    //method untuk menghapus 1 data  (delete)
    public function destroy($id){
        $pengantar = Pengantar::find($id); //mencari data  berdasarkan id

        if(is_null($pengantar)){
            return response([
                'message' => 'Pengantar Data Not Found',
                'data' => null
            ], 404); 
        }// return message saat data tidak ditemukan

        if($pengantar->delete()){
            return response([
                'message' => 'Delete Pengantar Data Success',
                'data' => $pengantar
            ], 200);
        }//return message saat berhasil hapus data 

        return response([
            'message' => 'Delete Pengantar Failed',
            'data' => null
        ], 400); //return message saat gagal hapus data 
    }

    //method untuk mengubah 1 data Delivery (update)
    public function update(Request $request, $id){
        $pengantar = Pengantar::find($id); // mencari data berdasarkan id
        if(is_null($pengantar)){
            return response([
                'message' => 'Pengantar Data Not Found',
                'data' => null
            ], 404);
        } //return message saat data tidak ditemukan

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama' => 'required',
            'noTelp' => 'required|numeric|regex:/^((08))/|digits_between:10,13',
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        //mengedit timpa data yang lama dengan data yang baru
        $pengantar->nama = $updateData['nama'];
        $pengantar->noTelp = $updateData['noTelp'];

        if($pengantar->save()){
            return response([
                'message' => 'Update Pengantar Data Success',
                'data' => $pengantar
            ], 200);
        }// return data yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update Pengantar Failed',
            'data' => null
        ], 400); //return message saat data gagal di edit
    }
}