<?php

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
|
| Routes for logged in users with a linked dA account.
|
*/

/**************************************************************************************************
    Users
**************************************************************************************************/

Route::group(['prefix' => 'notifications', 'namespace' => 'Users'], function() {
    Route::get('/', 'AccountController@getNotifications');
    Route::get('delete/{id}', 'AccountController@getDeleteNotification');
    Route::post('clear', 'AccountController@postClearNotifications');
    Route::post('clear/{type}', 'AccountController@postClearNotifications');
});

Route::group(['prefix' => 'account', 'namespace' => 'Users'], function() {
    Route::get('settings', 'AccountController@getSettings');
    Route::post('profile', 'AccountController@postProfile');
    Route::post('password', 'AccountController@postPassword');
    Route::post('email', 'AccountController@postEmail');
    Route::post('location', 'AccountController@postLocation');
    Route::post('faction', 'AccountController@postFaction');
    Route::post('avatar', 'AccountController@postAvatar');
    Route::post('socials', 'AccountController@postLinks');
    Route::post('dob', 'AccountController@postBirthday');

    Route::get('bookmarks', 'BookmarkController@getBookmarks');
    Route::get('bookmarks/create', 'BookmarkController@getCreateBookmark');
    Route::get('bookmarks/edit/{id}', 'BookmarkController@getEditBookmark');
    Route::post('bookmarks/create', 'BookmarkController@postCreateEditBookmark');
    Route::post('bookmarks/edit/{id}', 'BookmarkController@postCreateEditBookmark');
    Route::get('bookmarks/delete/{id}', 'BookmarkController@getDeleteBookmark');
    Route::post('bookmarks/delete/{id}', 'BookmarkController@postDeleteBookmark');
});

Route::group(['prefix' => 'inventory', 'namespace' => 'Users'], function() {
    Route::get('/', 'InventoryController@getIndex');
    Route::post('edit', 'InventoryController@postEdit');
    Route::get('account-search', 'InventoryController@getAccountSearch');

    Route::get('selector', 'InventoryController@getSelector');
});

Route::group(['prefix' => 'pets', 'namespace' => 'Users'], function() {
    Route::get('/', 'PetController@getIndex');
    Route::post('transfer/{id}', 'PetController@postTransfer');
    Route::post('delete/{id}', 'PetController@postDelete');
    Route::post('name/{id}', 'PetController@postName');
    Route::post('attach/{id}', 'PetController@postAttach');
    Route::post('detach/{id}', 'PetController@postDetach');

    Route::get('selector', 'PetController@getSelector');
});

Route::group(['prefix' => 'characters', 'namespace' => 'Users'], function() {
    Route::get('/', 'CharacterController@getIndex');
    Route::post('sort', 'CharacterController@postSortCharacters');

    Route::get('transfers/{type}', 'CharacterController@getTransfers');
    Route::post('transfer/act/{id}', 'CharacterController@postHandleTransfer');

    Route::get('myos', 'CharacterController@getMyos');
});

Route::group(['prefix' => 'bank', 'namespace' => 'Users'], function() {
    Route::get('/', 'BankController@getIndex');
    Route::post('transfer', 'BankController@postTransfer');
});

Route::group(['prefix' => 'level', 'namespace' => 'Users'], function() {
    Route::get('/', 'LevelController@getIndex');
    Route::post('up', 'LevelController@postLevel');
    Route::post('transfer', 'LevelController@postTransfer');
});

Route::group(['prefix' => 'trades', 'namespace' => 'Users'], function() {
    Route::get('listings', 'TradeController@getListingIndex');
    Route::get('listings/expired', 'TradeController@getExpiredListings');
    Route::get('listings/create', 'TradeController@getCreateListing');
    Route::post('listings/create', 'TradeController@postCreateListing');
    Route::get('listings/{id}', 'TradeController@getListing')->where('id', '[0-9]+');
    Route::post('listings/{id}/expire', 'TradeController@postExpireListing')->where('id', '[0-9]+');
    
    Route::get('{status}', 'TradeController@getIndex')->where('status', 'open|pending|completed|rejected|canceled');
    Route::get('create', 'TradeController@getCreateTrade');
    Route::get('{id}/edit', 'TradeController@getEditTrade')->where('id', '[0-9]+');
    Route::post('create', 'TradeController@postCreateTrade');
    Route::post('{id}/edit', 'TradeController@postEditTrade')->where('id', '[0-9]+');
    Route::get('{id}', 'TradeController@getTrade')->where('id', '[0-9]+');

    Route::get('{id}/confirm-offer', 'TradeController@getConfirmOffer');
    Route::post('{id}/confirm-offer', 'TradeController@postConfirmOffer');
    Route::get('{id}/confirm-trade', 'TradeController@getConfirmTrade');
    Route::post('{id}/confirm-trade', 'TradeController@postConfirmTrade');
    Route::get('{id}/cancel-trade', 'TradeController@getCancelTrade');
    Route::post('{id}/cancel-trade', 'TradeController@postCancelTrade');
});

