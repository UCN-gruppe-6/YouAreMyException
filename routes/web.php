<?php

use Illuminate\Support\Facades\Route;

/**Route::view('/driftsstatus', 'status.index')->name('status.index');*/

/** Gives the view an array of carriers that we can loop through
Should later get the carriers and messages from the API */
Route::view('/driftsstatus', 'status.index', [
    'carriers' => [
        [
            'name'      => 'BPOST',
            'has_issue' => true,
            'message'   => 'Planlagt strejke i Belgien — mulige forsinkelser (24.–26. november)',
        ],
        [
            'name'      => 'BRING',
            'has_issue' => true,
            'message'   => 'Mulige forsinkelser på Bring Ekspress-forsendelser (27.10.–21.12.2025)',
        ],
        [
            'name'      => 'DHL EXPRESS',
            'has_issue' => true,
            'message'   => 'Midlertidig suspension af alle internationale forsendelser til og fra Israel',
        ],
        [
            'name'      => 'DHL CONNECT',
            'has_issue' => true,
            'message'   => 'Forsinkelser på retur-forsendelser fra Tyskland (Göttingen)',
        ],
        [
            'name'      => 'UPS',
            'has_issue' => true,
            'message'   => 'Risiko for forsinkelser på forsendelser til USA',
        ],
        [
            'name'      => 'ASENDIA',
            'has_issue' => false, /* no errors -> green dot */
            'message'   => null,
        ],
    ],
])->name('status.index');

Route::get('/', function () {
    return view('welcome');
});

