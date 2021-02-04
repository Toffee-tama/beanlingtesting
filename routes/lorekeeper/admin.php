<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for users with powers.
|
*/

Route::get('/', 'HomeController@getIndex');

Route::group(['prefix' => 'users', 'namespace' => 'Users'], function() {

    # USER LIST
    Route::group(['middleware' => 'power:edit_user_info'], function() {
        Route::get('/', 'UserController@getIndex');

        Route::get('{name}/edit', 'UserController@getUser');
        Route::post('{name}/basic', 'UserController@postUserBasicInfo');
        Route::post('{name}/alias/{id}', 'UserController@postUserAlias');
        Route::post('{name}/account', 'UserController@postUserAccount');
        Route::get('{name}/updates', 'UserController@getUserUpdates');
        Route::get('{name}/ban', 'UserController@getBan');
        Route::get('{name}/ban-confirm', 'UserController@getBanConfirmation');
        Route::post('{name}/ban', 'UserController@postBan');
        Route::get('{name}/unban-confirm', 'UserController@getUnbanConfirmation');
        Route::post('{name}/unban', 'UserController@postUnban');
    });

    # RANKS
    Route::group(['middleware' => 'admin'], function() {
        Route::get('ranks', 'RankController@getIndex');
        Route::get('ranks/create', 'RankController@getCreateRank');
        Route::get('ranks/edit/{id}', 'RankController@getEditRank');
        Route::get('ranks/delete/{id}', 'RankController@getDeleteRank');
        Route::post('ranks/create', 'RankController@postCreateEditRank');
        Route::post('ranks/edit/{id?}', 'RankController@postCreateEditRank');
        Route::post('ranks/delete/{id}', 'RankController@postDeleteRank');
        Route::post('ranks/sort', 'RankController@postSortRanks');
    });
});

# SETTINGS
Route::group(['prefix' => 'invitations', 'middleware' => 'power:edit_site_settings'], function() {
    Route::get('/', 'InvitationController@getIndex');

    Route::post('create', 'InvitationController@postGenerateKey');
    Route::post('delete/{id}', 'InvitationController@postDeleteKey');
});

# FILE MANAGER
Route::group(['prefix' => 'files', 'middleware' => 'power:edit_site_settings'], function() {
    Route::get('/{folder?}', 'FileController@getIndex');

    Route::post('upload', 'FileController@postUploadFile');
    Route::post('move', 'FileController@postMoveFile');
    Route::post('rename', 'FileController@postRenameFile');
    Route::post('delete', 'FileController@postDeleteFile');
    Route::post('folder/create', 'FileController@postCreateFolder');
    Route::post('folder/delete', 'FileController@postDeleteFolder');
    Route::post('folder/rename', 'FileController@postRenameFolder');
});

# SITE IMAGES
Route::group(['prefix' => 'images', 'middleware' => 'power:edit_site_settings'], function() {
    Route::get('/', 'FileController@getSiteImages');

    Route::post('upload/css', 'FileController@postUploadCss');
    Route::post('upload', 'FileController@postUploadImage');
    Route::post('reset', 'FileController@postResetFile');
});

