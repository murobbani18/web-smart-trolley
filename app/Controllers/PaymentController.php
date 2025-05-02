<?php
namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\PaymentItemModel;

class PaymentController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        
        // Inisialisasi model
        $paymentModel = new PaymentModel();

        // Ambil semua pembayaran berdasarkan user_id
        $payments = $paymentModel->where('user_id', $userId)
                                ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
                                ->findAll();

        // Kirim data ke view
        return view('payment/history', ['payments' => $payments]);
    }

    public function validationPage()
    {
        $paymentModel = new PaymentModel();
        $payments = $paymentModel->where('status', 'pending')->findAll();
    
        return view('payment/payment-validation', ['payments' => $payments]);
    }
    
    public function detail($paymentId)
    {
        // Inisialisasi model
        $paymentModel = new PaymentModel();
        $paymentItemModel = new PaymentItemModel();

        // Ambil data pembayaran berdasarkan ID
        $payment = $paymentModel->find($paymentId);

        if (!$payment) {
            return redirect()->to('/payments')->with('error', 'Pembayaran tidak ditemukan.');
        }

        // Ambil detail item pembayaran
        $paymentItems = $paymentItemModel
            ->select('payment_items.payment_id, payment_items.item_id, SUM(payment_items.quantity) as quantity, payment_items.price_at_purchase, items.name, items.price')
            ->join('items', 'payment_items.item_id = items.id')
            ->where('payment_items.payment_id', $paymentId)
            ->groupBy('payment_items.payment_id, payment_items.item_id')
            ->findAll();

        // Kirim data ke view
        return view('payment/detail', [
            'payment' => $payment,
            'paymentItems' => $paymentItems
        ]);
    }

    public function validatePayment($paymentId)
    {
        // Ambil data pembayaran dari database berdasarkan ID pembayaran
        $paymentModel = new PaymentModel();
        $payment = $paymentModel->find($paymentId);

        if (!$payment || $payment['status'] != 'pending') {
            return redirect()->to('/payments/validation')->with('error', 'Pembayaran tidak ditemukan atau sudah divalidasi.');
        }

        // Proses validasi pembayaran
        $isValid = $this->processValidation($payment);

        // Perbarui status pembayaran
        $newStatus = $isValid ? 'validated' : 'cancelled';
        $paymentModel->update($paymentId, ['status' => $newStatus]);

        return redirect()->to('/payments/validation')->with('success', 'Pembayaran telah divalidasi.');
    }

    public function cancelPayment($paymentId)
    {
        // Proses pembatalan pembayaran
        $paymentModel = new PaymentModel();
        
        $payment = $paymentModel->find($paymentId);
        if (!$payment) {
            return redirect()->to('/payments/validation')->with('error', 'Pembayaran tidak ditemukan.');
        }

        // Perbarui status pembayaran menjadi 'canceled'
        $paymentModel->update($paymentId, ['status' => 'cancelled']);
        
        // Redirect setelah pembatalan
        return redirect()->to('/payments/validation')->with('success', 'Pembayaran berhasil dibatalkan.');
    }
    // Proses validasi pembayaran oleh staff
    private function processValidation($payment)
    {
        // Cek apakah pembayaran valid atau tidak
        // Misalnya: validasi berdasarkan transaksi pembayaran yang telah dilakukan
        // Jika pembayaran valid, return true, jika tidak, return false
        return true; // Misalnya valid
    }
}
