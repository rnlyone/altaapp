<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Penilaian;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->role != 'admin'){
            return abort(403, 'Maaf, Halaman Ini Bukan Untuk Anda');
        }

        $alterdata = Alternatif::all();

        if ($request->ajax()){
            return Datatables::of($alterdata)
            ->addColumn('action', function($data){
                $button = '
                <button data-toggle="modal" data-bs-toggle="modal" data-original-title="Edit" type="button" data-bs-target="#modaledit'.$data->id.'" type="button" class="edit-post btn btn-icon btn-success">
                    <i data-feather="edit-3"></i>
                </button>';
                // $button .= '&nbsp;&nbsp;';
                $button .= '
                <button data-toggle="modal" data-bs-toggle="modal" name="delete" data-original-title="delete" data-bs-target="#modaldel'.$data->id.'" type="button" class="delete btn btn-icon btn-outline-danger">
                    <i data-feather="trash-2"></i>
                </button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        try {
            $latestalter_id = Alternatif::latest()->first()->id;
        } catch (\Throwable $th) {
            $latestalter_id = 0;
        }


        return view('auth.alternatif', ['alterdata' => $alterdata, 'latestalter_id' => $latestalter_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $r)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            Alternatif::create([
                'id' => $req->id,
                'nama' => $req->nama,
            ]);
            return back()->with('success', 'Alternatif Berhasil Dibuat.');
        } catch (Exception $e) {
            return back()->with('error', 'Maaf, Terdapat Kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function show(Alternatif $alternatif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function editalternatif(Request $req)
    {
        try {
            Alternatif::where('id', $req->idedit)->update([
                'id' => $req->id,
                'nama' => $req->nama,
            ]);
            return back()->with('success', 'Kriteria Berhasil Diedit.');
        } catch (Exception $e) {
            return back()->with('error', 'Maaf, ID Telah Tersedia');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alternatif $alternatif)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alternatif $alternatif, $id)
    {
        Penilaian::where('id_alternatif', $id)->delete();
        Alternatif::where('id', $id)->delete();
        return back()->with('success', 'Alternatif Berhasil Dihapus.');
    }
}
