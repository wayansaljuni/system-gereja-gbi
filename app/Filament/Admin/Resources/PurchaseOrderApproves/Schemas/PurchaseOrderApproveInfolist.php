<?php

namespace App\Filament\Admin\Resources\PurchaseOrderApproves\Schemas;

use Filament\Schemas\Schema;

class PurchaseOrderApproveInfolist
{
    public static function configure(Schema $schema): Schema
    {
       $fields = [
            'id', 'kd_cab', 'nota', 'tgl', 'no_pr', 'repacking',
            'tgl_krm', 'sbyr', 'tkrm', 'ippn', 'l_i', 'kons',
            'kd_supp', 'm_uang', 'rate', 'ppn', 'jumlahrp',
            'jumlah', 'disc1', 'discrp1', 'disc2', 'discrp2',
            'disc3', 'discrp3', 'total', 'totalrp', 'tppn',
            'tppnrp', 'dpp', 'dpprp', 'gp', 'jt_tempo',
            'packing', 'delivery', 'shipment', 'destinat',
            'payment', 'insurance', 'remark1', 'reamrk2',
            'freigchar', 'otherchar', 'pricecon', 'iduser',
            'kat', 'done1', 'inventory', 'tgl_update',
            'user', 'tglentry', 'approve', 'tglapp',
            'userapp', 'tgl_krm_rev', 'jnspo',
            'kdcabentry', 'bypass',
        ];

        return $schema->components(
            array_map(
                fn (string $field) => \Filament\Infolists\Components\TextEntry::make($field)
                    ->label(str_replace('_', ' ', strtoupper($field)))
                    ->placeholder('-'),
                $fields,
            ),
        )->columns(3);
    }
}
