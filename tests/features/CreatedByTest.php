<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TrackWho\Traits\CreatedBy;
use Tests\TestCase;

class CreatedByTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $userModel = Config::get('auth.providers.users.model');

        $this->seed()
            ->createTestModelsTable()
            ->actingAs($userModel::first());
    }

    /** @test */
    public function adds_created_by_when_creating_model()
    {
        $testModel = CreatedByTestModel::create();

        $this->assertEquals(Auth::id(), $testModel->created_by);
    }

    private function createTestModelsTable()
    {
        Schema::create('created_by_test_models', function ($table) {
            $table->increments('id');
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        return $this;
    }
}

class CreatedByTestModel extends Model
{
    use CreatedBy;
}
