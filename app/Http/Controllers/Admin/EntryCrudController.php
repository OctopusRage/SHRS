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
        $this->crud->query = $this->crud->query->orderBy('id','desc');
        $this->crud->setColumns(['registration_id', 'room_id', 'entry_date', 'leave_date', 'status']);
        $this->crud->addButtonFromView('line', 'move', 'move', 'beginning');
        $this->crud->enableExportButtons();
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
        // $this->crud->addFilter([
        //     'type'=>'simple',
        //     'name'=>'newly_registered',
        //     'label'=>'Pasien Baru'
        // ],
        // false,
        // function(){
        //     $this->crud->addClause('where', 'status', '1'); 
        // });
        // $this->crud->addFilter([
        //     'type'=>'simple',
        //     'name'=>'moved_patient',
        //     'label'=>'Pasien Pindah'
        // ],
        // false,
        // function(){
        //     $this->crud->addClause('where', 'status', '2'); 
        // });
        $this->crud->addFilter([ // dropdown filter
            'name' => 'status',
            'type' => 'dropdown',
            'label'=> 'Status'
        ], [
            1 => 'Pasien Baru',
            2 => 'Pasien Pindah',
        ], function($value) { // if the filter is active
            switch($value) {
                case 1:
                    $this->crud->addClause('where', 'status', 1);
                    break;
                default:
                    $this->crud->addClause('where', 'status', 2);
                    break;
            }
        });
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