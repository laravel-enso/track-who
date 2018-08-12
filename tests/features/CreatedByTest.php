<?php

use App\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\TestHelper\app\Traits\SignIn;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatedByTest extends TestCase
{
    use RefreshDatabase, SignIn;

    private $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->createTestModelsTable();
        $this->signIn(User::first());
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
            $table->integer('created_by')->unsigned();
            $table->timestamps();
        });
    }
}

class CreatedByTestModel extends Model
{
    use CreatedBy;
}
