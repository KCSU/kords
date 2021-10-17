<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoomRequest;
use App\Models\Band;
use App\Models\Location;
use App\Models\Perk;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RoomCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoomCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Room::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/room');
        CRUD::setEntityNameStrings('room', 'rooms');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('id');
        CRUD::column('number');
        CRUD::column('floor');
        CRUD::column('available')->type('boolean');
        CRUD::column('long_contract')->type('boolean');
        // CRUD::column('created_at');
        // CRUD::column('updated_at');
        CRUD::column('band_id');
        CRUD::column('location_id');
        CRUD::column('ballot_id');
        CRUD::column('notes');
        CRUD::enableDetailsRow();
        CRUD::setDetailsRowView('admin.room');
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        CRUD::addFilter([
            'name'  => 'availability',
            'type'  => 'dropdown',
            'label' => 'Availability'
        ], [
            false => 'Unavailable',
            true => 'Available'
        ], function($value) { // if the filter is active
            // $this->crud->addClause('where', 'status', $value);
            CRUD::addClause('where', 'available', $value);
        });
        CRUD::addFilter([
            'name'  => 'contract',
            'type'  => 'dropdown',
            'label' => 'Contract'
        ], [
            false => 'Short',
            true => 'Long or Short'
        ], function($value) { // if the filter is active
            // $this->crud->addClause('where', 'status', $value);
            CRUD::addClause('where', 'long_contract', $value);
        });
        CRUD::addFilter([
            'name'  => 'band',
            'type'  => 'dropdown',
            'label' => 'Rent Band'
        ], function() {
            return Band::all()->pluck('number', 'id')->sort()->toArray();
        }, function($value) { // if the filter is active
            CRUD::addClause('where', 'band_id', $value);
        });
        CRUD::addFilter([
            'name'  => 'location',
            'type'  => 'dropdown',
            'label' => 'Location'
        ], function() {
            return Location::all()->pluck('name', 'id')->sort()->toArray();
        }, function($value) { // if the filter is active
            CRUD::addClause('where', 'location_id', $value);
        });
        CRUD::addFilter([
            'name'  => 'perks',
            'type'  => 'select2_multiple',
            'label' => 'Perks'
        ], function() {
            return Perk::all()->pluck('displayName', 'id')->toArray();
        }, function($values) { // if the filter is active
            foreach (json_decode($values) as $key => $value) {
                CRUD::addClause('whereHas', 'perks', function ($q) use ($value) {
                    $q->where('perk_id', $value);
                });
            }
        });
        CRUD::addFilter([
            'name' => 'notes',
            'type' => 'simple',
            'label' => 'Notes'
        ], false, function () {
            CRUD::addClause('where', 'notes', '<>', '');
        });
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RoomRequest::class);

        // CRUD::field('id');
        CRUD::field('number');
        CRUD::field('floor')->type('number');
        CRUD::field('available')->type('boolean');
        CRUD::field('long_contract')->type('boolean');
        // CRUD::field('created_at');
        // CRUD::field('updated_at');
        CRUD::field('band_id');
        CRUD::field('location_id');
        CRUD::field('ballot_id');
        CRUD::field('perks')->attribute('display_name');
        CRUD::field('notes');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
