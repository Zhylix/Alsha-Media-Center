<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'service_type'  => 'required|in:laptop,printer,hp',
            'rating'        => 'required|integer|between:1,5',
            'comment'       => 'required|string|max:1000',
        ]);
        $data['is_active'] = $request->has('is_active');
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil ditambahkan!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'service_type'  => 'required|in:laptop,printer,hp',
            'rating'        => 'required|integer|between:1,5',
            'comment'       => 'required|string|max:1000',
        ]);
        $data['is_active'] = $request->has('is_active');
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil diperbarui!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil dihapus!');
    }

    public function show(Testimonial $testimonial) { return redirect()->route('admin.testimonials.index'); }
}
