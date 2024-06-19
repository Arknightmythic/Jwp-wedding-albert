<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageBookingCheckoutRequest;
use App\Http\Requests\StorePackageBookingRequest;
use App\Http\Requests\UpdatePackageBookingRequest;
use App\Models\Category;
use App\Models\PackageBank;
use App\Models\PackageBooking;
use App\Models\PackageWedding;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FrontController extends Controller
{
    public function index(){
        // return view('welcome');
        $categories= Category::orderByDesc('id')->get();
        $package_weddings = PackageWedding::orderByDesc('id')->take(5)->get();
        return view('front.index', compact('package_weddings', 'categories'));
    }

    public function category(Category $category){
        return view('front.category',compact('category'));
    }


    public function details(PackageWedding $packageWedding)
    {
        $latestPhotos = $packageWedding->package_photos()->orderByDesc('id')->take(3)->get();
        return view('front.details',compact('packageWedding','latestPhotos'));
    }

    public function book(PackageWedding $packageWedding){
        return view('front.book', compact('packageWedding'));
    }

    public function book_store(StorePackageBookingRequest $request, PackageWedding $packageWedding){
        $user=Auth::user();
        $bank=PackageBank::orderByDesc('id')->first();
        $packageBookingId = null;

        DB::transaction(function() use ($request, $user, $packageWedding, $bank, &$packageBookingId){
            $validated = $request->validated();

            $weddingDate= new Carbon($validated['wedding_date']);
           
            $sub_total = $packageWedding->price * $validated['quantity'];
            $insurance = 300000 * $validated['quantity'];
            $tax = $sub_total * 0.10;
            
            $validated['wedding_date'] = $weddingDate;
            $validated['user_id'] = $user->id;
            $validated['is_paid'] = false;
            $validated['proof'] = 'dummytrx.png';
            $validated ['package_wedding_id'] = $packageWedding->id;
            $validated['package_bank_id'] = $bank->id;
            $validated['insurance'] = $insurance;
            $validated['tax'] = $tax;
            $validated['sub_total'] = $sub_total;
            $validated['total_amount'] = $sub_total + $tax + $insurance;
            
            $packageBooking = PackageBooking:: create($validated);

            $packageBookingId = $packageBooking->id;
            
        });

        if ($packageBookingId) {
            return  redirect()->route('front.choose_bank', $packageBookingId);
        } else{
            return back()->withErrors("Failed to create booking.");
        }
    }


    public function choose_bank(PackageBooking $packageBooking){
        $user=Auth::user();
        if ($packageBooking->user_id != $user->id) {
            abort(403);
        }

        $banks = PackageBank::all();

        return view('front.choose_bank', compact('packageBooking','banks'));
    }

    public function choose_bank_store(UpdatePackageBookingRequest $request, PackageBooking $packageBooking){
        $user=Auth::user();
        if ($packageBooking->user_id != $user->id) {
            abort(403);
        }

        DB::transaction(function () use($request, $packageBooking) {
            $validated = $request->validated();
            $packageBooking->update([
                'package_bank_id' => $validated['package_bank_id'],
            ]);
        });
        return redirect()->route('front.book_payment',$packageBooking->id);
    }

    public function book_payment(PackageBooking $packageBooking){
        return view('front.book_payment', compact('packageBooking'));
    }

    public function book_payment_store(StorePackageBookingCheckoutRequest $request, PackageBooking $packageBooking){
        $user=Auth::user();
        if ($packageBooking->user_id != $user->id) {
            abort(403);
        }

        DB::transaction(function () use($request,$user,$packageBooking){
            $validated = $request->validated();

            if($request->hasFile('proof')){
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $packageBooking->update($validated);
        });
        return redirect()->route('front.book_finish');
    }

    public function book_finish(){
        return view('front.book_finish');
    }
}
