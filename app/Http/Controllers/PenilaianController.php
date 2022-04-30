<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Subkriteria;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd($nilaidata);
        if (auth()->user()->role == 'admin'){
            return abort(403, 'Maaf, Halaman Ini Bukan Untuk Anda');
        }

        $alterdata = Alternatif::all();
        $kritdata = Kriteria::all();
        $subsdata = Subkriteria::all();

        if ($request->ajax()){
            return DataTables::of($alterdata)
            ->addColumn('action', function($data){
                $button = '
                <button data-toggle="modal" data-bs-toggle="modal" data-original-title="Edit" type="button" data-bs-target="#modaledit'.$data->id.'" type="button" class="edit-post btn btn-icon btn-success">
                    <i data-feather="edit-3"></i>
                </button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }


        return view('auth.penilaian', ['alterdata' => $alterdata, 'kritdata' => $kritdata, 'subsdata' => $subsdata]);
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
    public function store(Request $req)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function show(Penilaian $penilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function editpenilaian(Request $req)
    {
        $user = auth()->user();

        $kritlast = Kriteria::latest()->first()->id;

        // $penilaianlast = Penilaian::latest()->first()->id;
        $err_count = 0;
        for ($id=1; $id <= $kritlast ; $id++) {
            try {
                $validation = Kriteria::where('id', $id)->first()->id;
            } catch (\Throwable $th) {
                $validation = null;
                continue;
            }
            $sub = Subkriteria::where('id', $req->$id)->first();
            try {
                try {
                    $nilaiid = Penilaian::where('id_user', $user->id)
                                    ->where('id_alternatif', $req->alternatifid)
                                    ->where('id_kriteria', $validation)->first();

                    if ($req->$id == "") {
                        try {
                            $nilaiid = Penilaian::where('id_user', $user->id)
                                    ->where('id_alternatif', $req->alternatifid)
                                    ->where('id_kriteria', $validation)->delete();
                        } catch (\Throwable $th) {
                            $err_count = $err_count + 1;
                        }
                    }
                    Penilaian::where('id', $nilaiid->id)->update(
                        [
                            'id_user' => $user->id,
                            'id_alternatif' => $req->alternatifid,
                            'id_kriteria' => $sub->id_kriteria,
                            'id_subkriteria' => $sub->id,
                            'nilai' => $sub->nilai
                        ]);

                } catch (\Throwable $th) {
                    // $nilaiid = null;
                    Penilaian::create(
                        [
                            'id_user' => $user->id,
                            'id_alternatif' => $req->alternatifid,
                            'id_kriteria' => $sub->id_kriteria,
                            'id_subkriteria' => $sub->id,
                            'nilai' => $sub->nilai
                        ]);
                }
            } catch (\Throwable $th) {
                $err_count = $err_count + 1;
            }
        }

        if ($err_count == 0) {
            return back()->with('success', 'Nilai Sudah Disimpan* ('.$err_count.')');
        } else {
            return back()->with('error', 'Nilai Sudah Disimpan, Tapi Belum Lengkap. ('.$err_count.')');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penilaian $penilaian)
    {
        //
    }
}
