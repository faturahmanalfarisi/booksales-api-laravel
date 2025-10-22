<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'book')->get();

        if ($transactions->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Resource data not found",
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Resource",
            "data" => $transactions
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. validator & cek validator
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 422);
        }

        // 2. generate orderNumber -> unique | ORD-0123456789
        $uniqueCode = "ORD-" . strtoupper(uniqid());

        // 3. ambil user yang sedang login & cek login (apakah ada data user?)
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized!',
            ], 401);
        }

        // 4. mencari data buku dari request
        $book = Book::find($request->book_id);

        // 5. cek stok buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok barang tidak cukup'
            ], 400);
        }

        // 6. hitung total harga = price * quantity
        $totalAmount = $book->price * $request->quantity;

        /// 7. kurangi stok buku (update)
        DB::beginTransaction();
        try {
            $book->stock -= $request->quantity;
            $book->save();

            // 8. simpan data transaksi
            $transaction = Transaction::create([
                'order_number' => $uniqueCode,
                'customer_id' => $user->id,
                'book_id' => $request->book_id,
                'total_amount' => $totalAmount
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction added successfully!',
                'data' => $transaction->load('user', 'book')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to process transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id) {
        $transaction = Transaction::with('user', 'book')->find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get single resource',
            'data' => $transaction
        ], 200);
    }

    public function update(string $id, Request $request) {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // Ambil data buku lama
        $oldBook = Book::find($transaction->book_id);
        $oldQuantity = $oldBook->transactions()->where('id', $id)->first() ? ($transaction->total_amount / $oldBook->price) : 0; // Kuantitas lama

        // Cari data buku baru
        $newBook = Book::find($request->book_id);
        $newQuantity = $request->quantity;

        // Hanya Admin yang bisa mengupdate
        // Kembalikan stok lama ke buku lama, lalu kurangi stok dari buku baru.
        DB::beginTransaction();
        try {
            // 1. Kembalikan stok lama ke buku lama (jika buku lama masih ada)
            if ($oldBook) {
                $oldBook->stock += $oldQuantity;
                $oldBook->save();
            }

            // 2. Cek stok buku baru
            if ($newBook->stock < $newQuantity) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku baru tidak cukup untuk penyesuaian'
                ], 400);
            }

            // 3. Kurangi stok dari buku baru
            $newBook->stock -= $newQuantity;
            $newBook->save();

            // 4. Hitung total harga baru dan update transaksi
            $newTotalAmount = $newBook->price * $newQuantity;

            $transaction->update([
                'customer_id' => $transaction->customer_id, // Customer tetap sama
                'book_id' => $request->book_id,
                'total_amount' => $newTotalAmount,
            ]);

            DB::commit();

            return response()->json([
                'succses' => true,
                'message' => 'Transaction updated succesfully!',
                'data'=> $transaction->load('user', 'book')
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id) {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        // Batalkan transaksi berarti kembalikan stok buku ke database.
        $book = Book::find($transaction->book_id);

        DB::beginTransaction();
        try {
            // Hitung kuantitas buku yang dibeli dalam transaksi ini
            $quantity = $transaction->total_amount / $book->price;

            // Kembalikan stok
            $book->stock += $quantity;
            $book->save();

            // Hapus transaksi
            $transaction->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Delete transaction successfully (Stock returned to inventory)'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to destroy transaction: ' . $e->getMessage()
            ], 500);
        }
    }
}
