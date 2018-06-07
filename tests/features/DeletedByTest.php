<?php

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TestHelper\app\Traits\SignIn;
use LaravelEnso\TrackWho\app\Traits\DeletedBy;
use Tests\TestCase;

class DeletedByTest extends TestCase
{
    use RefreshDatabase, SignIn;

    protected $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->createTestModelsTable();
        $this->signIn();
    }

    /** @test */
    public function adds_deleted_by_when_deleting_model()
    {
        $testModel = DeletedByTestModel::create();

        $testModel->delete();

        $testModel = DeletedByTestModel::withTrashed()
            ->first();

        $this->assertEquals(
            auth()->user()->fresh(),
            $testModel->deletedBy
        );
    }

    private function createTestModelsTable()
    {
        Schema::create('deleted_by_test_models', function ($table) {
            $table->increments('id');
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
}

class DeletedByTestModel extends Model
{
    use SoftDeletes, DeletedBy;
}
