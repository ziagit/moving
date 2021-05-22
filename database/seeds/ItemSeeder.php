<?php

use App\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::truncate();
        $items = [
            [
                'name' => 'Sofa (8 Seater)',
                'code' => 'sofa_8seater',
                'moving_cost' => 40,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Sofa (4 Seater)',
                'code' => 'sofa_4seater',
                'moving_cost' => 30,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Sofa (3 Seater)',
                'code' => 'sofa_3seater',
                'moving_cost' => 20,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Sofa (2 Seater)',
                'code' => 'sofa_2seater',
                'moving_cost' => 18,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Sofa (loveseat)',
                'code' => 'sofa_loveseat',
                'moving_cost' => 18,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Mattress & Box Spring (Full)',
                'code' => 'mattress_full',
                'moving_cost' => 20,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Floor Lamp',
                'code' => 'floorlamp',
                'moving_cost' => 18,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Table Lamp',
                'code' => 'tablelamp',
                'moving_cost' => 17,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Bookcase (3 x 3)',
                'code' => 'bookcase_3x3',
                'moving_cost' => 15,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Bookcase (4 x 6)',
                'code' => 'bookcase_4x6',
                'moving_cost' => 14,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Conference Table (Long)',
                'code' => 'conference_table',
                'moving_cost' => 14,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Glass Conference Table (Long)',
                'code' => 'glass_conference_table',
                'moving_cost' => 15,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Work Table (2.5 x 2.5 inch)',
                'code' => 'work_table_2.5x2.5',
                'moving_cost' => 15,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Work Table (4 x 2.5 inch)',
                'code' => 'work_table_4x2.5',
                'moving_cost' => 15,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Work Table (6 x 3 inch)',
                'code' => 'work_tabel_6x3',
                'moving_cost' => 15,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Refrigerator (under 5 tall)',
                'code' => 'refrigerator_5tall',
                'moving_cost' => 18,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Refrigerator (approx 6.5 tall)',
                'code' => 'refrigerator_6.5',
                'moving_cost' => 15,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Refrigerator (taller than 7)',
                'code' => 'refrigerator_6.5',
                'moving_cost' => 15,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Coffee Maker',
                'code' => 'coffee_maker',
                'moving_cost' => 15,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Bread Maker',
                'code' => 'bread_maker',
                'moving_cost' => 16,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Refrigerator (mini)',
                'code' => 'refrigerator_mini',
                'moving_cost' => 16,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Small Box',
                'code' => 'amall_box',
                'moving_cost' => 10,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Large Box',
                'code' => 'large_box',
                'moving_cost' => 11,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Medium Box',
                'code' => 'medium_box',
                'moving_cost' => 12,
                'disposal_fee' => 10
            ],
            [
                'name' => 'File Box',
                'code' => 'file_box',
                'moving_cost' => 10,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Legal File Box ',
                'code' => 'legal_file_box',
                'moving_cost' => 10,
                'disposal_fee' => 10
            ],
            
            [
                'name' => 'Flat Panel TV',
                'code' => 'flat_panel_tv',
                'moving_cost' => 20,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Ottoman (2 x 2 x 2)',
                'code' => 'ottoman_2x2x2',
                'moving_cost' => 20,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Ottoman (18 x 18 x 18)',
                'code' => 'ottoman_18x18x18',
                'moving_cost' => 20,
                'disposal_fee' => 10
            ],
            [
                'name' => 'Ottoman (biger than 2 x 2 x 2)',
                'code' => 'ottoman_biger_than_2x2x2',
                'moving_cost' => 20,
                'disposal_fee' => 10
            ],
        ];
        Item::insert($items);
    }
}
