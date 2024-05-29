<?php

namespace App\Http\Controllers;

use App\Models\BagiBonus;
use App\Models\BagiBonusItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BagiBonusController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $bagiBonus = BagiBonus::with('BagiBonusItem')->get();
        $response = [
            'status' => 'ok',
            'data' => $bagiBonus
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pembayaran' => 'required',
            'item' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }

            $jumlahPekerja = count($request->get('item'));
            DB::beginTransaction();
            $bagiBonus = new BagiBonus();
            $bagiBonus->jumlah_pembayaran = $request->get('pembayaran');
            $bagiBonus->jumlah_pekerja = $jumlahPekerja;
            $bagiBonus->save();
            foreach ($request->get('item') as $item) {
                $bagiBonusItem = new BagiBonusItem();
                $bagiBonusItem->bagi_bonus_id = $bagiBonus->id;
                $bagiBonusItem->nama = $item['nama'];
                $bagiBonusItem->total_pembayaran = $item['pembayaran'];
                $bagiBonusItem->total_persentase = $item['persentase'];
                $bagiBonusItem->save();
            }
            DB::commit();

            $response = [
                'status' => 'success',
                'message' => 'Berhasil menambahkan data baru'
            ];

            return response()->json($response, 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 400);
        }
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $bagiBonus = BagiBonus::with('BagiBonusItem')->find($id);
            if (!$bagiBonus) {
                throw new \Exception('BagiBonus tidak ditemukan');
            }

            $response = [
                'status' => 'ok',
                'data' => $bagiBonus
            ];

            return response()->json($response, 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
           'pembayaran' => 'required',
           'item' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }

            $bagiBonus = BagiBonus::find($id);

            if(!$bagiBonus) {
                throw new \Exception("Data tidak ditemukan", 404);
            }

            $jumlahPekerja = count($request->get('item'));
            DB::beginTransaction();
            $bagiBonus->jumlah_pembayaran = $request->get('pembayaran');
            $bagiBonus->jumlah_pekerja = $jumlahPekerja;
            $bagiBonus->save();
            foreach ($request->get('item') as $item) {
                $bagiBonusItem = BagiBonusItem::find($item['id']);
                $bagiBonusItem->nama = $item['nama'];
                $bagiBonusItem->total_pembayaran = $item['pembayaran'];
                $bagiBonusItem->total_persentase = $item['persentase'];
                $bagiBonusItem->save();
            }
            DB::commit();

            $response = [
                'msg' => 'Data berhasil diupdate'
            ];

            return response()->json($response, 200);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 400);
        }
    }

    public function delete($id): \Illuminate\Http\JsonResponse {
        try {
            DB::beginTransaction();
            BagiBonus::where('id', $id)->delete();
            DB::commit();

            $response = [
                'msg' => 'data berhasil dihapus'
            ];

            return response()->json($response, 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 400);
        }
    }
}
