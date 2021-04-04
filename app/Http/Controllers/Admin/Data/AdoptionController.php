<?php

namespace App\Http\Controllers\Admin\Data;

use Illuminate\Http\Request;

use Settings;
use Auth;

use App\Models\Adoption\Adoption;
use App\Models\Adoption\AdoptionStock;
use App\Models\Character\Character;
use App\Models\Currency\Currency;
use App\Models\User\User;

use App\Services\AdoptionService;

use App\Http\Controllers\Controller;

class AdoptionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin / Adoption Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of adoptions and adoption stock.
    |
    */

    /**
     * Shows the adoption index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('admin.adoptions.adoptions', [
            'adoptions' => Adoption::get(),
            'adoptioncenter' => User::find(intval(Settings::get('adopts_user'))),
        ]);
    }

    /**
     * Gets adopt stock index
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\AdoptionService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getStockIndex() {
        return view('admin.adoptions.stocks', [
            'stock' => AdoptionStock::get(),
            'adoptioncenter' => User::find(intval(Settings::get('adopts_user'))),
        ]);
    }

    /**
     * Post adopt stock edits
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\AdoptionService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getEditStock($id) {
        $stock = AdoptionStock::find($id);
        if(!$stock) abort(404);
        return view('admin.adoptions._edit_stock', [
            'stock' => $stock,
            'characters' => Character::orderBy('id')->get()->where('user_id', intval(Settings::get('adopts_user')))->pluck('fullname', 'id'),
            'currencies' => Currency::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    /**
     * Post adopt stock edits
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\AdoptionService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCreateStock() {
        return view('admin.adoptions._create_stock', [
            'characters' => Character::orderBy('id')->get()->where('user_id', intval(Settings::get('adopts_user')))->pluck('fullname', 'id'),
            'currencies' => Currency::orderBy('name')->pluck('name', 'id'),
        ]);
    }
    
    /**
     * Shows the edit adoption page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditAdoption($id)
    {
        $adoption = Adoption::find($id);
        if(!$adoption) abort(404);
        return view('admin.adoptions.create_edit_adoption', [
            'adoption' => $adoption,
            'characters' => Character::orderBy('id')->get()->where('user_id', intval(Settings::get('adopts_user')))->pluck('fullname', 'id'),
            'currencies' => Currency::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    /**
     * Creates or edits a adoption.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\AdoptionService  $service
     * @param  int|null                  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditAdoption(Request $request, AdoptionService $service, $id = null)
    {
        $id ? $request->validate(Adoption::$updateRules) : $request->validate(Adoption::$createRules);
        $data = $request->only([
            'name', 'description', 'image', 'remove_image', 'is_active'
        ]);
        if($id && $service->updateAdoption(Adoption::find($id), $data, Auth::user())) {
            flash('Adoption updated successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Creates an adoption's stock.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\AdoptionService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateStock(Request $request, AdoptionService $service)
    {
        $data = $request->only([
            'adoption_id', 'character_id', 'currency_id', 'cost', 'use_user_bank', 'use_character_bank', 'is_visible'
        ]);

        if($service->createAdoptionStock(Adoption::find(1), $data)) {
            flash('Adoption stock updated successfully.')->success();
            return redirect()->to('admin/data/stock');
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Creates an adoption's stock.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\AdoptionService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteStock($id, AdoptionService $service)
    {

        if($service->deleteStock($id)) {
            flash('Adoption stock deleted successfully.')->success();
            return redirect()->to('admin/data/stock');
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Edits a adoption's stock.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\AdoptionService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditAdoptionStock(Request $request, AdoptionService $service, $id)
    {
        $data = $request->only([
             'adoption_id', 'character_id', 'currency_id', 'cost', 'use_user_bank', 'use_character_bank', 'is_visible'
        ]);

        if($service->updateAdoptionStock(Adoption::find(1), $data, $id)) {
            flash('Adoption stock updated successfully.')->success();
            return redirect()->back();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
}
