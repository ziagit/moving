<?php

namespace App\Imports;

use App\City;
use App\Citycode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PostalcodeImport implements ToCollection,WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if ($key > 0) {
                $postalcode = Citycode::where('postal_code', $value['postalcode'])->get();
                if (count($postalcode) === 0) {
                    $postalcodeId = Citycode::insertGetId(['postal_code' => $value['postalcode']]);
                    $city = City::find($value['city_id']);
                    $city->citycodes()->attach($postalcodeId);
                }
            }
        }
    }
}