Route::group(['prefix' => 'crafting', 'namespace' => 'Users'], function() {
    Route::get('/', 'CraftingController@getIndex');
    Route::get('craft/{id}', 'CraftingController@getCraftRecipe');
    Route::post('craft/{id}', 'CraftingController@postCraftRecipe');
});

/**************************************************************************************************
    Characters
**************************************************************************************************/
Route::group(['prefix' => 'character', 'namespace' => 'Characters'], function() {
    Route::get('{slug}/profile/edit', 'CharacterController@getEditCharacterProfile');
    Route::post('{slug}/profile/edit', 'CharacterController@postEditCharacterProfile');

    Route::get('{slug}/links/edit', 'CharacterController@getEditCharacterLinks');
    Route::post('{slug}/links/edit', 'CharacterController@postEditCharacterLinks');

    Route::post('{slug}/links/info/{id}', 'CharacterController@postEditCharacterLinkInfo');
    Route::post('{slug}/links/delete/{id}', 'CharacterController@postDeleteCharacterLink');
    
    Route::post('{slug}/inventory/edit', 'CharacterController@postInventoryEdit');

    Route::post('{slug}/bank/transfer', 'CharacterController@postCurrencyTransfer');

    Route::get('{slug}/transfer', 'CharacterController@getTransfer');
    Route::post('{slug}/transfer', 'CharacterController@postTransfer');
    Route::post('{slug}/transfer/{id}/cancel', 'CharacterController@postCancelTransfer');

    Route::post('{slug}/approval', 'CharacterController@postCharacterApproval');
    Route::get('{slug}/approval', 'CharacterController@getCharacterApproval');

    Route::get('{slug}/profile/edit', 'CharacterController@getEditCharacterProfile');
    Route::post('{slug}/profile/edit', 'CharacterController@postEditCharacterProfile');

    Route::post('{slug}/drops', 'CharacterController@postClaimCharacterDrops');
    Route::get('{slug}/level-area', 'LevelController@getIndex');
    Route::get('{slug}/stats-area', 'LevelController@getStatsIndex');
    Route::post('{slug}/level-area/up', 'LevelController@postLevel');
    Route::post('{slug}/stats-area/{id}', 'LevelController@postStat');
    Route::post('{slug}/stats-area/admin/{id}', 'LevelController@postAdminStat');
    Route::post('{slug}/stats-area/edit/{id}', 'LevelController@postEditStat');
    # EXP
    Route::post('{slug}/level-area/exp-grant', 'LevelController@postExpGrant');
    Route::post('{slug}/level-area/stat-grant', 'LevelController@postStatGrant');
});

Route::get('links/accept/{id}', 'LinkController@getAcceptLink');
Route::get('links/reject/{id}', 'LinkController@getRejectLink');
// LINKS

Route::group(['prefix' => 'myo', 'namespace' => 'Characters'], function() {
    Route::get('{id}/profile/edit', 'MyoController@getEditCharacterProfile');
    Route::post('{id}/profile/edit', 'MyoController@postEditCharacterProfile');

    Route::get('{id}/transfer', 'MyoController@getTransfer');
    Route::post('{id}/transfer', 'MyoController@postTransfer');
    Route::post('{id}/transfer/{id2}/cancel', 'MyoController@postCancelTransfer');

    Route::post('{id}/approval', 'MyoController@postCharacterApproval');
    Route::get('{id}/approval', 'MyoController@getCharacterApproval');
});

Route::group(['prefix' => 'level', 'namespace' => 'Users'], function() {
    Route::get('/', 'LevelController@getIndex');

});



/**************************************************************************************************
    Submissions
**************************************************************************************************/

Route::group(['prefix' => 'gallery'], function() {
    Route::get('submissions/{type}', 'GalleryController@getUserSubmissions')->where('type', 'pending|accepted|rejected');

    Route::post('favorite/{id}', 'GalleryController@postFavoriteSubmission');

    Route::get('submit/{id}', 'GalleryController@getNewGallerySubmission');
    Route::get('submit/character/{slug}', 'GalleryController@getCharacterInfo');
    Route::get('edit/{id}', 'GalleryController@getEditGallerySubmission');
    Route::get('queue/{id}', 'GalleryController@getSubmissionLog');
    Route::post('submit', 'GalleryController@postCreateEditGallerySubmission');
    Route::post('edit/{id}', 'GalleryController@postCreateEditGallerySubmission');

    Route::post('collaborator/{id}', 'GalleryController@postEditCollaborator');

    Route::get('archive/{id}', 'GalleryController@getArchiveSubmission');
    Route::post('archive/{id}', 'GalleryController@postArchiveSubmission');
});

