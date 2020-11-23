<?php
	
	
	namespace AliAbdalla\PDF;
	
	
	use Illuminate\Support\Facades\Facade;
	
	class APDF extends  Facade
	{
		/**
		 * Get the registered name of the component.
		 *
		 * @return string
		 */
		protected static function getFacadeAccessor()
		{
			return 'apdf';
		}
	}