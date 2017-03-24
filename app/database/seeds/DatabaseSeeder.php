<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->call('RanksTableSeeder');
		$this->call('PositionsTableSeeder');
		$this->call('EmployeesTableSeeder');
		$this->call('Main_activitiesTableSeeder');
		$this->call('Unit_officesTableSeeder');
		$this->call('MeasuresTableSeeder');
		$this->call('EmploysTableSeeder');
		$this->call('Sub_activitiesTableSeeder');
		$this->call('PerspectivesTableSeeder');
		$this->call('Measure_target_unitsTableSeeder');
		$this->call('ObjectivesTableSeeder');
		$this->call('Measure_targetsTableSeeder');
		$this->call('Unit_office_secondariesTableSeeder');
		$this->call('Unit_office_tertiariesTableSeeder');
		$this->call('Unit_office_quaternariesTableSeeder');
		$this->call('Secondary_unit_officesTableSeeder');
		$this->call('Tertiary_unit_officesTableSeeder');
		$this->call('Quaternary_unit_officesTableSeeder');
	}

}
