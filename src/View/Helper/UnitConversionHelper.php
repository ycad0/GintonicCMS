<?php

namespace GintonicCMS\View\Helper;

use Cake\View\Helper\HtmlHelper;

class UnitConversionHelper extends HtmlHelper
{

    public $helpers = ['Html'];

    /**
     * TODO: doccomment
     */
    public function convertLength($value = null, $fromUnit = null, $toUnit = null)
    {
        $valid = $this->__checkInputs($value, $fromUnit, $toUnit);
        if (!$valid['success']) {
            return $valid['value'];
        }
        
        switch ($fromUnit) {
            case 'cm':
                return $this->__convertFromInch($value, $toUnit);
                break;

            default:
                break;
        }
    }

    /**
     * TODO: doccomment
     */
    public function convertMass($value = null, $fromUnit = null, $toUnit = null)
    {
        $valid = $this->__checkInputs($value, $fromUnit, $toUnit);
        if (!$valid['success']) {
            return $valid['value'];
        }
        
        switch ($fromUnit) {
            case 'kg':
                return $this->__convertFromKg($value, $toUnit);
                break;

            default:
                break;
        }
    }

    /**
     * TODO: doccomment
     */
    private function __checkInputs($value = null, $fromUnit = null, $toUnit = null)
    {
        $response = [
            'value' => $value,
            'success' => true
        ];
        if (empty($value) || empty($fromUnit)) {
            $response = [
                'value' => 0,
                'success' => false
            ];
        }

        if (empty($toUnit)) {
            $response = [
                'value' => $value,
                'success' => false
            ];
        }

        return $response;
    }

    /**
     * TODO: doccomment
     */
    private function __convertFromInch($value, $toUnit)
    {
        switch ($toUnit) {

            case 'feet':
                $feet = intval($value / 12);
                $inch = round($value % 12);

                return $feet . '\'' . $inch . '"';
                break;
        }
    }
    
    /**
     * TODO: doccomment
     */
    private function __convertFromKg($value, $toUnit)
    {
        switch ($toUnit) {

            case 'lbs':
                return round($value * 2.2046, 2) . ' lbs';
                break;
        }
    }
}
