<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        $transactions = Transaction::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions
        ]);
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        // Check if the transaction belongs to the authenticated user
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $transaction->load(['user', 'items']);

        return Inertia::render('Transactions/Show', [
            'transaction' => $transaction
        ]);
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Transaction request received', $request->all());

        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.subtotal' => 'required|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
            ]);

            DB::beginTransaction();
            try {
                // Create transaction
                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'total_amount' => $request->total_amount,
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'notes' => 'Transaksi dari POS'
                ]);
                \Log::info('Transaction created', ['id' => $transaction->id]);

                // Create transaction items
                foreach ($request->items as $item) {
                    // Get product name
                    $product = Product::find($item['product_id']);
                    
                    if (!$product) {
                        throw new \Exception("Produk dengan ID {$item['product_id']} tidak ditemukan");
                    }
                    
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok produk {$product->name} tidak mencukupi");
                    }
                    
                    $transaction->items()->create([
                        'product_id' => $item['product_id'],
                        'product_name' => $product->name,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ]);
                    \Log::info('Transaction item created', ['product' => $product->name, 'quantity' => $item['quantity']]);

                    // Update product stock
                    $product->stock -= $item['quantity'];
                    $product->save();
                }

                DB::commit();
                \Log::info('Transaction completed successfully', ['id' => $transaction->id]);
                
                // Redirect to success page with transaction data
                return redirect()->route('transactions.success', ['transaction' => $transaction->id])->with('success', 'Transaksi berhasil');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Transaction failed in DB operation', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                return redirect()->back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('Transaction failed in validation', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Data transaksi tidak valid: ' . $e->getMessage());
        }
    }
    
    /**
     * Show transaction success page
     */
    public function success(Transaction $transaction = null)
    {
        // If no transaction is provided, get the latest transaction for the user
        if (!$transaction) {
            $transaction = Transaction::where('user_id', auth()->id())
                ->latest()
                ->first();
                
            if (!$transaction) {
                return redirect()->route('dashboard');
            }
        }
        
        // Check if the transaction belongs to the authenticated user
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return Inertia::render('Transactions/Success', [
            'transaction' => $transaction
        ]);
    }
} 