<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminServiceController extends Controller
{
    public function index()
    {
        return view('admin.services', [
            'services' => Service::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'required|string|max:500',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        } else {
            unset($data['image']);
        }

        Service::create([
            ...$data,
            'is_active' => true
        ]);

        return back()->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'required|string|max:500',
            'price' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        } else {
            unset($data['image']);
        }

        $service->update($data);

        return back()->with('success', 'Data layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->bookings()->exists()) {
            $service->update(['is_active' => false]);
            return back()->with('success', 'Layanan sudah memiliki riwayat booking, jadi dinonaktifkan agar riwayat tetap aman.');
        }

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus permanen.');
    }
}