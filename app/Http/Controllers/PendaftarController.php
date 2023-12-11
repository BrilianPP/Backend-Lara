<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendaftarController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table perusahaans
        $pendaftars = Pendaftar::latest()->get();
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Pendaftar',
            'data' => $pendaftars
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

        $pendaftar = Pendaftar::findOrfail($id);
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Pendaftar',
            'data' => $pendaftar
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
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'berkas' => 'required|file',
            'foto' => 'required|file',
            'user' => 'required',
            'perusahaan' => 'required',
            'status' => 'required',
        ]);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $foto = $request->file('foto');
        $foto->storeAs('public/pendaftar', $foto->hashName());
        $berkas = $request->file('berkas');
        $berkas->storeAs('public/pendaftar', $berkas->hashName());

        //save to database
        $pendaftar = Pendaftar::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'berkas' => $berkas->hashName(),
            'foto' => $foto->hashName(),
            'user' => $request->user,
            'perusahaan' => $request->perusahaan,
            'status' => $request->status
        ]);
        //success save to database
        if ($pendaftar) {
            return response()->json([
                'success' => true,
                'message' => 'Pendaftar Created',
                'data' => $pendaftar
            ], 201);
        }
        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Pendaftar Failed to Save',

        ], 409);
    }
    /**
     * update
     *
     * @param mixed $request
     * @param mixed $pendaftar
     * @return void
     */
    public function update(Request $request, Pendaftar $pendaftar)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'status' => 'required',
        ]);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        //find perusa$perusahaan by ID
        $pendaftar = Pendaftar::findOrFail($pendaftar->id);
        if ($pendaftar) {
            //update perus$perusahaan
            $pendaftar->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'status' => $request->status
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Pendaftar Updated',
                'data' => $pendaftar
            ], 200);
        }
        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Pendaftar Not Found',
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
        $pendaftar = Pendaftar::findOrfail($id);
        if ($pendaftar) {
            //delete perusahan
            $pendaftar->delete();
            return response()->json([
                'success' => true,
                'message' => 'Pendaftar Deleted',
            ], 200);
        }
        //data perusahaan not found
        return response()->json([
            'success' => false,
            'message' => 'Pendaftar Not Found',
        ], 404);
    }
}
