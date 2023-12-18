<?php

namespace App\Http\Controllers;
use App\Models\User;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Web3\Eth;
use Web3\Utils;
class MetamaskController extends Controller
{
 // Fungsi untuk menghubungkan akun metamask dengan dompet laravel
 public function handle(Request $request)
 {
 // Mengecek apakah pengguna sudah login
 if (Auth::check()) {
 // Mendapatkan data dari request
 $data = $request->all();
 // Membuat validator untuk memvalidasi data
 $validator = Validator::make($data, [
 'address' => 'required|string',
 'signature' => 'required|string',
 'message' => 'required|string',
 ]);
 // Jika validator gagal, kembalikan pesan error
 if ($validator->fails()) {
 return response()->json(['error' => $validator->errors()], 422);
 }
 // Jika validator berhasil, lanjutkan proses
 else {
 // Mendapatkan akun metamask dari data
 $address = $data['address'];
 // Mendapatkan tanda tangan dari data
 $signature = $data['signature'];
 // Mendapatkan pesan dari data
 $message = $data['message'];
 // Membuat instance Eth untuk memverifikasi tanda tangan
 $eth = new Eth();
 // Memanggil fungsi recoverPersonalSignature untuk mendapatkan alamat yang menandatangani pesan
 $eth->personal->recoverPersonalSignature([
 'data' => $message,
'sig' => $signature,
 ], function ($err, $recoveredAddress) use ($address) {
 // Jika terjadi error, kembalikan pesan error
 if ($err) {
 return response()->json(['error' => $err->getMessage()], 500);
 }
 // Jika tidak terjadi error, bandingkan alamat yang diperoleh dengan alamat yang dikirim
else {
 // Jika alamat sama, berarti tanda tangan valid
if ($recoveredAddress === $address) {
 // Mendapatkan pengguna yang sedang login
$user = Auth::user();
 // Mendapatkan dompet laravel yang ingin dihubungkan dengan metamask
$wallet = $user->getWallet('metamask');
 // Jika dompet laravel belum ada, buat dompet baru
if (!$wallet) {
 $wallet = $user->createWallet([
 'name' => 'Metamask',
'slug' => 'metamask',
 ]);
 }
 // Mengupdate alamat dompet laravel dengan alamat metamask
$wallet->update(['meta' => ['address' => $address]]);
 // Kembalikan pesan sukses
return response()->json(['success' => 'Akun metamask berhasil dihubungkan dengan dompet laravel'], 200);
 }
 // Jika alamat berbeda, berarti tanda tangan tidak valid
else {
 // Kembalikan pesan error
return response()->json(['error' => 'Tanda tangan tidak valid'], 401);
 }
 }
 });
 }
 }
 // Jika pengguna belum login, kembalikan pesan error
 else {
 return response()->json(['error' => 'Anda harus login terlebih dahulu'], 401);
 }
 }
}