# DATA
Route::group(['prefix' => 'data', 'namespace' => 'Data', 'middleware' => 'power:edit_data'], function() {

    # GALLERIES
    Route::get('galleries', 'GalleryController@getIndex');
    Route::get('galleries/create', 'GalleryController@getCreateGallery');
    Route::get('galleries/edit/{id}', 'GalleryController@getEditGallery');
    Route::get('galleries/delete/{id}', 'GalleryController@getDeleteGallery');
    Route::post('galleries/create', 'GalleryController@postCreateEditGallery');
    Route::post('galleries/edit/{id?}', 'GalleryController@postCreateEditGallery');
    Route::post('galleries/delete/{id}', 'GalleryController@postDeleteGallery');
    Route::post('galleries/sort', 'GalleryController@postSortGallery');

    # CURRENCIES
    Route::get('currencies', 'CurrencyController@getIndex');
    Route::get('currencies/sort', 'CurrencyController@getSort');
    Route::get('currencies/create', 'CurrencyController@getCreateCurrency');
    Route::get('currencies/edit/{id}', 'CurrencyController@getEditCurrency');
    Route::get('currencies/delete/{id}', 'CurrencyController@getDeleteCurrency');
    Route::post('currencies/create', 'CurrencyController@postCreateEditCurrency');
    Route::post('currencies/edit/{id?}', 'CurrencyController@postCreateEditCurrency');
    Route::post('currencies/delete/{id}', 'CurrencyController@postDeleteCurrency');
    Route::post('currencies/sort/{type}', 'CurrencyController@postSortCurrency')->where('type', 'user|character');

    # RARITIES
    Route::get('rarities', 'RarityController@getIndex');
    Route::get('rarities/create', 'RarityController@getCreateRarity');
    Route::get('rarities/edit/{id}', 'RarityController@getEditRarity');
    Route::get('rarities/delete/{id}', 'RarityController@getDeleteRarity');
    Route::post('rarities/create', 'RarityController@postCreateEditRarity');
    Route::post('rarities/edit/{id?}', 'RarityController@postCreateEditRarity');
    Route::post('rarities/delete/{id}', 'RarityController@postDeleteRarity');
    Route::post('rarities/sort', 'RarityController@postSortRarity');

    # SPECIES
    Route::get('species', 'SpeciesController@getIndex');
    Route::get('species/create', 'SpeciesController@getCreateSpecies');
    Route::get('species/edit/{id}', 'SpeciesController@getEditSpecies');
    Route::get('species/delete/{id}', 'SpeciesController@getDeleteSpecies');
    Route::post('species/create', 'SpeciesController@postCreateEditSpecies');
    Route::post('species/edit/{id?}', 'SpeciesController@postCreateEditSpecies');
    Route::post('species/delete/{id}', 'SpeciesController@postDeleteSpecies');
    Route::post('species/sort', 'SpeciesController@postSortSpecies');

    Route::get('subtypes', 'SpeciesController@getSubtypeIndex');
    Route::get('subtypes/create', 'SpeciesController@getCreateSubtype');
    Route::get('subtypes/edit/{id}', 'SpeciesController@getEditSubtype');
    Route::get('subtypes/delete/{id}', 'SpeciesController@getDeleteSubtype');
    Route::post('subtypes/create', 'SpeciesController@postCreateEditSubtype');
    Route::post('subtypes/edit/{id?}', 'SpeciesController@postCreateEditSubtype');
    Route::post('subtypes/delete/{id}', 'SpeciesController@postDeleteSubtype');
    Route::post('subtypes/sort', 'SpeciesController@postSortSubtypes');

    Route::get('character-drops', 'SpeciesController@getDropIndex');
    Route::get('character-drops/create', 'SpeciesController@getCreateDrop');
    Route::get('character-drops/edit/{id}', 'SpeciesController@getEditDrop');
    Route::get('character-drops/delete/{id}', 'SpeciesController@getDeleteDrop');
    Route::post('character-drops/create', 'SpeciesController@postCreateEditDrop');
    Route::post('character-drops/edit/{id?}', 'SpeciesController@postCreateEditDrop');
    Route::post('character-drops/delete/{id}', 'SpeciesController@postDeleteDrop');

    # ITEMS
    Route::get('item-categories', 'ItemController@getIndex');
    Route::get('item-categories/create', 'ItemController@getCreateItemCategory');
    Route::get('item-categories/edit/{id}', 'ItemController@getEditItemCategory');
    Route::get('item-categories/delete/{id}', 'ItemController@getDeleteItemCategory');
    Route::post('item-categories/create', 'ItemController@postCreateEditItemCategory');
    Route::post('item-categories/edit/{id?}', 'ItemController@postCreateEditItemCategory');
    Route::post('item-categories/delete/{id}', 'ItemController@postDeleteItemCategory');
    Route::post('item-categories/sort', 'ItemController@postSortItemCategory');

    Route::get('items', 'ItemController@getItemIndex');
    Route::get('items/create', 'ItemController@getCreateItem');
    Route::get('items/edit/{id}', 'ItemController@getEditItem');
    Route::get('items/delete/{id}', 'ItemController@getDeleteItem');
    Route::post('items/create', 'ItemController@postCreateEditItem');
    Route::post('items/edit/{id?}', 'ItemController@postCreateEditItem');
    Route::post('items/delete/{id}', 'ItemController@postDeleteItem');

    Route::get('items/delete-tag/{id}/{tag}', 'ItemController@getDeleteItemTag');
    Route::post('items/delete-tag/{id}/{tag}', 'ItemController@postDeleteItemTag');
    Route::get('items/tag/{id}/{tag}', 'ItemController@getEditItemTag');
    Route::post('items/tag/{id}/{tag}', 'ItemController@postEditItemTag');
    Route::get('items/tag/{id}', 'ItemController@getAddItemTag');
    Route::post('items/tag/{id}', 'ItemController@postAddItemTag');

    # PETS
    Route::get('pet-categories', 'PetController@getIndex');
    Route::get('pet-categories/create', 'PetController@getCreatePetCategory');
    Route::get('pet-categories/edit/{id}', 'PetController@getEditPetCategory');
    Route::get('pet-categories/delete/{id}', 'PetController@getDeletePetCategory');
    Route::post('pet-categories/create', 'PetController@postCreateEditPetCategory');
    Route::post('pet-categories/edit/{id?}', 'PetController@postCreateEditPetCategory');
    Route::post('pet-categories/delete/{id}', 'PetController@postDeletePetCategory');
    Route::post('pet-categories/sort', 'PetController@postSortPetCategory');

    Route::get('pets', 'PetController@getPetIndex');
    Route::get('pets/create', 'PetController@getCreatePet');
    Route::get('pets/edit/{id}', 'PetController@getEditPet');
    Route::get('pets/delete/{id}', 'PetController@getDeletePet');
    Route::post('pets/create', 'PetController@postCreateEditPet');
    Route::post('pets/edit/{id?}', 'PetController@postCreateEditPet');
    Route::post('pets/delete/{id}', 'PetController@postDeletePet');
    
    # AWARDS
    Route::get('award-categories', 'AwardController@getIndex');
    Route::get('award-categories/create', 'AwardController@getCreateAwardCategory');
    Route::get('award-categories/edit/{id}', 'AwardController@getEditAwardCategory');
    Route::get('award-categories/delete/{id}', 'AwardController@getDeleteAwardCategory');
    Route::post('award-categories/create', 'AwardController@postCreateEditAwardCategory');
    Route::post('award-categories/edit/{id?}', 'AwardController@postCreateEditAwardCategory');
    Route::post('award-categories/delete/{id}', 'AwardController@postDeleteAwardCategory');
    Route::post('award-categories/sort', 'AwardController@postSortAwardCategory');

    Route::get('awards', 'AwardController@getAwardIndex');
    Route::get('awards/create', 'AwardController@getCreateAward');
    Route::get('awards/edit/{id}', 'AwardController@getEditAward');
    Route::get('awards/delete/{id}', 'AwardController@getDeleteAward');
    Route::post('awards/create', 'AwardController@postCreateEditAward');
    Route::post('awards/edit/{id?}', 'AwardController@postCreateEditAward');
    Route::post('awards/delete/{id}', 'AwardController@postDeleteAward');

    Route::get('awards/delete-tag/{id}/{tag}', 'AwardController@getDeleteAwardTag');
    Route::post('awards/delete-tag/{id}/{tag}', 'AwardController@postDeleteAwardTag');
    Route::get('awards/tag/{id}/{tag}', 'AwardController@getEditAwardTag');
    Route::post('awards/tag/{id}/{tag}', 'AwardController@postEditAwardTag');
    Route::get('awards/tag/{id}', 'AwardController@getAddAwardTag');
    Route::post('awards/tag/{id}', 'AwardController@postAddAwardTag');

    # RECIPES
    Route::get('recipes', 'RecipeController@getRecipeIndex');
    Route::get('recipes/create', 'RecipeController@getCreateRecipe');
    Route::get('recipes/edit/{id}', 'RecipeController@getEditRecipe');
    Route::get('recipes/delete/{id}', 'RecipeController@getDeleteRecipe');
    Route::post('recipes/create', 'RecipeController@postCreateEditRecipe');
    Route::post('recipes/edit/{id?}', 'RecipeController@postCreateEditRecipe');
    Route::post('recipes/delete/{id}', 'RecipeController@postDeleteRecipe');
    
    # SHOPS
    Route::get('shops', 'ShopController@getIndex');
    Route::get('shops/create', 'ShopController@getCreateShop');
    Route::get('shops/edit/{id}', 'ShopController@getEditShop');
    Route::get('shops/delete/{id}', 'ShopController@getDeleteShop');
    Route::post('shops/create', 'ShopController@postCreateEditShop');
    Route::post('shops/edit/{id?}', 'ShopController@postCreateEditShop');
    Route::post('shops/stock/{id}', 'ShopController@postEditShopStock');
    Route::post('shops/delete/{id}', 'ShopController@postDeleteShop');
    Route::post('shops/sort', 'ShopController@postSortShop');
    Route::post('shops/restrictions/{id}', 'ShopController@postRestrictShop');

    # ADOPTIONS
    Route::get('adoptions', 'AdoptionController@getIndex');
    Route::get('stock', 'AdoptionController@getStockIndex');
    Route::get('adoptions/edit/{id}', 'AdoptionController@getEditAdoption');
    Route::get('stock/create', 'AdoptionController@getCreateStock');
    Route::get('stock/edit/{id}', 'AdoptionController@getEditStock');
    Route::post('adoptions/edit/{id?}', 'AdoptionController@postCreateEditAdoption');
    Route::post('stock/{id}', 'AdoptionController@postEditAdoptionStock');
    Route::post('stock/create/new', 'AdoptionController@postCreateStock');
    Route::post('stock/delete/{id}', 'AdoptionController@postDeleteStock');
    
    # FEATURES (TRAITS)
    Route::get('trait-categories', 'FeatureController@getIndex');
    Route::get('trait-categories/create', 'FeatureController@getCreateFeatureCategory');
    Route::get('trait-categories/edit/{id}', 'FeatureController@getEditFeatureCategory');
    Route::get('trait-categories/delete/{id}', 'FeatureController@getDeleteFeatureCategory');
    Route::post('trait-categories/create', 'FeatureController@postCreateEditFeatureCategory');
    Route::post('trait-categories/edit/{id?}', 'FeatureController@postCreateEditFeatureCategory');
    Route::post('trait-categories/delete/{id}', 'FeatureController@postDeleteFeatureCategory');
    Route::post('trait-categories/sort', 'FeatureController@postSortFeatureCategory');

    Route::get('traits', 'FeatureController@getFeatureIndex');
    Route::get('traits/create', 'FeatureController@getCreateFeature');
    Route::get('traits/edit/{id}', 'FeatureController@getEditFeature');
    Route::get('traits/delete/{id}', 'FeatureController@getDeleteFeature');
    Route::post('traits/create', 'FeatureController@postCreateEditFeature');
    Route::post('traits/edit/{id?}', 'FeatureController@postCreateEditFeature');
    Route::post('traits/delete/{id}', 'FeatureController@postDeleteFeature');

    # CHARACTER CATEGORIES
    Route::get('character-categories', 'CharacterCategoryController@getIndex');
    Route::get('character-categories/create', 'CharacterCategoryController@getCreateCharacterCategory');
    Route::get('character-categories/edit/{id}', 'CharacterCategoryController@getEditCharacterCategory');
    Route::get('character-categories/delete/{id}', 'CharacterCategoryController@getDeleteCharacterCategory');
    Route::post('character-categories/create', 'CharacterCategoryController@postCreateEditCharacterCategory');
    Route::post('character-categories/edit/{id?}', 'CharacterCategoryController@postCreateEditCharacterCategory');
    Route::post('character-categories/delete/{id}', 'CharacterCategoryController@postDeleteCharacterCategory');
    Route::post('character-categories/sort', 'CharacterCategoryController@postSortCharacterCategory');

    # SUB MASTERLISTS
    Route::get('sublists', 'SublistController@getIndex');
    Route::get('sublists/create', 'SublistController@getCreateSublist');
    Route::get('sublists/edit/{id}', 'SublistController@getEditSublist');
    Route::get('sublists/delete/{id}', 'SublistController@getDeleteSublist');
    Route::post('sublists/create', 'SublistController@postCreateEditSublist');
    Route::post('sublists/edit/{id?}', 'SublistController@postCreateEditSublist');
    Route::post('sublists/delete/{id}', 'SublistController@postDeleteSublist');
    Route::post('sublists/sort', 'SublistController@postSortSublist');

    # LOOT TABLES
    Route::get('loot-tables', 'LootTableController@getIndex');
    Route::get('loot-tables/create', 'LootTableController@getCreateLootTable');
    Route::get('loot-tables/edit/{id}', 'LootTableController@getEditLootTable');
    Route::get('loot-tables/delete/{id}', 'LootTableController@getDeleteLootTable');
    Route::get('loot-tables/roll/{id}', 'LootTableController@getRollLootTable');
    Route::post('loot-tables/create', 'LootTableController@postCreateEditLootTable');
    Route::post('loot-tables/edit/{id?}', 'LootTableController@postCreateEditLootTable');
    Route::post('loot-tables/delete/{id}', 'LootTableController@postDeleteLootTable');

    # PROMPTS
    Route::get('prompt-categories', 'PromptController@getIndex');
    Route::get('prompt-categories/create', 'PromptController@getCreatePromptCategory');
    Route::get('prompt-categories/edit/{id}', 'PromptController@getEditPromptCategory');
    Route::get('prompt-categories/delete/{id}', 'PromptController@getDeletePromptCategory');
    Route::post('prompt-categories/create', 'PromptController@postCreateEditPromptCategory');
    Route::post('prompt-categories/edit/{id?}', 'PromptController@postCreateEditPromptCategory');
    Route::post('prompt-categories/delete/{id}', 'PromptController@postDeletePromptCategory');
    Route::post('prompt-categories/sort', 'PromptController@postSortPromptCategory');

    Route::get('prompts', 'PromptController@getPromptIndex');
    Route::get('prompts/old', 'PromptController@getPromptIndexOld');
    Route::get('prompts/create', 'PromptController@getCreatePrompt');
    Route::get('prompts/edit/{id}', 'PromptController@getEditPrompt');
    Route::get('prompts/delete/{id}', 'PromptController@getDeletePrompt');
    Route::post('prompts/create', 'PromptController@postCreateEditPrompt');
    Route::post('prompts/edit/{id?}', 'PromptController@postCreateEditPrompt');
    Route::post('prompts/delete/{id}', 'PromptController@postDeletePrompt');
    Route::post('prompts/delete/{id}', 'PromptController@postDeletePrompt');

    # SCAVENGER HUNTS
    Route::get('hunts', 'HuntController@getHuntIndex');
    Route::get('hunts/create', 'HuntController@getCreateHunt');
    Route::get('hunts/edit/{id}', 'HuntController@getEditHunt');
    Route::get('hunts/delete/{id}', 'HuntController@getDeleteHunt');
    Route::post('hunts/create', 'HuntController@postCreateEditHunt');
    Route::post('hunts/edit/{id?}', 'HuntController@postCreateEditHunt');
    Route::post('hunts/delete/{id}', 'HuntController@postDeleteHunt');

    Route::get('hunts/targets/create/{id}', 'HuntController@getCreateHuntTarget');
    Route::post('hunts/targets/create', 'HuntController@postCreateEditHuntTarget');
    Route::get('hunts/targets/edit/{id}', 'HuntController@getEditHuntTarget');
    Route::post('hunts/targets/edit/{id}', 'HuntController@postCreateEditHuntTarget');
    Route::get('hunts/targets/delete/{id}', 'HuntController@getDeleteHuntTarget');
    Route::post('hunts/targets/delete/{id}', 'HuntController@postDeleteHuntTarget');

    # ADVENT
    Route::get('advent-calendars', 'AdventController@getAdventIndex');
    Route::get('advent-calendars/create', 'AdventController@getCreateAdvent');
    Route::get('advent-calendars/edit/{id}', 'AdventController@getEditAdvent');
    Route::get('advent-calendars/delete/{id}', 'AdventController@getDeleteAdvent');
    Route::post('advent-calendars/create', 'AdventController@postCreateEditAdvent');
    Route::post('advent-calendars/edit/{id?}', 'AdventController@postCreateEditAdvent');
    Route::post('advent-calendars/delete/{id}', 'AdventController@postDeleteAdvent');
});


