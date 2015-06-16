<?php namespace App\Http\Controllers\Organisation;
use Input, Session, App, Paginator, Redirect, DB;
use App\Http\Controllers\BaseController;
use Illuminate\Support\MessageBag;
use App\Console\Commands\Saving;
use App\Console\Commands\Getting;
use App\Models\Organisation;
use App\Models\Work;
use App\Models\Person;
use App\Models\Branch;
class BranchController extends BaseController
{
	protected $controller_name = 'cabang';

	public function index($page = 1)
	{
		if(Input::has('org_id'))
		{
			$org_id 							= Input::get('org_id');
		}
		else
		{
			$org_id 							= Session::get('user.organisation');
		}

		// if(!in_array($org_id, Session::get('user.orgids')))
		// {
		// App::abort(404);
		// }

		$search['id'] 							= $org_id;
		$sort 									= ['name' => 'asc'];
		$results 								= $this->dispatch(new Getting(new Organisation, $search, $sort , $page, 1));
		$contents 								= json_decode($results);

		if(!$contents->meta->success)
		{
			App::abort(404);
		}

		$data 									= json_decode(json_encode($contents->data), true);
		$this->layout->page 					= view('pages.branch.index');
		$this->layout->page->controller_name 	= $this->controller_name;
		$this->layout->page->data 				= $data;
		return $this->layout;
	}
	
	public function create($id = null)
	{
		if(Input::has('org_id'))
		{
			$org_id 							= Input::get('org_id');
		}
		else
		{
			$org_id 							= Session::get('user.organisation');
		}

		// if(!in_array($org_id, Session::get('user.orgids')))
		// {
		// App::abort(404);
		// }

		$search['id'] 							= $org_id;
		$sort 									= ['name' => 'asc'];
		$results 								= $this->dispatch(new Getting(new Organisation, $search, $sort , 1, 1));
		$contents 								= json_decode($results);

		if(!$contents->meta->success)
		{
			App::abort(404);
		}

		$data 									= json_decode(json_encode($contents->data), true);

		// ---------------------- GENERATE CONTENT ----------------------
		$this->layout->pages 					= view('pages.branch.create', compact('id', 'data'));
		return $this->layout;
	}
	
	public function store($id = null)
	{
		if(Input::has('id'))
		{
			$id 								= Input::get('id');
		}
		$attributes 							= Input::only('name');

		if(Input::has('org_id'))
		{
			$org_id 							= Input::get('org_id');
		}
		else
		{
			$org_id 							= Session::get('user.organisation');
		}

		$attributes 							= Input::only('name');

		$errors 								= new MessageBag();

		DB::beginTransaction();

		$content 								= $this->dispatch(new Saving(new Branch, $attributes, $id, new Organisation, $org_id));
		$is_success 							= json_decode($content);
		
		if(!$is_success->meta->success)
		{
			$errors->add('Branch', $is_success->meta->errors);
		}

		if(!$errors->count())
		{
			DB::commit();
			return Redirect::route('hr.branches.show', [$is_success->data->id, 'org_id' => $is_success->data->id])->with('alert_success', 'Cabang "' . $is_success->data->name. '" sudah disimpan');
		}
		
		DB::rollback();
		return Redirect::back()->withErrors($content->meta->errors)->withInput();
	}

	public function show($id)
	{
		// ---------------------- LOAD DATA ----------------------
		if(Input::has('org_id'))
		{
			$org_id 					= Input::get('org_id');
		}
		else
		{
			$org_id 					= Session::get('user.organisation');
		}

		// if(!in_array($org_id, Session::get('user.orgids')))
		// {
		// App::abort(404);
		// }
		
		$search 						= ['id' => $id, 'organisationid' => $org_id, 'withattributes' => ['organisation']];
		$results 						= $this->dispatch(new Getting(new Branch, $search, [] , 1, 1));
		$contents 						= json_decode($results);
		
		if(!$contents->meta->success)
		{
			App::abort(404);
		}

		$branch 						= json_decode(json_encode($contents->data), true);
		$data 							= $branch['organisation'];

		// ---------------------- GENERATE CONTENT ----------------------
		$this->layout->pages 			= view('pages.branch.show');
		$this->layout->pages->data 		= $data;
		$this->layout->pages->branch 	= $branch;
		return $this->layout;
	}

	public function edit($id)
	{
		return $this->create($id);
	}
}