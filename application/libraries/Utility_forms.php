<?php
/**
 * THIS LIBRARY WAS DEVELOPED TO BE USED TO CREATE FORMS IN THE FLY
 * IT IS CAPABLE OF CREATING 2 TYPE OF FORMS THATS IS SINGLE COLUMNED AND
 * MULTI COLUMNED FORM.
 * 
 * IN ORDER TO RUN WELL BOOSTRAP 3 AND JQUERY 2.X SHOULD HAV BEEN INSTALLED
 * IN THE APPLICATION INTENDED TO BE USED.
 * 
 * THIS IS A CODEIGNITER LIBRARY BUILT WITH CODEIGNITER 3.6
 * 
 * 
 * 	@author Nicodemus Karisa Mwambire
 * 	@copyright Compassion Internation Kenya (c) 2019
 *	@package Toolkit
 * 	@version 2019.01.01
 * 	@license https://www.compassion-africa.org/software/license/utility_forms.txt
 * 
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Utility_forms{
	
	/**
	 * Form Fields
	 * 
	 * 
	 * A collection of array elements representing each field in a form group for
	 * single columned forms on a the first row and headers for multi columed
	 * form
	 * 
	 * @var Array
	 * 
	 */
	private $fields = array();
	
	/**
	 *
	 * Form Action
	 * 
	 *This is the value of the action property of the form.
	 * 
	 * @var String
	 *  
	 */
	 
	private $form_action = "";
	
	/**
	 *
	 * Form ID
	 * 
	 * This holds the form's id property. If not provided it is defaulted
	 * to frm
	 * 
	 * @var String
	 *  
	 */
	 
	private $form_id = "frm";
	
	/**
	 * 
	 * Form Output String
	 * 
	 * The whole form is assigned to this variable as plain string.
	 * When echoed the form gets created.
	 * 
	 * @var String
	 * 
	 */
	
	private $form_output_string = "";
	
	/**
	 * 
	 * Multi Column Table ID
	 * 
	 * This is the id ot the multi columned form. It hold the rows of the form.
	 * If not prodived it defaults to tbl_multi_column
	 * 
	 * @var String
	 * 
	 */
	 
	private $multi_column_table_id = 'tbl_multi_column';
	
	/**
	 * 
	 * Initial Row Count
	 * 
	 * This property when set atomatically creates rows equal to the value assigned.
	 * By default it has a value of 1, so only one row will be created.
	 * 
	 * @var Integer
	 * 
	 */
	
	private $initial_row_count = 1;
	
	/**
	 * 
	 * Form Tag
	 * 
	 * The form tag property help in setting whether the fields ought to be encapsulated 
	 * in a form tag of not. By default it is set to true to mean that the form elements
	 * are within a form tag otherwise the value should be false to strip off the form
	 * form elements from the form tag 
	 * 
	 * @var Boolean
	 * 
	 */
	
	private $use_form_tag = true;
	
	private $go_back_on_post = true;
	
	private $CI;
	
	private $use_panel = true;
	
	private $panel_title = "Panel";
	
	private $panel_color_theme = 'info';//success,info,danger,default
	
	private $debug_mode = false;
	
	private $db_table = "";
		
	private $selected_list_fields = array();
	
	private $use_datatable = true;
	
	private $data_limit = array();
	
	function __construct(){
		$this->CI =& get_instance();
		
		$this->CI->load->database();
		
		$this->CI->load->helper('url');
		
		$this->CI->load->helper('url');
		$this->CI->load->helper('form');
	}
	
	/**
	 * 
	 * Set Form Fields
	 * 
	 * @param Array form_elements 
	 * 
	 * This is public setter that enables to set the value of fields propoerty of this
	 * class.
	 * 
	 * The fields property is of array type. This is a multi dimensional array with 
	 * numeric outer keys. The inner arrays are associative arrays with the following 
	 * mandatory keys: label and element. Other fields are properties, a key that hold 
	 * an associative array of keys being the name of the form field propoerty and its 
	 * value e.g. name=>'username', options for select elements which holds an 
	 * associative array of options values as keys and its values an array with 2 keys 
	 * option equaling to option inner html and properties, an associtive array of option
	 * tag properties. The key values is a special propperty of fields that holds an array 
	 * of values which represent dafault values of elements. 
	 * 
	 * 
	 *   $fields[] = array(
		  'label'=>'Username',
		  'element'=>'input',
		  'properties' => array('name'=>'username','id'=>'username')
		 );
		 
		 $fields[] = array(
		  'label'=>'Password',
		  'element'=>'input',
		  'properties' => array('name'=>'password','id'=>'password')
		 );
		 
		 $fields[] = array(
		  'label'=>'Days Of Week',
		  'element'=>'select',
		  'properties' => array('name'=>'daysofweek','id'=>'daysofweek'),
		  'options' => array(	
		  						'day1'=>array('option'=>'Monday'),
		  						'day2'=>array('option'=>'Tuesday','properties'=>array('selected'=>'selected')),
		  						'day3'=>array('option'=>'Wednesday')
							)
		 );
	 * 
	 * 
	 * @return Void
	 * 
	 */
	
	public function set_form_fields($form_elements=array()){
		 
		$this->fields = $form_elements;		
	}
	
	/**
	 * 
	 * Get Form Elements
	 * 
	 * This returns an array of the form elements
	 * 
	 * @return Array
	 * 
	 */
	
	private function get_form_elements(){
		return $this->fields;
	}
	
	/**
	 * 
	 * Set Form Action
	 * 
	 * @param String form_action
	 * 
	 * This method set the form' action property.
	 * 
	 * @return Void
	 * 
	 */
	
	public function set_form_action($form_action=""){
		$this->form_action = $form_action;	
	}
	
	/**
	 *Get Form Action 
	 * 
	 * The method returns the action of the form
	 * 
	 * @return String
	 */
	
	private function get_form_action(){
		return $this->form_action;	
	}
	
	
	/**
	 * Set Form ID
	 * 
	 * @param String form_id
	 * 
	 * Sets the ID of the form
	 * 
	 * @return Void
	 */
	
	public function set_form_id($form_id=""){
		$this->form_id = $form_id;
	}
	
	/**
	 * Get form ID
	 * 
	 * Returns the ID of the form
	 * 
	 * @return String
	 */
	
	private function get_form_id(){
		return $this->form_id;
	}
	
	/**
	 * Set form tag
	 * 
	 * @param String use_form_tag
	 * 
	 * Set to true if tag is to be used to false
	 * 
	 * @return Void
	 */
	
	public function set_use_form_tag($use_form_tag = ""){
		$this->use_form_tag = $use_form_tag;
	}
	
	/**
	 * Get Form Tag
	 * 
	 * Return true if form tags is to be used to false if not
	 * 
	 * @return Boolean
	 */
	
	private function get_use_form_tag(){
		return $this->use_form_tag;
	}
	
	/**
	 * Set Initial Row Count
	 * 
	 * Set the number of default rows in a multi columned form.
	 * 
	 * @return Void
	 */
	
	function set_initial_row_count($row_count = ""){
		$this->initial_row_count = $row_count;
	}
	
	/**
	 * Get Initial Row Count
	 * 
	 * This method returns the number of default rows in a multi columned
	 * form. The default value of initial row count is 1.
	 * 
	 * @return Integer
	 */
	
	private function get_initial_row_count(){
		return $this->initial_row_count;
	}
	
	/**
	 * Form Open Tag
	 * 
	 * This method form_output_string to form opening tag. It uses the codeigniter
	 * form_open tag. The form is set to allow multi form data.
	 * 
	 * @return String
	 */
	 
	function set_go_back_on_post($go_back_on_post = true){
		$this->go_back_on_post = $go_back_on_post;
	} 
	
	private function get_go_back_on_post(){
		return $this->go_back_on_post;
	}
	
	private function form_open_tag(){
		
		$this->get_use_form_tag();
		
		$return_string = "";
		
		if($this->use_form_tag == true){
			$return_string .= form_open($this->form_action, 
			array('id' => $this->form_id, 'class' => 'form-horizontal 
			form-groups-bordered validate', 'enctype' => 'multipart/form-data'));
		}
		
		return $return_string;
	}
	
	private function open_panel(){
		
		$this->get_use_panel();
		
		$return_string = "";
		
		if($this->use_panel == true){
				$return_string .= '
					<div class="panel panel-'.$this->get_panel_color_theme().'">
										
						<div class="panel-heading">
							<div class="panel-title">'.$this->get_panel_title().'</div>						
						</div>
												
						<div class="panel-body">
				';
		}
		
		return $return_string;
	}
	
	private function close_panel(){
		
		$this->get_use_panel();
		
		$return_string = "";
		
		if($this->use_panel == true){
			$return_string  .= '</div>
				</div>';
		}
		return $return_string ;	
	}
	
	function set_use_panel($use_panel = ""){
		$this->use_panel = $use_panel;
	}
	
	private function get_use_panel(){
		return $this->use_panel;
	}
	
	function set_panel_color_theme($panel_color_theme = ""){
		$this->panel_color_theme = $panel_color_theme;
	}
	
	function get_panel_color_theme(){
		return $this->panel_color_theme;
	}
	
	
	//private $hide_save_button;
	
	//public function set_hide_save_button($bool_state){
		//$this->hide_save_button = $bool_state;
	//}
	
	//private function get_hide_save_button(){
		//return $this->hide_save_button;
	//}
	
	/**
	 * Form Close Tag
	 * 
	 * Returns the form close tag
	 * 
	 * @return String
	 */
	
	
	private function form_close_tag(){
			
		$this->get_use_form_tag();
		
		$return_string  = "";
		
			if($this->use_form_tag == true){
				
				$return_string .= form_close();
			
				
				//added
				if($this->view_or_edit_mode != 'view')
				{
					$return_string .= "<div class='form-group'>
				    <div class='col-xs-12'>
					<button type='submit' class='btn btn-default' id='btnCreate'><i class='fa fa-send'></i> Save</button>
				   </div>";
				}
			$return_string .= "</div>";	
		}
			
		
		return $return_string;	
	}
	
/**
 * Create Select Field
 * 
 * Renders a select form element
 * 
 * @return String
 */	

private function create_select_field($fields = array(),$cnt = 0){
		//print_r($fields);
		/**
		 * Additonal classes are other classes to the element other 
		 * than the hard coded form-control class. The are part of the properties element
		 * of the fields array.
		 * 
		 * For example 'properties'=>array('class'=>'resettable mandatory')
		 * 
		 * If the properties element has class key in it then it's value will be assigned
		 * to the additional_classes local variable. This variable is appended to the existing
		 * class.  	
		 */
		 
		$output_string = "";
		 
		$additional_classes = "";
		
		if(isset($fields['properties'])){
			if(array_key_exists('class', $fields['properties'])){
				$additional_classes = " ".$fields['properties']['class'];
			}
		}				
		
		
		$output_string .= "<select class='form-control ".$additional_classes."' ";
		
		/**
		 * This part of the code allows for a non key-value paired elements of the properties element.
		 * If such elemeents are found inside properties since they have a numeric key the values will
		 * be used as the key.
		 */
		if(isset($fields['properties'])){
			foreach($fields['properties'] as $property=>$value){
				if(is_numeric($property)){
					$output_string .= " ".$value." = '".$value."' ";
				}else{
					$output_string .= " ".$property." = '".$value."' ";
				}
			}
		}											
		
					
		$output_string .= ">
		<option value=''>Select ... </option>";
			/**
			 * Builds the options html in a select element
			 */			
			if(array_key_exists('options', $fields)){
				foreach($fields['options'] as $option_value=>$option){
					
					$output_string .="<option value='".$option_value."' ";
					
					
					/**
					 * Sets the selected option in a select element. It uses the key of the values
					 * element of the fields array. 
					 */
					
					if(isset($fields['values'][0]) && $option_value == $fields['values'][$cnt]){
						$output_string .= " selected = 'selected' ";	
					}
								
					if(array_key_exists('properties', $fields['options'][$option_value])){
						foreach($fields['options'][$option_value]['properties'] as $property=>$value){
							
							if(isset($fields['values']) && $value == 'selected') continue;
												
							if(is_numeric($property)){
								//For property array that is not associative
								$output_string .= " ".$value." = '".$value."' ";
							}else{
								//For associative property array
								$output_string .= " ".$property." = '".$value."' ";
							}			
						}
					}
		
									
				$output_string .= " '>".$option['option']."</option>";
				}
			}		
						
		$output_string .= "</select>";
		
		return $output_string;
	}


	
	private function create_input_field($fields = array(),$cnt = 0){
		
		$output_string = "";		
				
		$additional_classes = "";
		
		if(isset($fields['properties'])){
			if(array_key_exists('class', $fields['properties'])){
				$additional_classes = " ".$fields['properties']['class'];
			}	
		}		
		
		
		$output_string .= "<input class='form-control".$additional_classes."' ";
		
		if(isset($fields['properties'])){
			if(!array_key_exists('type', $fields['properties'])){
				$output_string .= "type='text'";
			}	
		}else{
			$output_string .= "type='text'";
		}
		
		if(isset($fields['values'])){
			$output_string .= " value = '".$fields['values'][$cnt]."' ";					
		}					
		
		if(isset($fields['properties'])){				
			foreach($fields['properties'] as $property=>$value){
				
				if(is_numeric($property)){
					$output_string .= " ".$value." = '".$value."' ";
				}else{
					$output_string .= " ".$property." = '".$value."' ";
				}
				
			} 
		}
						
		$output_string .= " />";
		
		return $output_string;
	}
	
	
	private function create_closed_html_tag($fields = array(),$cnt = 0){
		
		$output_string = "";				
		
		$output_string .= "<".$fields['element'];
				
		
		if(isset($fields['properties'])){				
			foreach($fields['properties'] as $property=>$value){
					
				if($property == 'innerHTML') continue;
				
				if(is_numeric($property)){
					$output_string .= " ".$value." = '".$value."' ";
				}else{
					$output_string .= " ".$property." = '".$value."' ";
				}
				
			} 
		}
						
		$output_string .= ">";
		
		$output_string .=$fields['properties']['innerHTML'];
		
		$output_string .= "</".$fields['element'].">";
		
		return $output_string;
	}
	
	private function create_single_column_form(){		
		
		$output_string = "";
		
		$output_string = "<div class='row'><div class='col-xs-12'><ul class='nav nav-pills'>
							<li>
								<a id='btnBack' onclick='go_back();' class='btn btn-default'><i class='fa fa-arrow-left'></i> Back</a>		
							</li>
										
						</ul></div></div>";
		
		foreach($this->fields as $fields){
			$label = isset($fields['label'])?$fields['label']:'Label Not Provided';
			$output_string .= "<div class='form-group'>
				<label class='control-label col-xs-4'>".$label."</label>
				<div class='col-xs-8'>";
					
					$additional_classes = "";
					
					if(isset($fields['properties'])){
						if(array_key_exists('class', $fields['properties'])){
							$additional_classes = $fields['properties']['class'];
						}
					}
					
					if($fields['element'] !== 'input' && $fields['element'] !== 'select' ){
						$output_string .= $this->create_closed_html_tag($fields);
					}else{
						if($fields['element'] == 'input'){
							$output_string .= $this->create_input_field($fields);
						}elseif($fields['element'] == 'select'){
							$output_string .= $this->create_select_field($fields);
						}
					}
										
				$output_string .= "</div>
			</div>";
		}
		
		return $output_string;
	}

	private function create_multi_column_form(){
		
		$output_string = "";
		
		$output_string .= '<ul class="nav nav-pills">
										<li>
											<a id="add_row" class="btn btn-default"><i class="fa fa-plus"></i>  Add Row</a>	
										</li>
										<li>
											<a id="btnDelRow" class="btn btn-default hidden"><i class="fa fa-minus"></i>  Remove Rows</a>	
										</li>
										<li>
											<a id="resetBtn" class="btn btn-default"><i class="fa fa-refresh"></i>  Reset</a>	
										</li>
										<li>
											<a id="btnBack" onclick="go_back();" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>	
										</li>
									</ul><hr />';
									
									
		$output_string .= "<table class='table table-striped' id='".$this->multi_column_table_id."'>
			<thead><tr>
			<th>Action</th>";
				foreach($this->fields as $headers){
					$output_string .= "<th>".$headers['label']."</th>";
				}
		$output_string .= "</tr></thead>
		<tbody>";
		
		for($i=0;$i<$this->get_initial_row_count();$i++){
			
			$output_string .= "<tr class='tr_clone'>
			<td><input type='checkbox' id='' class='check' /></td>";
			
			
			foreach($this->fields as $fields){
				$output_string .= "<td>";
				if($fields['element'] == 'select'){
					
					$output_string .= $this->create_select_field($fields,$i);
				
				}elseif($fields['element'] == 'input'){
					$output_string .= $this->create_input_field($fields,$i);
				}
				
				$output_string .= "</td>";
				
				
			}
			
			$output_string .= "</tr>";
			
		}	
		
		$output_string .= "</tbody>
		</table>";							
		
		return $output_string;
	}

	private function jquery_script(){
		
		$output_string = '<script>
				
				function go_back(){
					window.history.back();
				}
				
				$("#add_row").on("click",function(){
					clone_last_body_row("'.$this->multi_column_table_id.'","tr_clone");
				});
				
				$(document).on("click",".check",function(){
					show_hide_delete_button_on_check("check","btnDelRow");
				});
				
				$("#btnDelRow").click(function(){
					remove_selected_rows("'.$this->multi_column_table_id.'","btnDelRow","check");
				});
				
				
				$("#resetBtn").on("click",function(){
					remove_all_rows("'.$this->multi_column_table_id.'");
					$(".resetable").val(null);
				});
				
				function clone_last_body_row(table_id,row_class){
					var $tr    = $("#"+table_id+" tbody tr:last").closest("."+row_class);
					var $clone = $tr.clone();
					$clone.find(":checkbox").removeAttr("disabled");
					$clone.find("input[readonly!=readonly]:text").val(null);
					$tr.after($clone);
				}
	
				
				function remove_all_rows(tbl_id,td_hosting_checkbox_postion){
					if (td_hosting_checkbox_postion === undefined) {
				        td_hosting_checkbox_postion = 0;
				    }
					 $("#"+tbl_id+" tbody").find("tr:gt(0)").remove();
					 
					 var elem = $("select,input");
					 
					 //Clear values elements that are not readonly or disabled
					 $.each(elem,function(){
					 	if($(this).is("[readonly]") == false && $(this).is("[disabled]")== false)
					    {
					      $(this).val(null);
					    }
					 });
					
					 //Uncheck the check box of the first row
					 $("#"+tbl_id+" tbody").find("tr:eq(0) td:eq("+td_hosting_checkbox_postion+")").children().prop("checked",false);		 
				}
				
				function show_hide_delete_button_on_check(checkbox_class,delete_button_id){
					var checked = $("."+checkbox_class+":checked").length;
					if(checked>0){
						$("#"+delete_button_id).removeClass("hidden");	
					}else{
						$("#"+delete_button_id).addClass("hidden");
					}
				}
				
				function remove_selected_rows(tbl_id,action_btn_id,checkbox_class){
					var elem = $("#"+tbl_id+" tbody");
					
					$("."+checkbox_class).each(function(){
						if($(this).is(":checked")){
							if(elem.children().length > 1){
								$(this).closest("tr").remove();//Replaced .parent().parent() to .closest()
							}else{
								alert("You need atleast one row in the table");
								
								//Uncheck the check box of the first row
								$("#"+tbl_id+" tbody").find("tr:eq(0) td:eq("+td_hosting_checkbox_postion+")").children().prop("checked",false);
							}
						}
						
						var checked = $(".check:checked").length;
						if(checked>0){
							$("#"+action_btn_id).removeClass("hidden");	
						}else{
							$("#"+action_btn_id).addClass("hidden");
						}
					});		
				}
					
									
					$("#btnCreate").on("click",function(ev){
						
						var go_back_on_post = true;
						var go_back_after_post = "'.$this->get_go_back_on_post().'";
						
						if(go_back_after_post !== "1"){
							go_back_on_post = false;
						}
								
						var url = $("#'.$this->form_id.'").attr("action");
						var data = $("#'.$this->form_id.'").serializeArray();

						$.ajax({
							url:url,
							data:data,
							type:"POST",
							beforeSend:function(){
								$("#overlay").css("display","block");
							},
							success:function(resp){
								alert(resp);
								
								if(go_back_on_post){
									go_back();
								}
								
								$("#overlay").css("display","none");
								
								
							},
							error:function(){
								alert("Error Occurred");
							}
						});
						
						ev.preventDefault();
					});
				
		</script>';
		
		return $output_string;
	}

	private function style_script(){
		$output_string = '<style>
				#overlay {
				    position: fixed; /* Sit on top of the page content */
				    display: none; /* Hidden by default */
				    width: 100%; /* Full width (cover the whole page) */
				    height: 100%; /* Full height (cover the whole page) */
				    top: 0; 
				    left: 0;
				    right: 0;
				    bottom: 0;
				    background-color: rgba(0,0,0,0.5); /* Black background with opacity */
				    z-index: 2; /* Specify a stack order in case you\'re using a different order for other elements */
				    cursor: pointer; /* Add a pointer on hover */
				}
				
				#overlay img{
					display: block;
					margin-top:25%;
					margin-left: auto;
				    margin-right: auto;
				} 
				</style>';
				
		$output_string .= '<div id="overlay"><img src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif"/></div>';		
				
		return $output_string;			
	}
	
	
	function set_debug_mode($debug_mode = ""){
		$this->debug_mode = $debug_mode;
	}
	
	private function get_debug_mode(){
		return $this->debug_mode;
	}
	
	function show_debug_mode($to_debug){
		
		$this->get_debug_mode();
		
		$return_string = "";
		
		if($this->debug_mode == true){
			$return_string .= "<pre>".htmlentities($to_debug)."</pre>";
		}
		
		return $return_string;
	}
	
	function set_panel_title($panel_title = ""){
		$this->panel_title = $panel_title;
	}
	
	function get_panel_title(){
		return $this->panel_title;
	}
	
	function set_db_table($db_table = ""){
		$this->db_table = $db_table;
	}
	
	private function get_db_table(){
		return $this->db_table;
	}
	
	
	function set_selected_fields($selected_list_fields,$fields_not_selected){
		
		//$this->selected_list_fields = array("lead_bio_fields_id");
		$this->selected_list_fields = array($fields_not_selected);
		$this->selected_list_fields = array_merge($this->selected_list_fields,$selected_list_fields);
	}
	
	private function get_selected_fields(){
		return $this->selected_list_fields;
	}

	
	function set_data_limit($offset,$count){
		$this->data_limit = array('offset'=>$offset,'count'=>$count);
	}
	
	private function get_data_limit(){
		return $this->data_limit;
	}
	
	private $where = array();
	
	private $add_url = "#";
	private $view_url = "#";
	private $edit_url = "#";
	private $delete_url = "#";
	
	private $list_action = array();
	
	function set_list_action($action){
		$this->list_action = $action;
	}
	
	private function get_list_action(){
		return $this->list_action;
	}
	
	function set_where_clause($where){
		$this->where = array_merge($this->where,$where);
	}
	
	private function get_where_clause(){
		return $this->where;
	}
	
	private $join = array();
	
	public function set_table_join($join_array){
		$this->join = $join_array;
	}
	
	private function get_table_join(){
		return $this->join;
	}
	
	// private $display_field_as = array();
