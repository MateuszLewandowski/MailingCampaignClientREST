<?php 

namespace MailingCampaign\Src\Helpers;

abstract class DuplicateArgumentsHandler 
{
    public static function cleanup(array $args): array
    {
        $objectables = [];
        foreach ($args as $key => $value) {
            if (is_object($value)) {
                $objectables[] = get_object_vars($value);
            }
        }
        foreach ($objectables as $objectable) {
            foreach ($objectable as $key => $value) {
                if (isset($args[$key])) {
                    unset($args[$key]);
                }
            }
            
        }
        return $args;
    }
}