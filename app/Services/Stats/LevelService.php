<?php namespace App\Services\Stats;

use App\Services\Service;

use DB;
use Config;

use App\Models\Stats\User\Level;
use App\Models\Stats\Character\CharacterLevel;
use App\Models\Item\Item;

class LevelService extends Service
{
 /**
     * Creates a new level.
     *
     */
    public function createLevel($data)
    {
        DB::beginTransaction();

        try {

            $level = Level::create($data);

            return $this->commitReturn($level);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a level.
     *
     */
    public function updateLevel($level, $data)
    {
        DB::beginTransaction();

        try {

            $level->update($data);

            return $this->commitReturn($level);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
    
    /**
     * Deletes a level.
     *
     */
    public function deleteLevel($level)
    {
        DB::beginTransaction();

        try {

            // Check first if the level is currently owned or if some other site feature uses it
            if(DB::table('user_levels')->where('current_level', '>=', $level->level)->exists()) throw new \Exception("At least one user has already reached this level.");
            if(DB::table('prompts')->where('level_req', '>=', $level->level)->exists()) throw new \Exception("A prompt currently has this level as a requirement.");

            $level->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /*******************************************************************************
     * 
     *  CHARACTERS
     ******************************************************************************/
    /**
     * Creates a new level.
     *
     */
    public function createCharaLevel($data)
    {
        DB::beginTransaction();

        try {

            $level = CharacterLevel::create($data);

            return $this->commitReturn($level);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a level.
     *
     */
    public function updateCharaLevel($level, $data)
    {
        DB::beginTransaction();

        try {

            $level->update($data);

            return $this->commitReturn($level);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
    
    /**
     * Deletes a level.
     *
     */
    public function deleteCharaLevel($level)
    {
        DB::beginTransaction();

        try {
            // Check first if the level is currently owned or if some other site feature uses it
            if(DB::table('character_levels')->where('current_level', '>=', $level->level)->exists()) throw new \Exception("At least one character has already reached this level.");
            $level->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}