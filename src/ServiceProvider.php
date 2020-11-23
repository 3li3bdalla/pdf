<?php
	
	namespace AliAbdalla\PDF;
	
	class ServiceProvider extends \Illuminate\Support\ServiceProvider
	{
		/**
		 * Register services.
		 *
		 * @return void
		 */
		public function register()
		{
			
			$this->app->singleton(
				"apdf", function() {
				return new APDFCore();
			}
			);
			
			$this->app->alias(APDF::class, 'APDF');
			
			
		}
		
		/**
		 * Bootstrap services.
		 *
		 * @return void
		 */
		public function boot()
		{
		
		}
	}