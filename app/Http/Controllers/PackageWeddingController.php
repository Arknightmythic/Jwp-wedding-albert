<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageWeddingRequest;
use App\Http\Requests\UpdatePackageWeddingRequest;
use App\Models\Category;
use App\Models\PackageWedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageWeddingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $package_weddings= PackageWedding::orderByDesc('id')->paginate('10');
        return view('admin.package_weddings.index', compact('package_weddings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories= Category::orderByDesc('id')->get();
        return view('admin.package_weddings.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageWeddingRequest $request)
    {
        DB::transaction(function() use ($request){
            $validated = $request->validated();

            if($request->hasFile('thumbnail')){
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails/'. date('Y/m/d'), 'public');
                $validated['thumbnail'] = $thumbnailPath;
            
            }
            
            $validated['slug'] = Str::slug($validated['name']);
            
            $packageWedding = PackageWedding::create($validated);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('package_photos/' .date('Y/m/d'),'public');
                    $packageWedding->package_photos()->create([
                        'photo' =>$photoPath
                    ]);
                }
            }
            
       
        });
        return redirect()->route('admin.package_weddings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageWedding $packageWedding)
    {
        $latestPhotos = $packageWedding->package_photos()->orderByDesc('id')->take(3)->get();
        return view('admin.package_weddings.show',compact('packageWedding','latestPhotos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageWedding $packageWedding)
    {
        $categories= Category::orderByDesc('id')->get();
        $latestPhotos = $packageWedding->package_photos()->orderByDesc('id')->take(3)->get();
        return view('admin.package_weddings.edit',compact('packageWedding','latestPhotos','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageWeddingRequest $request, PackageWedding $packageWedding)
    {
        DB::transaction(function() use ($request, $packageWedding){
            $validated = $request->validated();
            if($request->hasFile('thumbnail')){
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails/'. date('Y/m/d'), 'public');
                $validated['thumbnail'] = $thumbnailPath;
            
            }
            
            $validated['slug'] = Str::slug($validated['name']);
            
            $packageWedding->update($validated);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('package_photos/' .date('Y/m/d'),'public');
                    $packageWedding->package_photos()->create([
                        'photo' =>$photoPath
                    ]);
                }
            }
       
        });
        return redirect()->route('admin.package_weddings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageWedding $packageWedding)
    {
        DB:: transaction(function() use ($packageWedding){
            $packageWedding->delete();
        });
        return redirect()->route('admin.package_weddings.index');
    }
}
