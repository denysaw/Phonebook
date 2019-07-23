<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

use App\Models\Items;
use PHPUnit\Framework\TestCase;

final class ValidationTest extends TestCase
{

	public function testNoRequiredFields()
	{
		$item = new Items();
		$this->assertFalse($item->save());
	}

	public function testProperListOfRequiredFields()
	{
		$item = new Items();
		$item->save();

		$this->assertEquals(['firstName is required', 'phone is required'], $item->messages());
	}

	public function testFirstNameIsTooLong()
	{
		$item = new Items([
			'firstName' => 'ToooooooooooooooooooooooooooooooooLongFirstName',
			'phone'     => '+11 111 11111111'
		]);

		$item->save();

		$this->assertContains("Field 'firstName' exceeds it's maximum length", $item->messages());
	}

	public function testWrongPhonePattern()
	{
		$item = new Items([
			'firstName' => 'unreal name',
			'phone'     => '+1111111111111'
		]);

		$item->save();

		$this->assertContains("Provided phone has invalid format", $item->messages());
	}

	public function testExistingName()
	{
		$item = new Items([
			'firstName' => 'First',
			'lastName'  => 'Last',
			'phone'     => '+10 101 10101010'
		]);

		$item->save();

		$item = new Items([
			'firstName' => 'First',
			'lastName'  => 'Last',
			'phone'     => '+10 101 10101011'
		]);

		$item->save();

		$this->assertContains("Record with such 'firstName, lastName' already exists", $item->messages());
	}

	public function testExistingPhone()
	{
		Items::find("firstName LIKE '__name%'")->delete();

		$item = new Items([
			'firstName' => '__name1',
			'lastName'  => '__name1',
			'phone'     => '+10 101 10101111'
		]);

		$item->save();

		$item = new Items([
			'firstName' => '__name2',
			'lastName'  => '__name2',
			'phone'     => '+10 101 10101111'
		]);

		$item->save();

		$this->assertContains("Record with such 'phone' already exists", $item->messages());
	}

	public function testCountryOutOfList()
	{
		Items::find("firstName LIKE '__name%'")->delete();

		$item = new Items([
			'firstName' => '__name1',
			'lastName'  => '__name2',
			'phone'     => '+10 101 10111111',
			'country'   => 'xxx'
		]);

		$item->save();

		$this->assertContains("Provided 'country' value is out of the Hostaway's list", $item->messages());
	}

	public function testTimezoneOutOfList()
	{
		Items::find("firstName LIKE '__name%'")->delete();

		$item = new Items([
			'firstName' => '__name1',
			'lastName'  => '__name2',
			'phone'     => '+10 101 10111111',
			'timezone'  => 'solar/system'
		]);

		$item->save();

		$this->assertContains("Provided 'timezone' value is out of the Hostaway's list", $item->messages());
	}
}
