<?php

namespace Tests\Unit\Actions;

use App\Actions\StoreUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreUserTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function it_can_store_a_user(): void
    {
        $storeUser = new StoreUser();

        $result = $storeUser([
            'email' => 'new.user@email.com',
            'password' => 'password'
        ]);

        $this->assertInstanceOf(User::class, $result);
    }

    /** @test */
    public function it_returns_false_if_the_user_data_is_invalid(): void
    {
        $storeUser = new StoreUser();

        $result = $storeUser([
            'email' => 'new.user@email.com',
        ]);

        $this->assertFalse($result);
    }
}
