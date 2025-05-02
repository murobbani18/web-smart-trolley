<?php
namespace App\Controllers;

use App\Models\TrolleyItemModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class TrolleyController extends BaseController
{
    public function addToCart()
    {
        $userId = session()->get('user_id'); // pastikan session login
        $itemId = $this->request->getPost('item_id');
        $quantity = $this->request->getPost('quantity') ?? 1;

        // Validasi: apakah item ada?
        $itemModel = new ProductModel();
        $item = $itemModel->find($itemId);

        if (!$item) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Item tidak ditemukan']);
        }

        $model = new TrolleyItemModel();
        $existing = $model
            ->where('user_id', $userId)
            ->where('item_id', $itemId)
            ->first();

        if ($existing) {
            $model->update($existing['id'], [
                'quantity' => $existing['quantity'] + $quantity
            ]);
        } else {
            $model->save([
                'user_id' => $userId,
                'item_id' => $itemId,
                'quantity' => $quantity
            ]);
        }
        return redirect()->to('/cart')->with('success', 'Produk berhasil ditambahkan!');

        // return $this->response->setJSON(['message' => 'Berhasil ditambahkan ke keranjang']);
    }

    public function viewCart()
    {
        $userId = session()->get('user_id');
        
        $trolleyModel = new TrolleyItemModel();
        // Join untuk ambil detail produk
        $cartItems = $trolleyModel
            ->select('trolley_items.user_id, trolley_items.item_id, SUM(trolley_items.quantity) as quantity, items.name, items.stock, items.price, items.image')
            ->join('items', 'items.id = trolley_items.item_id')
            ->where('trolley_items.user_id', $userId)
            ->groupBy('trolley_items.item_id') // Mengelompokkan berdasarkan item_id
            ->findAll();
    
        return view('trolley/cart', ['cartItems' => $cartItems]);
    }

    public function updateQuantity()
    {
        $itemId = $this->request->getPost('item_id');
        $quantity = $this->request->getPost('quantity');
    
        // Validasi input untuk jumlah
        if ($quantity < 1 || $quantity > 100) {
            return redirect()->back()->with('error', 'Jumlah tidak valid.');
        }
        $cartModel = new TrolleyItemModel();
    
        // Update quantity di keranjang
        $cartModel->updateItemQuantity($itemId, $quantity);
    
        return redirect()->to('/cart')->with('success', 'Jumlah item berhasil diperbarui.');
    }
    
    public function removeFromCart()
    {
        $userId = session()->get('user_id');
        $itemId = $this->request->getPost('item_id');
    
        $trolleyModel = new TrolleyItemModel();
    
        $deleted = $trolleyModel
            ->where('user_id', $userId)
            ->where('item_id', $itemId)
            ->delete();
    
        if ($deleted) {
            return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
        }
    
        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
    }

    public function checkout()
    {
        $userId = session()->get('user_id');
        $trolleyModel = new \App\Models\TrolleyItemModel();
        $paymentModel = new \App\Models\PaymentModel();
        $paymentItemModel = new \App\Models\PaymentItemModel();
        $itemModel = new \App\Models\ProductModel();
    
        $trolleyItems = $trolleyModel
            ->select('trolley_items.*, items.stock, items.price')
            ->join('items', 'trolley_items.item_id = items.id')
            ->where('trolley_items.user_id', $userId)
            ->findAll();
    
        if (empty($trolleyItems)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }
    
        $total = 0;
        foreach ($trolleyItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    
        // Simpan ke tabel payments
        $paymentId = $paymentModel->insert([
            'user_id'      => $userId,
            'total_amount' => $total
        ]);
    
        // Simpan detail item ke tabel payment_items
        foreach ($trolleyItems as $item) {
            $paymentItemModel->insert([
                'payment_id'       => $paymentId,
                'item_id'          => $item['item_id'],
                'quantity'         => $item['quantity'],
                'price_at_purchase'=> $item['price']
            ]);
    
            // Update stok di tabel items
            $itemModel->where('id', $item['item_id'])->decrement('stock', (int) $item['quantity']);
        }
    
        // Kosongkan keranjang
        $trolleyModel->where('user_id', $userId)->delete();
    
        return redirect()->to('/payments/detail/' . $paymentId)->with('success', 'Pembayaran berhasil!');
    }
}