# PAGES
Route::group(['prefix' => 'pages', 'middleware' => 'power:edit_pages'], function() {

    Route::get('/', 'PageController@getIndex');
    Route::get('create', 'PageController@getCreatePage');
    Route::get('edit/{id}', 'PageController@getEditPage');
    Route::get('delete/{id}', 'PageController@getDeletePage');
    Route::post('create', 'PageController@postCreateEditPage');
    Route::post('edit/{id?}', 'PageController@postCreateEditPage');
    Route::post('delete/{id}', 'PageController@postDeletePage');
});


# NEWS
Route::group(['prefix' => 'news', 'middleware' => 'power:edit_pages'], function() {

    Route::get('/', 'NewsController@getIndex');
    Route::get('create', 'NewsController@getCreateNews');
    Route::get('edit/{id}', 'NewsController@getEditNews');
    Route::get('delete/{id}', 'NewsController@getDeleteNews');
    Route::post('create', 'NewsController@postCreateEditNews');
    Route::post('edit/{id?}', 'NewsController@postCreateEditNews');
    Route::post('delete/{id}', 'NewsController@postDeleteNews');
});

# SALES
Route::group(['prefix' => 'sales', 'middleware' => 'power:edit_pages'], function() {

    Route::get('/', 'SalesController@getIndex');
    Route::get('create', 'SalesController@getCreateSales');
    Route::get('edit/{id}', 'SalesController@getEditSales');
    Route::get('delete/{id}', 'SalesController@getDeleteSales');
    Route::post('create', 'SalesController@postCreateEditSales');
    Route::post('edit/{id?}', 'SalesController@postCreateEditSales');
    Route::post('delete/{id}', 'SalesController@postDeleteSales');
});

