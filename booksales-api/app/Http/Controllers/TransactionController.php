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

        $uniqueCode = "ORD-" . strtoupper(uniqid());

        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized!',
            ], 401);
        }

        $book = Book::find($request->book_id);

        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok barang tidak cukup'
            ], 400);
        }

        $totalAmount = $book->price * $request->quantity;

        DB::beginTransaction();
        try {
            $book->stock -= $request->quantity;
            $book->save();

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

        $oldBook = Book::find($transaction->book_id);

        if (!$oldBook) {
            return response()->json([
                'success' => false,
                'message' => 'Original book resource not found'
            ], 404);
        }

        $oldQuantity = (int) round($transaction->total_amount / $oldBook->price);

        $newBook = Book::find($request->book_id);
        $newQuantity = $request->quantity;

        if (!$newBook) {
            return response()->json([
                'success' => false,
                'message' => 'New book resource not found for update'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $oldBook->stock += $oldQuantity;
            $oldBook->save();

            $currentStock = $newBook->stock;

            if ($currentStock < $newQuantity) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Stok buku baru ({$newBook->title}) tidak cukup. Tersisa: {$currentStock}"
                ], 400);
            }

            $newBook->stock -= $newQuantity;
            $newBook->save();

            $newTotalAmount = $newBook->price * $newQuantity;

            $transaction->update([
                'book_id' => $request->book_id,
                'total_amount' => $newTotalAmount,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction updated successfully!',
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

        $book = Book::find($transaction->book_id);

        DB::beginTransaction();
        try {
            $quantity = $transaction->total_amount / $book->price;

            $book->stock += $quantity;
            $book->save();

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
