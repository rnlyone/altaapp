<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Subkriteria;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class KriteriaController extends Controller
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

        $kriteriadata = Kriteria::all();

        if ($request->ajax()){
            return Datatables::of($kriteriadata)
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
            ->addColumn('kode', function($data){
                $kodekriteria = 'C'.$data->id;
                return $kodekriteria;
            })
        ->rawColumns(['action', 'kode'])
            ->addIndexColumn()
            ->make(true);
        }

        try {
            $latestkriteria_id = Kriteria::latest()->first()->id+1;
        } catch (\Throwable $th) {
            $latestkriteria_id = 0;
        }

        return view('auth.kriteria', ['kriteriadata' => $kriteriadata, 'latestkriteria_id' => $latestkriteria_id]);
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
        try {
            Kriteria::create([
                'id' => $req->id,
                'nama' => $req->nama,
                'bobot' => $req->bobot,
                'jenis' => $req->jenis
            ]);
            return back()->with('success', 'Kriteria Berhasil Dibuat.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Maaf, Terdapat Kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function show(Kriteria $kriteria)
    {
        //
    }


    private function pengeditan($req)
    {
        Kriteria::where('id', $req->idedit)->update([
            'id' => $req->id,
            'nama' => $req->nama,
            'bobot' => $req->bobot,
            'jenis' => $req->jenis
        ]);
    }
    public function editkriteria(Request $req)
    {
        try {
            // dd(Subkriteria::where('id_kriteria', $req->idedit)->get());
            if (($req->id != $req->idedit)){
                $validate = Kriteria::where('id', $req->id)->first();
                if ($validate == null){
                    $subs = Subkriteria::where('id_kriteria', $req->idedit)->get();

                    Kriteria::create([
                        'id' => '99',
                        'nama' => 'temp',
                        'bobot' => '1',
                        'jenis' => 'cost'
                    ]);

                    foreach ($subs as $sub) {
                        $sub->update([
                            'id_kriteria' => '99'
                        ]);
                    }

                    KriteriaController::pengeditan($req);

                    foreach ($subs as $sub) {
                        $sub->update([
                            'id_kriteria' => $req->id
                        ]);
                    }

                    Kriteria::where('id', '99')->delete();

                }else {
                    KriteriaController::pengeditan($req);
                }
            }
            else {
                KriteriaController::pengeditan($req);
            }

            return back()->with('success', 'Kriteria Berhasil Diedit.');

        }catch (Exception $e) {
            return back()->with('error', 'Maaf, ID Telah Tersedia');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penilaian::where('id_kriteria', $id)->delete();
        Subkriteria::where('id_kriteria', $id)->delete();
        Kriteria::where('id', $id)->delete();
        return back()->with('success', 'Kriteria Berhasil Dihapus.');
    }
}
