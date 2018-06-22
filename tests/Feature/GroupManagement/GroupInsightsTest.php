<?php

namespace Tests\Feature\Groups;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class GroupInsightsTest extends TestCase
{
    use DatabaseMigrations;
    use WithAccountSetup;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->addAccount();

        $this->pages = [
            '/insights/analytics',
            '/insights/feedback',
            '/insights/history',
            '/insights/praise',
            '/insights/exceptions'
        ];

    }

    /** @test */
    public function facilitator_can_view_page()
    {
        foreach ($this->pages as $page) {
            $this->givenLoggedInUser($this->facilitator)
                ->get($page)
                ->assertSuccessful();
        }
    }

    /** @test */
    public function non_facilitator_cannot_view_pages()
    {
        foreach ($this->pages as $page) {
            $this->givenLoggedInUser($this->member)
                ->get($page)
                ->assertStatus(403);

            $this->givenLoggedInUser($this->manager)
                ->get($page)
                ->assertStatus(403);

            $this->givenLoggedInUser($this->other_member)
                ->get($page)
                ->assertStatus(403);
        }
    }
}
