<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }
    public function index()
    {
        $report = DB::table('order_details')
            ->join('products','products.id', '=', 'order_details.id_produk')
            ->select(DB::raw('
                count(*) as jumlah_debeli, 
                nama_barang, 
                harga, 
                SUM(jumlah) as total_qty'))
            ->groupBy('id_produk', 'nama_barang', 'harga')
            ->get();

        return response()->json([
            'data' => $report
        ]);

    }
}
