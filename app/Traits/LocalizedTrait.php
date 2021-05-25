<?php

namespace App\Traits;

use App;

trait LocalizedTrait
{
    public function getLocalValue($model, $field)
    {
        if (App::isLocale('en')) {
            $enField = $field . '_en';
            if (isset($model->$enField)) {
                return $model->$enField;
            }
        }

        elseif  (App::isLocale('ar')) {
            $arField = $field . '_ar';
            if (isset($model->$arField)) {
                return $model->$arField;
            }
        }
        else
        {
            $enField = $field . '_en';
            if (isset($model->$enField)) {
                return $model->$enField;
            }
        }

        if (isset($model->$field)) {
            return $model->$field;
        }


        return null;
    }

    /**
     * @param mixed $model
     * @param array $fields
     * @return ?string
     */

    public function getLocalValueMultiColumns($model, ...$fields): ?string
    {
        $attribute = '';
        foreach ($fields as $field) {

            $attribute .= $this->getLocalValue($model, $field);
        }

        return $attribute;

    }

}