Route::group(['prefix' => 'submissions', 'namespace' => 'Users'], function() {
    Route::get('/', 'SubmissionController@getIndex');
    Route::get('new', 'SubmissionController@getNewSubmission');
    Route::get('new/character/{slug}', 'SubmissionController@getCharacterInfo');
    Route::get('new/prompt/{id}', 'SubmissionController@getPromptInfo');
    Route::post('new', 'SubmissionController@postNewSubmission');
});

Route::group(['prefix' => 'claims', 'namespace' => 'Users'], function() {
    Route::get('/', 'SubmissionController@getClaimsIndex');
    Route::get('new', 'SubmissionController@getNewClaim');
    Route::post('new', 'SubmissionController@postNewClaim');
});

Route::group(['prefix' => 'reports', 'namespace' => 'Users'], function() {
    Route::get('/', 'ReportController@getReportsIndex');
    Route::get('new', 'ReportController@getNewReport');
    Route::post('new', 'ReportController@postNewReport');
    Route::get('view/{id}', 'ReportController@getReport');
});

Route::group(['prefix' => 'designs', 'namespace' => 'Characters'], function() {
    Route::get('{type?}', 'DesignController@getDesignUpdateIndex')->where('type', 'pending|approved|rejected');
    Route::get('{id}', 'DesignController@getDesignUpdate');

    Route::get('{id}/comments', 'DesignController@getComments');
    Route::post('{id}/comments', 'DesignController@postComments');

    Route::get('{id}/image', 'DesignController@getImage');
    Route::post('{id}/image', 'DesignController@postImage');

    Route::get('{id}/addons', 'DesignController@getAddons');
    Route::post('{id}/addons', 'DesignController@postAddons');

    Route::get('{id}/traits', 'DesignController@getFeatures');
    Route::post('{id}/traits', 'DesignController@postFeatures');
    Route::get('traits/subtype', 'DesignController@getFeaturesSubtype');

    Route::get('{id}/confirm', 'DesignController@getConfirm');
    Route::post('{id}/submit', 'DesignController@postSubmit');

    Route::get('{id}/delete', 'DesignController@getDelete');
    Route::post('{id}/delete', 'DesignController@postDelete');
});

/**************************************************************************************************
    Adoptions
**************************************************************************************************/

Route::group(['prefix' => 'adoptions'], function() {
    Route::post('buy', 'AdoptionController@postBuy');
    Route::get('history', 'AdoptionController@getPurchaseHistory');
});

Route::group(['prefix' => 'surrenders'], function() {
Route::get('new', 'SurrenderController@getSurrender');
Route::get('/', 'SurrenderController@getIndex')->where('status', 'pending|approved|rejected');
Route::post('new/post', 'SurrenderController@postSurrender');
});


/**************************************************************************************************
    Shops
**************************************************************************************************/

Route::group(['prefix' => 'shops'], function() {
    Route::post('buy', 'ShopController@postBuy');
    Route::get('history', 'ShopController@getPurchaseHistory');
});



/**************************************************************************************************
    Research
**************************************************************************************************/

Route::group(['prefix' => 'research', 'namespace' => 'Research'], function() {
    Route::get('/purchase/{id}', 'ResearchController@getPurchaseResearch');
    Route::post('/purchase/{id}', 'ResearchController@postPurchaseResearch');
    Route::post('/claim-rewards/{id}', 'ResearchController@postClaimRewards');
    Route::get('/history', 'ResearchController@getResearchHistory');
    Route::get('/unlocked', 'TreeController@getUserTree');
});


/**************************************************************************************************
    Scavenger Hunts
**************************************************************************************************/

Route::group(['prefix' => 'hunts'], function() {
    Route::get('{id}', 'HuntController@getHunt');
    Route::get('targets/{pageId}', 'HuntController@getTarget');
    Route::post('targets/claim', 'HuntController@postClaimTarget');
});

/**************************************************************************************************
    Comments
**************************************************************************************************/
Route::group(['prefix' => 'comments', 'namespace' => 'Comments'], function() {
    Route::post('/', 'CommentController@store')->name('comments.store');
    Route::delete('/{comment}', 'CommentController@destroy')->name('comments.destroy');
    Route::put('/{comment}', 'CommentController@update')->name('comments.update');
    Route::post('/{comment}', 'CommentController@reply')->name('comments.reply');
    Route::post('/{id}/feature', 'CommentController@feature')->name('comments.feature');
});

/**************************************************************************************************
    Advent Calendars
**************************************************************************************************/

Route::group(['prefix' => 'advent-calendars'], function() {
    Route::get('{id}', 'AdventController@getAdvent');
    Route::post('{id}', 'AdventController@postClaimPrize');
});
