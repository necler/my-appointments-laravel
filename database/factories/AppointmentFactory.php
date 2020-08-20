<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Appointment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {

    $doctorId = User::doctors()->pluck('id');
    $patientId = User::patients()->pluck('id');

    $scheduled = $faker->dateTimeBetween('-1 years','now');
    $scheduled_date = $scheduled->format('Y:m:d');
    $scheduled_time = $scheduled->format('H:i:s');

    $types = ['Consulta','Examen','Operación'];
    $statuses = ['Atendida','Cancelada','Reservada','Confirmada'];

    return [
        //
        'description' => $faker->sentence(5),
        'specialty_id' => $faker->numberBetween(1,3),
        'doctor_id' => $faker->randomElement($doctorId),
        'patient_id' => $faker->randomElement($patientId),
        'scheduled_date' => $scheduled_date,
        'scheduled_time' => $scheduled_time,
        'type' => $faker->randomElement($types),
        'status' => $faker->randomElement($statuses),
    ];
});
