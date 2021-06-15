<?php
namespace webrise1\pdfgenerator\models;
class Menu {
    public static function getAdminMenu($label='Сертификаты'){
        return
            [
                'label' => $label, 'icon' => 'certificate','url' => ['/admin/pdfgenerator/template-certificate']
            ];
    }
}