<?php
namespace Samplejunction\CustomBootstrapForm;

use Watson\BootstrapForm\BootstrapForm;

class CustomBootstrapForm extends BootstrapForm{

    private $typeMap = [
        "Numeric Open Ended" => 'number',
        "Text Open Ended" => 'text',
        "Single Punch" => 'radios',
        "Multi Punch" => 'checkboxes',
        "Multi-Punch" => 'checkboxes',
        //Have to remove below after making changes in DB
        "Open End - Numeric" => 'number',
        "Dummy" => 'text'
    ];

    public $country_locale;

    public function __construct($app, $bypass)
    {
        // only perform actions inside if not bypassing
        if (!$bypass) {

        }
        // call BootstrapForm's constructor
        parent::__construct($app['html'], $app['form'], $app['config']);
    }

    public function text($name, $label = null, $value = null, array $options = [])
    {
        $options['placeholder']= 'Please mention';
		
		return $this->input('text', $name, $label, $value, $options);
    }

    public function number($name, $label = null, $value = null, array $options = [])
    {
        return $this->input('number', $name, $label, $value, $options);
    }


    /**
     * Create a collection of Bootstrap checkboxes.
     *
     * @param  string  $name
     * @param  string  $label
     * @param  array   $choices
     * @param  array   $checkedValues
     * @param  bool    $inline
     * @param  array   $options
     * @return string
     */
    public function checkboxes($name, $label = null, $choices = [], $checkedValues = [], $inline = false, array $options = [])
    {
        $elements = '';
        $name .= '[]';

        $elementWrapper = '<div class="col-sm-4 col-md-4">';
        $elementWrapperClose = '</div>';

        $requireOption = 'aria-required="true" required="true" minlength="1"';
        if (empty($choices)) {
            dd('Answers not found');
        }
        foreach ($choices as $index => $answer) {

            if($index == 0){
                $options['aria-required'] = "true";
                $options['required'] = "true";
                $options['minlength'] = "1";
            }else{
                unset($options['aria-required']);
                unset($options['required']);
                unset($options['minlength']);
            }

            $checked = in_array($answer['precode'], (array) $checkedValues);
            $options['data-precode_type']= $answer['precode_type'];
            $options['data-question']= $name;


            $elements .= $elementWrapper.$this->checkboxElement($name, $answer['text'], $answer['precode'], $checked, $inline, $options).$elementWrapperClose;
        }

        $error_label = '<label for="'.$name.'" class="error">&nbsp;</label>';
        $wrapperOptions = $this->isHorizontal() ? ['class' => $this->getRightColumnClass()] : [];
        $wrapperElement = $error_label.'<div' . $this->html->attributes($wrapperOptions) . '>' . $elements . $this->getFieldError($name) . $this->getHelpText($name, $options) . '</div>';

        return $this->getFormGroup($name, $label, $wrapperElement);
    }

    /**
     * Create a single Bootstrap checkbox element.
     *
     * @param  string   $name
     * @param  string   $label
     * @param  string   $value
     * @param  bool     $checked
     * @param  bool     $inline
     * @param  array    $options
     * @return string
     */
    public function checkboxElement($name, $label = null, $value = 1, $checked = null, $inline = false, array $options = [])
    {
        $label = $label === false ? null : $this->getLabelTitle($label, $name);

        $labelOptions = $inline ? ['class' => 'checkbox-inline'] : [];
        $inputElement = $this->form->checkbox($name, $value, $checked, $options);
        $labelElement = '<label ' . $this->html->attributes($labelOptions) . '>' . $inputElement . $label . '</label>';

        return $inline ? $labelElement : '<div class="checkbox">' . $labelElement . '</div>';
    }

    /**
     * Create a collection of Bootstrap radio inputs.
     *
     * @param  string  $name
     * @param  string  $label
     * @param  array   $choices
     * @param  string  $checkedValue
     * @param  bool    $inline
     * @param  array   $options
     * @return string
     */
    public function radios($name, $label = null, $choices = [], $checkedValue = null, $inline = false, array $options = [])
    {

        $elements = '';
        $elementWrapper = '<div class="col-sm-4 col-md-4">';
        $elementWrapperClose = '</div>';
        $error_label = '<label for="'.$name.'" class="error">&nbsp;</label>';
        if (empty($choices)) {
            dd('Answers not found');
        }
        foreach ($choices as $answer) {
            $checked = $answer['precode'] === $checkedValue;
			$options['data-precode_type']= $answer['precode_type'];
            $options['data-question']= $name;
            $elements .= $elementWrapper.$this->radioElement($name, $answer['text'], $answer['precode'], $checked, $inline, $options).$elementWrapperClose;
        }

        $wrapperOptions = $this->isHorizontal() ? ['class' => $this->getRightColumnClass()] : [];

        $wrapperElement = $error_label.'<div' . $this->html->attributes($wrapperOptions) . '>' . $elements . $this->getFieldError($name) . $this->getHelpText($name, $options) . '</div>';

        return $this->getFormGroup($name, $label, $wrapperElement);
    }

    public function generateFields($type, $name, $answers, $userAnswers, $country_locale = false)
    {
        if($country_locale){
            $this->country_locale = $country_locale;
        }
        if(! array_key_exists($type, $this->typeMap )){
            return 'Invalid Type';
        }
        $field_type = $this->typeMap[$type];
        $user_answer = (($userAnswers) && (!$userAnswers->isEmpty()) )?$userAnswers->first():false;
        if( in_array($field_type, ['text', 'number' ]) ){
            return call_user_func_array([ $this, $field_type], [ $name, false, $user_answer,['required'=>'true'] ]);
        }

        if( in_array($field_type, [ 'checkboxes' ]) ){
            if(!empty($user_answer)){
                $user_answer = explode(',', $user_answer);
            }

            return call_user_func_array([ $this, $field_type], [ $name, null, $answers, $user_answer, false ]);
        }
        if( in_array($field_type, [ 'radios' ]) ){
            return call_user_func_array([ $this, $field_type], [ $name, null, $answers, $user_answer,false,['required'=>'true'] ]);
        }

    }

    public function generateCountrySelect($name, $label = null, $list = [], $selected = null, array $options = [])
    {
        dd($list);
    }

    /**
     * Create the input group for an element with the correct classes for errors.
     *
     * @param  string  $type
     * @param  string  $name
     * @param  string  $label
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    public function input($type, $name, $label = null, $value = null, array $options = [])
    {
        $label = $this->getLabelTitle($label, $name);

        $optionsField = $this->getFieldOptions(array_except($options, ['suffix', 'prefix']), $name);

        $inputElement = '';

        if(isset($options['prefix'])) {
            $inputElement = $options['prefix'];
        }

        $inputElement .= $type === 'password' ? $this->form->password($name, $optionsField) : $this->form->{$type}($name, $value, $optionsField);

        if(isset($options['suffix'])) {
            $inputElement .= $options['suffix'];
        }

        if(isset($options['prefix']) || isset($options['suffix'])) {
            $inputElement = '<div class="input-group">' . $inputElement . '</div>';
        }

        $wrapperOptions = $this->isHorizontal() ? ['class' => $this->getRightColumnClass()] : [];
        $wrapperElement = '<div' . $this->html->attributes($wrapperOptions) . '>' . $inputElement . $this->getFieldError($name) . $this->getHelpText($name, $optionsField) . '</div>';

        return $this->getFormGroup($name, $label, $wrapperElement);
    }
}
