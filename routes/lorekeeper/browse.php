<?php

/*
|--------------------------------------------------------------------------
| Browse Routes
|--------------------------------------------------------------------------
|
| Routes for pages that don't require being logged in to view,
| specifically the information pages.
|
*/

/**************************************************************************************************
    Widgets
**************************************************************************************************/

Route::get('items/{id}', 'Users\InventoryController@getStack');
Route::get('pets/{id}', 'Users\PetController@getStack');
Route::get('items/character/{id}', 'Users\InventoryController@getCharacterStack');

/**************************************************************************************************
    News
**************************************************************************************************/
# PROFILES
Route::group(['prefix' => 'news'], function() {
    Route::get('/', 'NewsController@getIndex');
    Route::get('{id}.{slug?}', 'NewsController@getNews');
    Route::get('{id}.', 'NewsController@getNews');
});

/**************************************************************************************************
    Sales
**************************************************************************************************/
# PROFILES
Route::group(['prefix' => 'sales'], function() {
    Route::get('/', 'SalesController@getIndex');
    Route::get('{id}.{slug?}', 'SalesController@getSales');
    Route::get('{id}.', 'SalesController@getSales');
});

/**************************************************************************************************
    Users
**************************************************************************************************/
Route::get('/users', 'BrowseController@getUsers');
Route::get('/blacklist', 'BrowseController@getBlacklist');

# PROFILES
Route::group(['prefix' => 'user', 'namespace' => 'Users'], function() {
    Route::get('{name}/gallery', 'UserController@getUserGallery');
    Route::get('{name}/favorites', 'UserController@getUserFavorites');
    Route::get('{name}/favorites/own-characters', 'UserController@getUserOwnCharacterFavorites');

    Route::get('{name}', 'UserController@getUser');
    Route::get('{name}/characters', 'UserController@getUserCharacters');
    Route::get('{name}/sublist/{key}', 'UserController@getUserSublist');
    Route::get('{name}/myos', 'UserController@getUserMyoSlots');
    Route::get('{name}/inventory', 'UserController@getUserInventory');
    Route::get('{name}/pets', 'UserController@getUserPets');
    Route::get('{name}/bank', 'UserController@getUserBank');
    Route::get('{name}/level', 'UserController@getUserLevel');
    
    Route::get('{name}/currency-logs', 'UserController@getUserCurrencyLogs');
    Route::get('{name}/item-logs', 'UserController@getUserItemLogs');
    Route::get('{name}/pet-logs', 'UserController@getUserPetLogs');
    Route::get('{name}/ownership', 'UserController@getUserOwnershipLogs');
    Route::get('{name}/submissions', 'UserController@getUserSubmissions');

    Route::get('{name}/recipe-logs', 'UserController@getUserRecipeLogs');
});
Route::group(['prefix' => 'user', 'namespace' => 'Research'], function() {
    Route::get('{name}/unlocked-research', 'TreeController@getUserTree');
    Route::get('{name}/exp-logs', 'UserController@getUserExpLogs');
    Route::get('{name}/level-logs', 'UserController@getUserLevelLogs');
    Route::get('{name}/stat-logs', 'UserController@getUserStatLogs');
});