# SITE SETTINGS
Route::group(['prefix' => 'settings', 'middleware' => 'power:edit_site_settings'], function() {
    Route::get('/', 'SettingsController@getIndex');
    Route::post('{key}', 'SettingsController@postEditSetting');
});

# GRANTS
Route::group(['prefix' => 'grants', 'namespace' => 'Users', 'middleware' => 'power:edit_inventories'], function() {
    Route::get('user-currency', 'GrantController@getUserCurrency');
    Route::post('user-currency', 'GrantController@postUserCurrency');

    Route::get('items', 'GrantController@getItems');
    Route::post('items', 'GrantController@postItems');

    Route::get('pets', 'GrantController@getPets');
    Route::post('pets', 'GrantController@postPets');
    
    Route::get('item-search', 'GrantController@getItemSearch');
    
    Route::get('exp', 'GrantController@getExp');
    Route::post('exp', 'GrantController@postExp');

    Route::get('event-currency', 'GrantController@getEventCurrency');
    Route::get('event-currency/clear', 'GrantController@getClearEventCurrency');
    Route::post('event-currency/clear', 'GrantController@postClearEventCurrency');
    
    Route::get('item-search', 'GrantController@getItemSearch');

    Route::get('recipes', 'GrantController@getRecipes');
    Route::post('recipes', 'GrantController@postRecipes');
});

