<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LostItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class LostItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lost_items.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lost_items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lost_item_name' => 'required|max:25',
            'place' => 'required|max:30',
            'finder_name' => 'required|max:10',
            'description' => 'nullable|max:255',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $photoDir = storage_path('app/public/photo');
        if (!File::exists($photoDir)) {
            File::makeDirectory($photoDir, 0755, true);
        }

        $photoPaths = [];
        $manager = new ImageManager(new GdDriver());

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                if ($photo && $photo->isValid()) {
                    $img = $manager->read($photo->getRealPath());
                    $img->resize(360, 360, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $filename = uniqid('photo_') . '.' . $photo->getClientOriginalExtension();

                    Storage::disk('public')->put('photo/' . $filename, (string) $img->encode());

                    $photoPaths[$index] = 'photo/' . $filename;
                }
            }
        }

        LostItem::create([
            'lost_item_name' => $validated['lost_item_name'],
            'place' => $validated['place'],
            'finder_name' => $validated['finder_name'],
            'description' => $validated['description'] ?? null,
            'photo1' => $photoPaths[0] ?? null,
            'photo2' => $photoPaths[1] ?? null,
            'photo3' => $photoPaths[2] ?? null,
        ]);

        return back()->with('message', '保存しました');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
