<?php

namespace Database\Seeders;

use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $permits = [
            [
                'number'               => '19000',
                'reference'            => '20248960145',
                'document_type'        => 'Permit',
                'client_name'          => 'Nacala Frios Transporte e Logistica',
                'nuit'                 => '400 396 681',
                'vehicle_registration' => 'ANA-595-MC',
                'vehicle_brand'        => 'SHACMAN',
                'cargo_type'           => 'Mercadoria (Regular)',
                'capacity'             => '+25.001kg',
                'origin'               => 'Mozambique',
                'transit_countries'    => ['Africa do Sul','Angola','Botsuana','Malawi','Zâmbia','Zimbabué','Tanzânia','Namíbia','República do Congo','Suazilândia','Lesoto','Madagáscar'],
                'issued_at'            => '2026-03-26',
                'expires_at'           => '2026-09-26',
                'status'               => 'valid',
            ],
            [
                'number'               => '19001',
                'reference'            => '20248960200',
                'document_type'        => 'Permit',
                'client_name'          => 'Transportes Maputo Lda',
                'nuit'                 => '500 123 456',
                'vehicle_registration' => 'MXP-100-M',
                'vehicle_brand'        => 'VOLVO',
                'cargo_type'           => 'Mercadoria Perigosa',
                'capacity'             => '10.000kg',
                'origin'               => 'Mozambique',
                'transit_countries'    => ['Africa do Sul','Zimbabué'],
                'issued_at'            => '2025-01-01',
                'expires_at'           => '2025-12-31',
                'status'               => 'expired',
            ],
            [
                'number'               => '19002',
                'reference'            => '20248960300',
                'document_type'        => 'License',
                'client_name'          => 'Beira Logistics SA',
                'nuit'                 => '600 789 012',
                'vehicle_registration' => 'BRA-222-S',
                'vehicle_brand'        => 'MAN',
                'cargo_type'           => 'Mercadoria (Regular)',
                'capacity'             => '15.000kg',
                'origin'               => 'Mozambique',
                'transit_countries'    => ['Malawi','Zâmbia'],
                'issued_at'            => '2026-01-15',
                'expires_at'           => '2026-07-15',
                'status'               => 'valid',
            ],
        ];

        foreach ($permits as $data) {
            $data['validation_token'] = Str::random(40);
            Permit::create($data);
        }
    }
}