/**************************************************************************************************
    Characters
**************************************************************************************************/
Route::get('/masterlist', 'BrowseController@getCharacters');
Route::get('/myos', 'BrowseController@getMyos');
Route::get('/sublist/{key}', 'BrowseController@getSublist');
Route::group(['prefix' => 'character', 'namespace' => 'Characters'], function() {
    Route::get('{slug}', 'CharacterController@getCharacter');
    Route::get('{slug}/profile', 'CharacterController@getCharacterProfile');
    Route::get('{slug}/links', 'CharacterController@getCharacterLinks');
    Route::get('{slug}/bank', 'CharacterController@getCharacterBank');
    Route::get('{slug}/level-logs', 'CharacterController@getCharacterLevel');
    Route::get('{slug}/inventory', 'CharacterController@getCharacterInventory');
    Route::get('{slug}/images', 'CharacterController@getCharacterImages');
    Route::get('{slug}/drops', 'CharacterController@getCharacterDrops');
    
    Route::get('{slug}/currency-logs', 'CharacterController@getCharacterCurrencyLogs');
    Route::get('{slug}/item-logs', 'CharacterController@getCharacterItemLogs');
    Route::get('{slug}/ownership', 'CharacterController@getCharacterOwnershipLogs');
    Route::get('{slug}/change-log', 'CharacterController@getCharacterLogs');
    Route::get('{slug}/submissions', 'CharacterController@getCharacterSubmissions');

    Route::get('{slug}/gallery', 'CharacterController@getCharacterGallery');
    # lineage
    Route::get('{slug}/lineage', 'CharacterLineageController@getCharacterLineage');
    Route::get('{slug}/children', 'CharacterLineageController@getCharacterChildren');
    Route::get('{slug}/grandchildren', 'CharacterLineageController@getCharacterGrandChildren');
    Route::get('{slug}/great-grandchildren', 'CharacterLineageController@getCharacterGreatGrandChildren');
});
Route::group(['prefix' => 'myo', 'namespace' => 'Characters'], function() {
    Route::get('{id}', 'MyoController@getCharacter');
    Route::get('{id}/profile', 'MyoController@getCharacterProfile');
    Route::get('{id}/ownership', 'MyoController@getCharacterOwnershipLogs');
    Route::get('{id}/change-log', 'MyoController@getCharacterLogs');
});


/**************************************************************************************************
    World
**************************************************************************************************/

Route::group(['prefix' => 'world'], function() {
    Route::get('/', 'WorldController@getIndex');

    Route::get('currencies', 'WorldController@getCurrencies');
    Route::get('rarities', 'WorldController@getRarities');
    Route::get('species', 'WorldController@getSpecieses');
    Route::get('subtypes', 'WorldController@getSubtypes');
    Route::get('species/{id}/traits', 'WorldController@getSpeciesFeatures');
    Route::get('item-categories', 'WorldController@getItemCategories');
    Route::get('items', 'WorldController@getItems');
    Route::get('items/{id}', 'WorldController@getItem');
    Route::get('trait-categories', 'WorldController@getFeatureCategories');
    Route::get('traits', 'WorldController@getFeatures');
    Route::get('pet-categories', 'WorldController@getPetCategories');
    Route::get('pets', 'WorldController@getPets');
    Route::get('prompt-categories', 'WorldController@getPromptCategories');
    Route::get('prompts', 'WorldController@getPrompts');
    Route::get('character-categories', 'WorldController@getCharacterCategories');
    Route::get('recipes', 'WorldController@getRecipes');
    Route::get('recipes/{id}', 'WorldController@getRecipe');
    Route::get('character-titles', 'WorldController@getCharacterTitles');
    Route::get('levels', 'WorldController@getLevels');
    Route::get('levels/{type}', 'WorldController@getLevelTypes');
    Route::get('levels/{type}/{level}', 'WorldController@getSingleLevel');
    Route::get('stats', 'WorldController@getStats');
});

Route::group(['prefix' => 'prompts'], function() {
    Route::get('/', 'PromptsController@getIndex');
    Route::get('prompt-categories', 'PromptsController@getPromptCategories');
    Route::get('prompts', 'PromptsController@getPrompts');
});

Route::group(['prefix' => 'shops'], function() {
    Route::get('/', 'ShopController@getIndex');
    Route::get('{id}', 'ShopController@getShop')->where(['id' => '[0-9]+']);
    Route::get('{id}/{stockId}', 'ShopController@getShopStock')->where(['id' => '[0-9]+', 'stockId' => '[0-9]+']);
});

Route::group(['prefix' => 'research-trees', 'namespace' => 'Research'], function() {
    Route::get('/', 'TreeController@getIndex');
    Route::get('/{id}', 'TreeController@getTree')->where(['id' => '[0-9]+']);
});
Route::group(['prefix' => 'research', 'namespace' => 'Research'], function() {
    Route::get('/', 'ResearchController@getIndex');
    Route::get('/{id}', 'ResearchController@getResearch')->where(['id' => '[0-9]+']);
});
Route::group(['prefix' => 'adoptions'], function() {
    Route::get('/', 'AdoptionController@getAdoption');
    Route::get('{id}/{stockId}', 'AdoptionController@getAdoptionStock')->where(['id' => '[0-9]+', 'stockId' => '[0-9]+']);
});
Route::get('event-tracking', 'PromptsController@getEventTracking');

