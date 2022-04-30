<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Subkriteria;
use App\Models\User;
use Illuminate\Http\Request;

class WPController extends Controller
{

    function array_rank( $in ) {
    $x = $in; arsort($x);
     $rank       = 0;
    $hiddenrank = 0;
    $hold = null;
    foreach ( $x as $key=>$val ) {
        $hiddenrank += 1;
        if ( is_null($hold) || $val < $hold ) {
            $rank = $hiddenrank; $hold = $val;
        }
        $in[$key] = $rank;
    }
    return $in;
    }

    public function WPOWA()
    {
        $gdm = User::where('role', '!=', 'admin')->get();
        $alterdata = Alternatif::all();
        $kritdata = Kriteria::all();
        $subkritdata = Subkriteria::all();
        $nilaidata = Penilaian::all();

        $altercount = Alternatif::all()->count();
        $kritcount = Kriteria::all()->count();
        $gdmcount = User::where('role', '!=', 'admin')->count();

        $kritbobotsum = Kriteria::sum('bobot');
        global $wprank;

        //hitungwp

        //pembobotan dan pemangkatan
        foreach ($kritdata as $k) {
            if($k->jenis == 'benefit'){
                $bobot[$k->id] = ($k->bobot/$kritbobotsum)*1;
            } else {
                $bobot[$k->id] = ($k->bobot/$kritbobotsum)*-1;
            }
        }

        //persiapan variable
        $gdmnum = 1;
        foreach ($gdm as $u) {
            $gdmidsort[$u->id] = $gdmnum; //ini variable untuk mengurutkan id gdm (valuenya berupa urutan)
            $gdmid[$gdmnum-1] = $u->id; //ini variable untuk mengurutkan id gdm (indexnya berupa urutan, valuenya berupa id gdm)
            $gdmnum++;
        }
        foreach ($alterdata as $i => $a) {
            $alteridsort[$a->id] = $i+1;
        }
        // dd($gdmidsort);

        foreach ($gdm as $u) {
            try {
                $nilaiuser = $nilaidata->where('id_user', $u->id);
            } catch (\Throwable $th) {
                $nilaiuser = 0;
            }
            foreach ($alterdata as $a) {

                //part 4 wp (Perhitungan Nilai Vektor S)
                $vectorwp[$u->id][$a->id] = 0;
                foreach ($kritdata as $k) {
                    try {
                        $kritnilai = $nilaiuser->where('id_alternatif', $a->id)->where('id_kriteria', $k->id)->first()->nilai;
                    } catch (\Throwable $th) {
                        $kritnilai = 0;
                    }
                    if ($vectorwp[$u->id][$a->id] == 0) {
                        $vectorwp[$u->id][$a->id] = pow($kritnilai, $bobot[$k->id]);
                    } else {
                        $vectorwp[$u->id][$a->id] = $vectorwp[$u->id][$a->id]*(pow($kritnilai, $bobot[$k->id]));
                    }
                }
            }
            $sumvectors = array_sum($vectorwp[$u->id]);
                //part 5 wp (Perhitungan Preferensi Relatif[Vektor V])
            foreach ($alterdata as $a) {
                $prefwp[$u->id][$a->id] = 0;
                if ($prefwp[$u->id][$a->id] == 0) {
                    try {
                        $prefwp[$u->id][$a->id] = $vectorwp[$u->id][$a->id]/$sumvectors;
                    } catch (\Throwable $th) {
                        $prefwp[$u->id][$a->id] = 0;
                    }
                } else {
                    try {
                        $prefwp[$u->id][$a->id] = $prefwp[$u->id][$a->id]+($vectorwp[$u->id][$a->id]/$sumvectors);
                    } catch (\Throwable $th) {
                        $prefwp[$u->id][$a->id] = $prefwp[$u->id][$a->id]+0;
                    }
                }
            }
            //wp ranking $wprank[id]
            $wprank[$u->id] = WPController::array_rank($prefwp[$u->id]);

            // MULAI OWA

            //PIJ
            //owa pij array $owapij[id gid][i][j]
            foreach ($alterdata as $a) {
                foreach ($alterdata as $wp) {
                    $owapij[$u->id][$a->id][$wp->id] = 0.5*(1+($wprank[$u->id][$wp->id]/($altercount-1))-($wprank[$u->id][$a->id]/($altercount-1)));
                    // dd($wprank[$u->id][$a->id]/($altercount-1));
                }
            }


            //aggegasi preferensi owa untuk gdm
            $wowa[$u->id] = (sqrt($gdmidsort[$u->id]/$gdmcount))-(sqrt(($gdmidsort[$u->id]-1)/$gdmcount));

            //pengambilan nilai pij[1][3] untuk di ranking
            foreach ($alterdata as $a) {
                $pij13[$u->id] = $owapij[$u->id][1][3];
            }

        }
        rsort($pij13);


        //aggregasi preferensi bagian pembentukan p
        foreach ($gdmid as $index => $value) {
            //index 3 value 8
            $err = 0;
            for ($i=0; $i <= $altercount-1; $i++) {
                // dd($i, $index, $gdmid[$index]);
                try {
                    $powa[$value][$i+1] = $owapij[$gdmid[$index+$i]][$i+1];
                } catch (\Throwable $th) {
                    $powa[$value][$i+1] = $owapij[$gdmid[$err]][$i+1];
                    $err++;
                }
            }
        }

        //pengubahan setiap p13 menjadi p13 yang sudah diranking
        $powarank = $powa;
        foreach ($gdm as $i => $u) {
            $powarank[$u->id][1][3] = $pij13[$i];
        }

        //perkalian setiap w per gdm dengan setiap p
        foreach ($gdm as $i => $u) {
            foreach ($alterdata as $ia => $a) {
                foreach ($alterdata as $iwp => $wp) {
                    $pcgdm[$u->id][$a->id][$wp->id] = $wowa[$u->id] * $powarank[$u->id][$a->id][$wp->id];
                }
            }
        }
        // dd($pcgdm);

        //penjumlahan aggregasi preferensi
        foreach ($alterdata as $ia => $a) {
            foreach ($alterdata as $iwp => $wp) {
                $sumnilai = null;
                foreach ($gdm as $igdm => $u) {
                    try {
                        $sumnilai[$a->id][$wp->id] += $pcgdm[$u->id][$a->id][$wp->id];
                    } catch (\Throwable $th) {
                        $sumnilai[$a->id][$wp->id] = $pcgdm[$u->id][$a->id][$wp->id];
                    }
                }
                $nilaipc[$ia+1][$iwp+1] = $sumnilai[$a->id][$wp->id];
            }
        }
        // dd($nilaipc);


        //QGDD
        foreach ($alterdata as $ia => $a) {
            foreach ($alterdata as $iwp => $wp) {
                $pcqgdd[$ia+1][$iwp+1] = $nilaipc[$ia+1][$iwp+1] / ($nilaipc[$ia+1][$iwp+1] + $nilaipc[$iwp+1][$ia+1]);
            }
        }
        // dd($pcqgdd, $nilaipc);

        //WOWA untuk Alternatif
        foreach ($alterdata as $a) {
            $alterwowa[$a->id] = (sqrt($alteridsort[$a->id]/$altercount))-(sqrt(($alteridsort[$a->id]-1)/$altercount));
        }
        // dd($alterwowa);

        //final step QGDD
        foreach ($alterdata as $ia => $a) {
            $varbantu = null;
            foreach ($alterdata as $iwp => $wp) {
                try {
                    $varbantu += $alterwowa[$a->id] * $pcqgdd[$ia+1][$iwp+1];
                } catch (\Throwable $th) {
                    $varbantu = $alterwowa[$a->id] * $pcqgdd[$ia+1][$iwp+1];
                }
            }
            $QGDD[$a->id] = $varbantu;
        }
        // dd($QGDD);

        return view('auth.owa', [

            //wp
            'alterdata' => $alterdata,
            'kritdata' => $kritdata,
            'subkritdata' => $subkritdata,
            'nilaidata' => $nilaidata,
            'gdm' => $gdm,
            'kritcount' => $kritcount,
            'kritbobotsum' => $kritbobotsum,
            'wp' => $prefwp,
            'rankwp' => $wprank,
            'altercount' => $altercount,

            //owa
            'gdmwowa' => $wowa,
            'Agpref' => $nilaipc,
            'QGDD' => $QGDD,

        ]);
    }

    public function index()
    {
        return view('auth.wp', [
            'alterdata' => WPController::WPOWA()->alterdata,
            'kritdata' => WPController::WPOWA()->kritdata,
            'subkritdata' => WPController::WPOWA()->subkritdata,
            'nilaidata' => WPController::WPOWA()->nilaidata,
            'gdm' => WPController::WPOWA()->gdm,
            'kritcount' => WPController::WPOWA()->kritcount,
            'kritbobotsum' => WPController::WPOWA()->kritbobotsum,
            'wp' => WPController::WPOWA()->wp,
            'rankwp' => WPController::WPOWA()->rankwp,
        ]);
    }

    public function indexOWA()
    {
        dd(WPController::WPOWA()->QGDD);
        return view('auth.owa', [
            'gdm' => WPController::WPOWA()->gdm,
            'alterdata' => WPController::WPOWA()->alterdata,
            'altercount' => WPController::WPOWA()->altercount,
            'rankwp' => WPController::WPOWA()->rankwp,
            'gdmwowa' => WPController::WPOWA()->gdmwowa,
            'Agpref' => WPController::WPOWA()->Agpref,
            'QGDD' => WPController::WPOWA()->QGDD,
        ]);
    }
}
