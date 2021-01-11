<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Models\User\User;
use App\Models\User\UserPet;
use App\Models\Pet\Pet;
use App\Models\Pet\PetCategory;
use App\Models\Pet\PetLog;
use App\Services\PetManager;
use App\Models\Character\Character;

use App\Http\Controllers\Controller;

class PetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Pet Controller
    |--------------------------------------------------------------------------
    |
    | Handles pet management for the user.
    |
    */

    /**
     * Shows the user's pet page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        $categories = PetCategory::orderBy('sort', 'DESC')->get();
        $pets = count($categories) ? Auth::user()->pets()->orderByRaw('FIELD(pet_category_id,'.implode(',', $categories->pluck('id')->toArray()).')')->orderBy('name')->orderBy('updated_at')->get()->groupBy('pet_category_id') : Auth::user()->pets()->orderBy('name')->orderBy('updated_at')->get()->groupBy('pet_category_id');
        return view('home.pet', [
            'categories' => $categories->keyBy('id'),
            'pets' => $pets,
            'userOptions' => User::visible()->where('id', '!=', Auth::user()->id)->orderBy('name')->pluck('name', 'id')->toArray(),
            'user' => Auth::user()
        ]);
    }

    /**
     * Shows the pet stack modal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getStack(Request $request, $id)
    {
        $stack = UserPet::withTrashed()->where('id', $id)->with('pet')->first();
        $chara = Character::find($stack->chara_id);
        if(!$chara) {
            $slug = null;
        }
        else {
        $slug = $chara->slug;
        }
        $readOnly = $request->get('read_only') ? : ((Auth::check() && $stack && !$stack->deleted_at && ($stack->user_id == Auth::user()->id || Auth::user()->hasPower('edit_inventories'))) ? 0 : 1);

        return view('home._pet_stack', [
            'stack' => $stack,
            'chara' => $slug,
            'user' => Auth::user(),
            'userOptions' => ['' => 'Select User'] + User::visible()->where('id', '!=', $stack ? $stack->user_id : 0)->orderBy('name')->get()->pluck('verified_name', 'id')->toArray(),
            'readOnly' => $readOnly
        ]);
    }
    
    /**
     * Transfers an pet stack to another user.
     *
     * @param  \Illuminate\Http\Request       $request
     * @param  App\Services\PetManager  $service
     * @param  int                            $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTransfer(Request $request, PetManager $service, $id)
    {
        if($service->transferStack(Auth::user(), User::visible()->where('id', $request->get('user_id'))->first(), UserPet::where('id', $id)->first())) {
            flash('Pet transferred successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
    
    /**
     * Deletes an pet stack.
     *
     * @param  \Illuminate\Http\Request       $request
     * @param  App\Services\PetManager  $service
     * @param  int                            $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete(Request $request, PetManager $service, $id)
    {
        if($service->deleteStack(Auth::user(), UserPet::where('id', $id)->first())) {
            flash('Pet deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Names an pet.
     *
     * @param  \Illuminate\Http\Request       $request
     * @param  App\Services\CharacterManager  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postName(Request $request, PetManager $service, $id)
    {
        if($service->nameStack(UserPet::find($id), $request->get('name'))) {
            flash('Pet named successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Attaches an pet.
     *
     * @param  \Illuminate\Http\Request       $request
     * @param  App\Services\CharacterManager  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAttach(Request $request, PetManager $service, $id)
    {
        if($service->attachStack(UserPet::find($id), $request->get('slug'))) {
            flash('Pet attached successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }


    /**
     * Shows the pet selection widget.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSelector($id)
    {
        return view('widgets._pet_select', [
            'user' => Auth::user(),
        ]);
    }
}
