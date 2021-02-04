<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Config;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Prompt\PromptCategory;
use App\Models\Submission\Submission;
use App\Models\Item\Item;
use App\Models\Item\ItemCategory;
use App\Models\Award\Award;
use App\Models\Award\AwardCategory;
use App\Models\Currency\Currency;
use App\Models\Loot\LootTable;
use App\Models\Raffle\Raffle;
use App\Models\Prompt\Prompt;
use App\Models\Character\Character;
use App\Models\Pet\Pet;

use App\Services\SubmissionManager;

use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    /**
     * Shows the submission index page.
     *
     * @param  string  $status
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSubmissionIndex(Request $request, $status = null)
    {
        $submissions = Submission::with('prompt')->where('status', $status ? ucfirst($status) : 'Pending')->whereNotNull('prompt_id');
        $data = $request->only(['prompt_category_id', 'sort']);
        if(isset($data['prompt_category_id']) && $data['prompt_category_id'] != 'none') 
            $submissions->whereHas('prompt', function($query) use ($data) {
                $query->where('prompt_category_id', $data['prompt_category_id']);
            });
        if(isset($data['sort'])) 
        {
            switch($data['sort']) {
                case 'newest':
                    $submissions->sortNewest();
                    break;
                case 'oldest':
                    $submissions->sortOldest();
                    break;
            }
        } 
        else $submissions->sortOldest();
        return view('admin.submissions.index', [
            'submissions' => $submissions->paginate(30)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + PromptCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'isClaims' => false
        ]);
    }
    
    /**
     * Shows the submission detail page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSubmission($id)
    {
        $submission = Submission::whereNotNull('prompt_id')->where('id', $id)->first();
        $inventory = isset($submission->data['user']) ? parseAssetData($submission->data['user']) : null;
        $prompt = Prompt::where('id', $submission->prompt_id)->first();
        if(!$submission) abort(404);

        $count['all'] = Submission::submitted($prompt->id, $submission->user_id)->count();
        $count['Hour'] = Submission::submitted($prompt->id, $submission->user_id)->where('created_at', '>=', now()->startOfHour())->count();
        $count['Day'] = Submission::submitted($prompt->id, $submission->user_id)->where('created_at', '>=', now()->startOfDay())->count();
        $count['Week'] = Submission::submitted($prompt->id, $submission->user_id)->where('created_at', '>=', now()->startOfWeek())->count();
        $count['Month'] = Submission::submitted($prompt->id, $submission->user_id)->where('created_at', '>=', now()->startOfMonth())->count();
        $count['Year'] = Submission::submitted($prompt->id, $submission->user_id)->where('created_at', '>=', now()->startOfYear())->count();
        
        if($prompt->limit_character) {
            $limit = $prompt->limit * Character::visible()->where('is_myo_slot', 0)->where('user_id', $submission->user_id)->count();
        } else {
            $limit = $prompt->limit;
        }

        return view('admin.submissions.submission', [
            'submission' => $submission,
            'inventory' => $inventory,
            'rewardsData' => isset($submission->data['rewards']) ? parseAssetData($submission->data['rewards']) : null,
            'itemsrow' => Item::all()->keyBy('id'),
            'page' => 'submission',
        ] + ($submission->status == 'Pending' ? [
            'characterCurrencies' => Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id'),
            'items' => Item::orderBy('name')->pluck('name', 'id'),
            'currencies' => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'tables' => LootTable::orderBy('name')->pluck('name', 'id'),
            'raffles' => Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id'),
            'count' => Submission::where('prompt_id', $submission->prompt_id)->where('status', 'Approved')->where('user_id', $submission->user_id)->count(),
            'pets' => Pet::orderBy('name')->pluck('name', 'id'),
            'prompt' => $prompt,
            'limit' => $limit

        ] : []));
    }    
    
    /**
     * Shows the claim index page.
     *
     * @param  string  $status
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getClaimIndex(Request $request, $status = null)
    {
        $submissions = Submission::where('status', $status ? ucfirst($status) : 'Pending')->whereNull('prompt_id');
        $data = $request->only(['sort']);
        if(isset($data['sort'])) 
        {
            switch($data['sort']) {
                case 'newest':
                    $submissions->sortNewest();
                    break;
                case 'oldest':
                    $submissions->sortOldest();
                    break;
            }
        } 
        else $submissions->sortOldest();
        return view('admin.submissions.index', [
            'submissions' => $submissions->paginate(30),
            'isClaims' => true
        ]);
    }
    
    /**
     * Shows the claim detail page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getClaim($id)
    {
        $submission = Submission::whereNull('prompt_id')->where('id', $id)->first();
        $inventory = isset($submission->data['user']) ? parseAssetData($submission->data['user']) : null;
        if(!$submission) abort(404);
        return view('admin.submissions.submission', [
            'submission' => $submission,
            'inventory' => $inventory,
            'itemsrow' => Item::all()->keyBy('id'),
            'awardsrow' => Award::all()->keyBy('id'),
        ] + ($submission->status == 'Pending' ? [
            'characterCurrencies' => Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id'),
            'items' => Item::orderBy('name')->pluck('name', 'id'),
            'currencies' => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'tables' => LootTable::orderBy('name')->pluck('name', 'id'),
            'raffles' => Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id'),
            'count' => Submission::where('prompt_id', $id)->where('status', 'Approved')->where('user_id', $submission->user_id)->count(),
            'pets' => Pet::orderBy('name')->pluck('name', 'id'),
            'count' => $count,
            'limit' => $limit,
            'rewardsData' => isset($submission->data['rewards']) ? parseAssetData($submission->data['rewards']) : null
        ] : []));
    }

    /**
     * Creates a new submission.
     *
     * @param  \Illuminate\Http\Request        $request
     * @param  App\Services\SubmissionManager  $service
     * @param  int                             $id
     * @param  string                          $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSubmission(Request $request, SubmissionManager $service, $id, $action)
    {
        $data = $request->only(['slug',  'character_quantity', 'character_currency_id', 'rewardable_type', 'rewardable_id', 'quantity', 'staff_comments', 'bonus_exp', 'bonus_points', 'bonus_user_exp', 'bonus_user_points' ]);
        if($action == 'reject' && $service->rejectSubmission($request->only(['staff_comments']) + ['id' => $id], Auth::user())) {
            flash('Submission rejected successfully.')->success();
        }
        elseif($action == 'approve' && $service->approveSubmission($data + ['id' => $id], Auth::user())) {
            flash('Submission approved successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
}