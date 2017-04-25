<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MoveCrudRequest as StoreRequest;
use App\Models\Entry;
class RegistrationCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\Registration");
        $this->crud->setRoute("admin/registrations");
        $this->crud->setEntityNameStrings('registration', 'registrations');
        $this->crud->allowAccess('list');
        $this->crud->setListView('custom.registrations.list');
    }
}