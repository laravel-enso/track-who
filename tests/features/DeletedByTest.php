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
        $createdTestModel = DeletedByTestModel::create([
            'name' => $this->faker->word,
        ]);

        $createdTestModel->delete();

        $this->assertTrue($createdTestModel->trashed());
    }

    private function createTestModelsTable()
    {
        Schema::create('deleted_by_test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
}

class DeletedByTestModel extends Model
{
    use SoftDeletes, DeletedBy;

    protected $fillable = ['name'];
    protected $dates = ['deleted_at'];
}