# AWARD GRANTS
Route::group(['prefix' => 'grants', 'namespace' => 'Users', 'middleware' => 'power:edit_awardcases'], function() {
    
    Route::get('awards', 'GrantController@getAwards');
    Route::post('awards', 'GrantController@postAwards');
});

# MASTERLIST
Route::group(['prefix' => 'masterlist', 'namespace' => 'Characters', 'middleware' => 'power:manage_characters'], function() {
    Route::get('create-character', 'CharacterController@getCreateCharacter');
    Route::post('create-character', 'CharacterController@postCreateCharacter');

    Route::get('get-number', 'CharacterController@getPullNumber');

    Route::get('transfers/{type}', 'CharacterController@getTransferQueue');
    Route::get('transfer/{id}', 'CharacterController@getTransferInfo');
    Route::get('transfer/act/{id}/{type}', 'CharacterController@getTransferModal');
    Route::post('transfer/{id}', 'CharacterController@postTransferQueue');

    Route::get('trades/{type}', 'CharacterController@getTradeQueue');
    Route::get('trade/{id}', 'CharacterController@getTradeInfo');
    Route::get('trade/act/{id}/{type}', 'CharacterController@getTradeModal');
    Route::post('trade/{id}', 'CharacterController@postTradeQueue');

    Route::get('create-myo', 'CharacterController@getCreateMyo');
    Route::post('create-myo', 'CharacterController@postCreateMyo');

    Route::get('check-subtype', 'CharacterController@getCreateCharacterMyoSubtype');
    Route::get('check-group', 'CharacterController@getCreateCharacterMyoGroup');
});
Route::group(['prefix' => 'character', 'namespace' => 'Characters', 'middleware' => 'power:edit_inventories'], function() {
    Route::post('{slug}/grant', 'GrantController@postCharacterCurrency');
    Route::post('{slug}/grant-items', 'GrantController@postCharacterItems');
});
Route::group(['prefix' => 'character', 'namespace' => 'Characters', 'middleware' => 'power:manage_characters'], function() {

    # IMAGES
    Route::get('{slug}/image', 'CharacterImageController@getNewImage');
    Route::post('{slug}/image', 'CharacterImageController@postNewImage');
    Route::get('image/subtype', 'CharacterImageController@getNewImageSubtype');

    Route::get('image/{id}/traits', 'CharacterImageController@getEditImageFeatures');
    Route::post('image/{id}/traits', 'CharacterImageController@postEditImageFeatures');
    Route::get('image/traits/subtype', 'CharacterImageController@getEditImageSubtype');

    Route::get('image/{id}/notes', 'CharacterImageController@getEditImageNotes');
    Route::post('image/{id}/notes', 'CharacterImageController@postEditImageNotes');

    Route::get('image/{id}/credits', 'CharacterImageController@getEditImageCredits');
    Route::post('image/{id}/credits', 'CharacterImageController@postEditImageCredits');

    Route::get('image/{id}/reupload', 'CharacterImageController@getImageReupload');
    Route::post('image/{id}/reupload', 'CharacterImageController@postImageReupload');

    Route::post('image/{id}/settings', 'CharacterImageController@postImageSettings');

    Route::get('image/{id}/active', 'CharacterImageController@getImageActive');
    Route::post('image/{id}/active', 'CharacterImageController@postImageActive');

    Route::get('image/{id}/delete', 'CharacterImageController@getImageDelete');
    Route::post('image/{id}/delete', 'CharacterImageController@postImageDelete');

    Route::post('{slug}/images/sort', 'CharacterImageController@postSortImages');

    # CHARACTER
    Route::get('{slug}/stats', 'CharacterController@getEditCharacterStats');
    Route::post('{slug}/stats', 'CharacterController@postEditCharacterStats');

    Route::get('{slug}/description', 'CharacterController@getEditCharacterDescription');
    Route::post('{slug}/description', 'CharacterController@postEditCharacterDescription');

    Route::get('{slug}/profile', 'CharacterController@getEditCharacterProfile');
    Route::post('{slug}/profile', 'CharacterController@postEditCharacterProfile');

    Route::post('{slug}/drops', 'CharacterController@postEditCharacterDrop');

    Route::get('{slug}/delete', 'CharacterController@getCharacterDelete');
    Route::post('{slug}/delete', 'CharacterController@postCharacterDelete');

    Route::post('{slug}/settings', 'CharacterController@postCharacterSettings');

    Route::post('{slug}/transfer', 'CharacterController@postTransfer');

    # LINEAGE
    Route::get('{slug}/lineage', 'CharacterLineageController@getEditCharacterLineage');
    Route::post('{slug}/lineage', 'CharacterLineageController@postEditCharacterLineage');
});
// Might rewrite these parts eventually so there's less code duplication...
Route::group(['prefix' => 'myo', 'namespace' => 'Characters', 'middleware' => 'power:manage_characters'], function() {
    # CHARACTER
    Route::get('{id}/stats', 'CharacterController@getEditMyoStats');
    Route::post('{id}/stats', 'CharacterController@postEditMyoStats');

    Route::get('{id}/description', 'CharacterController@getEditMyoDescription');
    Route::post('{id}/description', 'CharacterController@postEditMyoDescription');

    Route::get('{id}/profile', 'CharacterController@getEditMyoProfile');
    Route::post('{id}/profile', 'CharacterController@postEditMyoProfile');

    Route::get('{id}/delete', 'CharacterController@getMyoDelete');
    Route::post('{id}/delete', 'CharacterController@postMyoDelete');

    Route::post('{id}/settings', 'CharacterController@postMyoSettings');

    Route::post('{id}/transfer', 'CharacterController@postMyoTransfer');

    # LINEAGE
    Route::get('{id}/lineage', 'CharacterLineageController@getEditMyoLineage');
    Route::post('{id}/lineage', 'CharacterLineageController@postEditMyoLineage');
});

