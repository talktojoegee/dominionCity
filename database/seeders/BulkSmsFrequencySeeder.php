<?php

namespace Database\Seeders;

use App\Models\BulkSmsFrequency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkSmsFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $frequencies = [
            [
              'label'=>'Every Monday',
              'value'=>7,
              'letter'=>'d',
          ],
            [
                'label'=>'Every Tuesday',
                'value'=>7,
                'letter'=>'d',
            ],
            [
                'label'=>'Every Wednesday',
                'value'=>7,
                'letter'=>'d',
            ],
            [
                'label'=>'Every Thursday',
                'value'=>7,
                'letter'=>'d',
            ],
            [
                'label'=>'Every Friday',
                'value'=>7,
                'letter'=>'d',
            ],
            [
                'label'=>'Every Saturday',
                'value'=>7,
                'letter'=>'d',
            ],
            [
                'label'=>'Every Sunday',
                'value'=>7,
                'letter'=>'d',
            ],
            //Sunday of the Month
            [
                'label'=>'First Sunday',
                'value'=>'first sunday',
                'letter'=>'m',
            ],
            [
                'label'=>'Second Sunday',
                'value'=>'second sunday',
                'letter'=>'m',
            ],
            [
                'label'=>'Third Sunday',
                'value'=>'third sunday',
                'letter'=>'m',
            ],
            [
                'label'=>'Fourth Sunday',
                'value'=>'fourth sunday',
                'letter'=>'m',
            ],
            //Monday of the Month
            [
                'label'=>'First Monday',
                'value'=>'first monday',
                'letter'=>'m',
            ],
            [
                'label'=>'Second Monday',
                'value'=>'second monday',
                'letter'=>'m',
            ],
            [
                'label'=>'Third Monday',
                'value'=>'third monday',
                'letter'=>'m',
            ],
            [
                'label'=>'Fourth Monday',
                'value'=>'fourth monday',
                'letter'=>'m',
            ],
            //Tuesday of the Month
            [
                'label'=>'First Tuesday',
                'value'=>'first tuesday',
                'letter'=>'m',
            ],
            [
                'label'=>'Second Tuesday',
                'value'=>'second tuesday',
                'letter'=>'m',
            ],
            [
                'label'=>'Third Tuesday',
                'value'=>'third tuesday',
                'letter'=>'m',
            ],
            [
                'label'=>'Fourth Tuesday',
                'value'=>'fourth tuesday',
                'letter'=>'m',
            ],
            //Wednesday of the Month
            [
                'label'=>'First Wednesday',
                'value'=>'first wednesday',
                'letter'=>'m',
            ],
            [
                'label'=>'Second Wednesday',
                'value'=>'second wednesday',
                'letter'=>'m',
            ],
            [
                'label'=>'Third Wednesday',
                'value'=>'third wednesday',
                'letter'=>'m',
            ],
            [
                'label'=>'Fourth Wednesday',
                'value'=>'fourth wednesday',
                'letter'=>'m',
            ],
            //Thursday of the Month
            [
                'label'=>'First Thursday',
                'value'=>'first thursday',
                'letter'=>'m',
            ],
            [
                'label'=>'Second Thursday',
                'value'=>'second thursday',
                'letter'=>'m',
            ],
            [
                'label'=>'Third Thursday',
                'value'=>'third thursday',
                'letter'=>'m',
            ],
            [
                'label'=>'Fourth Thursday',
                'value'=>'fourth thursday',
                'letter'=>'m',
            ],
            //Friday of the Month
            [
                'label'=>'First Friday',
                'value'=>'first friday',
                'letter'=>'m',
            ],
            [
                'label'=>'Second Friday',
                'value'=>'second friday',
                'letter'=>'m',
            ],
            [
                'label'=>'Third Friday',
                'value'=>'third friday',
                'letter'=>'m',
            ],
            [
                'label'=>'Fourth Friday',
                'value'=>'fourth friday',
                'letter'=>'m',
            ],
            //Saturday of the Month
            [
                'label'=>'First Saturday',
                'value'=>'first saturday',
                'letter'=>'m',
            ],
            [
                'label'=>'Second Saturday',
                'value'=>'second saturday',
                'letter'=>'m',
            ],
            [
                'label'=>'Third Saturday',
                'value'=>'third saturday',
                'letter'=>'m',
            ],
            [
                'label'=>'Fourth Saturday',
                'value'=>'fourth saturday',
                'letter'=>'m',
            ],

            //Others
            [
                'label'=>'First Day of the Month',
                'value'=>'first month',
                'letter'=>'o', //others
            ],
            [
                'label'=>'First Day of the Year',
                'value'=>'first year',
                'letter'=>'o', //others
            ],

        ];
        foreach($frequencies as $frequency){
            BulkSmsFrequency::create($frequency);
        }
    }
}