/**************************************************************************************************
    Site Pages
**************************************************************************************************/
Route::get('credits', 'PageController@getCreditsPage');
Route::get('info/{key}', 'PageController@getPage');
Route::get('world/info/{key}', 'PageController@getPageSection');

/**************************************************************************************************
    Raffles
**************************************************************************************************/
Route::group(['prefix' => 'raffles'], function () {
    Route::get('/', 'RaffleController@getRaffleIndex');
    Route::get('view/{id}', 'RaffleController@getRaffleTickets');
});

/**************************************************************************************************
    Submissions
**************************************************************************************************/
Route::group(['prefix' => 'submissions', 'namespace' => 'Users'], function() {
    Route::get('view/{id}', 'SubmissionController@getSubmission');
});
Route::group(['prefix' => 'claims', 'namespace' => 'Users'], function() {
    Route::get('view/{id}', 'SubmissionController@getClaim');
});
Route::group(['prefix' => 'surrender'], function() {
    Route::get('view/{id}', 'SurrenderController@getPublicSurrender');
});

/**************************************************************************************************
    Comments
**************************************************************************************************/
Route::get('comment/{id}', 'PermalinkController@getComment');

/**************************************************************************************************
    Galleries
**************************************************************************************************/
Route::group(['prefix' => 'gallery'], function() {
    Route::get('/', 'GalleryController@getGalleryIndex');
    Route::get('{id}', 'GalleryController@getGallery');
    Route::get('view/{id}', 'GalleryController@getSubmission');
    Route::get('view/favorites/{id}', 'GalleryController@getSubmissionFavorites');
});

/**************************************************************************************************
    Reports
**************************************************************************************************/
Route::group(['prefix' => 'reports', 'namespace' => 'Users'], function() {
    Route::get('/bug-reports', 'ReportController@getBugIndex');
});

/**************************************************************************************************
    World Expansion
**************************************************************************************************/

Route::group(['prefix' => 'world', 'namespace' => 'WorldExpansion'], function() {

    Route::get('info', 'LocationController@getWorld');
    Route::get('locations', 'LocationController@getLocations');
    Route::get('locations/{id}', 'LocationController@getLocation');
    Route::get('location-types', 'LocationController@getLocationTypes');
    Route::get('location-types/{id}', 'LocationController@getLocationType');

    Route::get('faunas', 'NatureController@getFaunas');
    Route::get('faunas/{id}', 'NatureController@getFauna');
    Route::get('fauna-categories', 'NatureController@getFaunaCategories');
    Route::get('fauna-categories/{id}', 'NatureController@getFaunaCategory');

    Route::get('floras', 'NatureController@getFloras');
    Route::get('floras/{id}', 'NatureController@getFlora');
    Route::get('flora-categories', 'NatureController@getFloraCategories');
    Route::get('flora-categories/{id}', 'NatureController@getFloraCategory');

    Route::get('events', 'EventController@getEvents');
    Route::get('events/{id}', 'EventController@getEvent');
    Route::get('event-categories', 'EventController@getEventCategories');
    Route::get('event-categories/{id}', 'EventController@getEventCategory');

    Route::get('figures', 'FigureController@getFigures');
    Route::get('figures/{id}', 'FigureController@getFigure');
    Route::get('figure-categories', 'FigureController@getFigureCategories');
    Route::get('figure-categories/{id}', 'FigureController@getFigureCategory');

    Route::get('info', 'FactionController@getWorld');
    Route::get('factions', 'FactionController@getFactions');
    Route::get('factions/{id}', 'FactionController@getFaction');
    Route::get('faction-types', 'FactionController@getFactionTypes');
    Route::get('faction-types/{id}', 'FactionController@getFactionType');

    Route::get('concepts', 'ConceptController@getConcepts');
    Route::get('concepts/{id}', 'ConceptController@getConcept');
    Route::get('concept-categories', 'ConceptController@getConceptCategories');
    Route::get('concept-categories/{id}', 'ConceptController@getConceptCategory');
});


