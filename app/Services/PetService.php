<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\Pet\PetCategory;
use App\Models\Pet\Pet;

class PetService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Pet Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of pet categories and pets.
    |
    */

    /**********************************************************************************************
     
        PET CATEGORIES

    **********************************************************************************************/

    /**
     * Create a category.
     *
     * @param  array                 $data
     * @param  \App\Models\User\User $user
     * @return \App\Models\Pet\PetCategory|bool
     */
    public function createPetCategory($data, $user)
    {
        DB::beginTransaction();

        try {

            $data = $this->populateCategoryData($data);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }
            else $data['has_image'] = 0;

            $category = PetCategory::create($data);

            if ($image) $this->handleImage($image, $category->categoryImagePath, $category->categoryImageFileName);

            return $this->commitReturn($category);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Update a category.
     *
     * @param  \App\Models\Pet\PetCategory  $category
     * @param  array                          $data
     * @param  \App\Models\User\User          $user
     * @return \App\Models\Pet\PetCategory|bool
     */
    public function updatePetCategory($category, $data, $user)
    {
        DB::beginTransaction();

        try {
            // More specific validation
            if(PetCategory::where('name', $data['name'])->where('id', '!=', $category->id)->exists()) throw new \Exception("The name has already been taken.");

            $data = $this->populateCategoryData($data, $category);

            $image = null;            
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }

            $category->update($data);

            if ($category) $this->handleImage($image, $category->categoryImagePath, $category->categoryImageFileName);

            return $this->commitReturn($category);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Handle category data.
     *
     * @param  array                               $data
     * @param  \App\Models\Pet\PetCategory|null  $category
     * @return array
     */
    private function populateCategoryData($data, $category = null)
    {
        if(isset($data['description']) && $data['description']) $data['parsed_description'] = parse($data['description']);
        
        if(isset($data['remove_image']))
        {
            if($category && $category->has_image && $data['remove_image']) 
            { 
                $data['has_image'] = 0; 
                $this->deleteImage($category->categoryImagePath, $category->categoryImageFileName); 
            }
            unset($data['remove_image']);
        }

        return $data;
    }

    /**
     * Delete a category.
     *
     * @param  \App\Models\Pet\PetCategory  $category
     * @return bool
     */
    public function deletePetCategory($category)
    {
        DB::beginTransaction();

        try {
            // Check first if the category is currently in use
            if(Pet::where('pet_category_id', $category->id)->exists()) throw new \Exception("An pet with this category exists. Please change its category first.");
            
            if($category->has_image) $this->deleteImage($category->categoryImagePath, $category->categoryImageFileName); 
            $category->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Sorts category order.
     *
     * @param  array  $data
     * @return bool
     */
    public function sortPetCategory($data)
    {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach($sort as $key => $s) {
                PetCategory::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
    
    /**********************************************************************************************
     
        PETS

    **********************************************************************************************/

    /**
     * Creates a new pet.
     *
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\Pet\Pet
     */
    public function createPet($data, $user)
    {
        DB::beginTransaction();

        try {
            if(isset($data['pet_category_id']) && $data['pet_category_id'] == 'none') $data['pet_category_id'] = null;

            if((isset($data['pet_category_id']) && $data['pet_category_id']) && !PetCategory::where('id', $data['pet_category_id'])->exists()) throw new \Exception("The selected pet category is invalid.");

            $data = $this->populateData($data);

            $image = null;
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }
            else $data['has_image'] = 0;

            $pet = Pet::create($data);

            if ($image) $this->handleImage($image, $pet->imagePath, $pet->imageFileName);

            return $this->commitReturn($pet);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates an pet.
     *
     * @param  \App\Models\Pet\Pet  $pet
     * @param  array                  $data 
     * @param  \App\Models\User\User  $user
     * @return bool|\App\Models\Pet\Pet
     */
    public function updatePet($pet, $data, $user)
    {
        DB::beginTransaction();

        try {
            if(isset($data['pet_category_id']) && $data['pet_category_id'] == 'none') $data['pet_category_id'] = null;

            // More specific validation
            if(Pet::where('name', $data['name'])->where('id', '!=', $pet->id)->exists()) throw new \Exception("The name has already been taken.");
            if((isset($data['pet_category_id']) && $data['pet_category_id']) && !PetCategory::where('id', $data['pet_category_id'])->exists()) throw new \Exception("The selected pet category is invalid.");

            $data = $this->populateData($data);

            $image = null;            
            if(isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image = $data['image'];
                unset($data['image']);
            }

            $pet->update($data);

            if ($pet) $this->handleImage($image, $pet->imagePath, $pet->imageFileName);

            return $this->commitReturn($pet);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Processes user input for creating/updating an pet.
     *
     * @param  array                  $data 
     * @param  \App\Models\Pet\Pet  $pet
     * @return array
     */
    private function populateData($data, $pet = null)
    {
        if(isset($data['description']) && $data['description']) $data['parsed_description'] = parse($data['description']);
        
        if(!isset($data['allow_transfer'])) $data['allow_transfer'] = 0;

        if(isset($data['remove_image']))
        {
            if($pet && $pet->has_image && $data['remove_image']) 
            { 
                $data['has_image'] = 0; 
                $this->deleteImage($pet->imagePath, $pet->imageFileName); 
            }
            unset($data['remove_image']);
        }

        return $data;
    }
    
    /**
     * Deletes an pet.
     *
     * @param  \App\Models\Pet\Pet  $pet
     * @return bool
     */
    public function deletePet($pet)
    {
        DB::beginTransaction();

        try {
            // Check first if the pet is currently owned or if some other site feature uses it
            if(DB::table('user_pets')->where('pet_id', $pet->id)->exists()) throw new \Exception("At least one user currently owns this pet. Please remove the pet(s) before deleting it.");
            if(DB::table('loots')->where('rewardable_type', 'Pet')->where('rewardable_id', $pet->id)->exists()) throw new \Exception("A loot table currently distributes this pet as a potential reward. Please remove the pet before deleting it.");
            if(DB::table('prompt_rewards')->where('rewardable_type', 'Pet')->where('rewardable_id', $pet->id)->exists()) throw new \Exception("A prompt currently distributes this pet as a reward. Please remove the pet before deleting it.");
            //if(DB::table('shop_stock')->where('pet_id', $pet->id)->exists()) throw new \Exception("A shop currently stocks this pet. Please remove the pet before deleting it.");
            
            $pet->tags()->delete();
            if($pet->has_image) $this->deleteImage($pet->imagePath, $pet->imageFileName); 
            $pet->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}