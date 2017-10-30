<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2014 Sapplica
 *   
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/

class Default_Form_projecttype extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('action',BASE_URL.'projecttype/edit');
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'projecttype');


        $id = new Zend_Form_Element_Hidden('id');
		
		$projecttype = new Zend_Form_Element_Text('projecttype');
        $projecttype->setAttrib('maxLength', 200);
        
        $projecttype->setRequired(true);
        $projecttype->addValidator('NotEmpty', false, array('messages' => 'Please enter project type.'));
        $projecttype->addValidator(new Zend_Validate_Db_NoRecordExists(
                                              array('table'=>'main_projecttype',
                                                        'field'=>'projecttype',
                                                      'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('id').'" and isactive=1',    
                                                 ) )  
                                    );
        $projecttype->getValidator('Db_NoRecordExists')->setMessage('Project type already exists.');	
        	
      
		$description = new Zend_Form_Element_Textarea('description');
        $description->setAttrib('rows', 10);
        $description->setAttrib('cols', 50);
		$description ->setAttrib('maxlength', '200');
      
		$hours_day = new Zend_Form_Element_Text('hours_day');
    $hours_day->setAttrib('maxLength', 2);
    $hours_day->addFilter(new Zend_Filter_StringTrim());
    $hours_day->setRequired(true);
		$hours_day->addValidator("regex",true,array(
															'pattern'=>'/^([0-9]|[1][0-9]|[2][0-4])$/', 
                           		'messages'=>array(
                             			'regexNotMatch'=>'Billing hours per day cannot be more than 24 hours. If no overriding billing hours from timesheet required for project type, enter zero.'
                           			)
        											)
														);

        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save');

		 $this->addElements(array($id,$projecttype,$description,$hours_day,$submit));
         $this->setElementDecorators(array('ViewHelper')); 
	}
}