<?php
	
	
	namespace AliAbdalla\PDF;
	
	
	use Mpdf\Mpdf;
	use Mustache_Autoloader;
	use Mustache_Engine;
	use Mustache_Loader_FilesystemLoader;
	
	Mustache_Autoloader::register();
	
	
	class APDFCore extends Mpdf
	{
		
		
		public $page_size = "";
		// Templates folder and default filename adjustment variables.
		public $currency = "";
		public $logo = "";
		public $date = "";
		public $time = "";      /* Currency format */
		// No modification suggested for these two.
		public $due = "";
		public $from = array();
		
		// Default variables initialized
		public $to = array();
		public $items = array();
		public $totals = array();
		public $addText = array();
		public $badge = "";
		public $footernote = "";
		public $curreny_direction = "left";
		public $items_total = 0;
		public $grand_total = 0;
		public $reference = 0;
		protected $_template = '';
		protected $_data = array();
		private $thanks_message;
		private $langContent = [
			'en' => [
				'item_name' => 'Item Name',
				'qty' => 'QTY',
				'price' => 'Price',
				'vat' => 'VAT',
				'discont' => 'Discont',
				'total' => 'Total',
				'subtotal' => 'Subtotal',
				'shipment' => 'Shipment',
			],
			'ar' => [
				'item_name' => 'اسم المنتج',
				'qty' => 'الكمية',
				'price' => 'السعر',
				'tax' => 'الضريبة',
				'discont' => 'الخصم',
				'total' => 'المجموع',
				'subtotal' => 'الصافي',
				'shipment' => 'الشحن',
				'net' => 'النهائي',
			]
		];
		private $template_dir = "/templates";
		private $main_file = "/main.mustache";
		private $mpdfobj = null;
		private $referenceformat = array('.', ',');
		private $direction = 'ltr';
		private $language = 'en';
		private $footer_content = "";
		
		/**
		 * @param string $footer_content
		 */
		public function setFooterContent(string $footer_content): void
		{
			$this->footer_content = $footer_content;
		}
		
		/* Class Constructor */
		public function __construct($template = 'basic', $currency = '$', $page_size = 'A4')
		{
			
			$this->mpdfobj = new Mpdf(
				array(
					'',         // mode - default ''
					$page_size,  // format - A4, for example, default 'A4'
					9,             // font size - default 0
					'Arial',         // default font family
					10,         // margin_left
					10,         // margin right
					10,         // margin top
					10,         // margin bottom
					9,             // margin header
					9,             // margin footer
					'L'             // L - landscape, P - portrait
				)
			);
			
			$this->_template = $template;
			$this->page_size = $page_size;
			$this->currency = html_entity_decode($currency);
		}
		
		
		/*
		 * __set();
		 * return bool
		 */
		public function __set($key, $value)
		{
			$this->_data[$key] = $value;
			return true;
		}
//		/*
//		 * __get();
//		 * return bool/data
//		 */
//		public function __get($key) {
//			return isset($this->_data[$key]) ? $this->_data[$key] : false;
//		}
		
		public function setThanksMessage($thanks_message)
		{
			
			$this->thanks_message = $thanks_message;
		}
		
		public function setCurrenyDirection($direction = "left")
		{
			$this->curreny_direction = $direction;
		}
		
		public function setType($title)
		{
			$this->title = $title;
		}
		
		public function setDate($date)
		{
			$this->date = $date;
		}
		
		public function setDue($date)
		{
			$this->due = $date;
		}
		
		public function setLogo($logo = 0)
		{
			$this->logo = $logo;
		}
		
		
		public function setDirection($direction)
		{
			$this->direction = $direction;
		}
		
		
		public function setLang($lang)
		{
			$this->language = $lang;
		}
		
		
		public function setFrom($data)
		{
			$this->from = $data;
		}
		
		public function setTo($data)
		{
			$this->to = $data;
		}
		
		public function setReference($reference)
		{
			$this->reference = $reference;
		}
		
		public function setNumberFormat($decimals, $thousands_sep)
		{
			$this->referenceformat = array($decimals, $thousands_sep);
		}
		
		
		public function addItem($item, $quantity = 1, $price = 0, $total = 0, $tax = 0, $net = 0, array $serials = [])
		{
			
			
			$p['item'] = $item;
			$p['quantity'] = $quantity;
			$p['price'] = number_format($price, 2, $this->referenceformat[0], $this->referenceformat[1]) . ' ' . $this->currency;
			$p['total'] = number_format($total, 2, $this->referenceformat[0], $this->referenceformat[1]) . ' ' . $this->currency;
			$p['tax'] = number_format($tax, 2, $this->referenceformat[0], $this->referenceformat[1]) . ' ' . $this->currency;
			$p['net'] = number_format($net, 2, $this->referenceformat[0], $this->referenceformat[1]) . ' ' . $this->currency;
			$p['serials'] = $serials;
			
			$this->items[] = $p;
			
			
		}
		
		public function addTotal($name, $value, $colored = "", $subtract = FALSE)
		{
			$t['name'] = $name;
			$t['value'] = $value;
			if(is_numeric($value)) {
				if($this->curreny_direction == "left") {
					$t['value'] = $this->currency . ' ' . number_format($value, 2, $this->referenceformat[0], $this->referenceformat[1]);
				} else {
					$t['value'] = number_format($value, 2, $this->referenceformat[0], $this->referenceformat[1]) . ' ' . $this->currency;
				}
				if($subtract === TRUE) {
					$this->grand_total -= $value;
				} else {
					$this->grand_total += $value;
				}
			}
			$t['colored'] = $colored;
			$this->totals[] = $t;
			// Make Total Due equal to Balance Due
			if(strtolower($name) == 'total due') $this->balanceDue = $value;
		}
		
		public function GetPercentage($percentage)
		{
			$total = $this->grand_total;
			if(!empty($total) and !empty($percentage)) {
				$percentage = ($percentage / 100);
				$vat = $total * $percentage;
				return $vat;
			}
		}
		
		public function GetGrandTotal()
		{
			return $this->grand_total;
		}
		
		public function addTitle($title)
		{
			$this->addText[] = "<h3>$title :</h3><br/>";
		}
		
		public function addParagraph($paragraph)
		{
			$this->addText[] = "<p>$paragraph</p>";
		}
		
		public function addBadge($badge)
		{
			$this->badge = $badge;
		}
		
		public function setFooternote($note)
		{
			$this->footernote = $note;
		}
		
		public function render($filename = "invoice", $action = "")
		{
			
			$m = new Mustache_Engine(
				array(
					'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . $this->template_dir),
				)
			);
			$tpl = $m->loadTemplate($this->_template . $this->main_file);
			$template_output = $tpl->render(
				array(
					'title' => $this->title,
					'reference' => $this->reference,
					'invoice_date' => $this->date,
					'due_date' => $this->due,
					'from' => $this->from,
					'to' => $this->to,
					'items' => $this->items,
					'totals' => $this->totals,
					'logo' => $this->logo,
					'footer_details' => $this->addText,
					'custom' => $this->_data,
					'direction' => $this->direction,
					'footer_content' => $this->footer_content,
					'content' => $this->langContent[$this->language],
					'is_rtl' => $this->direction == 'rtl',
					'thanks_message' => $this->thanks_message
				)
			);


//			return $template_output;
			$this->mpdfobj->SetFooter($this->footernote . ' |  | .');
			if(isset($this->badge) and !empty($this->badge)) {
				$this->mpdfobj->SetWatermarkText($this->badge, 0.1);
				$this->mpdfobj->showWatermarkText = true;
				$this->mpdfobj->watermark_font = 'ZawgyiOne';
			}
			
			//echo $template_output;
			//die;
			
			$this->mpdfobj->WriteHTML($template_output);
			
			return $this->mpdfobj->Output($filename, $action);
		}
	}