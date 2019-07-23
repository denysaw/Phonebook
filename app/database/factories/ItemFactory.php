<?php
/**
 * @author Denysaw
 */
declare(strict_types=1);

use App\Models\Items;
use Faker\Generator as Faker;
use Yarak\DB\Factories\ModelFactory;

/** @var $factory ModelFactory */
$factory->define(Items::class, function(Faker $faker) use ($factory) {
	$patterns = ['/^.+\.\s/i', '/\s(?=\S*$).+\.$/i'];
	$name = preg_replace($patterns, '', $faker->unique()->name);
	list($firstName, $lastName) = explode(' ', $name, 2);

	$phone = $faker->unique()->numberBetween(19999999999999, 49999999999999);
	$pattern = '/^(\d{2})(\d{3})(\d{7,9})$/';
	$replacement = join(' ', ['$1', '$2', '$3']);
	$phone = '+'. preg_replace($pattern, $replacement, $phone);

    return [
        'firstName' => $firstName,
        'lastName'  => $lastName,
        'phone'     => $phone,
        'country'   => $faker->countryCode,
        'timezone'  => $faker->timezone
    ];
});