// 	
	// public function set_display_field_as($array_of_key_value = array()){
		// $this->display_field_as = $array_of_key_value;
	// }
// 	
	// private function get_display_field_as($array_of_key_value = array()){
		// return $this->display_field_as;	
	// }
	
	private function display_field_as($results,$set_db_table,$join_array){
		
		$this->get_selected_fields();
		
		$field_data = $this->CI->db->field_data($set_db_table);
		
		foreach($join_array as $table=>$keys){
			$field_data = array_merge($field_data,$this->CI->db->field_data($table));
		}
		
		$field_names = array_column($field_data, 'name');
		$field_types = array_column($field_data, 'type');
		
		$field_types = array_combine($field_names, $field_types);
		
		
		$final_array = array();
		
		$cnt = 0;
		

		
		foreach($results as $result){
			
			
			foreach($result as $elem_key => $elem_value){
				
				if(in_array($elem_key, $this->selected_list_fields)){
						$key_for_display_as_elem = array_search($elem_key, $this->selected_list_fields);
						
						if(is_numeric($key_for_display_as_elem)){
							$final_array[$cnt][$this->selected_list_fields[$key_for_display_as_elem]] = $elem_value;
						}else{
							$final_array[$cnt][$key_for_display_as_elem] = $elem_value;
						}
							
						
					}else{
						$final_array[$cnt][$elem_key] = $elem_value;
				}
			}
		
			$cnt++;
		}
		
		return $final_array;
	}
	
	private function db_results(){
		$this->get_selected_fields();
		$this->get_db_table();
		$this->get_data_limit();
		$this->get_where_clause();
		$this->get_table_join();
		
		//print_r($this->selected_list_fields);
		
		if(is_array($this->selected_list_fields) && !empty($this->selected_list_fields)){
			$this->CI->db->select($this->selected_list_fields);
		}
		
		if(is_array($this->where) && !empty($this->where)){
			$this->CI->db->where($this->where);
		}
		
		if(is_array($this->join) && !empty($this->join)){
			/**
			 * INPUT ARRAY
			 * join_array(
			 * 	'country'=>array('user.country_id','country.country_id'),
			 * 'province'=>array('country.country_id','province.country_id')
			 * )
			 */
			 
				foreach($this->join as $secondary_table=>$join_keys){
					
					$this->CI->db->join($secondary_table,$join_keys[1]."=".$join_keys[0]);
				}
		}
		
		if(!empty($this->data_limit)){
			$this->CI->db->limit($this->data_limit['offset'],$this->data_limit['count']);
		}
		
		//$results = $this->CI->db->get($this->db_table)->result_array();
		$results = $this->display_field_as($this->CI->db->get($this->db_table)->result_array(),$this->db_table,$this->join);
		
		return $results;
	}	
	
	private $dropdown_element_type = array();
	
	public function set_dropdown_element_type($dropdown_element_type  = array()){
		$this->dropdown_element_type [] = $dropdown_element_type ;
	}
	
	public function get_dropdown_element_type(){
		return $this->dropdown_element_type;
	}
	
	private function build_single_form_fields(){

	$this->get_view_or_edit_mode();

	$this->get_dropdown_element_type();
		
	$results = $this->db_results();
		
	$fields = array();

	$elem = $results[0];
		
	array_shift($elem);
		
	//print_r($elem);
	//print_r($this->selected_list_fields);
	$fields_with_type = array_column($this->dropdown_element_type , '0');
	//echo "++++++++++++";
	//print_r($this->element_type);
	//print_r($fields_with_type);
	
	$fields_options = array_column($this->dropdown_element_type , '1');
	
	//print_r($fields_options[0]);
	$cnt = 0;
	foreach($elem as $key=>$value){
		if($this->view_or_edit_mode == 'view'){
			
				$fields[] = array(
					'element' =>'div',
					'label' => $key,
					'properties'=>array('innerHTML'=>ucfirst($value),'class'=>'','id'=>'','style'=>'margin-top:8px;',
					$this->view_or_edit_mode == 'view'?'':'value'=>$value)
				);
			
		}else{
			
			if(in_array($this->selected_list_fields[$key], $fields_with_type)){
				
				$element = "select";
				
								
				//$fields[]['options']['properties'] = array('selected'=>'selected');
				
				$options = array();
				
				foreach($fields_options[$cnt] as $option_key=>$option_value){
					if($option_key == $value){
						$options[$option_key] = array('option'=>$option_value['option'],'properties'=>array('selected'=>'selected'));
					}else{
						$options[$option_key] = array('option'=>$option_key);
					}
				}
									
				$fields[] = array(
						'element' => $element,
						'label' => $key,
						'properties'=>array('class'=>'','value'=>$value,'id'=>'','style'=>'margin-top:8px;'),
						'options'=>$options
						
					);
					$cnt++;
					
			}else{
					
					$fields[] = array(
						'element' => 'input',
						'label' => $key,
						'properties'=>array('class'=>'','value'=>$value,'id'=>'','style'=>'margin-top:8px;')
					);
				
			}
			
		}
	}
				
		
		$this->fields = $fields;
		
		return $this->create_single_column_form();
	}
	
	private $extra_list_action = array();
	
	function set_extra_list_action($extra_action){
		$this->extra_list_action = $extra_action;
	}
	
	private function get_extra_list_action(){
		$this->extra_list_action;
	}
	
	private function additional_list_action(){
		$this->get_extra_list_action();
		
		$output = "";
		
		if(!empty($this->extra_list_action)){
			foreach($this->extra_list_action as $row){
				$output .= "
					<li>
						<a href='".base_url()."index.php/".$row['href']."'>
							<i class='fa fa-pencil'></i>
								".$row['label']."
						</a>
					</li>
					<li class='divider'></li>
				";	
			}
		}
		
		return $output;
	}
	
	private $add_form = false;
	
	function set_add_form(){
		$this->add_form = true;
	}
	
	function get_add_form(){
		return $this->add_form;
	}
	
	
	private $view_or_edit_mode = 'view';
	
	public function set_view_or_edit_mode($view_or_edit_mode){
		$this->view_or_edit_mode = $view_or_edit_mode;
	}
	
	private function get_view_or_edit_mode(){
		return $this->view_or_edit_mode;
	}
	
	function render_item_list(){
		$add = "#";
		$view= "#";
		$edit= "#";
		$delete = "#";
		
		
		$this->get_list_action();
		$this->get_add_form();
		
		if(!empty($this->list_action)){
			extract($this->list_action);
		}
		//print_r($view);
					
		$list_array = $this->db_results();	
		
		$output = $this->open_panel();
		if($this->add_form){
			$output .= "
						<div class='row'>
							<div class='col-xs-12'>									
									<ul class='nav nav-pills'>
										<li>
											<a href='".base_url()."index.php/".$add['href']."' class='btn btn-default'>Add New Record 
												<i class='fa fa-plus'></i></a>
										</li>
										<li>
											<a id='btnBack' onclick='go_back();' class='btn btn-default'><i class='fa fa-arrow-left'></i> Back</a>		
										</li>
										
									</ul>
							</div>	
						</div>	
					<hr/>	
			";
		}
		
		$output .= "
				<div class='row'>
						<div class='col-xs-12'>
							<table class='table datatable'>
								<thead><tr><th>Action</th>";
									$header_elem = $list_array[0];
									/**
									 * Remove the first element (red) from an array, and return 
									 * the value of the removed element
									 */
									array_shift($header_elem);

									foreach($header_elem as $key=>$value){
										
										$output .= "<th>".ucwords(str_replace("_", " ", $key))."</th>";
									}
								$output.="</tr></thead>
								<tbody>";
									foreach($list_array as $row){
										$primary_key = array_shift($row);
										//print_r($row);
										$output .= "<tr>";
										$output .= "<td>
										
											<div class='btn-group left-dropdown'>
											
												<a class='btn btn-default' href='#'>Action</a>
												
												<button type='button' class='btn btn-default dropdown-toggle' 
												data-toggle='dropdown'>
													<span class='caret'></span>
												</button>
												
												<ul class='dropdown-menu' role='menu'>
													
													<li>
														<a href='".base_url()."index.php/".$view['href']."/".$this->db_table."/".$primary_key."'>
															<i class='fa fa-eye'></i>
																View
														</a>
													</li>
													<li class='divider'></li>
													
													<li>
														<a href='".base_url()."index.php/".$edit['href']."/".$this->db_table."/".$primary_key."'>
															<i class='fa fa-pencil'></i>
																Edit
														</a>
													</li>
													<li class='divider'></li>
																										
													<li>
														<a href='".base_url()."index.php/".$delete['href']."/".$this->db_table."/".$primary_key."'>
															<i class='fa fa-trash'></i>
																Delete
														</a>
													</li>
													<li class='divider'></li>";
												$output .= $this->additional_list_action();		
											$output .="</ul>
											</div>
								
										</td>";
											foreach($row as $td_value){
												$output .= "<td>".$td_value."</td>";		
											}
										$output .= "</tr>";
									}
								$output.="</tbody>
							</table>
						</div>
				</div>				
		";
		$output .= $this->close_panel();
		
		$output .= $this->use_datatable();
		
		return $output;
	}

	private $table_primary_key;
	
	public function set_table_primary_key($table_primary_key){
		$this->table_primary_key = $table_primary_key;
	}
	
	private function get_table_primary_key(){
		return $this->table_primary_key;
	}
	
	
	function set_use_datatable($use_datatable){
		$this->use_datatable = $use_datatable;
	}
	
	private function get_use_datatable(){
		return $this->use_datatable;
	}
	
	private function use_datatable(){
		$this->get_use_datatable();
		
		$output = "";
		
		if($this->use_datatable){
			$output .= "
				<script>
					$(document).ready(function(){
						$('.datatable').DataTable(
								{
									dom: 'Bfrtip',
									buttons: [
						            	'copy', 'csv', 'excel', 'pdf', 'print'
						        	],
									'ordering': true,
								    'stateSave': true,
								    'scrollX': false
								 }
						);
					});
					
				</script>		
			";
		}
		
		
		return $output;
	}
	
	function render_form($form_type = "single_form"){
		
		if($this->form_output_string!=="") $this->form_output_string = "";
		
		$this->form_output_string .= $this->open_panel();
		$this->form_output_string .= $this->form_open_tag();
		
		if($form_type == 'multi_form') $this->form_output_string .= $this->create_multi_column_form();
		elseif($form_type == 'single_form')	$this->form_output_string .= $this->create_single_column_form();
		elseif($form_type == 'single_view_form') $this->form_output_string .= $this->build_single_form_fields();
			
		
		$this->form_output_string .= $this->form_close_tag();
		$this->form_output_string .= $this->close_panel();
	
		$this->form_output_string .= $this->show_debug_mode($this->form_output_string);
		
		$this->form_output_string .= $this->jquery_script();	
		
		$this->form_output_string .= $this->style_script();
	
		return $this->form_output_string;
			
	}
	
}