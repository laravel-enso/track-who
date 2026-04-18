<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TrackWho\Traits\CreatedBy;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function adds_created_by_when_creating_model()
    {
        $testModel = CreatedByTestModel::create();

        $this->assertEquals(Auth::id(), $testModel->created_by);
    }

    #[Test]
    public function does_not_set_created_by_for_guests()
    {
        auth()->forgetGuards();

        $testModel = CreatedByTestModel::create();

        $this->assertNull($testModel->created_by);
    }

    #[Test]
    public function exposes_created_by_relation()
    {
        $testModel = CreatedByTestModel::create();

        $this->assertTrue($testModel->createdBy->is(Auth::user()));
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
