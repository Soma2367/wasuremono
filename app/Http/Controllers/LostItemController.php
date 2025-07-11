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
        $lost_items = LostItem::all();
        return view('lost_items.index', compact('lost_items'));
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

        $validated['user_id'] = auth()->id();

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

    public function edit(LostItem $lost_item) 
    {
        return view('lost_items.edit', compact('lost_item'));
    }

    public function update(Request $request, LostItem $lost_item)
    {
        $validated = $request->validate([
            'lost_item_name' => 'required|max:25',
            'place' => 'required|max:30',
            'finder_name' => 'required|max:10',
            'description' => 'nullable|max:255',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'delete_photos.*' => 'nullable|in:0,1',
        ]);

        $photoDir = 'photo'; 
        if (!Storage::disk('public')->exists($photoDir)) {
            Storage::disk('public')->makeDirectory($photoDir);
        }

        $manager = new ImageManager(new GdDriver());

        foreach ([1, 2, 3] as $i) {
            $photoField = 'photo' . $i;
            if (isset($request->delete_photos[$i - 1]) && $request->delete_photos[$i - 1] == '1') {
                if ($lost_item->$photoField && Storage::disk('public')->exists($lost_item->$photoField)) {
                    Storage::disk('public')->delete($lost_item->$photoField);
                }
                $lost_item->$photoField = null;
            }

            if ($request->hasFile('photos') && isset($request->file('photos')[$i - 1])) {
                $photo = $request->file('photos')[$i - 1];

                if ($photo && $photo->isValid()) {
                    if ($lost_item->$photoField && Storage::disk('public')->exists($lost_item->$photoField)) {
                        Storage::disk('public')->delete($lost_item->$photoField);
                    }

                    $img = $manager->read($photo->getRealPath());
                    $img->resize(360, 360, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $filename = uniqid('photo_') . '.' . $photo->getClientOriginalExtension();
                    Storage::disk('public')->put($photoDir . '/' . $filename, (string) $img->encode());
                    $lost_item->$photoField = $photoDir . '/' . $filename;
                }
            }
        }
        $lost_item->fill($validated);
        $lost_item->save();

        return redirect()->route('lost_items.index')->with('success', '更新しました');
    }

    public function destroy(Request $request,LostItem $lost_item)
    {
        $lost_item->delete();
        $request->session()->flash('message', '削除しました');
        return redirect()->route('lost_items.index');
    }
}
