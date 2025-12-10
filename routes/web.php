<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusController;

/**
 * Makes the driftstatus page into the frontpage.
 * Calls StatusController@index when user visits.
 * Visit the page: http://127.0.0.1:8000
 * It page collects data from the database
 */
Route::get('/', [StatusController::class, 'index'])
    ->name('status.index');

/**
 * TEST DATA
 * This route returns hardcoded carriers for UI testing.
 * Visit the page: http://127.0.0.1:8000/driftsstatus-test
 * to see the test data
 *
 * In the .env file the SESSION_DRIVER=database should be changed
 * to SESSION_DRIVER=file for it to run.
 */
Route::get('/driftsstatus-test', function () {
    return view('status.index', [
        'carriers' => [
            [
                'name'      => 'GLS',
                'logo'      => 'gls.png',
                'has_issue' => true,
                'message'   => 'Label-generering fejler i øjeblikket.',
            ],
            [
                'name'      => 'DFM',
                'logo'      => 'dfm.png',
                'has_issue' => true,
                'message'   => 'Servicepoint-opslag fejler for enkelte postnumre.',
            ],
            [
                'name'      => 'Packeta',
                'logo'      => 'packeta.png',
                'has_issue' => true,
                'message'   => 'Packeta API svarer langsomt – der kan forekomme timeouts.',
            ],
            [
                'name'      => 'Bring',
                'logo'      => 'bring.png',
                'has_issue' => false,
                'message'   => 'Ingen kendte problemer.',
            ],
            [
                'name'      => 'PostNord',
                'logo'      => 'pdk.png',
                'has_issue' => false,
                'message'   => 'Ingen kendte problemer.',
            ],
            [
                'name'      => 'DAO',
                'logo'      => 'dao.png',
                'has_issue' => false,
                'message'   => 'Ingen kendte problemer.',
            ],
        ],
    ]);
});
