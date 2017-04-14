<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EntryCrudRequest as StoreRequest;
use App\Http\Requests\EntryCrudRequest as UpdateRequest;

class MoveCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\Entry");
        $this->crud->setRoute("admin/entry_moves");
        $this->crud->setEntityNameStrings('move', 'moves');
        $this->crud->allowAccess('update');
        $this->crud->addField([
            'name' => 'registration_id',
            'label' => "Kode Registrasi"
        ]);
        $this->crud->addField([
            'name' => 'room_id',
            'label' => "Room ID"    
        ]);
        $this->crud->addField([
            'name' => 'entry_date',
            'default' => date("Y-m-d H:i:s"),
            'label' => "Tanggal Masuk",
            'type' => 'datetime'
        ]);
        $this->crud->addField([
            'name' => 'leave_date',
            'default' => date("Y-m-d H:i:s"),
            'label' => "Tanggal Keluar",
            'type' => 'datetime'
        ]);
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getCreateView(), $this->data);
    }

	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}