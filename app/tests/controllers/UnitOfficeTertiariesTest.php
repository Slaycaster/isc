<?php

use Mockery as m;
use Way\Tests\Factory;

class UnitOfficeTertiariesTest extends TestCase {

	public function __construct()
	{
		$this->mock = m::mock('Eloquent', 'Unit_office_tertiary');
		$this->collection = m::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();
	}

	public function setUp()
	{
		parent::setUp();

		$this->attributes = Factory::unit_office_tertiary(['id' => 1]);
		$this->app->instance('Unit_office_tertiary', $this->mock);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testIndex()
	{
		$this->mock->shouldReceive('all')->once()->andReturn($this->collection);
		$this->call('GET', 'unit_office_tertiaries');

		$this->assertViewHas('unit_office_tertiaries');
	}

	public function testCreate()
	{
		$this->call('GET', 'unit_office_tertiaries/create');

		$this->assertResponseOk();
	}

	public function testStore()
	{
		$this->mock->shouldReceive('create')->once();
		$this->validate(true);
		$this->call('POST', 'unit_office_tertiaries');

		$this->assertRedirectedToRoute('unit_office_tertiaries.index');
	}

	public function testStoreFails()
	{
		$this->mock->shouldReceive('create')->once();
		$this->validate(false);
		$this->call('POST', 'unit_office_tertiaries');

		$this->assertRedirectedToRoute('unit_office_tertiaries.create');
		$this->assertSessionHasErrors();
		$this->assertSessionHas('message');
	}

	public function testShow()
	{
		$this->mock->shouldReceive('findOrFail')
				   ->with(1)
				   ->once()
				   ->andReturn($this->attributes);

		$this->call('GET', 'unit_office_tertiaries/1');

		$this->assertViewHas('unit_office_tertiary');
	}

	public function testEdit()
	{
		$this->collection->id = 1;
		$this->mock->shouldReceive('find')
				   ->with(1)
				   ->once()
				   ->andReturn($this->collection);

		$this->call('GET', 'unit_office_tertiaries/1/edit');

		$this->assertViewHas('unit_office_tertiary');
	}

	public function testUpdate()
	{
		$this->mock->shouldReceive('find')
				   ->with(1)
				   ->andReturn(m::mock(['update' => true]));

		$this->validate(true);
		$this->call('PATCH', 'unit_office_tertiaries/1');

		$this->assertRedirectedTo('unit_office_tertiaries/1');
	}

	public function testUpdateFails()
	{
		$this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['update' => true]));
		$this->validate(false);
		$this->call('PATCH', 'unit_office_tertiaries/1');

		$this->assertRedirectedTo('unit_office_tertiaries/1/edit');
		$this->assertSessionHasErrors();
		$this->assertSessionHas('message');
	}

	public function testDestroy()
	{
		$this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['delete' => true]));

		$this->call('DELETE', 'unit_office_tertiaries/1');
	}

	protected function validate($bool)
	{
		Validator::shouldReceive('make')
				->once()
				->andReturn(m::mock(['passes' => $bool]));
	}
}
