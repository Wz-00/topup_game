<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
class BannerController extends Controller
{
    public function index(){
        return view('admin.banner', [
            'title' => 'Promote Your Game',
            'banners' => Banner::all(),
            'items' => Item::all(),
            'games' => Game::all()
        ]);
    }
    // Method untuk mengupdate banner (mengganti gambar, game, atau menambahkan/menghapus banner)
    // Function to update and add banners
    public function update(Request $request)
    {
        // Ambil semua banners yang ada di database
        $banners = Banner::all();

        // Menghapus banner yang dihapus di front-end
        if ($request->deleted_banners) {
            $deletedBanners = explode(',', $request->deleted_banners);
            foreach ($deletedBanners as $bannerId) {
                $banner = Banner::find($bannerId);
                if ($banner) {
                    if ($banner->banner && Storage::exists('public/' . $banner->banner)) {
                        Storage::delete('public/' . $banner->banner);
                    }
                    $banner->delete();
                }
            }
        }

        // Proses setiap banner yang ada
        foreach ($banners as $index => $banner) {
            if ($request->has("banner_id_{$index}")) {
                $request->validate([
                    "banner_img_{$index}" => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    "game_{$index}" => 'required|exists:games,id',
                ]);

                if ($request->hasFile("banner_img_{$index}")) {
                    if ($banner->banner && Storage::exists('public/' . $banner->banner)) {
                        Storage::delete('public/' . $banner->banner);
                    }
                    $filePath = $request->file("banner_img_{$index}")->store('asset/img/banner', 'public');
                    $banner->banner = $filePath;
                }

                $banner->game_id = $request->input("game_{$index}");
                $banner->save();
            }
        }

        // Tambah banner baru jika ada
        $newBannerCount = $request->input('new_banner_count');
        for ($i = 1; $i <= $newBannerCount; $i++) {
            if ($request->hasFile("new_banner_img_{$i}") && $request->input("new_game_{$i}")) {
                $request->validate([
                    "new_banner_img_{$i}" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    "new_game_{$i}" => 'required|exists:games,id',
                ]);

                $filePath = $request->file("new_banner_img_{$i}")->store('banners', 'public');
                Banner::create([
                    'banner' => $filePath,
                    'game_id' => $request->input("new_game_{$i}"),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Banners updated successfully');
    }

    // Function to delete banners
    public function delete(Request $request)
    {
        // Ambil ID banner dari request
        $bannerId = $request->input('banner_id');
        
        // Cari banner di database
        $banner = Banner::find($bannerId);

        // Hapus file gambar dari storage jika ada
        if ($banner && Storage::disk('public')->exists($banner->banner)) {
            Storage::disk('public')->delete($banner->banner);
        }

        // Hapus banner dari database
        $banner->delete();

        return response()->json(['status' => 'Banner deleted successfully']);
    }
}