# RAFFLES
Route::group(['prefix' => 'raffles', 'middleware' => 'power:manage_raffles'], function() {
    Route::get('/', 'RaffleController@getRaffleIndex');
    Route::get('edit/group/{id?}', 'RaffleController@getCreateEditRaffleGroup');
    Route::post('edit/group/{id?}', 'RaffleController@postCreateEditRaffleGroup');
    Route::get('edit/raffle/{id?}', 'RaffleController@getCreateEditRaffle');
    Route::post('edit/raffle/{id?}', 'RaffleController@postCreateEditRaffle');

    Route::get('view/{id}', 'RaffleController@getRaffleTickets');
    Route::post('view/ticket/{id}', 'RaffleController@postCreateRaffleTickets');
    Route::post('view/ticket/delete/{id}', 'RaffleController@postDeleteRaffleTicket');

    Route::get('roll/raffle/{id}', 'RaffleController@getRollRaffle');
    Route::post('roll/raffle/{id}', 'RaffleController@postRollRaffle');
    Route::get('roll/group/{id}', 'RaffleController@getRollRaffleGroup');
    Route::post('roll/group/{id}', 'RaffleController@postRollRaffleGroup');
});

# SUBMISSIONS
Route::group(['prefix' => 'submissions', 'middleware' => 'power:manage_submissions'], function() {
    Route::get('/', 'SubmissionController@getSubmissionIndex');
    Route::get('/{status}', 'SubmissionController@getSubmissionIndex')->where('status', 'pending|approved|rejected');
    Route::get('edit/{id}', 'SubmissionController@getSubmission');
    Route::post('edit/{id}/{action}', 'SubmissionController@postSubmission')->where('action', 'approve|reject');
});

