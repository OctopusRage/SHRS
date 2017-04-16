<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MoveCrudRequest as StoreRequest;
use App\Models\Entry;
class MoveCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\Entry");
        $this->crud->setRoute("admin/entry_moves");
        $this->crud->setEntityNameStrings('move', 'moves');
        $this->crud->allowAccess('create');
        $this->crud->setCreateView('custom.movements.create');
    }

    public function customSave(StoreRequest $request) {
        $entry = Entry::findOrFail($request->entry_id);
        if(trim(strtolower($request->room_id)) == trim(strtolower($entry->room_id))){
            \Alert::error('Harus pindah ke ruang berbeda')->flash();
            return redirect()->route('custom.movements.create', $request->entry_id);
        }
        $now = date("Y-m-d H:i:s");
        $entry->update(['leave_date'=>$now]);
        Entry::create([
            'registration_id' => $entry->registration_id,
            'room_id' => $request->room_id,
            'entry_date'=> $now,
            'status'=> 2 , // 1 new entry ; 2 moving patient
        ]);
        return redirect()->route('crud.entries.index');
    }

    public function customCreate($id)
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $entry = Entry::find($id);
        $leave_time = date("Y-m-d H:i:s");
        $this->crud->addField([
            'name' => 'registration_id',
            'label' => "Kode Registrasi",
            'readonly'=> true,
            'attributes' => ['readonly' => 'readonly'],
            'default' => $entry->registration_id
        ]);
        $this->crud->addField([
            'name' => 'entry_id',
            'type' => "hidden",
            'default' => $id
        ]);
        $this->crud->addField([
            'name' => 'room_id',
            'label' => "Room ID"
        ]);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add').' '.$this->crud->entity_name;
        
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getCreateView(), $this->data);
    }
}