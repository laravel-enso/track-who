<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\TrackWho\Traits\UpdatedBy;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatedByTest extends TestCase
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
    public function adds_updated_by_when_updating_model()
    {
        $testModel = UpdatedByTestModel::create(['name' => 'initial']);

        $testModel->update(['name' => 'changed']);

        $this->assertEquals(Auth::id(), $testModel->updated_by);
    }

    #[Test]
    public function sets_updated_by_when_creating_model()
    {
        $testModel = UpdatedByTestModel::create(['name' => 'initial']);

        $this->assertEquals(Auth::id(), $testModel->updated_by);
    }

    #[Test]
    public function does_not_set_updated_by_for_guests()
    {
        auth()->forgetGuards();

        $testModel = UpdatedByTestModel::create(['name' => 'initial']);

        $this->assertNull($testModel->updated_by);

        $testModel->update(['name' => 'changed']);

        $this->assertNull($testModel->fresh()->updated_by);
    }

    #[Test]
    public function exposes_updated_by_relation()
    {
        $testModel = UpdatedByTestModel::create(['name' => 'initial']);

        $this->assertTrue($testModel->updatedBy->is(Auth::user()));
    }

    #[Test]
    public function guest_updates_do_not_override_existing_updated_by()
    {
        $testModel = UpdatedByTestModel::create(['name' => 'initial']);
        $updatedBy = $testModel->updated_by;

        auth()->forgetGuards();

        $testModel->update(['name' => 'changed']);

        $this->assertSame($updatedBy, $testModel->fresh()->updated_by);
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