# CLAIMS
Route::group(['prefix' => 'claims', 'middleware' => 'power:manage_submissions'], function() {
    Route::get('/', 'SubmissionController@getClaimIndex');
    Route::get('/{status}', 'SubmissionController@getClaimIndex')->where('status', 'pending|approved|rejected');
    Route::get('edit/{id}', 'SubmissionController@getClaim');
    Route::post('edit/{id}/{action}', 'SubmissionController@postSubmission')->where('action', 'approve|reject');
});

# SUBMISSIONS
Route::group(['prefix' => 'gallery', 'middleware' => 'power:manage_submissions'], function() {
    Route::get('/submissions', 'GalleryController@getSubmissionIndex');
    Route::get('/submissions/{status}', 'GalleryController@getSubmissionIndex')->where('status', 'pending|accepted|rejected');
    Route::get('/currency', 'GalleryController@getCurrencyIndex');
    Route::get('/currency/{status}', 'GalleryController@getCurrencyIndex')->where('status', 'pending|valued');
    Route::post('edit/{id}/{action}', 'GalleryController@postEditSubmission')->where('action', 'accept|reject|comment|move|value');
});

# SURRENDERS
Route::group(['prefix' => 'surrenders', 'middleware' => ['power:manage_submissions', 'power:manage_characters']], function() {
    Route::get('/', 'SurrenderController@getSurrenderIndex');
    Route::get('/{status}', 'SurrenderController@getSurrenderIndex')->where('status', 'pending|approved|rejected');
    Route::get('edit/{id}', 'SurrenderController@getSurrender');
    Route::post('edit/{id}/{action}', 'SurrenderController@postSurrender')->where('action', 'approve|reject');
});
# REPORTS
Route::group(['prefix' => 'reports', 'middleware' => 'power:manage_reports'], function() {
    Route::get('/', 'ReportController@getReportIndex');
    Route::get('/{status}', 'ReportController@getReportIndex')->where('status', 'pending|assigned|assigned-to-me|closed');
    Route::get('edit/{id}', 'ReportController@getReport');
    Route::post('edit/{id}/{action}', 'ReportController@postReport')->where('action', 'assign|close');
});

