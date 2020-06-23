<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Core\Models\User;
use LaravelEnso\TrackWho\Traits\DeletedBy;
use Tests\TestCase;

class DeletedByTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->createTestModelsTable()
            ->actingAs(User::first());
    }

    /** @test */
    public function adds_deleted_by_when_deleting_model()
    {
        DeletedByTestModel::create()
            ->delete();

        $testModel = DeletedByTestModel::withTrashed()->first();

        $this->assertEquals(Auth::id(), $testModel->deleted_by);
    }

    private function createTestModelsTable()
    {
        Schema::create('deleted_by_test_models', function ($table) {
            $table->increments('id');
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        return $this;
    }
}

class DeletedByTestModel extends Model
{
    use SoftDeletes, DeletedBy;
}
