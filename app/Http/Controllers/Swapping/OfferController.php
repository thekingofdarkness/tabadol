<?php

namespace App\Http\Controllers\Swapping;

use App\Http\Controllers\Controller;
use App\Helpers\TranslationHelper;
use App\Models\Framework;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::where('uid', Auth::user()->id)->paginate(10);
        // Iterate over each offer and update the required_aref value with its translation
        $offers->transform(function ($offer) {
            $offer->required_aref = TranslationHelper::translate($offer->required_aref);
            $offer->status_ar = TranslationHelper::translate($offer->status);
            return $offer;
        });
        return view('offers.index', compact('offers'));
    }

    public function create()
    {

        $frameworks = Framework::all();
        return view('offers.create', compact('frameworks'));
    }

    public function store(Request $request)
    {
        // Set the current user ID
        $userId = Auth::id();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'current_cadre' => 'required|string|exists:frameworks,codename',
            'current_aref' => 'required|string|max:255',
            'current_dir' => 'required|string|max:255',
            'current_commune' => 'required|string|max:255',
            'current_institution' => 'required|string|max:255',
            'required_aref' => 'required|string|max:255',
            'required_dir' => 'required|string|max:255',
            'required_commune' => 'required|string|max:255',
            'required_institution' => 'required|string|max:255',
            'note' => 'nullable|string',
            'speciality' => 'string|max:255'
        ], [], [
            'current_cadre' => 'حقل الهيئة التي تنتمي اليها',
            'current_aref' => 'الاكاديمية الحالية',
            'current_dir' => 'المديرية الحالية',
            'current_commune' => 'الجماعة الحالية',
            'current_institution' => 'المؤسسة الحالية',
            'required_aref' => 'الاكاديمية المطلوبة',
            'required_dir' => 'المديرية المطلوبة',
            'required_commune' => 'الجماعة المطلوبة',
            'required_institution' => 'المؤسسة المطلوبة',
            'note' => 'ملاحظات',
            'speciality' => 'التخصص'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the offer with validated data and the current user ID
        Offer::create(array_merge(
            $request->except('uid'), // Exclude uid from request data
            ['uid' => $userId], // Add the current user ID
            ['status' => 'approved']
        ));

        return redirect()->route('offers.index')->with('success', 'تمت العملية بنجاح.');
    }



    public function show($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->current_cadre = TranslationHelper::translate($offer->current_cadre);
        $offer->current_aref = TranslationHelper::translate($offer->current_aref);
        $offer->required_aref = TranslationHelper::translate($offer->required_aref);
        $offer->status_en = $offer->status;
        $offer->status = TranslationHelper::translate($offer->status);
        $user = $offer->user;
        // Check if user is null and handle accordingly
        if ($user === null) {
            return redirect()->back()->with('error', 'User not found for this offer.');
        }
        return view('offers.show', compact('offer', 'user'));
    }

    public function edit(Offer $offer)
    {
        return view('offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'uid' => 'required|integer',
            'current_cadre' => 'required|string|max:255',
            'current_aref' => 'required|string|max:255',
            'current_dir' => 'required|string|max:255',
            'current_commune' => 'required|string|max:255',
            'current_institution' => 'required|string|max:255',
            'required_aref' => 'required|string|max:255',
            'required_dir' => 'required|string|max:255',
            'required_commune' => 'required|string|max:255',
            'required_institution' => 'required|string|max:255',
            'note' => 'nullable|string',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
            'speciality' => 'string|max:255'
        ]);

        $offer->update($request->all());

        return redirect()->route('offers.index')->with('success', 'تمت العملية بنجاح.');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('offers.index')->with('success', 'تمت العملية بنجاح.');
    }
    /**
     * Update the status of a specific offer to 'done' if the authenticated user is the owner.
     */
    public function updateStatusToDone($id)
    {
        $userId = Auth::id();
        $offer = Offer::findOrFail($id);

        // Check if the authenticated user is the owner of the offer
        if ($offer->uid !== $userId) {
            return redirect()->back()->with('error', 'لا تملك صلاحيات القيام بالعملية');
        }

        // Update the status of the offer to 'done'
        $offer->status = 'done';
        $offer->save();

        return redirect()->route('offers.index')->with('success', 'تمت العملية بنجاح');
    }
}
