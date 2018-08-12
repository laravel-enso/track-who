<?php

use App\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\TestHelper\app\Traits\SignIn;
use LaravelEnso\TrackWho\app\Traits\UpdatedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatedByTest extends TestCase
{
    use RefreshDatabase, SignIn;

    private $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->createTestModelsTable();
    }

    /** @test */
    public function adds_updated_by_when_updating_model()
    {
        $this->signIn(User::first());

        $testModel = UpdatedByTestModel::create(['name' => 'initial']);

        $testModel->update(['name' => 'changed']);

        $this->assertEquals(
            auth()->user()->id,
            $testModel->fresh()->updated_by
        );
    }

    private function createTestModelsTable()
    {
        Schema::create('updated_by_test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }
}

class UpdatedByTestModel extends Model
{
    use UpdatedBy;

    protected $fillable = ['name'];
}
