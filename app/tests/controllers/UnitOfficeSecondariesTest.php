<?php

use Mockery as m;
use Way\Tests\Factory;

class UnitOfficeSecondariesTest extends TestCase {

	public function __construct()
	{
		$this->mock = m::mock('Eloquent', 'Unit_office_secondary');
		$this->collection = m::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();
	}

	public function setUp()
	{
		parent::setUp();

		$this->attributes = Factory::unit_office_secondary(['id' => 1]);
		$this->app->instance('Unit_office_secondary', $this->mock);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testIndex()
	{
		$this->mock->shouldReceive('all')->once()->andReturn($this->collection);
		$this->call('GET', 'unit_office_secondaries');

		$this->assertViewHas('unit_office_secondaries');
	}

	public function testCreate()
	{
		$this->call('GET', 'unit_office_secondaries/create');

		$this->assertResponseOk();
	}

	public function testStore()
	{
		$this->mock->shouldReceive('create')->once();
		$this->validate(true);
		$this->call('POST', 'unit_office_secondaries');

		$this->assertRedirectedToRoute('unit_office_secondaries.index');
	}

	public function testStoreFails()
	{
		$this->mock->shouldReceive('create')->once();
		$this->validate(false);
		$this->call('POST', 'unit_office_secondaries');

		$this->assertRedirectedToRoute('unit_office_secondaries.create');
		$this->assertSessionHasErrors();
		$this->assertSessionHas('message');
	}

	public function testShow()
	{
		$this->mock->shouldReceive('findOrFail')
				   ->with(1)
				   ->once()
				   ->andReturn($this->attributes);

		$this->call('GET', 'unit_office_secondaries/1');

		$this->assertViewHas('unit_office_secondary');
	}

	public function testEdit()
	{
		$this->collection->id = 1;
		$this->mock->shouldReceive('find')
				   ->with(1)
				   ->once()
				   ->andReturn($this->collection);

		$this->call('GET', 'unit_office_secondaries/1/edit');

		$this->assertViewHas('unit_office_secondary');
	}

	public function testUpdate()
	{
		$this->mock->shouldReceive('find')
				   ->with(1)
				   ->andReturn(m::mock(['update' => true]));

		$this->validate(true);
		$this->call('PATCH', 'unit_office_secondaries/1');

		$this->assertRedirectedTo('unit_office_secondaries/1');
	}

	public function testUpdateFails()
	{
		$this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['update' => true]));
		$this->validate(false);
		$this->call('PATCH', 'unit_office_secondaries/1');

		$this->assertRedirectedTo('unit_office_secondaries/1/edit');
		$this->assertSessionHasErrors();
		$this->assertSessionHas('message');
	}

	public function testDestroy()
	{
		$this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['delete' => true]));

		$this->call('DELETE', 'unit_office_secondaries/1');
	}

	protected function validate($bool)
	{
		Validator::shouldReceive('make')
				->once()
				->andReturn(m::mock(['passes' => $bool]));
	}
}
