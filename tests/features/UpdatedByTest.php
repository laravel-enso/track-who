<?php

use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\TrackWho\app\Traits\UpdatedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatedByTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->createTestModelsTable()
            ->actingAs(User::first());
    }

    /** @test */
    public function adds_updated_by_when_updating_model()
    {
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

        return $this;
    }
}

class UpdatedByTestModel extends Model
{
    use UpdatedBy;

    protected $fillable = ['name'];
}
