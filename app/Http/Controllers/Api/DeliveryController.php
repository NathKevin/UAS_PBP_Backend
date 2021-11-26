<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; //use tambahan
use Validator; // import library validasi
use App\Models\Delivery; //import model Course

class DeliveryController extends Controller
{
    //method untnuk menampilkan semua data delivery (read)
    public function index(){
        $delivery = Delivery::all(); // mengambil semua data 

        if(count($delivery)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $delivery
            ], 200);
        } //return data semua course dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //return message data  kosong
    }

    //method untuk menampilkan 1 data delivery (search)
    public function show($id){
        $delivery = Delivery::find($id); // mencari data  berdasarkan id

        if(!is_null($delivery)){
            return response([
                'message' => 'Retrieve Delivery Data Success',
                'data' => $delivery
            ], 200);
        } //return data  yang ditemukan dalam bentuk json

        return response([
            'message' => 'Delivery Data Not Found',
            'data' => null
        ], 400); //return message data tidak ditemukan
    }

    //method untuk menambah 1 data Delivery baru (create)
    public function store(Request $request){
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'recipientName' => 'required|max:60',
            'type' => 'required',
            'fragile' => 'required',
            'pickupAddress' => 'required',
            'destinationAddress' => 'required'
        ]); //membuat rule validasi input delivery

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        $delivery = Delivery::create($storeData);
        return response([
            'message' => 'Add Delivery Success',
            'data' => $delivery
        ], 200); //return data baru dalam bentuk json
    }

    //method untuk menghapus 1 data delivery (delete)
    public function destroy($id){
        $delivery = Delivery::find($id); //mencari data  berdasarkan id

        if(is_null($delivery)){
            return response([
                'message' => 'Delivery Data Not Found',
                'data' => null
            ], 404); 
        }// return message saat data tidak ditemukan

        if($delivery->delete()){
            return response([
                'message' => 'Delete Delivery Data Success',
                'data' => $delivery
            ], 200);
        }//return message saat berhasil hapus data 

        return response([
            'message' => 'Delete Course Failed',
            'data' => null
        ], 400); //return message saat gagal hapus data 
    }

    //method untuk mengubah 1 data Delivery (update)
    public function update(Request $request, $id){
        $delivery = Delivery::find($id); // mencari data berdasarkan id
        if(is_null($delivery)){
            return response([
                'message' => 'Delivery Data Not Found',
                'data' => null
            ], 404);
        } //return message saat data tidak ditemukan

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'recipientName' => 'required|max:60',
            'type' => 'required',
            'fragile' => 'required',
            'pickupAddress' => 'required',
            'destinationAddress' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        //mengedit timpa data yang lama dengan data yang baru
        $delivery->recipientName = $updateData['recipientName'];
        $delivery->type = $updateData['type'];
        $delivery->fragile = $updateData['fragile'];
        $delivery->pickupAddress = $updateData['pickupAddress'];
        $delivery->destinationAddress = $updateData['destinationAddress'];

        if($delivery->save()){
            return response([
                'message' => 'Update Delivery Data Success',
                'data' => $course
            ], 200);
        }// return data yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update Course Failed',
            'data' => null
        ], 400); //return message saat data gagal di edit
    }
}