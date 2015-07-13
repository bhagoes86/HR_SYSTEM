<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Config, Session, App, View, Route, Redirect, Request, Input;
use App\Console\Commands\Checking;
use App\Console\Commands\Getting;
use App\Models\Person;
use App\Models\Work;
use App\Models\WorkAuthentication;
use App\Models\Organisation;

class RouteServiceProvider extends ServiceProvider {

use \Illuminate\Foundation\Bus\DispatchesCommands;
use \Illuminate\Foundation\Validation\ValidatesRequests;

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	public function register()
	{
		// ACL
		App::singleton('hr_acl', function()
		{
			$routes_acl = [
							'hr.organisations.index'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.organisations.show'							=> [['1', '2', '3'], 'read'],
							'hr.organisations.create'						=> [['1'], 'create'],
							'hr.organisations.store'						=> [['1'], 'create'],
							'hr.organisations.edit'							=> [['1'], 'update'],
							'hr.organisations.update'						=> [['1'], 'update'],
							'hr.organisations.delete'						=> [['1'], 'delete'],

							'hr.idles.index'								=> [['1', '2'], 'read'],
							'hr.idles.show'									=> [['1', '2'], 'read'],
							'hr.idles.create'								=> [['1', '2'], 'create'],
							'hr.idles.store'								=> [['1', '2'], 'create'],
							'hr.idles.edit'									=> [['1', '2'], 'update'],
							'hr.idles.update'								=> [['1', '2'], 'update'],
							'hr.idles.delete'								=> [['1', '2'], 'delete'],

							'hr.authentications.index'						=> [['1', '2'], 'read'],
							'hr.authentications.show'						=> [['1', '2'], 'read'],
							'hr.authentications.create'						=> [['1', '2'], 'create'],
							'hr.authentications.store'						=> [['1', '2'], 'create'],
							'hr.authentications.edit'						=> [['1', '2'], 'update'],
							'hr.authentications.update'						=> [['1', '2'], 'update'],
							'hr.authentications.delete'						=> [['1', '2'], 'delete'],

							'hr.workleaves.index'							=> [['1', '2'], 'read'],
							'hr.workleaves.show'							=> [['1', '2'], 'read'],
							'hr.workleaves.create'							=> [['1', '2'], 'create'],
							'hr.workleaves.store'							=> [['1', '2'], 'create'],
							'hr.workleaves.edit'							=> [['1', '2'], 'update'],
							'hr.workleaves.update'							=> [['1', '2'], 'update'],
							'hr.workleaves.delete'							=> [['1', '2'], 'delete'],

							'hr.branches.index'								=> [['1', '2', '3'], 'read'],
							'hr.branches.show'								=> [['1', '2', '3'], 'read'],
							'hr.branches.create'							=> [['1', '2'], 'create'],
							'hr.branches.store'								=> [['1', '2'], 'create'],
							'hr.branches.edit'								=> [['1', '2'], 'update'],
							'hr.branches.update'							=> [['1', '2'], 'update'],
							'hr.branches.delete'							=> [['1', '2'], 'delete'],

							'hr.branch.contacts.index'						=> [['1', '2', '3'], 'read'],
							'hr.branch.contacts.show'						=> [['1', '2', '3'], 'read'],
							'hr.branch.contacts.create'						=> [['1', '2', '3'], 'create'],
							'hr.branch.contacts.store'						=> [['1', '2', '3'], 'create'],
							'hr.branch.contacts.edit'						=> [['1', '2', '3'], 'update'],
							'hr.branch.contacts.update'						=> [['1', '2', '3'], 'update'],
							'hr.branch.contacts.delete'						=> [['1', '2', '3'], 'delete'],

							'hr.branch.charts.index'						=> [['1', '2', '3'], 'read'],
							'hr.branch.charts.show'							=> [['1', '2', '3'], 'read'],
							'hr.branch.charts.create'						=> [['1', '2', '3'], 'create'],
							'hr.branch.charts.store'						=> [['1', '2', '3'], 'create'],
							'hr.branch.charts.edit'							=> [['1', '2', '3'], 'update'],
							'hr.branch.charts.update'						=> [['1', '2', '3'], 'update'],
							'hr.branch.charts.delete'						=> [['1', '2', '3'], 'delete'],

							'hr.branch.apis.index'							=> [['1'], 'read'],
							'hr.branch.apis.show'							=> [['1'], 'read'],
							'hr.branch.apis.create'							=> [['1'], 'create'],
							'hr.branch.apis.store'							=> [['1'], 'create'],
							'hr.branch.apis.edit'							=> [['1'], 'update'],
							'hr.branch.apis.update'							=> [['1'], 'update'],
							'hr.branch.apis.delete'							=> [['1'], 'delete'],

							'hr.branch.fingers.index'						=> [['1'], 'read'],
							'hr.branch.fingers.show'						=> [['1'], 'read'],
							'hr.branch.fingers.create'						=> [['1'], 'create'],
							'hr.branch.fingers.store'						=> [['1'], 'create'],
							'hr.branch.fingers.edit'						=> [['1'], 'update'],
							'hr.branch.fingers.update'						=> [['1'], 'update'],
							'hr.branch.fingers.delete'						=> [['1'], 'delete'],

							'hr.chart.authentications.index'				=> [['1', '2'], 'read'],
							'hr.chart.authentications.show'					=> [['1', '2'], 'read'],
							'hr.chart.authentications.create'				=> [['1', '2'], 'create'],
							'hr.chart.authentications.store'				=> [['1', '2'], 'create'],
							'hr.chart.authentications.edit'					=> [['1', '2'], 'update'],
							'hr.chart.authentications.update'				=> [['1', '2'], 'update'],
							'hr.chart.authentications.delete'				=> [['1', '2'], 'delete'],

							'hr.chart.calendars.index'						=> [['1', '2', '3'], 'read'],
							'hr.chart.calendars.show'						=> [['1', '2', '3'], 'read'],
							'hr.chart.calendars.create'						=> [['1', '2', '3'], 'create'],
							'hr.chart.calendars.store'						=> [['1', '2', '3'], 'create'],
							'hr.chart.calendars.edit'						=> [['1', '2', '3'], 'update'],
							'hr.chart.calendars.update'						=> [['1', '2', '3'], 'update'],
							'hr.chart.calendars.delete'						=> [['1', '2', '3'], 'delete'],

							'hr.calendars.index'							=> [['1', '2', '3'], 'read'],
							'hr.calendars.show'								=> [['1', '2', '3'], 'read'],
							'hr.calendars.create'							=> [['1', '2'], 'create'],
							'hr.calendars.store'							=> [['1', '2'], 'create'],
							'hr.calendars.edit'								=> [['1', '2'], 'update'],
							'hr.calendars.update'							=> [['1', '2'], 'update'],
							'hr.calendars.delete'							=> [['1', '2'], 'delete'],

							'hr.calendar.schedules.index'					=> [['1', '2', '3'], 'read'],
							'hr.calendar.schedules.show'					=> [['1', '2', '3'], 'read'],
							'hr.calendar.schedules.create'					=> [['1', '2', '3'], 'create'],
							'hr.calendar.schedules.store'					=> [['1', '2', '3'], 'create'],
							'hr.calendar.schedules.edit'					=> [['1', '2', '3'], 'update'],
							'hr.calendar.schedules.update'					=> [['1', '2', '3'], 'update'],
							'hr.calendar.schedules.delete'					=> [['1', '2', '3'], 'delete'],

							'hr.calendar.charts.index'						=> [['1', '2', '3'], 'read'],
							'hr.calendar.charts.show'						=> [['1', '2', '3'], 'read'],
							'hr.calendar.charts.create'						=> [['1', '2', '3'], 'create'],
							'hr.calendar.charts.store'						=> [['1', '2', '3'], 'create'],
							'hr.calendar.charts.edit'						=> [['1', '2', '3'], 'update'],
							'hr.calendar.charts.update'						=> [['1', '2', '3'], 'update'],
							'hr.calendar.charts.delete'						=> [['1', '2', '3'], 'delete'],

							'hr.documents.index'							=> [['1', '2', '3'], 'read'],
							'hr.documents.show'								=> [['1', '2', '3'], 'read'],
							'hr.documents.create'							=> [['1', '2', '3'], 'create'],
							'hr.documents.store'							=> [['1', '2', '3'], 'create'],
							'hr.documents.edit'								=> [['1', '2', '3'], 'update'],
							'hr.documents.update'							=> [['1', '2', '3'], 'update'],
							'hr.documents.delete'							=> [['1', '2', '3'], 'delete'],

							'hr.document.templates.index'					=> [['1', '2', '3'], 'read'],
							'hr.document.templates.show'					=> [['1', '2', '3'], 'read'],
							'hr.document.templates.create'					=> [['1', '2', '3'], 'create'],
							'hr.document.templates.store'					=> [['1', '2', '3'], 'create'],
							'hr.document.templates.edit'					=> [['1', '2', '3'], 'update'],
							'hr.document.templates.update'					=> [['1', '2', '3'], 'update'],
							'hr.document.templates.delete'					=> [['1', '2', '3'], 'delete'],

							'hr.persons.index'								=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.persons.show'								=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.persons.create'								=> [['1', '2', '3'], 'create'],
							'hr.persons.store'								=> [['1', '2', '3'], 'create'],
							'hr.persons.edit'								=> [['1', '2', '3'], 'update'],
							'hr.persons.update'								=> [['1', '2', '3'], 'update'],
							'hr.persons.delete'								=> [['1', '2', '3'], 'delete'],
				
							'hr.person.contacts.index'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.contacts.show'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.contacts.create'						=> [['1', '2', '3'], 'create'],
							'hr.person.contacts.store'						=> [['1', '2', '3'], 'create'],
							'hr.person.contacts.edit'						=> [['1', '2', '3'], 'update'],
							'hr.person.contacts.update'						=> [['1', '2', '3'], 'update'],
							'hr.person.contacts.delete'						=> [['1', '2', '3'], 'delete'],
				
							'hr.person.relatives.index'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.relatives.show'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.relatives.create'					=> [['1', '2', '3'], 'create'],
							'hr.person.relatives.store'						=> [['1', '2', '3'], 'create'],
							'hr.person.relatives.edit'						=> [['1', '2', '3'], 'update'],
							'hr.person.relatives.update'					=> [['1', '2', '3'], 'update'],
							'hr.person.relatives.delete'					=> [['1', '2', '3'], 'delete'],

							'hr.person.works.index'							=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.works.show'							=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.works.create'						=> [['1', '2', '3'], 'create'],
							'hr.person.works.store'							=> [['1', '2', '3'], 'create'],
							'hr.person.works.edit'							=> [['1', '2', '3'], 'update'],
							'hr.person.works.update'						=> [['1', '2', '3'], 'update'],
							'hr.person.works.delete'						=> [['1', '2', '3'], 'delete'],

							'hr.person.schedules.index'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.schedules.show'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.schedules.create'					=> [['1', '2', '3'], 'create'],
							'hr.person.schedules.store'						=> [['1', '2', '3'], 'create'],
							'hr.person.schedules.edit'						=> [['1', '2', '3'], 'update'],
							'hr.person.schedules.update'					=> [['1', '2', '3'], 'update'],
							'hr.person.schedules.delete'					=> [['1', '2', '3'], 'delete'],
							
							'hr.person.schedule.ajax'						=> [['1', '2', '3', '4', '5'], 'read'],

							'hr.person.workleaves.index'					=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.workleaves.show'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.workleaves.create'					=> [['1', '2', '3', '4', '5'], 'create'],
							'hr.person.workleaves.store'					=> [['1', '2', '3', '4', '5'], 'create'],
							'hr.person.workleaves.edit'						=> [['1', '2', '3', '4', '5'], 'update'],
							'hr.person.workleaves.update'					=> [['1', '2', '3', '4', '5'], 'update'],
							'hr.person.workleaves.delete'					=> [['1', '2', '3', '4', '5'], 'delete'],

							'hr.person.documents.index'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.documents.show'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.person.documents.create'					=> [['1', '2', '3'], 'create'],
							'hr.person.documents.store'						=> [['1', '2', '3'], 'create'],
							'hr.person.documents.edit'						=> [['1', '2', '3'], 'update'],
							'hr.person.documents.update'					=> [['1', '2', '3'], 'update'],
							'hr.person.documents.delete'					=> [['1', '2', '3'], 'delete'],

							'hr.report.activities.index'					=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.report.activities.show'						=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.report.activities.create'					=> [['1', '2', '3'], 'create'],
							'hr.report.activities.store'					=> [['1', '2', '3'], 'create'],
							'hr.report.activities.edit'						=> [['1', '2', '3'], 'update'],
							'hr.report.activities.update'					=> [['1', '2', '3'], 'update'],
							'hr.report.activities.delete'					=> [['1', '2', '3'], 'delete'],

							'hr.attendance.persons.index'					=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.attendance.persons.show'					=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.attendance.persons.create'					=> [['1', '2', '3', '4'], 'create'],
							'hr.attendance.persons.store'					=> [['1', '2', '3', '4'], 'create'],
							'hr.attendance.persons.edit'					=> [['1', '2', '3', '4'], 'update'],
							'hr.attendance.persons.update'					=> [['1', '2', '3', '4'], 'update'],
							'hr.attendance.persons.delete'					=> [['1', '2', '3', '4'], 'delete'],

							'hr.report.attendances.index'					=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.report.attendances.show'					=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.report.attendances.create'					=> [['1', '2', '3'], 'create'],
							'hr.report.attendances.store'					=> [['1', '2', '3'], 'create'],
							'hr.report.attendances.edit'					=> [['1', '2', '3'], 'update'],
							'hr.report.attendances.update'					=> [['1', '2', '3'], 'update'],
							'hr.report.attendances.delete'					=> [['1', '2', '3'], 'delete'],
							
							'hr.password.get'								=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.password.post'								=> [['1', '2', '3', '4', '5'], 'read'],
							'hr.logout.get'									=> [['1', '2', '3', '4', '5'], 'read'],
				];
			return $routes_acl;
		});

		// If you use this line of code then it'll be available in any view
		// as $site_settings but you may also use app('site_settings') as well
		View::share('hr_acl', app('hr_acl'));
	}

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		// Customize filter
		Route::filter('hr_acl', function()
		{
			if (!Session::has('loggedUser'))
			{
				if (Request::ajax())
				{
					return Response::make('Unauthorized', 401);
				}
				else
				{
					return Redirect::guest(route('hr.login.get'));
				}
			}
			else
			{
				$total_orgs 									= $this->dispatch(new Getting(new Organisation, [], [],1, 100));
				$count_orgs 									= json_decode($total_orgs);
				
				if(!$count_orgs->meta->success)
				{
					App::abort(404);
				}

				if($count_orgs->pagination->total_data>0)
				{
					//check user logged in 
					$results 									= $this->dispatch(new Getting(new Person, ['id' => Session::get('loggedUser'), 'withattributes' => ['organisation']], ['created_at' => 'asc'],1, 1));

					$contents 									= json_decode($results);

					if(!$contents->meta->success)
					{
						App::abort(404);
					}

					Session::put('user.id', $contents->data->id);
					Session::put('user.name', $contents->data->name);
					Session::put('user.username', $contents->data->username);
					Session::put('user.gender', $contents->data->gender);
					Session::put('user.avatar', $contents->data->avatar);

					$results 									= $this->dispatch(new Getting(new Work, ['personid' => Session::get('loggedUser'), 'active' => true, 'withattributes' => ['workauthentications', 'workauthentications.organisation', 'chart']], ['end' => 'asc'],1, 100));

					$contents_2 								= json_decode($results);

					if(!$contents_2->meta->success || !count($contents_2->data))
					{
						App::abort(404);
					}

					if(!Session::has('user.organisationid'))
					{
						Session::put('user.organisationid', $contents->data->organisation->id);
						Session::put('user.chartname', $contents_2->data[0]->chart->name);
						Session::put('user.chartpath', $contents_2->data[0]->chart->path);
						Session::put('user.branchid', $contents_2->data[0]->chart->branch_id);
						Session::put('user.organisationname', $contents->data->organisation->name);
					}

					$workid										= [];
					$chartids									= [];
					$chartsids									= [];
					$chartnames									= [];
					$organisationids							= [];
					$organisationnames							= [];
					
					foreach ($contents_2->data as $key => $value) 
					{
						$workid[]								= $value->id;
						foreach ($value->workauthentications as $key_2 => $value_2) 
						{
							if(!isset($chartids[$value_2->organisation->id]) || !in_array($value->chart->id, $chartids[$value_2->organisation->id]))
							{
								$chartids[$value_2->organisation->id][]			= $value->chart->id;
								$chartsids[]									= $value->chart->id;
							}

							if(!isset($chartnames[$value_2->organisation->id]) || !in_array($value->chart->name, $chartnames[$value_2->organisation->id]))
							{
								$chartnames[$value_2->organisation->id][]		= $value->chart->name;
							}

							if(!in_array($value_2->organisation->name, $organisationnames))
							{
								$organisationnames[]							= $value_2->organisation->name;
							}

							if(!in_array($value_2->organisation->id, $organisationids))
							{
								$organisationids[]								= $value_2->organisation->id;
							}
						}
					}

					Session::put('user.organisationids', $organisationids);
					Session::put('user.organisationnames', $organisationnames);
					Session::put('user.chartnames', $chartnames);

					//check access
					$menu 											= app('hr_acl')[Route::currentRouteName()];

					$results 										= $this->dispatch(new Getting(new WorkAuthentication, ['authgroupid' => $menu[0], 'workid' => $workid, 'organisationid' => $organisationids], ['tmp_auth_group_id' => 'asc'],1, 1));

					$contents 										= json_decode($results);

					// $contents 										= json_decode($results);

					if((!$contents->meta->success))
					{
						Session::flush();
						return Redirect::guest(route('hr.login.get'));
					}

					Session::put('user.menuid', $contents->data->tmp_auth_group_id);
				}
				elseif(Route::currentRouteName()=='hr.logout.get')
				{
					Session::flush();
					return Redirect::guest(route('hr.login.get'));
				}
				elseif(Route::currentRouteName()=='hr.organisations.store')
				{
					// Session::flush();
					// return Redirect::guest(route('hr.login.get'));
				}
				elseif(Route::currentRouteName()!='hr.organisations.create')
				{
					$results 										= $this->dispatch(new Getting(new Person, ['id' => Session::get('loggedUser'), 'defaultemail' => true], ['created_at' => 'asc'],1, 1));

					$contents 										= json_decode($results);

					if(!$contents->meta->success)
					{
						App::abort(404);
					}

					Session::put('user.id', $contents->data->id);
					Session::put('user.name', $contents->data->name);
					Session::put('user.email', $contents->data->contacts[0]->value);
					Session::put('user.gender', $contents->data->gender);
					Session::put('user.avatar', $contents->data->avatar);

					return Redirect::route('hr.organisations.create');
				}

			}
		});
	}
		
	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
		});
	}

}
