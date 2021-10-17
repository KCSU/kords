<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommentRequest;
use App\Models\Room;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CommentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Comment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/comment');
        CRUD::setEntityNameStrings('comment', 'comments');
    }

    // public function showDetailsRow($id)
    // {
    //     $comment = Comment::find($id);
    //     return view('admin.comment')->with([
    //         'comment' => $comment
    //     ]);
    // }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('text');
        CRUD::column('room_id');
        CRUD::column('user_id');
        CRUD::enableDetailsRow();
        CRUD::setDetailsRowView('admin.comment');
        CRUD::addFilter([
            'name' => 'room',
            'type' => 'select2',
            'label' => 'Room'
        ], function() {
            return Room::has('comments')->with('location')->orderBy('number')->get()->map(function (Room $room) {
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
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CommentRequest::class);

        CRUD::field('text');
        CRUD::field('room_id');
        CRUD::field('user_id');

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
