<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class AddSiteSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-site-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds the default site settings.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('*********************');
        $this->info('* ADD SITE SETTINGS *');
        $this->info('*********************'."\n");

        $this->line("Adding site settings...existing entries will be skipped.\n");

        if(!DB::table('site_settings')->where('key', 'is_registration_open')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'is_registration_open',
                    'value' => 1,
                    'description' => '0: Registration closed, 1: Registration open. When registration is closed, invitation keys can still be used to register.'
                ]

            ]);
            $this->info("Added:   is_registration_open / Default: 1");
        }
        else $this->line("Skipped: is_registration_open");

        if(!DB::table('site_settings')->where('key', 'transfer_cooldown')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'transfer_cooldown',
                    'value' => 0,
                    'description' => 'Number of days to add to the cooldown timer when a character is transferred.'
                ]

            ]);
            $this->info("Added:   transfer_cooldown / Default: 0");
        }
        else $this->line("Skipped: transfer_cooldown");

        if(!DB::table('site_settings')->where('key', 'open_transfers_queue')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'open_transfers_queue',
                    'value' => 0,
                    'description' => '0: Character transfers do not need mod approval, 1: Transfers must be approved by a mod.'
                ]

            ]);
            $this->info("Added:   open_transfers_queue / Default: 0");
        }
        else $this->line("Skipped: open_transfers_queue");

        if(!DB::table('site_settings')->where('key', 'is_prompts_open')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'is_prompts_open',
                    'value' => 1,
                    'description' => '0: New prompt submissions cannot be made (mods can work on the queue still), 1: Prompts are submittable.'
                ]

            ]);
            $this->info("Added:   is_prompts_open / Default: 1");
        }
        else $this->line("Skipped: is_prompts_open");

        if(!DB::table('site_settings')->where('key', 'is_claims_open')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'is_claims_open',
                    'value' => 1,
                    'description' => '0: New claims cannot be made (mods can work on the queue still), 1: Claims are submittable.'
                ]

            ]);
            $this->info("Added:   is_claims_open / Default: 1");
        }
        else $this->line("Skipped: is_claims_open");

        if(!DB::table('site_settings')->where('key', 'is_reports_open')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'is_reports_open',
                    'value' => 1,
                    'description' => '0: New reports cannot be made (mods can work on the queue still), 1: Reports are submittable.'
                ]

            ]);
            $this->info("Added:   is_reports_open / Default: 1");
        }
        else $this->line("Skipped: is_reports_open");

        if(!DB::table('site_settings')->where('key', 'is_myos_open')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'is_myos_open',
                    'value' => 1,
                    'description' => '0: MYO slots cannot be submitted for design approval, 1: MYO slots can be submitted for approval.'
                ]

            ]);
            $this->info("Added:   is_myos_open / Default: 1");
        }
        else $this->line("Skipped: is_myos_open");
        
        if(!DB::table('site_settings')->where('key', 'is_surrenders_open')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'is_surrenders_open',
                    'value' => 1,
                    'description' => '0: Characters can not be surrendered by users to the adoption center, 1: Characters can be submitted to surrender queue.'
                ]

            ]);
            $this->info("Added:   is_surrenders_open / Default: 1");
        }
        else $this->line("Skipped: is_surrenders_open");

        if(!DB::table('site_settings')->where('key', 'calculate_by_traits')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'calculate_by_traits',
                    'value' => 0,
                    'description' => '0: Characters must have currency be added manually, 1: Characters are valued automaticall by traits. THIS MUST BE HARDCODED. The controller has been commented for ease.'
                ]

            ]);
            $this->info("Added:   calculate_by_traits / Default: 0");
        }
        else $this->line("Skipped: calculate_by_traits");

        if(!DB::table('site_settings')->where('key', 'is_design_updates_open')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'is_design_updates_open',
                    'value' => 1,
                    'description' => '0: Characters cannot be submitted for design update approval, 1: Characters can be submitted for design update approval.'
                ]

            ]);
            $this->info("Added:   is_design_updates_open / Default: 1");
        }
        else $this->line("Skipped: is_design_updates_open");

        if(!DB::table('site_settings')->where('key', 'blacklist_privacy')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'blacklist_privacy',
                    'value' => 0,
                    'description' => 'Who can view the blacklist? 0: Admin only, 1: Staff only, 2: Members only, 3: Public.'
                ]

            ]);
            $this->info("Added:   blacklist_privacy / Default: 0");
        }
        else $this->line("Skipped: blacklist_privacy");

        if(!DB::table('site_settings')->where('key', 'blacklist_link')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'blacklist_link',
                    'value' => 0,
                    'description' => '0: No link to the blacklist is displayed anywhere, 1: Link to the blacklist is shown on the user list.'
                ]

            ]);
            $this->info("Added:   blacklist_link / Default: 0");
        }
        else $this->line("Skipped: blacklist_link");

        if(!DB::table('site_settings')->where('key', 'blacklist_key')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'blacklist_key',
                    'value' => 0,
                    'description' => 'Optional key to view the blacklist. Enter "0" to not require one.'
                ]

            ]);
            $this->info("Added:   blacklist_key / Default: 0");
        }
        else $this->line("Skipped: blacklist_key");

        if(!DB::table('site_settings')->where('key', 'design_votes_needed')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'design_votes_needed',
                    'value' => 3,
                    'description' => 'Number of approval votes needed for a design update or MYO submission to be considered as having approval.'
                ]

            ]);
            $this->info("Added:   design_votes_needed / Default: 3");
        }
        else $this->line("Skipped: design_votes_needed");

        if(!DB::table('site_settings')->where('key', 'admin_user')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'admin_user',
                    'value' => 1,
                    'description' => 'ID of the site\'s admin user.'
                ]

            ]);
            $this->info("Added:   admin_user / Default: 1");
        }
        else $this->line("Skipped: admin_user");

        if(!DB::table('site_settings')->where('key', 'gallery_submissions_open')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'gallery_submissions_open',
                    'value' => 1,
                    'description' => '0: Gallery submissions closed, 1: Gallery submissions open.'
                ]

            ]);
            $this->info("Added:   gallery_submissions_open / Default: 1");
        }
        else $this->line("Skipped: gallery_submissions_open");

        if(!DB::table('site_settings')->where('key', 'gallery_submissions_require_approval')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'gallery_submissions_require_approval',
                    'value' => 1,
                    'description' => '0: Gallery submissions do not require approval, 1: Gallery submissions require approval.'
                ]

            ]);
            $this->info("Added:   gallery_submissions_require_approval / Default: 1");
        }
        else $this->line("Skipped: gallery_submissions_require_approval");

        if(!DB::table('site_settings')->where('key', 'gallery_submissions_reward_currency')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'gallery_submissions_reward_currency',
                    'value' => 0,
                    'description' => '0: Gallery submissions do not reward currency, 1: Gallery submissions reward currency.'
                ]

            ]);
            $this->info("Added:   gallery_submissions_reward_currency / Default: 0");
        }
        else $this->line("Skipped: gallery_submissions_reward_currency");

        if(!DB::table('site_settings')->where('key', 'group_currency')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'group_currency',
                    'value' => 1,
                    'description' => 'ID of the group currency to award from gallery submissions (if enabled).'
                ]

            ]);
            $this->info("Added:   group_currency / Default: 1");
        }
        else $this->line("Skipped: group_currency");
        if(!DB::table('site_settings')->where('key', 'coupon_settings')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'coupon_settings',
                    'value' => 0,
                    'description' => '0: Percentage is taken from total (e.g 20% from 2 items costing a total of 100 = 80), 1: Percentage is taken from item (e.g 20% from 2 items costing a total of 100 = 90)'
                ]

            ]);
            $this->info("Added:   coupon_settings / Default: 0");
        }
        else $this->line("Skipped: limited_stock_coupon_settings");

        if(!DB::table('site_settings')->where('key', 'limited_stock_coupon_settings')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'limited_stock_coupon_settings',
                    'value' => 0,
                    'description' => '0: Does not allow coupons to be used on limited stock items, 1: Allows coupons to be used on limited stock items'
                ]

            ]);
            $this->info("Added:   limited_stock_coupon_settings / Default: 0");
        }
        else $this->line("Skipped: limited_stock_coupon_settings");
        if(!DB::table('site_settings')->where('key', 'adopts_user')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'adopts_user',
                    'value' => 1,
                    'description' => 'ID of the site\'s adoption center user.'
                ]

            ]);
            $this->info("Added:   adopts_user / Default: 1");
        }
        else $this->line("Skipped: adopts_user");

        if(!DB::table('site_settings')->where('key', 'character_title_display')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'character_title_display',
                    'value' => 0,
                    'description' => '0: Characters\' titles only display in their image info. 1: Characters\'s titles display alongside their category, species, rarity.'
                ]

            ]);
            $this->info("Added:   character_title_display / Default: 0");
        }
        else $this->line("Skipped: character_title_display");

        if(!DB::table('site_settings')->where('key', 'event_currency')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'event_currency',
                    'value' => 1,
                    'description' => 'ID of the currency used for events.'
                ]

            ]);
            $this->info("Added:   event_currency / Default: 1");
        }
        else $this->line("Skipped: event_currency");

        if(!DB::table('site_settings')->where('key', 'global_event_score')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'global_event_score',
                    'value' => 0,
                    'description' => '0: Event currency is only tracked individually, 1: A global tally of all event currency is also kept.'
                ]

            ]);
            $this->info("Added:   global_event_score / Default: 0");
        }
        else $this->line("Skipped: global_event_score");

        if(!DB::table('site_settings')->where('key', 'global_event_goal')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'global_event_goal',
                    'value' => 0,
                    'description' => 'Goal for global event score. Has no effect if global event score is not 1 and/or if set to 0.'
                ]

            ]);
            $this->info("Added:   global_event_goal / Default: 0");
        }
        else $this->line("Skipped: global_event_goal");

        if(!DB::table('site_settings')->where('key', 'group_currency_alt')->exists()) {
            DB::table('site_settings')->insert([
                [
                    'key' => 'group_currency_alt',
                    'value' => 1,
                    'description' => 'ID of the alternate group currency to award from gallery submissions (if enabled).'
                ]

            ]);
            $this->info("Added:   group_currency_alt / Default: 1");
        }
        else $this->line("Skipped: group_currency_alt");

        $this->line("\nSite settings up to date!");

    }
}
