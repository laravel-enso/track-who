<?php

use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatedByTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->createTestModelsTable()
            ->actingAs(User::first());
    }

    /** @test */
    public function adds_created_by_when_creating_model()
    {
        $testModel = CreatedByTestModel::create();

        $this->assertEquals(
            auth()->user()->id,
            $testModel->created_by
        );
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