# DESIGN APPROVALS
Route::group(['prefix' => 'designs', 'middleware' => 'power:manage_characters'], function() {
    Route::get('edit/{id}/{action}', 'DesignController@getDesignConfirmation')->where('action', 'cancel|approve|reject');
    Route::post('edit/{id}/{action}', 'DesignController@postDesign')->where('action', 'cancel|approve|reject');

Route::get('{type}/{status}', 'DesignController@getDesignIndex')->where('type', 'myo-approvals|design-approvals')->where('status', 'pending|approved|rejected');
});
# STATS - STATS
Route::group(['prefix' => 'stats', 'namespace' => 'Stats', 'middleware' => 'power:edit_stats'], function() {
    // GET
    Route::get('/', 'StatController@getIndex');
    Route::get('/create', 'StatController@getCreateStat');
    Route::get('/edit/{id}', 'StatController@getEditStat');
    Route::get('/delete/{id}', 'StatController@getDeleteStat');
    // POST
    Route::post('/create', 'StatController@postCreateEditStat');
    Route::post('/edit/{id}', 'StatController@postCreateEditStat');
    Route::post('/delete/{id}', 'StatController@postDeleteStat');


});
# STATS - LEVELS
Route::group(['prefix' => 'levels', 'namespace' => 'Stats', 'middleware' => 'power:edit_levels'], function() {
    # USER 
    // GET
    Route::get('/', 'LevelController@getIndex');
    Route::get('/create', 'LevelController@getCreateLevel');
    Route::get('/edit/{id}', 'LevelController@getEditLevel');
    Route::get('/delete/{id}', 'LevelController@getDeleteLevel');
    // POST
    Route::post('/create', 'LevelController@postCreateEditLevel');
    Route::post('/edit/{id}', 'LevelController@postCreateEditLevel');
    Route::post('/delete/{id}', 'LevelController@postDeleteLevel');    
    # ---------------------------------------------
    # CHARACTER
    // GET
    Route::get('/character', 'LevelController@getCharaIndex');
    Route::get('character/create', 'LevelController@getCharaCreateLevel');
    Route::get('character/edit/{id}', 'LevelController@getCharaEditLevel');
    Route::get('character/delete/{id}', 'LevelController@getCharaDeleteLevel');
        // POST
    Route::post('character/create', 'LevelController@postCharaCreateEditLevel');
    Route::post('character/edit/{id}', 'LevelController@postCharaCreateEditLevel');
    Route::post('character/delete/{id}', 'LevelController@postCharaDeleteLevel');    
});
Route::get('{type}/{status}', 'DesignController@getDesignIndex')->where('type', 'myo-approvals|design-approvals')->where('status', 'pending|approved|rejected');
