<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Room;

/**
 * Class ImageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ImageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Image::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/image');
        CRUD::setEntityNameStrings('image', 'images');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::enableDetailsRow();
        CRUD::column('id');
        CRUD::column('filename')->key('image')->label('Image')->type('image');
        CRUD::column('filename');
        CRUD::column('room_id');
        CRUD::column('created_at')->label('Uploaded')->type('datetime');
        
        CRUD::addFilter([
            'name' => 'room',
            'type' => 'select2',
            'label' => 'Room'
        ], function() {
            return Room::has('images')->with('location')->orderBy('number')->get()->map(function (Room $room) {
                $name = $room->number;
                $loc = $room->location->name;
                return [
                    'name' => "$name ($loc)",
                    'id' => $room->id
                ];
            })->pluck('name', 'id')->toArray();
        }, function ($value) {
            CRUD::addClause('where', 'room_id', $value);
        });
        CRUD::enableDetailsRow();
        CRUD::setDetailsRowView('admin.image');
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    // protected function showDetailsRow()

    protected function setupShowOperation()
    {
        CRUD::column('filename')->key('image')->label('Image')->type('image')->height(200);
        CRUD::column('filename');
        CRUD::column('room_id');
        CRUD::column('created_at')->label('Uploaded')->type('datetime');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }
}
