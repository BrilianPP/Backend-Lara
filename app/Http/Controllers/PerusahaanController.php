<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table perusahaans
        $perusahaans = Perusahaan::latest()->get();
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Perusahaan',
            'data' => $perusahaans
        ], 200);
    }
    /**
     * show
     *
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $perusahaan = Perusahaan::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Perusahaan',
            'data' => $perusahaan
        ], 200);
    }
    /**
     * store
     *
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'required',
            'email'     => 'required|email|unique:perusahaans',
            'password'  => 'required|min:8|confirmed',
            'alamat' => 'required',
            'foto' => 'required|file',
            'kontak' => 'required',
            'posisi' => 'required',
            'persyaratan' => 'required',
            'status' => 'required',
        ]);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $foto = $request->file('foto');
        $foto->storeAs('public/perusahaan', $foto->hashName());

        //save to database
        $perusahaan = Perusahaan::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'email' => $request->email,
            'password'  => Hash::make($request->password),
            'alamat' => $request->alamat,
            'foto' => $foto->hashName(),
            'kontak' => $request->kontak,
            'posisi' => $request->posisi,
            'persyaratan' => $request->persyaratan,
            'status' => $request->status
        ]);
        //success save to database
        if ($perusahaan) {
            return response()->json([
                'success' => true,
                'message' => 'Perusahaan Created',
                'data' => $perusahaan
            ], 201);
        }
        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Perusahaan Failed to Save',

        ], 409);
    }
    /**
     * update
     *
     * @param mixed $request
     * @param mixed $perusahaan
     * @return void
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'required',
            'email'     => 'required|email',
            'alamat' => 'required',
            'kontak' => 'required',
            'posisi' => 'required',
            'persyaratan' => 'required',
            'status' => 'required',
        ]);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        //find perusa$perusahaan by ID
        $perusahaan = Perusahaan::findOrFail($perusahaan->id);
        if ($perusahaan) {
            //update perus$perusahaan
            $perusahaan->update([
                'nama_perusahaan' => $request->nama_perusahaan,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'kontak' => $request->kontak,
                'posisi' => $request->posisi,
                'persyaratan' => $request->persyaratan,
                'status' => $request->status
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Perusahaan Updated',
                'data' => $perusahaan
            ], 200);
        }
        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Perusahaan Not Found',
        ], 404);
    }

    /**
     * destroy
     *
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find post by ID
        $perusahaan = Perusahaan::findOrfail($id);
        if ($perusahaan) {
            //delete perusahan
            $perusahaan->delete();
            return response()->json([
                'success' => true,
                'message' => 'Perusahaan Deleted',
            ], 200);
        }
        //data perusahaan not found
        return response()->json([
            'success' => false,
            'message' => 'Perusahaan Not Found',
        ], 404);
    }
}
