<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

namespace App\Models;

use App\Validation\ItemsValidation;

/**
 * Items
 * @package App\Models
 */
class Items extends ModelBase
{

	const PROTECTED_FIELDS = ['id', 'insertedOn', 'updatedOn'];

	/**
	 * @var integer
	 * @Primary
	 * @Identity
	 * @Column(column="id", type="integer", length=10, nullable=false)
	 */
	protected $id;

	/**
	 * @var string
	 * @Column(column="first_name", type="string", length=30, nullable=false)
	 */
	protected $firstName;

	/**
	 * @var string
	 * @Column(column="last_name", type="string", length=40, nullable=true)
	 */
	protected $lastName;

	/**
	 * @var string
	 * @Column(column="phone", type="string", length=17, nullable=false)
	 */
	protected $phone;

	/**
	 * @var string
	 * @Column(column="country", type="string", length=2, nullable=true)
	 */
	protected $country;

	/**
	 * @var string
	 * @Column(column="timezone", type="string", length=40, nullable=true)
	 */
	protected $timezone;

	/**
	 * @var string
	 * @Column(column="inserted_on", type="string", nullable=true)
	 */
	protected $insertedOn;

	/**
	 * @var string
	 * @Column(column="updated_on", type="string", nullable=true)
	 */
	protected $updatedOn;


	/**
	 * Returns the value of field id
	 *
	 * @return integer
	 */
	public function getId(): int
	{
		return (int) $this->id;
	}

	/**
	 * Returns the value of field firstName
	 *
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * Method to set the value of field first_name
	 *
	 * @param string $firstName
	 */
	public function setFirstName(string $firstName)
	{
		$this->firstName = $firstName;
	}

	/**
	 * Returns the value of field lastName
	 *
	 * @return string
	 */
	public function getLastName(): string
	{
		return (string) $this->lastName;
	}

	/**
	 * Method to set the value of field last_name
	 *
	 * @param string $lastName
	 */
	public function setLastName(string $lastName)
	{
		$this->lastName = $lastName;
	}

	/**
	 * Returns the value of field phone
	 *
	 * @return string
	 */
	public function getPhone(): string
	{
		return $this->phone;
	}

	/**
	 * Method to set the value of field phone
	 *
	 * @param string $phone
	 */
	public function setPhone(string $phone)
	{
		$this->phone = $phone;
	}

	/**
	 * Returns the value of field country
	 *
	 * @return string
	 */
	public function getCountry(): string
	{
		return (string) $this->country;
	}

	/**
	 * Method to set the value of field country
	 *
	 * @param string $country
	 */
	public function setCountry(string $country)
	{
		$this->country = $country;
	}

	/**
	 * Returns the value of field timezone
	 *
	 * @return string
	 */
	public function getTimezone(): string
	{
		return (string) $this->timezone;
	}

	/**
	 * Method to set the value of field timezone
	 *
	 * @param string $timezone
	 */
	public function setTimezone(string $timezone)
	{
		$this->timezone = $timezone;
	}

	/**
	 * Returns the value of field insertedOn
	 *
	 * @return string
	 */
	public function getInsertedOn(): string
	{
		return $this->insertedOn;
	}

	/**
	 * Method to set the value of field inserted_on
	 *
	 * @param string $insertedOn
	 */
	public function setInsertedOn(string $insertedOn)
	{
		$this->insertedOn = $insertedOn;
	}

	/**
	 * Returns the value of field updatedOn
	 *
	 * @return string
	 */
	public function getUpdatedOn(): string
	{
		return $this->updatedOn;
	}

	/**
	 * Method to set the value of field updated_on
	 *
	 * @param string $updatedOn
	 */
	public function setUpdatedOn(string $updatedOn)
	{
		$this->updatedOn = $updatedOn;
	}

	/**
	 * Validations and business logic
	 *
	 * @return boolean
	 */
	public function validation()
	{
		$validator = new ItemsValidation();

		return $this->validate($validator);
	}
}
