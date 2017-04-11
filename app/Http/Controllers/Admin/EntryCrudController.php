<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EntryCrudRequest as StoreRequest;
use App\Http\Requests\EntryCrudRequest as UpdateRequest;

class EntryCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\Entry");
        $this->crud->setRoute("admin/entries");
        $this->crud->setEntityNameStrings('entry', 'entries');
        $this->crud->query = $this->crud->query->where('leave_date', null);
        $this->crud->setColumns(['registration_id', 'room_id', 'entry_date']);
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