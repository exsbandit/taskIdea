<?php


namespace App\Services\v1\Discount;


abstract class DiscountRule
{
    protected $type; // İndirim uygulanacak yer
    protected $selection; // indirim uygulanacak olan id
    protected $desc; // indirim bilgisi
    protected $unit; // indirim tipi ADET / YüZDE
    protected $rule; // İndirim Kuralı büyük yada küçük olma durumu
    protected $controlColumn; // Kontrol edilecek kolon
    protected $control; // Kontrol edilecek id
    protected $input; // İndirim miktar
    protected $sub_total; // Varsa Sepet tutar kontrol

    public function __construct($params)
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    abstract public function applyRule($items);
}
