<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Subkriteria;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class SubkriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role != 'admin'){
            return abort(403, 'Maaf, Halaman Ini Bukan Untuk Anda');
        }

        $subsdata = Subkriteria::all();
        $kriteriadata = Kriteria::all();
        return view('auth.subkriteria', ['kriteriadata' => $kriteriadata, 'subsdata' => $subsdata]);
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
    public function  store(Request $req)
    {
        $req->validate([
            'nama' => [
                'regex:/^[a-zA-Z]+$/u',
                'unique:App\Models\Subkriteria,nama'
            ]
        ]);

        try {
            Subkriteria::create([
                'id_kriteria' => $req->id_kriteria,
                'nama' => $req->nama,
                'nilai' => $req->nilai
            ]);
            return back()->with('success', 'Kriteria Berhasil Dibuat.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Maaf, Terdapat Kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subkriteria  $subkriteria
     * @return \Illuminate\Http\Response
     */
    public function show(Subkriteria $subkriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subkriteria  $subkriteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {
        // dd($req);
        try {
            Subkriteria::where('id', $req->idsub)->update([
                'nama' => $req->nama,
                'nilai' => $req->nilai,
            ]);
            return back()->with('success', 'Kriteria Berhasil Diedit.');
        } catch (\Throwable $e) {
            dd($e);
            return back()->with('error', 'Terdapat Kesalahan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subkriteria  $subkriteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subkriteria $subkriteria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subkriteria  $subkriteria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penilaian::where('id_subkriteria', $id)->delete();
        Subkriteria::where('id', $id)->delete();
        return back()->with('success', 'Kriteria Berhasil Dihapus.');
    }
}
