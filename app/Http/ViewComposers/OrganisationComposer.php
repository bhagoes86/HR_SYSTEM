<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\MessageBag;
use App\Console\Commands\Getting;
use App\Models\Organisation;
use Input, Validator, App;

class OrganisationComposer extends WidgetComposer 
{
	protected function setRules()
	{
		$this->widget_rules['form_url']			= ['required_without', 'url'];				// url for form submit
		$this->widget_rules['search'] 			= ['array'];								// search: label for search
		$this->widget_rules['sort'] 			= ['array'];								// sort: label for sort
		$this->widget_rules['page'] 			= ['required', 'numeric'];					// page: label for page
		$this->widget_rules['per_page'] 		= ['required', 'numeric', 'max:100'];		// per page: label for per page
	}

	protected function setData()
	{
		$results 						=  $this->dispatch(new Getting(new Organisation, $this->widget_data['search'], $this->widget_data['sort'] , $this->widget_data['page'], $this->widget_data['per_page']));

		$contents 						= json_decode($results);

		if(!$contents->meta->success)
		{
			foreach ($contents->meta->errors as $key => $value) 
			{
				if(is_array($value))
				{
					foreach ($value as $key2 => $value2) 
					{
						$this->widget_errors->add('Organisation', $value2);
					}
				}
				else
				{
					$this->widget_errors->add('Organisation', $value);
				}
			}
			$this->widget_data['data'] 	= null;
		}
		else
		{
			$this->widget_data['data'] 	= json_decode(json_encode($contents->data), true);
		}
	}
}