<?php

namespace Tests\Browser;

use App\Account;
use App\Group;
use App\Member;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class ProfileTest
 * These tests are incomplete and pending the front-end revamping.
 *
 * @package Tests\Browser
 * @todo
 */
class ProfileTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $group;

    public function setUp()
    {
        parent::setUp();

        $this->user = $this->create(User::class);
        $this->facilitator = $this->create(User::class);
        $this->manager = $this->create(User::class);

        $this->account = $this->create(Account::class, [
            'manager_id'=>$this->manager->id,
        ]);

        $this->group = $this->create(Group::class,[
            'account_id'=>1,
            'facilitator_id'=>2,
        ]);
        
        $this->member = $this->create(Member::class, [
            'group_id' => $this->group->id,
            'user_id' => $this->user->id,
        ]);

        $this->create(Member::class, [
            'group_id' => $this->group->id,
            'user_id' => $this->manager->id,
        ]);

        $this->create(Member::class, [
            'group_id' => $this->group->id,
            'user_id' => $this->facilitator->id,
        ]);

        $this->endpoint = "/groups/{$this->group->slug}/profiles";

    }

    /** @test */
    public function hit_first_page()
    {

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->assertSee('Menu');
        });
    }

    /** @test */
    public function a_group_member_can_submit_their_personal_background()
    {

        $this->browse(function (Browser $browser) {
    		$browser
                ->loginAs($this->user)
    			->visit($this->endpoint.'/'.$this->member->id.'/edit')
                ->type('#personal_bio', 'New Bio Going Here...')
                ->press('button')
                ->waitForText('Your personal background has been updated successfully.')
                ->assertSee('Your personal background has been updated successfully.');
    	});
    }

    /** @test */
    public function a_group_member_can_submit_their_professional_background()
    {

        $this->browse(function (Browser $browser) {
    		$browser
                ->loginAs($this->user)
                ->visit($this->endpoint.'/'.$this->member->id.'/edit')
                ->type('#company_name', 'New Business Name')
                ->type('#business_bio', 'New Company Bio Going Here...')
                ->press('button')
                ->waitForText('Your professional background has been updated successfully.')
                ->assertSee('Your professional background has been updated successfully.');
    	});
    }
    
    /** @test */
    public function a_group_member_can_submit_their_contact_information()
    {

        $this->browse(function (Browser $browser) {
    		$browser
                ->loginAs($this->user)
                ->visit($this->endpoint.'/'.$this->member->id.'/edit')
                ->type('#email', 'email@example.com')
                ->press('button')
                ->waitForText('Your contact information has been updated successfully.')
                ->assertSee('Your contact information has been updated successfully.');
    	});
    }

}
